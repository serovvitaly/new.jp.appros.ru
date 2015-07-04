<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model {

    public $table = 'orders';

    /**
     * Возвращает общую сумму данного "Заказа"
     */
    public function getTotalSum()
    {
        return 0;
    }
}