@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Список заказов</div>

                {!! \App\Helpers\WidgetHelper::region('center_1') !!}

                <div class="panel-body">
                    @if(empty($purchases_ids_arr))
                        <h1>Заказов нет, сделайте свой первый заказ</h1>
                    @else
                    <div class="panel-group" id="orders-accordion" role="tablist" aria-multiselectable="true">
                    @foreach($purchases_ids_arr as $purchase_id)
                    <?php
                        $purchase_model = \App\Models\PurchaseModel::find($purchase_id);
                        \App\Helpers\Assistant::assertModel($purchase_model);
                    ?>
                        <div class="panel panel-default" id="purchasePanel-{{ $purchase_model->id }}">
                            <div class="panel-heading" role="tab" id="headingOne-{{ $purchase_model->id }}">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#orders-accordion" href="#collapseOne-{{ $purchase_model->id }}" aria-expanded="true" aria-controls="collapseOne-{{ $purchase_model->id }}" class="collapsed">
                                        <strong>{{ $purchase_model->name }}</strong>, товаров: {{ count($orders_models_arr_by_purchases_ids_arr[$purchase_id]) }}
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne-{{ $purchase_model->id }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne-{{ $purchase_model->id }}" aria-expanded="true" style="height: 0px;">
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Товар</th>
                                            <th>Цена*</th>
                                            <th>Количество</th>
                                            <th>Сумма</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orders_models_arr_by_purchases_ids_arr[$purchase_id] as $order_model)
                                        <?php
                                            $product_in_purchase_model = \App\Models\ProductInPurchaseModel::find($order_model->product_in_purchase_id);
                                            \App\Helpers\Assistant::assertModel($product_in_purchase_model);

                                            $current_max_price = $product_in_purchase_model->getMaxPrice();
                                        ?>
                                        <tr id="orderValue-{{ $order_model->id }}">
                                            <td><a href="{{ $product_in_purchase_model->alias() }}">{{ $product_in_purchase_model->product->name }}</a></td>
                                            <td class="product-price">{{ $current_max_price }}</td>
                                            <td><input type="number" style="width: 50px" data-order-id="{{ $order_model->id }}" value="{{ $order_model->amount }}"></td>
                                            <td class="total-price">{{ number_format(\App\Helpers\OrdersHelper::getTotalPrice($current_max_price, $order_model->amount), 2) }}</td>
                                            <td style="text-align: right"><button class="btn btn-xs btn-danger" onclick="destroyOrder({{ $order_model->id }});">удалить</button></td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><button class="btn btn-xs" onclick="recalculateOrdersInPurchase({{ $purchase_id }});">пересчитать</button></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function destroyOrder(orderId) {
        $.ajax({
            url: '/rest/orders/' + orderId,
            type: 'delete',
            data: {
                _token: getToken()
            }
        });
    }
    function recalculateOrdersInPurchase(purchaseId) {

        var updatedAmounts = [];

        $('#collapseOne-' + purchaseId + ' input').each(function(){
            var item = {};
            item.order_id = $(this).data('order-id');
            item.amount = $(this).val();
            if (item.amount < 1) {
                $('#orderValue-' + item.order_id).remove();
            }
            updatedAmounts.push(item);
        });

        $.ajax({
            url: '/rest/orders/' + purchaseId,
            type: 'put',
            data: {
                _token: getToken(),
                updated_amounts: updatedAmounts
            },
            success: function(data){

                if (!data.length) {
                    $('#purchasePanel-'+purchaseId).remove();
                    return;
                }

                $.each(data, function(index, item){
                    var orderValueRow = $('#orderValue-' + item.order_id);
                    orderValueRow.find('input').val(item.amount);
                    orderValueRow.find('.total-price').html(item.total_price);
                });
            }
        });
    }
</script>
@endsection