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
                    <li class="active"><a href="/seller/purchases/{{ $purchase_model->id }}">Основная</a></li>
                    <li><a href="/seller/purchases/products/{{ $purchase_model->id }}">Товары</a></li>
                    <li><a href="/seller/purchases/history/{{ $purchase_model->id }}">История</a></li>
                </ul>

                <form method="post" action="/seller/purchases/save" style="margin-top: 30px">
                    <input name="_token" value="79Du0Uoi474PdjsKp6WwB2zcnxGirlSl92f1x6yh" type="hidden">
                    <div class="form-group">
                        <label>Наименование*</label>
                        <input class="form-control" name="name" value="{{ $purchase_model->name }}">
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" class="form-control" rows="2">{{ $purchase_model->description }}</textarea>
                    </div>
                    <input name="supplier_id" value="4" type="hidden">
                    <div class="form-group">
                        <label>Ценовая сетка</label>
                        <select class="form-control" name="pricing_grid_id">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Колонка ценовой сетки</label>
                        <input class="form-control" name="pricing_grid_column" value="1">
                    </div>
                    <div class="form-group">
                        <label>Срок действия</label>
                        <input class="form-control" name="expiration_time" value="2015-04-21 00:56:12">
                    </div>


                    <p class="help-block">* - Обязательно для заполнения</p>
                </form>

            </div>
        </div>
    </div>

@endsection