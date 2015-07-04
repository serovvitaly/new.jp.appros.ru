<?php namespace App\BusinessLogic;


use App\BusinessLogic\Models\User;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{

    /**
     * Имя поля Пользователя Владельца в таблице БД
     */
    protected $user_id_field_name = 'user_id';

    /**
     * Ищет запись в БД
     * @param $id
     * @return null
     */
    public static function findRecordById($id)
    {
        $record = \DB::select('SELECT * FROM ' . self::getTableName() . ' WHERE id = ? LIMIT 1', [$id]);

        if (empty($record)) {
            return null;
        }

        return $record[0];
    }

    /**
     * Восстанавливает экземпляр из записи БД
     * @param $record_obj
     * @return Purchase|null
     */
    public static function restoreFromRecord($record_obj)
    {
        return new __CLASS__($record_obj);
    }

    /**
     * Возвращает имя таблицы БД
     */
    protected static function getTableName()
    {
        return static::$table_name;
    }

    /**
     * Утверждает, что переданный в функцию пользователь,
     * является владельцем экземпляра сущности
     * @param User $user
     * @throws \Exception
     */
    protected function assertOwnerUser(User $user)
    {
        if ($this->checkOwnerUser($user)) {
            return;
        }

        throw new \Exception('The specified user is not a owner');
    }

    /**
     * Проверяет, является ли пользователь, переданный в функцию,
     * владельцем экземпляра этой сущности
     * @param User $user
     * @return bool
     */
    protected function checkOwnerUser(User $user)
    {
        if ($this->getUser()->getId() !== $user->getId()) {
            return false;
        }

        return true;
    }

    /**
     * Возвращает Пользователя Владельца данной сущности
     * @return User
     */
    public function getUser()
    {
        return new User();
    }

    /**
     * Возвращает экземпляр модели, найденный по ID
     * @param $id
     * @return Model|null
     */
    public static function findById($id)
    {
        $record_obj = self::findRecordById($id);

        if (empty($record_obj)) {
            return null;
        }

        return self::restoreFromRecord($record_obj);
    }

    /**
     *
     */
    public function toArray()
    {
        //
    }

    /**
     * @return int
     */
    public function getId()
    {
        return 1;
    }

    public function __get($name)
    {
        //
    }

    public function __set($name, $value)
    {
        //
    }

}