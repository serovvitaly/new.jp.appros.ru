<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Public</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/vendor.css">
    <!--link rel="stylesheet" href="assets/public.css"-->
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-lg-12">ЗАГОЛОВОК</div>
    </div>

    <div class="row">
        <div class="col-lg-3">Каталог</div>
        <div class="col-lg-9">
            <div class="row">
                @for($i = 1; $i <= 9; $i++)
                    <div class="col-xs-6 col-lg-4">
                        <h2>Heading</h2>
                        <p>
                            Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo,
                            tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.
                            Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
                        </p>
                        <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <footer>

    </footer>

</div>

<!--script src="assets/vendor.js"></script>
<script src="assets/public.js"></script-->

</body>
</html>
