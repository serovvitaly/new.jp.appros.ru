<?php

namespace App\Http\Controllers;

use App\Http\Requests;

class HomeController extends Controller
{
    /**
     * @return Response
     */
    public function getIndex()
    {
        $user = app('BusinessLogic')->getUser();

        return 'home-'.$user;
    }

}
