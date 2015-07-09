<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
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
    public function handle()
    {
        $catalog_tree = \App\Models\CatalogModel::find(1)->descendants()->get()->toTree();

        $this->line(PHP_EOL);

        $tags_ids_arr = [];
        foreach ($catalog_tree as $catalog_tree_item) {

            $children = $catalog_tree_item->children;

            if ($children->count() < 1) {
                continue;
            }

            foreach ($children as $child) {
                $tags_ids_arr[] = $child->id;
            }
        }

        $products_mix_arr = \DB::table('products')->select('id')->get();

        $products_mix_arr = array_rand($products_mix_arr, 100);

        foreach ($products_mix_arr as $product_mix) {
            \DB::table('products_tags')->insert([
                'tag_id' => $tags_ids_arr[ rand(0, count($tags_ids_arr) - 1) ],
                'product_id' => $product_mix
            ]);

            echo '.';
        }

        $this->line(PHP_EOL);
    }
}
