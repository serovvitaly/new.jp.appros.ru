<!DOCTYPE HTML>
<html manifest="">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="UTF-8">

    <title>App</title>

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/bootstrap.css">
    <link rel="stylesheet" href="//www.fuelcdn.com/fuelux/3.6.3/css/fuelux.min.css">


    <style>
        .fa{
            color: #889DAD;
        }
        .fa-lg{
            padding: 5px;
        }
    </style>

    <script>
        var __TOKEN__ = '{{ csrf_token() }}';
        function updateToken(success){
            $.get('/rest/token', function(res){
                __TOKEN__ = res._token;
                success();
            });
        }
    </script>

    <!-- The line below must be kept intact for Sencha Cmd to build your application -->
    <script type="text/javascript" src="/ext/build/ext-all-debug.js"></script>
    <script type="text/javascript" src="/app/app.js"></script>
    <script src="//www.fuelcdn.com/fuelux/3.6.3/js/fuelux.min.js"></script>
</head>
<body></body>
</html>
