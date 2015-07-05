@extends('seller.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Ценовые сетки</div>


                <div class="btn-toolbar" role="toolbar" style="padding: 10px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editPricingGrid">
                        Добавить
                    </button>
                </div>

                <div class="">
                    <table class="table table-condensed table-striped table-hover" style="border-bottom: 1px solid #DDD; border-top: 1px solid #DDD">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Блок</th>
                            <th>Обработчик</th>
                            <th>Регион</th>
                            <th>Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($goods_models_arr as $widget_model)
                            <tr>
                                <th scope="row">{{$widget_model->id}}</th>
                                <td>{{ $widget_model->name }}<div style="font-size: 80%">{{ $widget_model->description }}</div></td>
                                <td>{{ $widget_model->handler }}</td>
                                <td>{{ $widget_model->region }}</td>
                                <td>{{ $widget_model->status }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <?= $goods_models_arr->render() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="editPricingGrid" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Новая ценовая сетка</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="/seller/pricing-grids/save">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Наименование*</label>
                        <input name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>


                    <p class="help-block">* - Обязательно для заполнения</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="$('#editPricingGrid form').submit()">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

@endsection