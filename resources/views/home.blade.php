@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
                {!! \App\Helpers\WidgetHelper::region('center_1') !!}
			</div>
		</div>
		<div class="col-md-9">
            <div class="col-md-5">
                <div class="panel panel-default" style="text-align: center">
                    <img src="http://pi1.lmcdn.ru/img320x461/R/E/RE883EGEGT74_1_v1.jpg" alt="">
                    <div>
                        миникартинки
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-wrapper">
                        <span style="font-size: 27px; line-height: 23px;">Олимпийка EUROPA TT <img src="/img/stars_110.png"></span>
                        <h4>adidas Originals</h4>
                        <p></p>
                        <p>
                            Олимпийка от adidas Originals выполнена из текстиля и декорирована тремя полосками на рукавах.
                            Детали: сетчатая подкладка, воротник-стойка, карманы на потайной молнии, эластичные манжеты, застежка на молнию.
                        </p>

                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h5 class="panel-title" style="font-weight: bold">
                                    Выгодные закупки по этому товару:<br>
                                    <span style="font-size: 12px; font-weight: normal">Список более выгодных закупок для этого товара</span>
                                </h5>
                            </div>
                            <div class="panel-body">
                                <div style="margin: 0 0 20px">
                                    <p><a href="#">Олимпийка EUROPA TT</a> - 3 420 руб.<br>
                                        <span style="font-size: 11px">Продавец: <a href="#">Хороший магазин товаров</a></span>
                                    </p>
                                    <div class="progress" style="height: 8px; margin: 3px 0 0">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width: 84%"></div>
                                    </div>
                                    <span style="font-size: 11px">
                                        <a href="#">Закупка парфюмерии на сумму 50000руб.</a><br>
                                        Закупка завершена на 84%, покупателей - 13, интенсивность - <span class="label label-danger" style="font-size: 10px">быстрая</span>
                                    </span>
                                </div>
                                <div style="margin: 0 0 20px">
                                    <p><a href="#">Олимпийка EUROPA TT</a> - 3 420 руб.<br>
                                        <span style="font-size: 11px">Продавец: <a href="#">Хороший магазин товаров</a></span>
                                    </p>
                                    <div class="progress" style="height: 8px; margin: 3px 0 0">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width: 34%"></div>
                                    </div>
                                    <span style="font-size: 11px">
                                        <a href="#">Закупка парфюмерии на сумму 50000руб.</a><br>
                                        Закупка завершена на 84%, покупателей - 13, интенсивность - <span class="label label-danger" style="font-size: 10px">быстрая</span>
                                    </span>
                                </div>
                                <div style="margin: 0 0 0px">
                                    <p><a href="#">Олимпийка EUROPA TT</a> - 3 420 руб.<br>
                                        <span style="font-size: 11px">Продавец: <a href="#">Хороший магазин товаров</a></span>
                                    </p>
                                    <div class="progress" style="height: 8px; margin: 3px 0 0">
                                        <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width: 64%"></div>
                                    </div>
                                    <span style="font-size: 11px">
                                        <a href="#">Закупка парфюмерии на сумму 50000руб.</a><br>
                                        Закупка завершена на 84%, покупателей - 13, интенсивность - <span class="label label-danger" style="font-size: 10px">быстрая</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <a href="#">Посмотреть все закупки по данному товару</a>

                        <div class="alert alert-warning" role="alert">
                            <strong>Внимание!</strong> Лучше посмотрите, что-то здесь не в порядке.
                        </div>

                        <div>
                            <span class="label label-danger">Опасность</span>
                            <span class="label label-danger">Опасность</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="">
                            <a href="#set" id="set-tab" role="tab" data-toggle="tab" aria-controls="set" aria-expanded="true">
                                Характеристики
                            </a>
                        </li>
                        <li role="presentation" class="active">
                            <a href="#home" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                Отзывы
                            </a>
                        </li>
                        <li role="presentation" class="">
                            <a href="#profile" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile" aria-expanded="false">
                                Обсуждения
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="set" aria-labelledby="set-tab">
                            <table class="table" style="width: 50%">
                                <tbody>
                                <tr><th class="product-content__th">Параметры модели</th><td>83-64-92 </td></tr>
                                <tr><th class="product-content__th">Состав</th><td>Хлопок - 52%, Полиэстер - 48% </td></tr>
                                <tr><th class="product-content__th">Материал подкладки</th><td>Полиэстер - 100% </td></tr>
                                <tr><th class="product-content__th">Длина по спинке</th><td>60 см</td></tr>
                                <tr><th class="product-content__th">Длина рукава</th><td>60 см</td></tr>
                                <tr><th class="product-content__th">Цвет</th><td>розовый </td></tr>
                                <tr><th class="product-content__th">Сезон</th><td>Мульти </td></tr>
                                <tr><th class="product-content__th">Коллекция</th><td>Весна-лето </td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade active in" id="home" aria-labelledby="home-tab">
                            <div class="comment-item">
                                <ul class="media-list">
                                    <li class="media">
                                        <a class="media-left" href="#">
                                            <img width="50" height="50" src="http://cs421320.vk.me/v421320600/dd16/L0_MNmRYFCo.jpg">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">Ирина Завалова</h4>
                                            <img src="/img/stars_80.png"> 24 декабря 2014
                                        </div>
                                    </li>
                                </ul>
                                <p>
                                    <strong>Достоинства</strong> - Компактный
                                    -Высокая(заявленная) автономность
                                    -Отличный сочный/чёткий FHD экран.
                                    -Отлично ловит LTE и/или WI-FI.
                                    Полноценная W8.1, работает шустро.
                                    Бесплатный Office 365(на 1 планшет + 1 ПК/MAC), активируется на одну учётку.
                                    ИМХО, презентабельный внешний вид.
                                    Нормальный звук через колонки.
                                    Приятный материал задней крышки
                                </p>
                                <p>
                                    <strong>Недостатки</strong>
                                    MicroUSB и только 1 :(
                                    Внешнему(пассивному) винту на 1 gb(WD Passport 2,5``) не хватило питания
                                    Зарядка через тот же единственный порт microUSB
                                    Отключил автоподсветку экрана(проблема скорее всего софтовая, жду обновления)
                                </p>
                                <p>
                                    <strong>Общие впечатления</strong>
                                    В целом, создаёт приятное впечатление. Сразу докупил кабель OTG(MicroUSB->USB), USB тройник, беспроводную мышь(ес-но Logitech) и конечно 64 GB micro SDXC. Для удалённой работы(например через VPN, в SAP GUI:) - один из лучших вариантов. На использование для игр - не рассчитываю, а как рабочая лошадка - рекомендую.
                                    P.S.: Тоже успел урвать до подорожания(за 26,5)
                                </p>
                            </div>
                            <div class="comment-item">
                                <ul class="media-list">
                                    <li class="media">
                                        <a class="media-left" href="#">
                                            <img width="50" height="50" src="http://cs421320.vk.me/v421320600/dd16/L0_MNmRYFCo.jpg">
                                        </a>
                                        <div class="media-body">
                                            <h4 class="media-heading">Ирина Завалова</h4>
                                            <img src="/img/stars_80.png"> 24 декабря 2014
                                        </div>
                                    </li>
                                </ul>
                                <p>
                                    <strong>Достоинства</strong> - Компактный
                                    -Высокая(заявленная) автономность
                                    -Отличный сочный/чёткий FHD экран.
                                    -Отлично ловит LTE и/или WI-FI.
                                    Полноценная W8.1, работает шустро.
                                    Бесплатный Office 365(на 1 планшет + 1 ПК/MAC), активируется на одну учётку.
                                    ИМХО, презентабельный внешний вид.
                                    Нормальный звук через колонки.
                                    Приятный материал задней крышки
                                </p>
                                <p>
                                    <strong>Недостатки</strong>
                                    MicroUSB и только 1 :(
                                    Внешнему(пассивному) винту на 1 gb(WD Passport 2,5``) не хватило питания
                                    Зарядка через тот же единственный порт microUSB
                                    Отключил автоподсветку экрана(проблема скорее всего софтовая, жду обновления)
                                </p>
                                <p>
                                    <strong>Общие впечатления</strong>
                                    В целом, создаёт приятное впечатление. Сразу докупил кабель OTG(MicroUSB->USB), USB тройник, беспроводную мышь(ес-но Logitech) и конечно 64 GB micro SDXC. Для удалённой работы(например через VPN, в SAP GUI:) - один из лучших вариантов. На использование для игр - не рассчитываю, а как рабочая лошадка - рекомендую.
                                    P.S.: Тоже успел урвать до подорожания(за 26,5)
                                </p>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                            Список обсуждений
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-md-3">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-wrapper">
                        <span style="font-size: 40px; line-height: 33px;">3 990 руб.</span>
                        <p style="padding: 5px 0">
                            <button class="btn btn-danger">В КОРЗИНУ</button>
                            <span style="padding-left: 10px">
                                <a href="#">Сравнить</a><br>
                                <a href="#">В закладки</a>
                            </span>
                        </p>
                        <p>Продавец: <br><a href="#">Хороший магазин товаров</a><br><img src="/img/stars_80_red.png"></p>
                        <p><strong>Информация о закупке</strong></p>
                        <p>Целевая сумма: 50 000 руб.</p>
                        <p>Закупка завершена на: 84%</p>

                        <div class="progress">
                            <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="84" aria-valuemin="0" aria-valuemax="100" style="width: 84%"></div>
                        </div>

                        <p>Срок истечения: 25 марта 2015 в 22.10 </p>
                        <p><a href="/zakupka/23456" class="btn btn-default btn-sm">Подробная информация о <strong>закупке</strong></a></p>

                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h5 class="panel-title">Название панели</h5>
                            </div>
                            <div class="panel-body">Содержимое панели</div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-wrapper">
                        панель
                    </div>
                </div>
            </div>
		</div>
	</div>
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
@endsection
