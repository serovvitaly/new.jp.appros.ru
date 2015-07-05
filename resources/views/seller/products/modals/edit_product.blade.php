<div class="modal" id="editProduct" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Новый товар</h4>
            </div>
            <div class="modal-body">

                <div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#home" data-toggle="tab">Главная</a>
                        </li>
                        <li>
                            <a href="#attributes" data-toggle="tab">Атрибуты</a>
                        </li>
                        <li>
                            <a href="#categories" data-toggle="tab">Категории</a>
                        </li>
                        <li>
                            <a href="#prices" data-toggle="tab">Цены</a>
                        </li>
                        <li>
                            <a href="#photos" data-toggle="tab">Фотогалерея</a>
                        </li>
                    </ul>
                    <div class="tab-content" style="margin-top: 20px">
                        <div class="tab-pane in active" id="home">
                            <input type="hidden" name="id" value="">
                            <input type="hidden" name="attributes_group_id" value="{{ $attributes_group_id }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label>Наименование*</label>
                                <input name="name" class="form-control">
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
                            <div class="form-group">
                                <label>Описание</label>
                                <textarea name="description" class="form-control" rows="6"></textarea>
                            </div>
                            <p class="help-block">* - Обязательно для заполнения</p>
                        </div>
                        <div class="tab-pane" id="attributes">
                            @foreach ($attributes as $attribute)
                                <div class="form-group">
                                    <label>{{ $attribute->title }}</label>
                                    <input role="attr" name="attr_{{ $attribute->id }}" class="form-control">
                                </div>
                            @endforeach
                        </div>
                        <div class="tab-pane" id="categories">
                            <div class="form-group">
                                <label>Категории каталога</label>
                                <select multiple class="form-control" style="height: 400px" name="categories_ids">
                                    @foreach ($categories_models as $category_model)
                                        <option value="{{ $category_model->id }}">{{ $category_model->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="tab-pane" id="prices">
                        @foreach ($project->pricing_grids as $pricing_grid_model)
                            <div class="form-group">
                                <label>{{ $pricing_grid_model->name }}</label>
                                <table class="table" role="pricing_grid">
                                    <thead>
                                        <tr>
                                        @foreach ($pricing_grid_model->columns() as $column)
                                            <th>{{ $column->column_title }}</th>
                                        @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        @foreach ($pricing_grid_model->columns() as $column)
                                            <td><input style="width: 65px" name="col_{{ $column->id }}" value=""></td>
                                        @endforeach
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        @endforeach
                        </div>
                        <div class="tab-pane" id="photos">

                            <div>
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Add files...</span>
                                    <input id="fileupload" type="file" name="files[]" multiple>
                                </span>
                                <br>
                                <br>
                                <!-- The global progress bar -->
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <!-- The container for the uploaded files -->
                                <div id="files" class="files row"></div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="saveProduct();">Сохранить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            </div>
        </div>
    </div>
</div>