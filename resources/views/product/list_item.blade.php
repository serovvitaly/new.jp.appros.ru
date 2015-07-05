<?php
/**
 * @var $product_in_purchase \App\Models\ProductInPurchaseModel
 */

?>
<div class="col-sm-6 col-md-4 catalog-item">
    <div class="catalog-item-wrapper">
        <div class="catalog-item-header">
            <a href="{{ $product_in_purchase->alias() }}" title="{{ $product_in_purchase->product->name }}">
                <?php
                    $first_image_file_name = $product_in_purchase->getFirstImageFileName();
                ?>
                @if(empty($first_image_file_name))
                <span class="glyphicon glyphicon-picture empty-image"></span>
                @else
                <img alt="" src="/media/images/177x139/{{ $first_image_file_name }}">
                @endif
            </a>
        </div>
        <div class="catalog-item-body">
            <h5 class="title"><a href="{{ $product_in_purchase->alias() }}" title="{{ $product_in_purchase->product->name }}">{{ $product_in_purchase->product->name }}</a></h5>

            <h2>
                {{ $product_in_purchase->getCurrentMaxPrice() }}
                <sup style="font-size: 14px"><span class="glyphicon glyphicon-ruble" title="Рублей"></span></sup>
            </h2>

            <span class="stars-small">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
            </span>
            <?php
            $purchase = $product_in_purchase->purchase;
            ?>
            <div class="font-mini catalog-item-info">
                <!--span class="glyphicon glyphicon-user" title="Продавец" style="color: #00708e"></span> <a href="/seller/{{ $purchase->seller->id }}">{{ $purchase->seller->name }}</a><br-->
                <span class="glyphicon glyphicon-piggy-bank" title="Закупка" style="color: #00708e"></span> <a href="/zakupka/{{ $purchase->id }}">{{ $purchase->name }}</a><br>
                Завершено на {{ $purchase->getCompletedOnPercents() }}%
                <br>
                Покупателей - {{ $purchase->getParticipantsCount() }}
            </div>
        </div>
        <div class="catalog-item-footer">
            <span class="glyphicon glyphicon-eye-open"></span> {{ $product_in_purchase->getAttendance() }}
            <!--span class="glyphicon glyphicon-thumbs-up"></span-->
            <span class="glyphicon glyphicon-comment"></span> {{ $product_in_purchase->getCommentsCount() }}
        </div>
    </div>
</div>