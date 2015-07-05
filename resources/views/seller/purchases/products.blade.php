@extends('seller.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <a style="font-size: 18px" href="/seller/purchases?supplier_id={{ $purchase_model->supplier->id }}">
                    <span class="glyphicon glyphicon-menu-left"></span>
                    Поставщик: {{ $purchase_model->supplier->name }}
                </a>
                <h3 style="margin: 5px 0 25px">Закупка: {{ $purchase_model->name }}</h3>
                <ul class="nav nav-pills">
                    <li><a href="/seller/purchases/{{ $purchase_model->id }}">Основная</a></li>
                    <li class="active"><a href="/seller/purchases/products/{{ $purchase_model->id }}">Товары в закупке</a></li>
                    <li><a href="/seller/purchases/history/{{ $purchase_model->id }}">История</a></li>
                </ul>

                <div style="height: 20px"></div>

                <div class="row">
                    <!--div class="col-md-3">
                        <div style="padding: 10px 20px">
                            <?php
                            $catalog = \App\Models\CatalogModel::getRootNode()->getDescendants()->toTree();
                            ?>
                            <ul class="list-unstyled">
                                @foreach($catalog as $catalog_item)
                                <li><h5>{{ $catalog_item->name }}</h5>
                                  <ul>
                                      @foreach($catalog_item->children as $catalog_sub_item)
                                      <li><a href="#" onclick="loadCatalog({{ $catalog_sub_item->id }}); return false;">{{ $catalog_sub_item->name }}</a></li>
                                      @endforeach
                                  </ul>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div-->
                    <div class="col-md-6">
                        <div class="btn-toolbar" role="toolbar" style="padding: 10px 0;">

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default" title="Выбрать все" onclick="manipulationChoices('check-all', '#supplier-products-list')">
                                    <span class="glyphicon glyphicon-collapse-down"></span>
                                </button>
                                <button type="button" class="btn btn-default" title="Отменить все" onclick="manipulationChoices('uncheck-all', '#supplier-products-list')">
                                    <span class="glyphicon glyphicon-unchecked"></span>
                                </button>
                                <button type="button" class="btn btn-default" title="Инвертировать" onclick="manipulationChoices('invert', '#supplier-products-list')">
                                    <span class="glyphicon glyphicon-random"></span>
                                </button>
                            </div>

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-primary btn-sm" onclick="addToPurchase({{ $purchase_model->id }});">Добавить в закупку</button>
                                <button type="button" class="btn btn-default btn-sm" onclick="addAllToPurchase({{ $purchase_model->id }});">Добавить все</button>
                            </div>

                        </div>

                        <table class="table table-condensed table-striped table-hover table-bordered" id="supplier-products-list">
                            <thead>
                            <tr>
                                <th style="width: 40px">ID</th>
                                <th>Товар</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $products_models = $purchase_model->supplier->products()->paginate(30);
                            ?>

                            @foreach ($products_models as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>
                                        <label title="{{ $product->name }}" style="font-weight: normal; margin: 0">
                                            <input style="margin: 0" type="checkbox" value="{{ $product->id }}">
                                            {{ str_limit($product->name, 70) }}
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <?= $products_models->render() ?>

                    </div>
                    <div class="col-md-6">
                        <div class="btn-toolbar" role="toolbar" style="padding: 10px 0;">

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-default" title="Выбрать все" onclick="manipulationChoices('check-all', '#supplier-products-in-purchase-list')">
                                    <span class="glyphicon glyphicon-collapse-down"></span>
                                </button>
                                <button type="button" class="btn btn-default" title="Отменить все" onclick="manipulationChoices('uncheck-all', '#supplier-products-in-purchase-list')">
                                    <span class="glyphicon glyphicon-unchecked"></span>
                                </button>
                                <button type="button" class="btn btn-default" title="Инвертировать" onclick="manipulationChoices('invert', '#supplier-products-in-purchase-list')">
                                    <span class="glyphicon glyphicon-random"></span>
                                </button>
                            </div>

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-danger btn-sm">Удалить из закупки</button>
                                <button type="button" class="btn btn-default btn-sm">Удалить все</button>
                            </div>


                        </div>

                        <table class="table table-condensed table-striped table-hover table-bordered" id="supplier-products-in-purchase-list">
                            <thead>
                            <tr>
                                <th style="width: 40px">ID</th>
                                <th>Товар</th>
                                <th style="width: 80px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $product_in_purchase = $purchase_model->products()->paginate(30);
                            ?>

                            @foreach ($product_in_purchase as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>
                                        <input style="margin: 0" type="checkbox">
                                        <a href="#" onclick="openProduct({{ $product->id }}); return false;" title="{{ $product->name }}">{{ str_limit($product->name, 42) }}</a>
                                    </td>
                                    <td><a href="#" onclick="deleteProduct({{ $product->id }}); return false;">Удалить</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <?= $product_in_purchase->render() ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function addToPurchase(purchaseId){

            var productsIdsArr = [];

            $('#supplier-products-list').find('input:checked').each(function(index, item){
                productsIdsArr.push(item.value);
            });

            if (productsIdsArr.length < 1) {
                return;
            }

            $.ajax({
                url: '/seller/purchases/add-products',
                dataType: 'json',
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    purchase_id: purchaseId,
                    products_ids_arr: productsIdsArr
                },
                success: function(data){
                    window.location = window.location;
                }
            });
        }
        function addAllToPurchase(purchaseId){
            $.ajax({
                url: '/seller/purchases/add-all-products',
                dataType: 'json',
                type: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                    purchase_id: purchaseId
                },
                success: function(html){
                    //
                }
            });
        }
        function manipulationChoices(action, targetElement){
            targetElement = $(targetElement);

            switch (action) {
                case 'check-all':
                    targetElement.find('input:checkbox').prop('checked', true);
                    break;
                case 'uncheck-all':
                    targetElement.find('input:checkbox').prop('checked', false);
                    break;
                case 'invert':
                    var checkeds = targetElement.find('input:checked');
                    targetElement.find('input:checkbox').prop('checked', true);
                    checkeds.prop('checked', false);
                    break;
            }
        }
    </script>

@endsection