<?php

/**
 * Тестирование Платежных операций
 * @author Vitaly Serov
 */
class PaymentTransactionTest extends TestCase
{
    /**
     * Поступление средств
     */
    public function testAdmission()
    {
        /**
         * @var $user \App\User
         */
        $user = \App\User::find(1);

        $payment_transaction = $user->moneyAdmission(rand(130, 680));
    }
    /**
     * Расход средств
     * @depends testAdmission
     */
    public function testExpense()
    {
        /**
         * @var $user \App\User
         */
        $user = \App\User::find(1);

        $payment_transaction = $user->moneyExpense(rand(130, 680));
    }
    /**
     * Блокирование средств
     * @depends testExpense
     */
    public function testBlocking()
    {
        /**
         * @var $user \App\User
         */
        $user = \App\User::find(1);

        $payment_transaction = $user->moneyBlocking(rand(130, 680));
    }
}