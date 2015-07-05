<?php

namespace App\Http\Controllers\Rest;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PaymentTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user_id
     * @return Response
     */
    public function show($user_id)
    {
        /**
         * @var $user \App\User
         */
        $user = \App\User::find($user_id);

        if (!$user) {
            return ['User not found'];
        }

        return [
            'user_id' => $user_id,
            'absolut_balance' => $user->getAbsoluteBalance(),
            'cash_balance' => $user->getCashBalance()
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
