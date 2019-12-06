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
                    width: 50,
                    editable: false
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
                    width: 50,
                    editable: false
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
                    width: 50,
                    editable: false
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
                    width: 50,
                    editable: false
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

            //кнопки должны быть в отдельной памяти для каждой таблицы (отак как привязывается к таблице)
            let tbarProducts = JSON.parse(JSON.stringify(tbar));
            let tbarOrders = JSON.parse(JSON.stringify(tbar));
            let tbarCustomers = JSON.parse(JSON.stringify(tbar));

            let paging = {
                pageSize: 20,
                pageSizeData: [5, 10, 20, 50, 100, 500, 1000]
            };

            let clicksToEdit = 2,
                i18n = 'ru';

            let grid = new FancyTab({
                resizable: false,
                renderTo: 'mainTable',
                title: 'База данных компьютерного магазина',
                height: 650,
                trackOver: true,
                items: [{
                        title: 'Категории',
                        selModel: 'rows',
                        type: 'grid',
                        data: {
                            proxy: {
                                type: 'rest',
                                url: `${baseApiPath}?table=categories`,
                                afterRequest: updateAfterRequest
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
                                url: `${baseApiPath}?table=products`,
                                afterRequest: updateAfterRequest
                            }
                        },
                        defaults: defaults,
                        columns: cols.products,
                        tbar: tbarProducts,
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
                                url: `${baseApiPath}?table=orders`,
                                afterRequest: updateAfterRequest
                            }
                        },
                        defaults: defaults,
                        columns: cols.orders,
                        tbar: tbarOrders,
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
                                url: `${baseApiPath}?table=customers`,
                                afterRequest: updateAfterRequest
                            }
                        },
                        defaults: defaults,
                        columns: cols.customers,
                        tbar: tbarCustomers,
                        clicksToEdit: clicksToEdit,
                        paging: paging,
                        i18n: i18n
                    }
                ]
            })

            //обновляет вкладки (кроме текущей) после удаления строк
            function updateAfterRequest(o) {
                if (o.type == 'destroy') {
                    let activeTab = grid.activeTab;
                    if (activeTab != 0 && activeTab != 3) //рассматриваем только "категории" и "покупатели" (для оптимизации)
                        return o;

                    for (let i = 0; i < grid.items.length; i++) {
                        if (i != activeTab && grid.items[i].load != undefined) {
                            grid.items[i].load(); //запрос к серверу для получения данных
                        }
                    }
                }
                return o;
            }
        });
    </script>
</body>

</html>