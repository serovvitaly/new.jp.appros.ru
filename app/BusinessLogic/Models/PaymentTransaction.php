<?php

namespace App\BusinessLogic\Models;


use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    const OPERATION_TYPE_ADMISSION  = 'admission';  // Поступление средств

    const OPERATION_TYPE_EXPENSE    = 'expense';    // Списание средств

    const OPERATION_TYPE_BLOCKING   = 'blocking';   // Блокировка средств

    const OPERATION_TYPE_UNBLOCKING = 'unblocking';  // Разблокировка средств

    const OPERATION_TYPE_ADMISSION_CODE  = 10;  // Код операции - Поступление средств

    const OPERATION_TYPE_EXPENSE_CODE    = 20;    // Код операции - Списание средств

    const OPERATION_TYPE_BLOCKING_CODE   = 30;   // Код операции - Блокировка средств

    const OPERATION_TYPE_UNBLOCKING_CODE = 40; // Код операции - Разблокировка средств

    public $table = 'payments_transactions';

    protected $fillable = ['user_id', 'order_id', 'sum', 'operation_type', 'operation_type_code'];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function order()
    {
        return $this->belongsTo('\App\BusinessLogic\Models\Order');
    }

    public function delete()
    {
        return;
    }

    /**
     * Разблокирование блокирующей транзакции
     * @throws \Exception
     */
    public function unblocking()
    {
        if ($this->operation_type !==  self::OPERATION_TYPE_BLOCKING) {
            return false;
        }

        $order = $this->order;
        \App\Helpers\Assistant::assertModel($order);

        // Начало транзакции БД
        \DB::beginTransaction();

        self::create([
            'sum' => $this->sum,
            'user_id' => $order->user->id,
            'operation_type' => self::OPERATION_TYPE_UNBLOCKING,
            'operation_type_code' => self::OPERATION_TYPE_UNBLOCKING_CODE,
            'order_id' => $order->id
        ]);

        \App\ActionLog::action('PAYMENT_TRANSACTION.UNBLOCKING', [
            'payment_transaction_id' => $this->id,
            'sum' => $this->sum,
            'user_id' => $order->user->id,
            'operation_type' => self::OPERATION_TYPE_UNBLOCKING,
            'operation_type_code' => self::OPERATION_TYPE_UNBLOCKING_CODE,
            'order_id' => $order->id
        ]);

        \DB::commit();
        // Окончание транзакции БД

        return true;
    }

    /**
     * Создание транзакции Поступление средств
     * @param double $sum
     * @param \App\User $user
     * @return \App\BusinessLogic\Models\PaymentTransaction
     */
    public static function makeAdmission($sum, \App\User $user)
    {
        \App\Helpers\Assistant::assertUserAsJson($user);

        // Начало транзакции БД
        \DB::beginTransaction();

        $payment_transaction = self::create([
            'sum' => $sum,
            'user_id' => $user->id,
            'operation_type' => self::OPERATION_TYPE_ADMISSION,
            'operation_type_code' => self::OPERATION_TYPE_ADMISSION_CODE
        ]);

        \App\ActionLog::action('PAYMENT_TRANSACTION.BLOCKING', [
            'payment_transaction_id' => $payment_transaction->id,
            'sum' => $sum,
            'user_id' => $user->id,
            'operation_type' => self::OPERATION_TYPE_ADMISSION,
            'operation_type_code' => self::OPERATION_TYPE_ADMISSION_CODE
        ]);

        \DB::commit();
        // Окончание транзакции БД

        return $payment_transaction;
    }

    /**
     * Создание транзакции Списание средств
     * @param double $sum
     * @param \App\BusinessLogic\Models\Order $order
     * @return \App\BusinessLogic\Models\PaymentTransaction
     */
    public static function makeExpense($sum, \App\BusinessLogic\Models\Order $order)
    {
        $payment_transaction = self::create([
            'sum' => $sum,
            'user_id' => $order->user->id,
            'operation_type' => self::OPERATION_TYPE_EXPENSE,
            'operation_type_code' => self::OPERATION_TYPE_EXPENSE_CODE,
            'order_id' => $order->id
        ]);

        return $payment_transaction;
    }

    /**
     * Создание транзакции Блокирование средств
     * @param double $sum
     * @param \App\BusinessLogic\Models\Order $order
     * @return \App\BusinessLogic\Models\PaymentTransaction
     */
    public static function makeBlocking($sum, \App\BusinessLogic\Models\Order $order)
    {
        // Начало транзакции БД
        \DB::beginTransaction();

        $payment_transaction = self::create([
            'sum' => $sum,
            'user_id' => $order->user->id,
            'operation_type' => self::OPERATION_TYPE_BLOCKING,
            'operation_type_code' => self::OPERATION_TYPE_BLOCKING_CODE,
            'order_id' => $order->id
        ]);

        \App\ActionLog::action('PAYMENT_TRANSACTION.BLOCKING', [
            'payment_transaction_id' => $payment_transaction->id,
            'sum' => $sum,
            'user_id' => $order->user->id,
            'operation_type' => self::OPERATION_TYPE_BLOCKING,
            'operation_type_code' => self::OPERATION_TYPE_BLOCKING_CODE,
            'order_id' => $order->id
        ]);

        \DB::commit();
        // Окончание транзакции БД

        return $payment_transaction;
    }
}