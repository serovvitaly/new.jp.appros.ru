<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Public</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/vendor/bootstrap/css/_bootstrap.css">
    <link rel="stylesheet" href="/css/preloader.css">
</head>
<body>

<script type="text/x-handlebars" data-template-name="application">
    <h1>APPLICATION</h1>
</script>

<script type="text/x-handlebars" data-template-name="photos">
    <h1>PHOTOS</h1>
</script>

<div class="container">
    <div class="row">
        <div class="col-lg-12">ЗАГОЛОВОК</div>
    </div>
    <div class="row">
        <div class="col-lg-2">
        </div>
        <div class="col-lg-8">

            <div class="input-group input-group-lg" controller="MainTopSearchController">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" id="mainTopCategoriesListButton">Все категории <span class="caret"></span></button>
                    <div class="dropdown-menu" controller="MainTopCategoriesListController">
                        @include('catalog.list_min')
                    </div>
                </div>
                <input type="text" class="form-control" placeholder="что ищем?" autocomplete="off">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                </span>
            </div>
        </div>
        <div class="col-lg-2">
        </div>
    </div>
    <div class="row">

        <div class="col-lg-12">
            <nav class="navbar navbar-default" style="margin: 10px 0 5px">
                <div class="collapse navbar-collapse btn-group">
                    <button type="button" class="btn btn-default navbar-btn">Товары для детей</button>
                    <button type="button" class="btn btn-default navbar-btn">Товары для женщин</button>
                    <button type="button" class="btn btn-default navbar-btn">Товары для мужчин</button>
                </div>
            </nav>
        </div>

        <div class="col-lg-12">
            <nav class="navbar navbar-default" style="margin: 5px 0 10px">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">Найдено</a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <a class="btn btn-sm navbar-btn">Товары: <strong>120</strong></a>
                        <a class="btn btn-sm navbar-btn">Закупки: <strong>2</strong></a>
                        <a class="btn btn-sm navbar-btn">Популярные товары: <strong>34</strong></a>
                        <a class="btn btn-sm navbar-btn">По акции: <strong>10</strong></a>
                        <a class="btn btn-sm navbar-btn">Похожие товары: <strong>15</strong></a>
                    </div>
                </div>
            </nav>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="row" id="mainProductsListContainer" controller="ProductsListController">
            </div>
        </div>
    </div>

    <footer>

    </footer>

</div>

<script src="/vendor/jquery/jquery-2.1.4.js"></script>
<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/app/app.js"></script>

</body>
</html>