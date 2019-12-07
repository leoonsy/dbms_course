<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Компьютерный магазин - управление БД</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="public/dist/styles/bootstrap.min.css">
    <link rel="stylesheet" href="public/dist/styles/main.min.css">
    <link rel="stylesheet" href="public/dist/styles/fancy.min.css">
</head>

<body>
    <!--[if lt IE 8]>
	<p>Вы используете <strong>устаревшую</strong> версию браузера. Пожалуйста <a
			href="http://browsehappy.com/">обновите свой браузер</a>.</p>
    <![endif]-->
    <div id="wrapper">
        <div id="content">
            <div class="container account">
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <span>Добро пожаловать, </span><b class="account__name">
                            <?= $params['login'] ?>!
                        </b>
                        <span class="account__divider">|</span>
                        <a href="/?logout" class="account__logout">Выйти</a>
                    </div>
                </div>
            </div>
            <div class="container panel">
                <div class="row">
                    <div class="col-12 panel__mainTable" id="mainTable"></div>
                </div>
            </div>
        </div>
        <footer class="footer"></footer>
    </div>

    <script src="public/dist/scripts/jquery-3.4.1.min.js"></script>
    <script src="public/dist/scripts/popper.min.js"></script>
    <script src="public/dist/scripts/bootstrap.min.js"></script>
    <script src="public/dist/scripts/fontawesome.min.js"></script>
    <script src="public/dist/scripts/fancy.min.js"></script>
    <script src="public/dist/scripts/main.min.js"></script>
</body>

</html>