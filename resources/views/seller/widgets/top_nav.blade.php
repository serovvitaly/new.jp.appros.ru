<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="/seller">Продавец</a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="/seller/suppliers">Поставщини</a></li>
                <li><a href="/seller/products">Товары</a></li>
                <li><a href="/seller/pricing-grids">Ценовые сетки</a></li>
                <li @if(\Request::is('seller/purchases')) class="active" @endif ><a href="/seller/purchases">Закупки</a></li>
                <li><a href="/seller/prices">Управление ценами</a></li>
                <li><a href="/seller/attributes">Атрибуты</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if (Auth::guest())
                    <li><a href="/auth/login">Вход</a></li>
                    <li><a href="/auth/register">Регистрация</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/auth/logout">Выход</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>