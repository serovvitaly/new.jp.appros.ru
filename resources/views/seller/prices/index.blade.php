@extends('seller.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Управление ценами</div>
                    <?php
                    $user_pricing_grids = \App\Models\PricingGridModel::where('user_id', '=', \Auth::user()->id)->get();
                    ?>
                    <div class="panel-body">
                        <div class="btn-group btn-group-sm" style="margin-right: 30px">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Каталог товаров <span style="margin-left: 10px" class="glyphicon glyphicon-th-list"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Парфюмерия</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                            </ul>
                        </div>
                        <div class="btn-group btn-group-sm" id="pricing-grid-selector">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <span class="text">Ценовая сетка</span> <span style="margin-left: 5px" class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                            @foreach ($user_pricing_grids as $pricing_grid)
                                <li><a href="#" data-id="{{ $pricing_grid['id'] }}" data-name="{{ $pricing_grid['name'] }}">{{ $pricing_grid['name'] }}</a></li>
                            @endforeach
                            </ul>
                        </div>
                        <script>
                            $('#pricing-grid-selector .dropdown-menu a').on('click', function(){
                                var self = $(this);
                                var parent = self.parents('.btn-group');
                                parent.find('button[data-toggle="dropdown"] .text').text(self.data('name'));
                                return false;
                            });
                        </script>
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
                                <tr>
                                    <th scope="row">1</th>
                                    <td>2</td>
                                    <td>3</td>
                                    <td>4</td>
                                    <td>5</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection