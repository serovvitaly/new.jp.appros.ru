<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model {

    public $table = 'orders';

    protected $fillable = ['user_id', 'purchase_id', 'product_id', 'amount'];

    /**
     * Возвращает общую сумму данного "Заказа"
     */
    public function getTotalSum()
    {
        return 0;
    }
}