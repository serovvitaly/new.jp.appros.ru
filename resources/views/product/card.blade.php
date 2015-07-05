@extends('app')

@section('content')
    <?php
    /**
     * @var $product_in_purchase \App\Models\ProductInPurchaseModel
     */
    //$product = $product_in_purchase->product;

    $product_images = $product->media('image')->get();
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12 container-wrapper">
                <div class="col-md-8 container-item container-item-shadow">
                    <div class="row product-info">
                        <div class="col-md-5">
                            <div style="text-align: center; padding: 10px;">
                                <div id="carousel-images-gallery" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carousel-images-gallery" data-slide-to="0" class="active"></li>
                                        @for($im = 1; $im <= ($product_images->count() - 1); $im++)
                                            <li data-target="#carousel-images-gallery" data-slide-to="{{ $im }}" class=""></li>
                                        @endfor
                                    </ol>
                                    <div class="carousel-inner" role="listbox">
                                        @foreach($product_images as $key => $image)
                                            <div class="item @if ($key == 0) active @endif">
                                                <img alt="" src="/media/images/294x435/{{ $image->file_name }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="left carousel-control" href="#carousel-images-gallery" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-images-gallery" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div>
                                <div style="padding: 10px 20px 10px 10px">
                                    <h1 style="font-size: 27px; line-height: 23px; margin-top: 0; font-weight: bold;">{{ $product->name }}</h1>
                                    <p>
                                        <span class="product-stars">
                                            <span class="glyphicon glyphicon-star"></span>
                                            <span class="glyphicon glyphicon-star"></span>
                                            <span class="glyphicon glyphicon-star"></span>
                                            <span class="glyphicon glyphicon-star-empty"></span>
                                            <span class="glyphicon glyphicon-star-empty"></span>
                                        </span>
                                    </p>
                                    <h4><a href="#">{{ $product->attr('brand') }}</a> ({{ $product->attr('country') }})</h4>
                                    <p>Объем: {{ $product->attr('weight') }}</p>
                                    <p class="truncate" style="height: 110px">{{ $product->description }}</p>

                                    <div class="row" style="margin: 5px 0 10px">
                                        <div class="col-md-4">
                                            <a href="#" class="button button-rounded button-flat button-small">подробнее</a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="#"><span class="glyphicon glyphicon-paperclip"></span> в избранное</a>
                                        </div>
                                        <!--div class="col-md-4">
                                            <a href="#"><span class="glyphicon glyphicon-duplicate"></span> к сравнению</a>
                                        </div-->
                                    </div>

                                    <div class="row" style="margin: 20px 0 30px; color: #9B9B9B">
                                        <div class="col-md-4">
                                            <span class="glyphicon glyphicon-eye-open"></span> Просмотры: {{ $product_in_purchase->getAttendance() }}
                                        </div>
                                        <div class="col-md-4">
                                            <span class="glyphicon glyphicon-thumbs-up"></span> Рекомендации: 5
                                        </div>
                                        <div class="col-md-4">
                                            <span class="glyphicon glyphicon-comment"></span> Комментарии: {{ $product_in_purchase->getCommentsCount() }}
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6" style="text-align: center">
                                            <div style="font-size: 35px; padding: 0; line-height: 34px;">
                                                {{ $product_in_purchase->getCurrentMaxPrice() }}
                                                <sup style="font-size: 20px"><span class="glyphicon glyphicon-ruble" title="Рублей"></span></sup>
                                            </div>
                                            <a href="#" style="font-size: 12px; color: #DB3232;">как формируются цены?</a>
                                        </div>

                                        <div class="col-md-6" style="text-align: right">
                                            @if(Auth::user())
                                                <button class="button button-rounded button-flat-caution" style="padding: 2px 12px;" onclick="productAddToBasket('{{ $product_in_purchase->getProductId() }}', '{{ $product_in_purchase->getPurchaseId() }}');">
                                            @else
                                                <button class="button button-rounded button-flat-caution" style="padding: 2px 12px;" onclick="mustAuthorize();">
                                            @endif
                                                <span class="glyphicon glyphicon-shopping-cart"></span>
                                                ДОБАВИТЬ В КОРЗИНУ
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            Закупка завершается {{ \App\Helpers\DateHelper::getDateAgoStr($product_in_purchase->purchase->expiration_time) }}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="middle-block">
                                @include('product.widgets.carousel_similar_offers')
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            @include('product.widgets.comments',  ['target_id' => $product_in_purchase->id, 'target_type' => \App\Models\CommentModel::TARGET_TYPE_PRODUCT_IN_PURCHASE])
                            {!! \App\Helpers\WidgetHelper::region('product_bottom', 'buyer') !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 container-item">
                    <div class="sidebar-block">
                        <div class="content-block">
                            <div class="alert alert-warning alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                <strong>Как работать с закупками?</strong><br>
                                Если Вы впервые совершаете совместную покупку и не знакомы с процессом заказа, то рекомендуем
                                <br><a href="#">ознакомиться с документацией</a>.
                            </div>
                            <!--h5 class="content-block-title">Информация о закупке <span class="glyphicon glyphicon-question-sign"></span></--h5>

                            <table-- class="table table-stats table-condensed table-hover">
                                <tr>
                                    <td style="width: 22px"><span class="glyphicon glyphicon-eye-open"></span></td>
                                    <td>Просмотры</td>
                                    <td class="data-value">250</td>
                                </tr>
                                <tr>
                                    <td><span class="glyphicon glyphicon-thumbs-up"></span></td>
                                    <td>Рекомендации</td>
                                    <td class="data-value">10</td>
                                </tr>
                                <tr>
                                    <td><span class="glyphicon glyphicon-comment"></span></td>
                                    <td>Комментарии</td>
                                    <td class="data-value">12</td>
                                </tr>
                            </table-->
                        </div>
                        <div class="content-block">
                            <h5 class="content-block-title">
                                Текущее состояние закупки
                                <span class="glyphicon glyphicon-question-sign" data-container="body" data-toggle="popover" data-placement="left" data-content="Справочная информация, описывающая раздел.<a href=&#34;#&#34; onclick=&#34;alert('hello');&#34;>ссылка</a>" title="Текущее состояние закупки"></span>
                            </h5>

                            <table class="table table-stats table-condensed table-hover">
                                <tr>
                                    <td style="width: 22px"><span class="glyphicon glyphicon-user"></span></td>
                                    <td>Участники</td>
                                    <td class="data-value">{{ $product_in_purchase->purchase->getParticipantsCount() }}</td>
                                </tr>
                                <tr>
                                    <td><span class="glyphicon glyphicon-ruble"></span></td>
                                    <td>Целевая сумма, руб.</td>
                                    <td class="data-value">{{ $product_in_purchase->purchase->minimum_total_amount }}</td>
                                </tr>
                                <tr>
                                    <td><span class="glyphicon glyphicon-time"></span></td>
                                    <td>Время истечения</td>
                                    <td class="data-value">{{ $product_in_purchase->purchase->expiration_time }}</td>
                                </tr>
                            </table>

                        </div>
                        <div class="content-block">
                            <h5 class="content-block-title">Таблица цен <span class="glyphicon glyphicon-question-sign"></span></h5>

                            <table class="table table-stats table-condensed table-hover">
                                <tbody>
                                @foreach(\App\Helpers\PurchaseHelper::getPricingGridMixForProduct($product->id, $purchase->id) as $pricing_grid_mix)
                                    <tr>
                                        <td>
                                            {{ $pricing_grid_mix['title'] }}
                                            <br><span style="font-size: 12px">Срок истечения: {{ $pricing_grid_mix['expiry_date'] }}</span>
                                            <div class="progress" style="height: 8px; margin: 3px 0 0">
                                                <div class="progress-bar progress-bar-danger progress-bar-striped"
                                                     role="progressbar" aria-valuenow="84" aria-valuemin="0"
                                                     aria-valuemax="100" style="width: 84%"></div>
                                            </div>
                                        </td>
                                        <td class="data-value">{{ $pricing_grid_mix['price'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="content-block">
                            <a href="/zakupka/{{ $product_in_purchase->purchase->id }}" class="button button-rounded button-flat button-small"><span class="glyphicon glyphicon-link"></span> Перейти к закупке</a>
                            <!--p><span class="glyphicon glyphicon-link"></span> <a href="#">http://exsemple.com/product-10</a></p-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="modalAuthorization" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Авторизация / Регистрация</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal" role="form" method="POST" action="/auth/login">
                        <input type="hidden" name="_token" value="tNsSLCkoEGPUMlKitZxSM28vdjX5dS2Eet325VsK">

                        <div class="form-group">
                            <label class="col-md-4 control-label">E-Mail Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                                    Login
                                </button>

                                <a href="/password/email">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Вход / регистрация</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        function mustAuthorize(){
            $('#modalAuthorization').modal('show');
        }

        function productAddToBasket(productId, purchaseId){
            $.ajax({
                url: '/rest/basket',
                dataType: 'json',
                type: 'post',
                data: {
                    _token: __TOKEN__,
                    product_id: productId,
                    purchase_id: purchaseId
                },
                success: function(data){
                    console.log(data);
                },
                error: function(response){
                    switch (response.status) {
                        case 403:
                            mustAuthorize();
                            break;
                        case 500:
                            updateToken(function(){
                                productAddToBasket(productId, purchaseId);
                            });
                            break;
                    }
                }
            });
        }

        $(function(){
            //$('.carousel').carousel();

            $('[data-toggle="popover"]').popover({html : true});
        })
    </script>
@endsection
