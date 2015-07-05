@extends('seller.suppliers.wrapper')

@section('container')

    <?php

    $project_id = 1;

    $project = \App\Models\ProjectModel::find($project_id);

    $categories_models = \App\Helpers\ProjectHelper::getCategoriesByProjectId($project_id);

    $attributes_group_id = \App\Helpers\ProjectHelper::getDefaultAttributesGroupId();

    $attributes = \App\Models\AttributeModel::where('attribute_group_id', '=', $attributes_group_id)->get();
    ?>

    <div class="btn-toolbar" style="padding: 10px 0;">
        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#editProduct">
            Добавить товар
        </button>
    </div>

    <table class="table table-condensed table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th colspan="2">Товар</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($goods_models_arr as $product)
            <tr>
                <th>{{ $product->id }}</th>
                <th style="width: 34px">
                    <div class="btn-group btn-group-xs">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-menu-hamburger"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" onclick="openProduct({{ $product->id }}); return false;">Редактировать</a></li>
                            <li class="divider"></li>
                            <li><a href="#" onclick="deleteProduct({{ $product->id }}); return false;">Удалить</a></li>
                        </ul>
                    </div>
                </th>
                <td><a href="#" onclick="openProduct({{ $product->id }}); return false;">{{ $product->name }}</a></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <?= $goods_models_arr->render() ?>

    <!-- Modals -->
    @include('seller.products.modals.edit_product')

    <!-- Scripts -->
    <script>
        function deleteProduct(product_id) {
            if (!confirm('При удалении продукта, будут удалены все связанные с ним данные. Продолжить?')) {
                return;
            }

            $.get('/seller/product/delete/' + product_id, function(){
                window.location = window.location;
            });
        }
        function openProduct(product_id){
            var modal = $('#editProduct');

            $.get('/seller/product/' + product_id, function(data){

                modal.find('[name="id"]').val(data.id);
                modal.find('[name="name"]').val(data.name);
                modal.find('[name="description"]').val(data.description);

                modal.find('[role="attr"]').each(function(){
                    if (data.attributes[this.name]) {
                        this.value = data.attributes[this.name];
                    }
                });

                $.each(data.categories_ids, function(index, item){
                    modal.find('[name="categories_ids"] [value="'+item+'"]').attr('selected', 'selected');
                });

                $.each(data.prices, function(index, item){
                    modal.find('[role="pricing_grid"] input[name="col_'+item.column_id+'"]').val(item.price);
                });

                $.each(data.images, function(index, item){
                    var box = '<div id="product-media-'+item.id+'" class="col-lg-3" style="margin-bottom: 5px; text-align: center">'+
                            '<img src="/media/images/100x100/'+item.file_name+'" alt="" class="img-thumbnail" style="width:100%;">'+
                            '<br><button class="btn btn-link btn-xs" onclick="removeImage('+item.id+');">удалить</button>'+
                            '</div>';
                    modal.find('#files').append(box);
                });

                modal.modal('show');
            });
        }
        function saveProduct(){
            var modal = $('#editProduct');

            var attributes = {};
            modal.find('[role="attr"]').each(function(){
                attributes[this.name] = this.value;
            });

            var prices = {};
            modal.find('[role="pricing_grid"] input').each(function(){
                prices[this.name] = this.value;
            });

            $.post('/seller/products/save', {
                id: modal.find('[name="id"]').val(),
                supplier_id: modal.find('[name="supplier_id"]').val(),
                name: modal.find('[name="name"]').val(),
                description: modal.find('[name="description"]').val(),
                project_id: '{{ $project_id }}',
                attributes_group_id: '{{ $attributes_group_id }}',
                _token: '{{ csrf_token() }}',
                attributes: attributes,
                categories_ids: modal.find('[name="categories_ids"]').val(),
                prices: prices
            }, function(data){
                modal.modal('hide');
                window.location = window.location;
            });
        }

        function removeImage(id){
            $.get('/seller/media/remove/'+id, function(data){
                if (data.success != true) {
                    return;
                }
                $('#product-media-'+id).remove();
            }, 'json');
        }

        $(document).ready(function(){
            $('#editProduct').on('hidden.bs.modal', function (e) {
                var modal = $('#editProduct');
                modal.find('[name="id"]').val('');
                modal.find('[name="name"]').val('');
                modal.find('[name="description"]').val('');
                modal.find('[role="attr"]').val('');
                modal.find('[role="pricing_grid"] input').val('');
                modal.find('#files').html('');
                modal.find('[name="categories_ids"] option').attr('selected', null);
            });

            $('#fileupload')
                    .fileupload({
                        url: '/seller/media/upload',
                        dataType: 'json',
                        autoUpload: true,
                        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                        maxFileSize: 5000000, // 5 MB
                        disableImageResize: /Android(?!.*Chrome)|Opera/
                                .test(window.navigator.userAgent),
                        previewMaxWidth: 100,
                        previewMaxHeight: 100,
                        previewCrop: true
                    })
                    .bind('fileuploadsubmit', function (e, data) {
                        data.formData = {
                            product_id: $('#editProduct input[name="id"]').val(),
                            _token: '{{ csrf_token() }}'
                        };
                    })
                    .bind('fileuploaddone', function (e, data) {
                        var box = '<div id="product-media-'+data.result.id+'" class="col-lg-3" style="margin-bottom: 5px; text-align: center">'+
                                '<img src="/media/images/100x100/'+data.result.file_name+'" alt="" class="img-thumbnail" style="width:100%;">'+
                                '<br><button class="btn btn-link btn-xs" onclick="removeImage('+data.result.id+');">удалить</button>'+
                                '</div>';
                        $('#editProduct #files').append(box);
                    })
        });

    </script>

@endsection