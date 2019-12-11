$(function () {
    let baseApiPath = "core/api.php";
    let acl = getAcl();
    let reference = getReference();

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
            title: 'Категория',
            type: 'combo',
            data: getNamesFromRef('categories'),
            width: 150
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
            title: 'Покупатель',
            type: 'combo',
            data: getNamesFromRef('customers'),
            width: 140
        }, {
            index: 'product_id',
            title: 'Товар',
            type: 'combo',
            data: getNamesFromRef('products'),
            width: 160
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
                    afterRequest: updateAfterRequest,
                    beforeRequest: updateBeforeRequest
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
                    afterRequest: updateAfterRequest,
                    beforeRequest: updateBeforeRequest
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
                    afterRequest: updateAfterRequest,
                    beforeRequest: updateBeforeRequest
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
                    afterRequest: updateAfterRequest,
                    beforeRequest: updateBeforeRequest
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

    /**
     * Получает права для управления таблицей
     */
    function getAcl() {
        let res;
        $.ajax({
            url: 'core/api.php?acl',
            method: 'get',
            dataType: 'json',
            async: false,
            success: (data) => {
                res = data;
            }
        });
        return res;
    }

    /**
     * Получает соответствия id и name для таблиц
     */
    function getReference() {
        let res;
        $.ajax({
            url: 'core/api.php?reference',
            method: 'get',
            dataType: 'json',
            async: false,
            success: (data) => {
                res = data;
            }
        });
        return res;
    }

    /**
     * Возвращает имена для combobox
     * 
     * @param {string} tableName 
     */
    function getNamesFromRef(tableName) {
        let data = [];
        for (let row of reference[tableName])
            data.push(row.name);

        return data;
    }

    /**
     * Получить имя записи из таблицы по id
     * 
     * @param {number} id 
     * @param {string} tableName 
     */
    function getNameById(id, tableName) {
        //todo: сделать из reference словарь для более быстрого поиска
        for (let row of reference[tableName])
            if (row.id == id)
                return row.name;
        return null;
    }

    /**
     * Получить id из таблицы по имени записи
     * 
     * @param {string} name 
     * @param {string} tableName 
     */
    function getIdByName(name, tableName) {
        //todo: сделать из reference словарь для более быстрого поиска
        for (let row of reference[tableName])
            if (row.name == name)
                return row.id;
        return null;
    }

    /**
     * Изменить id на имя
     * 
     * @param {object} row - объект для изменения
     */
    function changeIdToName(row) {
        if (row['customer_id'])
            row['customer_id'] = getNameById(row['customer_id'], 'customers');

        if (row['product_id'])
            row['product_id'] = getNameById(row['product_id'], 'products');

        if (row['category_id'])
            row['category_id'] = getNameById(row['category_id'], 'categories');
    }

    /**
     * Функция, вызываемая после получения ответа от сервера
     * 
     * @param {object} o объект, содержащий информацию о типе запроса и ответ сервера
     * @param {string} o.type тип запроса (create/read/update/delete)
     * @param {object} o.response ответ от сервера
     */
    function updateAfterRequest(o) {
        if (o.type != 'read')
            reference = getReference(); //todo: заменить на локальное изменение для повышения производительности

        //заменяет id на name (для удобства пользователя)
        if (o.response.data) {
            if (Array.isArray(o.response.data))
                for (let row of o.response.data)
                    changeIdToName(row);        
            else
                changeIdToName(o.response.data);
        }

        //обновляет вкладки (кроме текущей) после удаления строк
        if (o.type == 'destroy' || o.type == 'update') {
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

    /**
     * Функция, вызываемая до отправки запроса таблицы к серверу
     * 
     * @param {object} o объект, содержащий информацию о типе запроса и его параметрах 
     * @param {string} o.type тип запроса (create/read/update/delete)
     * @param {object} o.params параметры запроса к серверу
     * @param {object} o.headers заголовки запроса к серверу
     */
    function updateBeforeRequest(o) {
        switch (o.params.key) {
            case 'customer_id':
                o.params.value = getIdByName(o.params.value, 'customers');
                break;
            case 'product_id':
                o.params.value = getIdByName(o.params.value, 'products');
                break;
            case 'category_id':
                o.params.value = getIdByName(o.params.value, 'categories');
                break;
        }

        return o;
    }
});