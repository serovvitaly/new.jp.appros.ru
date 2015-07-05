<?php namespace app\Http\Controllers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;

class PrivateController extends Controller
{

    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->user = \Auth::user();
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('buyer');
    }

}