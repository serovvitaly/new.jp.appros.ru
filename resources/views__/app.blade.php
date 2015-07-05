<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Laravel</title>

    <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700&subset=cyrillic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=PT+Serif:400,400italic&subset=cyrillic' rel='stylesheet' type='text/css'>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="/css/app_bootstrap.css">
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css"-->
    <!-- Optional theme -->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css"-->
    <link rel="stylesheet" href="/public/buttons/css/buttons.css">
    <link rel="stylesheet" href="//www.fuelcdn.com/fuelux/3.6.3/css/fuelux.min.css">
    <link rel="stylesheet" href="/css/app.css">

    <script src="http://yastatic.net/jquery/2.1.3/jquery.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <script>
        var __TOKEN__ = '{{ csrf_token() }}';
        function getToken(){
            return __TOKEN__;
        }
        function updateToken(success){
            $.get('/rest/token', function(res){
                __TOKEN__ = res._token;
                success();
            });
        }
    </script>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-2">LOGO</div>
            <div class="col-md-5">LOGO</div>
            <div class="col-md-5">
                <a href="#" class="button button-rounded button-flat button-small">Главная</a>
                <a href="#" class="button button-rounded button-flat button-small">Доставка</a>
                <a href="#" class="button button-rounded button-flat button-small">Оплата</a>
                <a href="#" class="button button-rounded button-flat button-small">Личный кабинет</a>
            </div>
        </div>
    </div>

	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav nav-pills">
					<li><a href="/">Home</a></li>
					<li><a href="/">Оплата</a></li>
					<li class="active"><a href="/">Доставка</a></li>
					<li><a href="/">Правила</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="/auth/login">Login</a></li>
						<li><a href="/auth/register">Register</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="glyphicon glyphicon-shopping-cart"></span> {{ \App\Helpers\BasketHelper::getBasketContentMini() }}
                                <span style="padding: 3px 10px"></span>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/orders">Список заказов</a></li>
								<li><a href="/orders">Избранное</a></li>
                                <li role="separator" class="divider"></li>
								<li><a href="/auth/logout">Выход</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

    <div class="container">

        @yield('content')

        <div class="row">
            <div class="col-md-12">
                <p>
                    Описание товара носит информационный характер и может отличаться от описания,
                    представленного в технической документации производителя.
                    Рекомендуем при покупке проверять наличие желаемых функций и характеристик.
                    Вы можете сообщить о неточности в описании товара — выделите её и нажмите
                </p>
            </div>
        </div>

    </div>

	<!-- Scripts -->
    <script src="/public/jquery/jquery.loadTemplate-1.4.5.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="//www.fuelcdn.com/fuelux/3.6.3/js/fuelux.min.js"></script>
    <script src="/front/app.js"></script>
</body>
</html>
