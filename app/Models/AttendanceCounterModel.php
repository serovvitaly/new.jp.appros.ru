<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Счетчик посещаемости
 * @package App\Models
 */
class AttendanceCounterModel extends Model
{
    protected $table = 'attendance_counter';

    protected $fillable = ['target_id', 'target_type', 'user_id', 'user_ip'];

    const TARGET_TYPE_SELLER   = 'seller';

    const TARGET_TYPE_PRODUCT  = 'product';

    const TARGET_TYPE_PRODUCT_IN_PURCHASE  = 'product_in_purchase';

    const TARGET_TYPE_PURCHASE = 'purchase';

    /**
     * Регистрирует посещение
     * @param $target_id
     * @param $target_type
     */
    public static function enrol($target_id, $target_type)
    {

        $user_id = 0;

        $user_model = \Auth::user();
        if ($user_model) {
            $user_id = $user_model->id;
        }

        $request = \Request::instance();

        self::create([
            'user_id' => $user_id,
            'user_ip' => $request->getClientIp(),
            'target_id' => $target_id,
            'target_type' => $target_type,
        ]);

    }

}