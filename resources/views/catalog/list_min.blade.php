<?php

$catalog_tree = \App\Models\CatalogModel::find(1)->descendants()->get()->toTree();

if (!$catalog_tree->count()) {
    return '';
}

?>

@foreach($catalog_tree as $root_item)
    <h4>{{ $root_item->name }}</h4>
    @foreach($root_item->children as $children_item)
        <li><a href="#" data-cid="{{ $children_item->id }}">{{ $children_item->name }} ({{ \App\Helpers\ProjectHelper::getProductsCountByTagId($children_item->id) }})</a></li>
    @endforeach
    <li role="separator" class="divider"></li>
@endforeach