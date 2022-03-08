<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', env('APP_NAME'))</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:400" rel="stylesheet">
    <style>body,head,html{font-family:"Poppins",sans-serif;font-size:14px;margin:0;height:100%}.main{background:#eee;color:#333;height:100%}.footer a,.footer p{color:#aaa}.container{padding:15px}hr{height:1px;border:0;border-top:1px solid #eee;margin:1em 0;padding:0}.table{background:#fafafa;padding:10px;border-radius:5px}td{padding:5px 10px}.body,.btn{padding:10px 20px}.body{margin:auto;max-width:500px;border-radius:10px;background:#fff}.footer{margin-top:20px}.footer p{font-size:12px;margin:1px 0}.footer a:hover{color:#888}.btn{background:#eee;border-radius:20px;text-decoration:none;color:#333;font-weight:700}.btn:hover{background:#ddd}.full-height {height: 100vh; -webkit-flex-flow: column wrap; -ms-flex-flow: column wrap; flex-flow: column wrap; display: -webkit-box; display: -webkit-flex; display: -ms-flexbox; display: flex; -webkit-box-pack:center; -webkit-justify-content:center; -ms-flex-pack:center; justify-content:center; }.center{text-align: center;}.m-0{margin: 0;}.mt-0{margin-top: 0;}.mb-0{margin-bottom: 0;}.btn,.footer{text-align:center}.title{font-size: 5em;}

        /*
        Blue      : #3498db, #2980b9
        Purple    : #9b59b6, #8e44ad
        Darkblue  : #34495e, #2c3e50
        Yellow    : #f1c40f, #f39c12
        Orange    : #e67e22, #d35400
        Red       : #e74c3c, #c0392b
        Green     : #2ecc71, #27ae60
        */

        .btn-primary {
            background: #3498db;
            color: #fff !important;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
    </style>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/main-logo.png') }}"/>
</head>
<body>
    <div class="main">
        <div class="@yield('full-height', 'full-height')">
            <div class="container">
                <div class="body">
                    @yield('main')
                </div>
                <div class="footer">
                    <p>{{ env('APP_NAME') }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>