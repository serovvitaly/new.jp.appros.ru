<?php namespace App\Http\Controllers\Rest;

use App\Http\Requests;
use App\Http\Controllers\Controller;

abstract class RestController extends Controller {

    public function __construct()
    {
        $this->user = \Auth::user();
    }

}
