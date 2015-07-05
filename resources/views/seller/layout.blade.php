<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <!-- Optional theme -->
    <!--link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css"-->
    <link href="//www.fuelcdn.com/fuelux/3.6.3/css/fuelux.min.css" rel="stylesheet">
    <style>
        body{
            font-family: arial;
            font-size: 13px;
        }
    </style>

    <script src="http://yastatic.net/jquery/2.1.3/jquery.min.js"></script>
    <!--script src="/app/app.js"></script-->

    <!--link rel="stylesheet" href="//cdn.datatables.net/1.10.5/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script-->

    <link rel="stylesheet" href="/public/fileupload/css/jquery.fileupload.css">

    <title></title>
</head>
<body class="fuelux">

{!! \App\Helpers\WidgetHelper::region('top', 'seller') !!}

@yield('content')

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="//www.fuelcdn.com/fuelux/3.6.3/js/fuelux.min.js"></script>

<script src="/public/jquery-ui/jquery-ui.min.js"></script>

<script src="/public/fileupload/js/jquery.fileupload.js"></script>
<script src="/public/fileupload/js/jquery.fileupload-process.js"></script>

</body>
</html>