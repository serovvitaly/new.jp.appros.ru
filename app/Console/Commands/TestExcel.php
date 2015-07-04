<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use PHPExcel_Cell_DataType;

class TestExcel extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'excel';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

        $catalog = \App\Helpers\CitynatureHelper::getCatalogArrayFromCsvFile( base_path('storage/app/price1.csv') );

        $this->info('Catalog count = ' . count($catalog));

        foreach ($catalog as $item) {
            $product = new \App\Models\ProductModel;

            $product->name = $item->title;
            $product->user_id = 1;
            $product->supplier_id = 5;

            $product->save();

            $product->setAttributeById(1, $item->volume);   // weight
            $product->setAttributeById(4, $item->article);  // article

            $product->setPriceByColumnId(18, $item->price_1);
            $product->setPriceByColumnId(19, $item->price_2);
            $product->setPriceByColumnId(20, $item->price_3);
            $product->setPriceByColumnId(21, $item->price_4);

            echo '.';
        }

        echo "\n";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
