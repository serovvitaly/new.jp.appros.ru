<?php

namespace App\BusinessLogic\Models;


use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = 'orders';

    protected $fillable = ['user_id', 'purchase_id', 'product_id', 'amount'];

    /**
     * Возвращает общую сумму данного "Заказа"
     */
    public function getTotalSum()
    {
        return 0;
    }

    public function product()
    {
        return $this->belongsTo('\App\BusinessLogic\Models\Product');
    }

    public function purchase()
    {
        return $this->belongsTo('\App\BusinessLogic\Models\Purchase');
    }

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function payments_transactions()
    {
        return $this->hasMany('\App\BusinessLogic\Models\PaymentTransaction');
    }

    /**
     * Возвращет текущую корректную платежную операцию для данного заказа
     * @return \App\BusinessLogic\Models\PaymentTransaction
     */
    public function getCurrentPaymentTransaction()
    {
        $payment_transaction = $this->payments_transactions()->orderBy('created_at', 'desc')->first();
        \App\Helpers\Assistant::assertModel($payment_transaction);

        return $payment_transaction;
    }

    public function save(array $options = [])
    {
        $order_id = $this->id;

        //$old_amount = $this->getOriginal('amount');

        /**
         * @var $product \App\BusinessLogic\Models\Product
         */
        $product = \App\BusinessLogic\Models\Product::find($this->product_id);
        \App\Helpers\Assistant::assertModel($product);

        $current_max_price_for_purchase = $product->getCurrentMaxPriceForPurchase($this->purchase_id);

        $sum = $current_max_price_for_purchase * $this->amount;

        \App\ActionLog::action('ORDER.SAVE.BEFORE_TRANSACTION', [
            'order_id' => $order_id,
            'current_max_price_for_purchase' => $current_max_price_for_purchase,
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'sum' => $sum,
        ]);

        // Начало транзакции БД
        \DB::beginTransaction();

        parent::save($options);

        if ($order_id) {
            $current_payment_transaction = $this->getCurrentPaymentTransaction();
            $current_payment_transaction->unblocking();
        }

        $this->moneyBlocking($sum);

        \DB::commit();
        // Окончание транзакции БД

        \App\ActionLog::action('ORDER.SAVE.AFTER_TRANSACTION', [
            'order_id' => $order_id,
            'current_max_price_for_purchase' => $current_max_price_for_purchase,
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'amount' => $this->amount,
            'sum' => $sum,
        ]);
    }

    public function delete()
    {
        return;
    }

    protected function _delete()
    {
        return parent::delete();
    }

    /**
     * Изменение объема(количества продуктов) заказа
     * @param $amount
     * @return $this|null
     * @throws \Exception
     */
    public function updateAmount($amount)
    {
        $amount = intval($amount);

        if ($amount < 1) {
            $this->_delete();
            return null;
        }

        if ($amount === intval($this->amount)) {
            return $this;
        }

        $product = $this->product;
        \App\Helpers\Assistant::assertModel($product);

        $current_max_price_for_purchase = $product->getCurrentMaxPriceForPurchase($this->purchase_id);

        $sum = $current_max_price_for_purchase * $amount;

        \App\ActionLog::action('ORDER.UPDATE.BEFORE_TRANSACTION', [
            'order_id' => $this->id,
            'current_max_price_for_purchase' => $current_max_price_for_purchase,
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'amount' => $amount,
            'sum' => $sum,
        ]);

        // Начало транзакции БД
        \DB::beginTransaction();

        $current_payment_transaction = $this->getCurrentPaymentTransaction();

        $current_payment_transaction->unblocking();

        $this->moneyBlocking($sum);

        $this->amount = $amount;

        $this->save();

        \DB::commit();
        // Окончание транзакции БД

        \App\ActionLog::action('ORDER.UPDATE.AFTER_TRANSACTION', [
            'order_id' => $this->id,
            'current_max_price_for_purchase' => $current_max_price_for_purchase,
            'purchase_id' => $this->purchase_id,
            'product_id' => $this->product_id,
            'amount' => $amount,
            'sum' => $sum,
        ]);

        return $this;
    }

    /**
     * Расход средств
     * @param $sum
     * @return \App\BusinessLogic\Models\PaymentTransaction
     */
    public function moneyExpense($sum)
    {
        return \App\BusinessLogic\Models\PaymentTransaction::makeExpense($sum, $this);
    }

    /**
     * Блокирование средств
     * @param $sum
     * @return \App\BusinessLogic\Models\PaymentTransaction
     */
    protected function moneyBlocking($sum)
    {
        return \App\BusinessLogic\Models\PaymentTransaction::makeBlocking($sum, $this);
    }
}
