<?php namespace App\Widgets;

class BaseCatalog {

    public function render()
    {
        $catalog_tree = \App\Models\CatalogModel::find(1)->descendants()->get()->toTree();

        return view('catalog.widgets.side_nav', ['catalog_tree' => $catalog_tree]);
    }

} 