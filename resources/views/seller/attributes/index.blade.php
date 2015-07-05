@extends('seller.layout')

@section('content')
    <?php

    $attributes_groups = \App\Helpers\ProjectHelper::getAttributesGroups();

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Группы атрибутов</div>
                    <div class="panel-body">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#editAttributesGroup">
                                Добавить группу атрибутов
                            </button>
                        </div>
                    </div>

                    <div class="">
                        <table class="table table-condensed table-striped table-hover" style="border-bottom: 1px solid #DDD; border-top: 1px solid #DDD">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Наименование группы</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($attributes_groups as $attributes_group)
                                <tr>
                                    <td>{{ $attributes_group->id }}</td>
                                    <td><a href="/seller/attribute-group/{{ $attributes_group->id }}">{{ $attributes_group->name }}</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal" id="editAttributesGroup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Новая группа атрибутов</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="/seller/attributes/save-group">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <label>Наименование*</label>
                            <input name="name" class="form-control">
                        </div>
                        <p class="help-block">* - Обязательно для заполнения</p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="$('#editAttributesGroup form').submit()">Сохранить</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                </div>
            </div>
        </div>
    </div>
@endsection