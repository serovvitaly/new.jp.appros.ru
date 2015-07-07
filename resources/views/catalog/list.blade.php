<?php

$catalog_tree = \App\Models\CatalogModel::find(1)->descendants()->get()->toTree();

if (!$catalog_tree->count()) {
    return '';
}

?>

@foreach($catalog_tree as $root_item)
    <div class="col-lg-4">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $root_item->name }}</h3>
            </div>
            <div class="panel-body">
        @foreach($root_item->children as $children_item)
            <div>
                <a href="#" data-cid="{{ $children_item->id }}">{{ $children_item->name }}</a>
                @foreach($children_item->children as $sub_children_item)
                    <a href="">{{ $sub_children_item->name }}</a>
                @endforeach
            </div>
        @endforeach
                Panel content
            </div>
        </div>
    </div>
@endforeach
