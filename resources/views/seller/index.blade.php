@extends('seller.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">

            {!! \App\Helpers\WidgetHelper::region('center_1') !!}

            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-warning">
                        <div class="panel-heading">Товары</div>
                        <div class="panel-body">
                            <a href="/seller/products">Управление товарами</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-info">
                        <div class="panel-heading">Ценовые сетки</div>
                        <div class="panel-body">
                            <a href="/seller/pricing-grids">Управление ценовыми сетками</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-success">
                        <div class="panel-heading">Закупки</div>
                        <div class="panel-body">
                            <a href="/seller/purchases">Управление закупками</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection