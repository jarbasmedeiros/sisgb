<!DOCTYPE html>
<html>
    <head>
        <title>Sistema em manutenção.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #fff;
                display: table;
                font-weight: 100;
                background: #0076A3;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title"> Sistema em Manutenção!</div>
                <h2>{{ $exception->getMessage() }}</h2>
               
            </div>
        </div>
    </body>
</html>
