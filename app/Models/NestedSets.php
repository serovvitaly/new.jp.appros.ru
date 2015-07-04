<?php namespace App\Models;

class NestedSets extends \Kalnoy\Nestedset\Node {

    public $timestamps = false;

    protected $fillable = array('name', 'parent_id');

	public static function append2($parent_id, array $fields)
    {
        $parent_id = intval($parent_id);

        $right_key = 0;

        $level = 0;

        if ($parent_id) {
            $parent_obj = self::find($parent_id);

            if (!$parent_obj) {
                return false;
            }

            $right_key = $parent_obj->right_key;

            $level = $parent_obj->level;
        }

        $table_name = 'nested_sets';

        \DB::table($table_name)
            ->where('left_key', '>', $right_key)
            ->update([
                'left_key' => 'left_key + 2',
                'right_key' => 'right_key + 2'
            ]);

        \DB::table($table_name)
            ->where('right_key', '>=', $right_key)
            ->where('left_key', '<', $right_key)
            ->update([
                'right_key' => 'right_key + 2'
            ]);

        $new_item = new self;

        $new_item->left_key = $right_key;
        $new_item->right_key = $right_key + 1;
        $new_item->level = $level + 1;
        $new_item->name = array_get($fields, 'name');

        $new_item->save();

        return $new_item;
    }

    protected function log($message)
    {
        \Log::warning('NESTED_SETS: ' . $message);
    }

    /**
     * Проверка целостности ключей
     * 1. Левый ключ ВСЕГДА меньше правого;
     * 2. Наименьший левый ключ ВСЕГДА равен 1;
     * 3. Наибольший правый ключ ВСЕГДА равен двойному числу узлов;
     * 4. Разница между правым и левым ключом ВСЕГДА нечетное число;
     * 5. Если уровень узла нечетное число то тогда левый ключ ВСЕГДА нечетное число, то же самое и для четных чисел;
     * 6. Ключи ВСЕГДА уникальны, вне зависимости от того правый он или левый;
     */
    public function checkIntegrityKeys()
    {
        /**
         * 1. Левый ключ ВСЕГДА меньше правого
         * SELECT id FROM my_tree WHERE left_key >= right_key
         */
        $result = $this->where('left_key', '>=', 'right_key')->get(['id']);

        if ($result) {
            $this->log('Найдены левые ключи, большие правых');
            return false;
        }

        /**
         * 2,3. Получаем количество записей (узлов), минимальный левый ключ и максимальный
         *      правый ключ, проверяем значения
         * SELECT COUNT(id), MIN(left_key), MAX(right_key) FROM my_tree
         */
        $result = $this->get(['COUNT(id)', 'MIN(left_key)', 'MAX(right_key)']);
        // TODO: обработать результат
        if ($result) {
            //$this->log('Найдены левые ключи, большие правых');
            return false;
        }

        /**
         * 4. Если все правильно то результата работы запроса не будет, иначе,
         *    получаем список идентификаторов неправильных строк
         * SELECT id, MOD((right_key - left_key) / 2) AS remainder FROM my_tree WHERE ostatok = 0
         */
        $result = $this->where('remainder', '=', 0)->get(['id', 'MOD((right_key - left_key) / 2) AS remainder']);

        if ($result) {
            $this->log('Разница между правым и левым ключом - четное число');
            return false;
        }

        /**
         * 5. Если все правильно то результата работы запроса не будет, иначе, получаем список
         *    идентификаторов неправильных строк
         * SELECT id, MOD((left_key – level + 2) / 2) AS ostatok FROM my_tree WHERE ostatok = 1
         */
        $result = $this->where('remainder', '=', 1)->get(['id', 'MOD((left_key – level + 2) / 2) AS remainder']);

        if ($result) {
            $this->log('Несоответствие уровня узла');
            return false;
        }

        /**
         * 6. Здесь, я думаю, потребуется некоторое пояснение запроса. Выборка по сути осуществляется из одной таблицы,
         *    но в разделе FROM эта таблица "виртуально" продублирована 3 раза: из первой мы выбираем все записи по
         *    порядку и начинаем сравнивать с записями второй таблицы (раздел WHERE) в результате мы получаем все записи
         *    неповторяющихся значений. Для того, что бы определить сколько раз запись не повторялась в таблице,
         *    производим группировку (раздел GROUP BY) и получаем число "не повторов" (COUNT(t1.id)). По условию, если
         *    все ключи уникальны, то число не повторов будет меньше на одну единицу чем общее количество записей.
         *    Для того, чтобы определить количество записей в таблице, берем максимальный правый ключ (MAX(t3.right_key)),
         *    так как его значение - двойное число записей, но так как в условии отбора для записи с максимальным правым
         *    ключом - максимальный правый ключ будет другим, вводится третья таблица, при этом число "неповторов"
         *    увеличивается умножением его на количество записей. SQRT(4*rep +1) - решение уравнения x^2 + x = rep.
         *    Если все правильно то результата работы запроса не будет, иначе, получаем список идентификаторов неправильных строк
         *
         * SELECT t1.id, COUNT(t1.id) AS rep, MAX(t3.right_key) AS max_right FROM my_tree AS t1, my_tree AS t2, my_tree AS t3
         * WHERE t1.left_key <> t2.left_key AND t1.left_key <> t2.right_key AND t1.right_key <> t2.left_key
         * AND t1.right_key <> t2.right_key GROUP BY t1.id HAVING max_right <> SQRT(4 * rep + 1) + 1
         */

        // TODO: реализовать проверку

        return true;
    }

}
