<?php
/**
 * @var $catalog_tree
 */

if (!$catalog_tree->count()) {
    return '';
}

?>

<div class="content-block">

    <div style="margin: 0 -20px;">
        <a href="#" onclick="return false;" class="button button-rounded button-flat-primary button-large">КАТАЛОГ ТОВАРОВ <span class="glyphicon glyphicon-menu-hamburger"></span></a>
    </div>

    <div class="list-group" style="margin: 0 -20px">
        @foreach($catalog_tree as $root_item)
            <a href="#" class="list-group-item">{{ $root_item->name }}</a>
            <div>
            @foreach($root_item->children as $children_item)
                <div><h5>{{ $children_item->name }}</h5>
                    @foreach($children_item->children as $sub_children_item)
                        <a href="">{{ $sub_children_item->name }}</a>
                    @endforeach
                </div>

            @endforeach
            </div>
        @endforeach
    </div>

</div>