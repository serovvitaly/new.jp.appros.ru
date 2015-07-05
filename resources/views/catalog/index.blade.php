@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 container-wrapper">

                <div class="col-md-3 container-item">
                    <div class="sidebar-block">

                        {!! \App\Helpers\WidgetHelper::region('left_side') !!}

                        <div class="content-block">
                            <h5 class="content-block-title">Информация о закупке <span class="glyphicon glyphicon-question-sign"></span></h5>

                            <table class="table table-stats table-condensed table-hover">
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
                            </table>
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
                                    <td class="data-value">34</td>
                                </tr>
                                <tr>
                                    <td><span class="glyphicon glyphicon-ruble"></span></td>
                                    <td>Целевая сумма, руб.</td>
                                    <td class="data-value">50`000</td>
                                </tr>
                                <tr>
                                    <td><span class="glyphicon glyphicon-time"></span></td>
                                    <td>Время истечения</td>
                                    <td class="data-value">13.03.2015 13:30</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>

                <div class="col-md-9 container-item container-item-shadow" style="padding: 30px;">
                    <div class="row">
                        @foreach($products_in_purchases as $product_in_purchase)
                            @include('product.list_item')
                        @endforeach
                    </div>
                    <a href="#" class="button button-block button-rounded button-flat" onclick="return false;">показать еще</a>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(function(){
            //$('.carousel').carousel();

            $('[data-toggle="popover"]').popover({html : true});
        })
    </script>
@endsection
