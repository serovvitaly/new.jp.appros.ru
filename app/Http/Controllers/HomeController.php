<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		return view('index');
	}

}
