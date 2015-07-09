<?php
/**
 * @var $product_in_purchase \App\BusinessLogic\ProductInPurchase
 */

?>

<div class="col-sm-6 col-md-3">
    <div class="thumbnail" style="padding: 0">
        <a href="{{ $product_in_purchase->alias() }}" title="{{ $product_in_purchase->getProduct()->name }}">
            <?php
            $first_image_file_name = $product_in_purchase->getFirstImageFileName();
            ?>
            @if(empty($first_image_file_name))
                <img style="width: 100%" data-src="holder.js/100%x200" alt="100%x200" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjQyIiBoZWlnaHQ9IjIwMCIgdmlld0JveD0iMCAwIDI0MiAyMDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzEwMCV4MjAwCkNyZWF0ZWQgd2l0aCBIb2xkZXIuanMgMi42LjAuCkxlYXJuIG1vcmUgYXQgaHR0cDovL2hvbGRlcmpzLmNvbQooYykgMjAxMi0yMDE1IEl2YW4gTWFsb3BpbnNreSAtIGh0dHA6Ly9pbXNreS5jbwotLT48ZGVmcz48c3R5bGUgdHlwZT0idGV4dC9jc3MiPjwhW0NEQVRBWyNob2xkZXJfMTRlNjg5ZDRlNGUgdGV4dCB7IGZpbGw6I0FBQUFBQTtmb250LXdlaWdodDpib2xkO2ZvbnQtZmFtaWx5OkFyaWFsLCBIZWx2ZXRpY2EsIE9wZW4gU2Fucywgc2Fucy1zZXJpZiwgbW9ub3NwYWNlO2ZvbnQtc2l6ZToxMnB0IH0gXV0+PC9zdHlsZT48L2RlZnM+PGcgaWQ9ImhvbGRlcl8xNGU2ODlkNGU0ZSI+PHJlY3Qgd2lkdGg9IjI0MiIgaGVpZ2h0PSIyMDAiIGZpbGw9IiNFRUVFRUUiLz48Zz48dGV4dCB4PSI4OS44NTE1NjI1IiB5PSIxMDUuMSI+MjQyeDIwMDwvdGV4dD48L2c+PC9nPjwvc3ZnPg==" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
                @else
                <img style="width: 100%" alt="" src="/media/images/177x139/{{ $first_image_file_name }}">
            @endif
        </a>
        <div class="caption">
            <h4 class="title"><a href="{{ $product_in_purchase->alias() }}" title="{{ $product_in_purchase->getProduct()->name }}">{{ str_limit($product_in_purchase->getProduct()->name, 25) }}</a></h4>

            <div class="row">
                <div class="col-lg-6">
                    <span class="stars-small">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
            </span>
                </div>
                <div class="col-lg-6">
                    <span style="font-size: 22px">
                        {{ $product_in_purchase->getCurrentMaxPrice() }}
                        <sup style="font-size: 14px"><span class="glyphicon glyphicon-ruble" title="Рублей"></span></sup>
                    </span>
                </div>
            </div>

            <?php
            $purchase = $product_in_purchase->getPurchase();
            ?>
            <p class="font-mini catalog-item-info">
                <!--span class="glyphicon glyphicon-user" title="Продавец" style="color: #00708e"></span> <a href="/seller/{{ $purchase->seller->id }}">{{ $purchase->seller->name }}</a><br-->
                <span class="glyphicon glyphicon-piggy-bank" title="Закупка: {{ $purchase->name }}" style="color: #00708e"></span> <a href="/zakupka/{{ $purchase->id }}">{{ str_limit($purchase->name, 26) }}</a><br>
                Завершено на {{ $purchase->getCompletedOnPercents() }}%
                <br>
                Покупателей - {{ $purchase->getParticipantsCount() }}
            </p>
            <div class="catalog-item-footer">
                <span class="glyphicon glyphicon-eye-open"></span> {{ $product_in_purchase->getAttendance() }}
                <span class="glyphicon glyphicon-comment"></span> {{ $product_in_purchase->getCommentsCount() }}
                <div class="btn-group btn-group-justified">
                    <div class="btn-group"><a href="{{ $product_in_purchase->alias() }}" class="btn btn-default btn-sm">Подробнее</a></div>
                    <div class="btn-group"><button type="button" class="btn btn-danger btn-sm">В корзину</button></div>
                </div>
            </div>
        </div>
    </div>
</div>