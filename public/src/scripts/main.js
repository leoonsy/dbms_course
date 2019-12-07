$(function () {
    let baseApiPath = "core/api.php";
    let acl = [];

    $.ajax({
        url: 'core/api.php?acl',
        method: 'get',
        dataType: 'json',
        async: false,
        success: (data) => {
            acl = data;
        }
    });

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
        editable: acl.update
    }

    let tbar = [{
        key: 'insert',
        text: 'Добавить',
        action: 'add'
    }, {
        key: 'delete',
        text: 'Удалить',
        action: 'remove',
        tip: 'Выделите строки для удаления'
    }, {
        key: 'search',
        type: 'search',
        width: 350,
        emptyText: 'Поиск',
        paramsMenu: true,
        paramsText: 'Параметры'
    }];

    //отключаем кнопки в зависимости от прав доступа
    tbar = tbar.filter((item, index, array) => {
        return !(acl[item.key] === false);
    });

    //кнопки должны быть в отдельной памяти для каждой таблицы (так как привязывается к таблице)
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