<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Компьютерный магазин - вход</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="public/dist/styles/bootstrap.min.css">
    <link rel="stylesheet" href="public/dist/styles/main.min.css">
</head>

<body>
    <!--[if lt IE 8]>
	<p>Вы используете <strong>устаревшую</strong> версию браузера. Пожалуйста <a
			href="http://browsehappy.com/">обновите свой браузер</a>.</p>
    <![endif]-->
    <div id="wrapper">
        <div id="content" class="justify-content-center align-items-center">
            <div class="container my-2 auth" >
                <h2 class="auth__title">Введите данные для входа</h2>
                <form action="/" method="post">
                    <div class="form-row">
                        <div class="col-12 form-group">
                            <input type="text" name="login" class="form-control" placeholder="Логин">
                        </div>
                        <div class="col-12 form-group">
                            <input type="password" name="password" class="form-control" placeholder="Пароль">
                        </div>
                        <button type="submit" name="auth" class="btn btn-primary col-12">Войти</button>
                        <h3 class="auth__error col-12">
                            <?php if ($params['authError']) : ?>
                                Неверно введен логин или пароль!
                            <?php endif; ?>
                        </h3>
                    </div>
                </form>
            </div>
        </div>
        <footer class="footer"></footer>
    </div>

    <script src="public/dist/scripts/jquery-3.4.1.min.js"></script>
    <script src="public/dist/scripts/popper.min.js"></script>
    <script src="public/dist/scripts/bootstrap.min.js"></script>
    <script src="public/dist/scripts/fontawesome.min.js"></script>
</body>

</html>