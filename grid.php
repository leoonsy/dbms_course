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
                    <div class="col-12 panel__mainTable" id="mainTable"></div>
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
            let baseApiPath = "api.php";

            let cols = {
                categories: [{
                    index: 'id',
                    title: 'ID',
                    type: 'number',
                    locked: true,
                    width: 50
                }, {
                    index: 'name',
                    title: 'Имя',
                    type: 'string',
                    width: 200
                }],
                products: [{
                    index: 'id',
                    title: 'ID',
                    type: 'number',
                    locked: true,
                    width: 50
                }, {
                    index: 'category_id',
                    title: 'ID категории',
                    type: 'number',
                    width: 110
                }, {
                    index: 'name',
                    title: 'Имя',
                    type: 'string',
                    width: 200
                }, {
                    index: 'price',
                    title: 'Цена',
                    type: 'number',
                    width: 80
                }, {
                    index: 'count',
                    title: 'Количество',
                    type: 'string',
                    width: 90
                }],
                orders: [{
                    index: 'id',
                    title: 'ID',
                    type: 'number',
                    locked: true,
                    width: 50
                }, {
                    index: 'customer_id',
                    title: 'ID покупателя',
                    type: 'number',
                    width: 110
                }, {
                    index: 'product_id',
                    title: 'ID товара',
                    type: 'number',
                    width: 80
                }, {
                    index: 'product_count',
                    title: 'Количество товаров',
                    type: 'number',
                    width: 150
                }, {
                    index: 'price',
                    title: 'Цена',
                    type: 'number',
                    width: 80
                }],
                customers: [{
                    index: 'id',
                    title: 'ID',
                    type: 'number',
                    locked: true,
                    width: 50
                }, {
                    index: 'first_name',
                    title: 'Имя',
                    type: 'string'
                }, {
                    index: 'last_name',
                    title: 'Фамилия',
                    type: 'string'
                }]
            };

            let defaults = {
                type: 'string',
                width: 150,
                resizable: true,
                sortable: true,
                editable: true
            }

            let tbar = [{
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
            }];

            let paging = {
                pageSize: 20,
                pageSizeData: [5, 10, 20, 50, 100, 500, 1000]
            };

            let clicksToEdit = 2,
                i18n = 'ru';

            let grid = new FancyTab({
                resizable: true,
                renderTo: 'mainTable',
                title: 'База данных компьютерного магазина',
                height: 450,
                trackOver: true,
                items: [{
                        title: 'Категории',
                        selModel: 'rows',
                        type: 'grid',
                        data: {
                            proxy: {
                                type: 'rest',
                                url: `${baseApiPath}?table=categories`
                            }
                        },
                        defaults: defaults,
                        columns: cols.categories,
                        tbar: tbar,
                        clicksToEdit: clicksToEdit,
                        paging: paging,
                        i18n: i18n
                    },
                    {
                        title: 'Продукты',
                        selModel: 'rows',
                        type: 'grid',
                        data: {
                            proxy: {
                                type: 'rest',
                                url: `${baseApiPath}?table=products`
                            }
                        },
                        defaults: defaults,
                        columns: cols.products,
                        tbar: tbar,
                        clicksToEdit: clicksToEdit,
                        paging: paging,
                        i18n: i18n
                    },
                    {
                        title: 'Заказы',
                        selModel: 'rows',
                        type: 'grid',
                        data: {
                            proxy: {
                                type: 'rest',
                                url: `${baseApiPath}?table=orders`
                            }
                        },
                        defaults: defaults,
                        columns: cols.orders,
                        tbar: tbar,
                        clicksToEdit: clicksToEdit,
                        paging: paging,
                        i18n: i18n
                    },
                    {
                        title: 'Покупатели',
                        selModel: 'rows',
                        type: 'grid',
                        data: {
                            proxy: {
                                type: 'rest',
                                url: `${baseApiPath}?table=customers`
                            }
                        },
                        defaults: defaults,
                        columns: cols.customers,
                        tbar: tbar,
                        clicksToEdit: clicksToEdit,
                        paging: paging,
                        i18n: i18n
                    }
                ]
            })

            // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            //     switch (e.target.id) {
            //         case 'nav-categories-tab':
            //             apiPath = `${baseApiPath}?table=categories`;
            //             break;

            //         case 'nav-products-tab':
            //             apiPath = `${baseApiPath}?table=products`;
            //             break;

            //         case 'nav-orders-tab':
            //             apiPath = `${baseApiPath}?table=orders`;
            //             break;

            //         case 'nav-customers-tab':
            //             apiPath = `${baseApiPath}?table=customers`;
            //             break;

            //         default:
            //             throw new Exception('Не определена таблица базы данных');
            //     }
            //     grid.setUrl(apiPath);
            //     grid.load();
            // });
        });
    </script>
</body>

</html>