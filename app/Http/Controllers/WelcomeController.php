<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('welcome');
	}

    public function test()
    {
        print_r(get_loaded_extensions());

        //phpinfo();

        return;

        $result = \App\Models\NestedSets::withDepth()->having('depth', '=', 1)->get();

        return $result;

        $parent = \App\Models\NestedSets::find(1);

        \App\Models\NestedSets::create(['name' => 'Парфюмерия'], $parent);

        return;

        $node = new \App\Models\NestedSets;

        $node->name = 'hello NS';

        $node->save();

        return '';

        $catalog = \App\Helpers\CitynatureHelper::getCatalogArrayFromCsvFile( base_path('storage/app/price1.csv') );

        foreach ($catalog as $item_level_1) {

            foreach ($item_level_1['items'] as $item_level_2) {
                //
                foreach ($item_level_2['items'] as $item_level_3) {
                    //
                    foreach ($item_level_3['items'] as $item_level_4) {
                        //
                        foreach ($item_level_4 as $product) {
                            //
                        }
                    }
                }
            }

        }

        return view('test.page');
    }
}
