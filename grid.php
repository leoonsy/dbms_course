<?php

declare(strict_types=1);

mb_internal_encoding("UTF-8");

ini_set('display_errors', (string) 1);
ini_set('display_startup_errors', (string) 1);
ini_set('error_reporting', (string) E_ALL);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Панель управления базой данных</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="public/dist/styles/bootstrap.min.css">
    <link rel="stylesheet" href="public/dist/styles/main.min.css">
    <link rel="stylesheet" href="public/dist/styles/aos.min.css">
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
                        <span>Добро пожаловать, </span><b class="account__name">Admin</b>!
                        <span class="account__divider">|</span>
                        <a href="#" class="account__logout">Выйти</a>
                    </div>
                </div>
            </div>
            <div class="container panel">
                <div class="row">
                    <nav class="panel__nav col-12">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-categories-tab" data-toggle="tab" href="#mainTable">Категории</a>
                            <a class="nav-item nav-link" id="nav-products-tab" data-toggle="tab" href="#mainTable">Продукты</a>
                            <a class="nav-item nav-link" id="nav-orders-tab" data-toggle="tab" href="#mainTable">Заказы</a>
                            <a class="nav-item nav-link" id="nav-customers-tab" data-toggle="tab" href="#mainTable">Покупатели</a>
                        </div>
                    </nav>
                    <div class="tab-content col-12" id="nav-tabContent">
                        <div class="tab-pane fade show active mainTable" id="mainTable"></div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">

        </footer>
    </div>

    <script src="public/dist/scripts/jquery-3.4.1.min.js"></script>
    <script src="public/dist/scripts/popper.min.js"></script>
    <script src="public/dist/scripts/bootstrap.min.js"></script>
    <script src="public/dist/scripts/fontawesome.min.js"></script>
    <script src="public/dist/scripts/aos.min.js"></script>
    <script src="public/dist/scripts/fancy.min.js"></script>

    <script>
        $(function() {

            let data = [{
                    "id": 1,
                    "name": "Ted",
                    "surname": "Smith",
                    "company": "Electrical Systems",
                    "age": 30
                },
                {
                    "id": 2,
                    "name": "Ed",
                    "surname": "Johnson",
                    "company": "Energy and Oil",
                    "age": 35
                },
                {
                    "id": 3,
                    "name": "Test",
                    "surname": "Sunovich",
                    "company": "Lalala",
                    "age": 22
                }
            ];

            let baseApiPath = "api.php";
            let apiPath = `${baseApiPath}?table=categories`;

            let grid = new FancyGrid({
                resizable: true,
                renderTo: 'mainTable',
                title: 'База данных компьютерного магазина',
                height: 450,
                trackOver: true,
                selModel: 'rows',
                data: {
                    proxy: {
                        type: 'rest',
                        url: apiPath
                    }
                },
                tbar: [{
                    text: 'Добавить',
                    action: 'add'
                }, {
                    text: 'Удалить',
                    action: 'remove',
                    tip: 'Select one or more rows to remove.'
                }, {
                    type: 'search',
                    width: 350,
                    emptyText: 'Поиск',
                    paramsMenu: true,
                    paramsText: 'Параметры'
                }],
                defaults: {
                    type: 'string',
                    width: 75,
                    resizable: true,
                    sortable: true,
                    editable: true
                },
                clicksToEdit: 2,
                paging: {
                    pageSize: 20,
                    pageSizeData: [5, 10, 20, 50, 100, 500, 1000]
                },
                i18n: 'ru',
                columns: [{
                    index: 'id',
                    title: 'Id',
                    type: 'number',
                    locked: true,
                    width: 100
                }, {
                    index: 'company',
                    title: 'Company',
                    type: 'string',
                    width: 100
                }, {
                    index: 'name',
                    title: 'Name',
                    type: 'string',
                    width: 100
                }, {
                    index: 'surname',
                    title: 'Sur Name',
                    type: 'string',
                    width: 100
                }, {
                    index: 'age',
                    title: 'Age',
                    type: 'number',
                    width: 100
                }]
            })

            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                switch (e.target.id) {
                    case 'nav-categories-tab':
                        apiPath = `${baseApiPath}?table=categories`;
                        break;

                    case 'nav-products-tab':
                        apiPath = `${baseApiPath}?table=products`;
                        break;

                    case 'nav-orders-tab':
                        apiPath = `${baseApiPath}?table=orders`;
                        break;

                    case 'nav-customers-tab':
                        apiPath = `${baseApiPath}?table=customers`;
                        break;

                    default:
                        throw new Exception('Не определена таблица базы данных');
                }
                grid.setUrl(apiPath);
                grid.load();
            });
        });
    </script>
</body>

</html>