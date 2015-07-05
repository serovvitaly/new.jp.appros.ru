@extends('seller.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h3>{{ $supplier_model->name }}</h3>

                <ul class="nav nav-pills">
                    <li role="presentation"@if(\Request::is('seller/suppliers/'.$supplier_model->id))  class="active"@endif>
                        <a href="/seller/suppliers/{{ $supplier_model->id }}">Основная</a>
                    </li>
                    <li role="presentation"@if(\Request::is('seller/suppliers/products/*'))  class="active"@endif>
                        <a href="/seller/suppliers/products/{{ $supplier_model->id }}">Товары</a>
                    </li>
                    <li role="presentation"@if(\Request::is('seller/suppliers/pricing-grids/*'))  class="active"@endif>
                        <a href="/seller/suppliers/pricing-grids/{{ $supplier_model->id }}">Ценовые сетки</a>
                    </li>
                    <li role="presentation"@if(\Request::is('seller/suppliers/purchases/*'))  class="active"@endif>
                        <a href="/seller/purchases?supplier_id={{ $supplier_model->id }}">Закупки</a>
                    </li>
                </ul>

                @yield('container')

            </div>
        </div>
    </div>

@endsection