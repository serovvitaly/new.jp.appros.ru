@extends('admin.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Виджеты</div>


                <div class="btn-toolbar" role="toolbar" style="padding: 10px;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editWidget">
                        Добавить виджет
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
                        @foreach ($widgets_models_arr as $widget_model)
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
                    <?= $widgets_models_arr->render() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal" id="editWidget" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Новый виджет</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="/admin/widgets/save">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label>Наименование*</label>
                        <input name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Обработчик*</label>
                        <input name="handler" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Регион*</label>
                        <input name="region" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Области видимости</label>
                        <div class="checkbox">
                            <label><input type="checkbox" name="layouts" value="admin"> admin</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="layouts" value="seller"> seller</label>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="layouts" value="buyer"> buyer</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Состояние</label>
                        <div class="checkbox">
                            <label><input type="checkbox" name="status"> Включен</label>
                        </div>
                    </div>
                    <p class="help-block">* - Обязательно для заполнения</p>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="$('#editWidget form').submit()">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>

@endsection