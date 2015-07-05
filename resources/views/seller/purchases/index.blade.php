@extends('seller.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            $supplier_id = \Input::get('supplier_id');
            $supplier_model = null;
            if($supplier_id) {
                $supplier_model = $user->suppliers()->find($supplier_id);
                \App\Helpers\Assistant::assertModel($supplier_model);
            }
            ?>

            @if($supplier_model)
            <h3>{{ $supplier_model->name }}</h3>
            <ul class="nav nav-pills">
                <li role="presentation"><a href="/seller/suppliers/{{ $supplier_model->id }}">Основная</a></li>
                <li role="presentation"><a href="/seller/suppliers/products/{{ $supplier_model->id }}">Товары</a></li>
                <li role="presentation"><a href="/seller/suppliers/pricing-grids/{{ $supplier_model->id }}">Ценовые сетки</a></li>
                <li role="presentation" class="active"><a href="/seller/purchases?supplier_id={{ $supplier_model->id }}">Закупки</a></li>
            </ul>
            @endif

            <div class="btn-toolbar" role="toolbar" style="padding: 10px 0;">
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editProduct">
                    Добавить закупку
                </button>
            </div>

            <table class="table table-condensed table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Наименование</th>
                    @if(!$supplier_model)
                    <th>Поставщик</th>
                    @endif
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $purchases_models = $supplier_model ? $supplier_model->purchases()->paginate(50) : $user->purchases()->paginate(50);
                ?>
                @foreach ($purchases_models as $purchase_model)
                    <tr>
                        <th scope="row">{{$purchase_model->id}}</th>
                        <td>
                            <a href="/seller/purchases/{{ $purchase_model->id }}">{{ $purchase_model->name }}</a>
                            <div><small>{{ $purchase_model->description }}</small></div>
                        </td>
                        @if(!$supplier_model)
                        <td><a href="/seller/purchases?supplier_id={{ $purchase_model->supplier->id }}">{{ $purchase_model->supplier->name }}</a></td>
                        @endif
                        <td>
                            <a href="/seller/purchases/products/{{ $purchase_model->id }}" class="btn btn-info btn-xs">Товары</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <?= $purchases_models->render() ?>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="editProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Новая закупка</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="/seller/purchases/save">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Наименование</label>
                        <input class="form-control" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    @if($supplier_model)
                        <input type="hidden" name="supplier_id" value="{{ $supplier_model->id }}">
                    @else
                        <div class="form-group">
                            <label>Поставщик*</label>
                            <select class="form-control" name="supplier_id">
                                <option></option>
                                @foreach ($user->suppliers as $supplier_model)
                                    <option value="{{ $supplier_model->id }}">{{ $supplier_model->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <?php
                    $pricing_grids = \App\Models\PricingGridModel::getPricingGridsForCurrentUser();
                    ?>
                    <div class="form-group">
                        <label>Ценовая сетка</label>
                        <select class="form-control" name="pricing_grid_id">
                            <option></option>
                            @foreach ($pricing_grids as $pricing_grid)
                                <option value="{{ $pricing_grid->id }}">{{ $pricing_grid->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Колонка ценовой сетки</label>
                        <input class="form-control" name="pricing_grid_column" value="1">
                    </div>
                    <div class="form-group">
                        <label>Срок действия</label>
                        <input class="form-control" name="expiration_time" value="{{{ date('Y-m-d H:i:s', time() + 604800) }}}">
                    </div>


                    <p class="help-block">* - Обязательно для заполнения</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="$('#editProduct form').submit()">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>
@endsection