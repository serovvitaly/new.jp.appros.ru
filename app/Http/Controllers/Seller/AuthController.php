<?php namespace App\Http\Controllers\Seller;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends SellerController {

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('seller.guest', ['except' => 'getLogout']);
    }

    public function getIndex()
    {
        return 'seller-auth-form';
    }

    public function getLogin()
    {
        return 'seller-auth-login-form';
    }
}