<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, EntrustUserTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    protected $basket = null;


    public function products()
    {
        return $this->hasMany('\App\BusinessLogic\Models\Product');
    }

    public function purchases()
    {
        return $this->hasMany('\App\BusinessLogic\Models\Purchase');
    }

    public function orders()
    {
        return $this->hasMany('\App\BusinessLogic\Models\Order');
    }

    public function payments_transactions()
    {
        return $this->hasMany('\App\BusinessLogic\Models\PaymentTransaction');
    }

    /**
     * Зачисление средств
     * @param $sum
     * @return \App\BusinessLogic\Models\PaymentTransaction
     */
    public function moneyAdmission($sum)
    {
        return \App\BusinessLogic\Models\PaymentTransaction::makeAdmission($sum, $this);
    }

    /**
     * Возвращает баланс, без учета заблокированных средств.
     * Т.е. разницу между Поступлениями и Расходами
     */
    public function getAbsoluteBalance()
    {
        $resource = \DB::select('SELECT (SUM(admission) - SUM(expense)) AS balance FROM payments_transactions WHERE user_id = ?', [$this->id]);

        return doubleval($resource[0]->balance);
    }

    /**
     * Возвращает доступные средства.
     * Т.е. учитываются заблокированные средства
     */
    public function getCashBalance()
    {
        $resource = \DB::select('SELECT (SUM(admission) - SUM(expense) - SUM(blocking)) AS balance FROM payments_transactions WHERE user_id = ?', [$this->id]);

        return doubleval($resource[0]->balance);
    }

    /**
     * Добавление заказа
     * @param $purchase_id
     * @param $product_id
     * @param $amount
     * @return \App\BusinessLogic\Models\Order
     */
    public function makeOrder($purchase_id, $product_id, $amount)
    {
        $purchase_id = intval($purchase_id);
        $product_id  = intval($product_id);
        $amount      = intval($amount);

        /**
         * @var $order \App\BusinessLogic\Models\Order
         */
        $order = \App\BusinessLogic\Models\Order::where('purchase_id', '=', $purchase_id)
            ->where('product_id', '=', $product_id)
            ->where('user_id', '=', $this->id)
            ->first();

        if ($order) {
            $order->amount = $order->amount + $amount;
            $order->save();
            return $order;
        }

        $order = \App\BusinessLogic\Models\Order::create([
            'purchase_id' => $purchase_id,
            'product_id' => $product_id,
            'amount' => $amount,
            'user_id' => $this->id,
        ]);

        return $order;
    }

    /**
     * Изменение объема заказа
     * @param $order_id
     * @param $amount
     * @return \App\BusinessLogic\Models\Order|null
     */
    public function updateAmountOrder($order_id, $amount)
    {
        // TODO: сделать проверку прав на изменение заказа

        $order = $this->orders()->find($order_id);
        \App\Helpers\Assistant::assertModel($order);

        $order->updateAmount($amount);

        return $order;
    }

    public function basket()
    {
        if (!$this->basket) {
            $this->basket = new \App\Basket($this->id);
        }

        return $this->basket;
    }
}
