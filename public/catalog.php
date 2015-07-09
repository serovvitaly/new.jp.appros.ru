<?php

$filter = [];
if (array_key_exists('filter', $_GET)) {
    $filter = $_GET['filter'];
}

$search_query = '';
$category_id = 0;
if (array_key_exists('query', $filter)) {
    $search_query = trim($filter['query']);
}
if (array_key_exists('category', $filter)) {
    $category_id = intval($filter['category']);
}

$matches_ids = [];
$db = new mysqli('localhost', 'root', '123456', 'joint_purchasing');


if ($category_id) {
    $products_tags_table_resource = $db->query('SELECT product_id FROM products_tags WHERE tag_id = ' . $category_id);
    $products_ids_arr = [];
    while($product_mix = $products_tags_table_resource->fetch_assoc()) {
        $products_ids_arr[] = $product_mix['product_id'];
    }
    $matches_ids = array_merge($matches_ids, $products_ids_arr);
}


$sql = 'SELECT * FROM products_in_purchase WHERE product_id IN('.implode(',', $matches_ids).') LIMIT 0,12';
$products_in_purchases_table_resource = $db->query($sql);
if (!$products_in_purchases_table_resource->num_rows) {
    return;
}


$products_ids_arr = [];
$purchases_ids_arr = [];
$purchases_in_products_arr = [];
while ($product_in_purchase_mix = $products_in_purchases_table_resource->fetch_assoc()) {
    $products_ids_arr[] = $product_in_purchase_mix['product_id'];
    $purchases_ids_arr[] = $product_in_purchase_mix['purchase_id'];
    $purchases_in_products_arr[$product_in_purchase_mix['product_id']] = $product_in_purchase_mix['purchase_id'];
}
$purchases_ids_arr = array_unique($purchases_ids_arr);

// Собираем данные о закупках
$purchases_table_resource = $db->query('SELECT * FROM purchases WHERE id IN('.implode(',', $purchases_ids_arr).')');
$purchases_arr = [];
while ($purchase_mix = $purchases_table_resource->fetch_assoc()) {
    $purchases_arr[$purchase_mix['id']] = $purchase_mix;
}

// Собираем картинки для продуктов
$products_images_table_resource = $db->query('SELECT * FROM media WHERE product_id IN('.implode(',', $products_ids_arr).') ORDER BY `position` GROUP BY product_id');
$products_images_arr = [];
if ($products_images_table_resource->num_rows) {
    while ($product_image = $products_images_table_resource->fetch_assoc()) {
        $products_images_arr[$product_image['product_id']] = $product_image['file_name'];
    }
}


$products_table_resource = $db->query('SELECT * FROM products WHERE id IN('.implode(',', $products_ids_arr).')');

while ($product_mix = $products_table_resource->fetch_assoc()) {
    ?>
    <div class="col-sm-6 col-md-3">
        <div class="thumbnail">
            <a href="{{ $product_in_purchase->alias() }}" title="{{ $product_in_purchase->getProduct()->name }}">
                <?php
                $purchase_id =  $purchases_in_products_arr[$product_mix['id']];
                $first_image_file_name = isset($products_images_arr[$product_mix['id']]) ? $products_images_arr[$product_mix['id']] : null;
                if(empty($first_image_file_name)) {
                ?>
                <img data-src="holder.js/100%x200" alt="100%x200" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTRlNjg5ZDRlNGUgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNGU2ODlkNGU0ZSI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44NTE1NjI1IiB5PSIxMDUuMSI+MjQyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
                <?php } else { ?>
                <img style="height: 200px" alt="" src="/media/images/177x139/<?= $first_image_file_name ?>">
                <?php } ?>
            </a>
            <div class="caption">
                <h3 class="title"><a href="/product-<?= $product_mix['id'] ?>_<?= $purchase_id ?>" title="<?= $product_mix['name'] ?>"><?= $product_mix['name'] ?></a></h3>
                <p>
                <h2>
                    <?php
                    //$product_in_purchase->getCurrentMaxPrice()
                    ?>
                    <sup style="font-size: 14px"><span class="glyphicon glyphicon-ruble" title="Рублей"></span></sup>
                </h2>

        <span class="stars-small">
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
        </span>
                </p>
                <?php
                $purchase = $purchases_arr[$purchase_id];
                $completed_on_percents = ''; // $purchase->getCompletedOnPercents()
                $participants_count = ''; // $purchase->getParticipantsCount()
                $comments_count = ''; // $product_in_purchase->getCommentsCount()
                ?>
                <p class="font-mini catalog-item-info">
                    <span class="glyphicon glyphicon-piggy-bank" title="Закупка: <?= $purchase['name'] ?>" style="color: #00708e"></span> <a href="/zakupka/<?= $purchase_id ?>"><?= $purchase['name'] ?></a><br>
                    Завершено на <?= $completed_on_percents ?>%
                    <br>
                    Покупателей - <?= $participants_count ?>
                </p>
                <p class="catalog-item-footer">
                    <span class="glyphicon glyphicon-eye-open"></span> <?= $attendance ?>
                    <span class="glyphicon glyphicon-comment"></span> <?= $comments_count ?>
                </p>
            </div>
        </div>
    </div>
    <?php
}
