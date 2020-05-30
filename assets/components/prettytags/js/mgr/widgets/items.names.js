// Внутри Things есть grid. Вот внутри него и создаём свой объект
prettyTags.grid.Names = function (config) {
    config = config || {};
    Ext.apply(config, {
        columns: [
            {dataIndex: 'id', width: 150, header: 'Id'},
            {dataIndex: 'name', width: 250, header: _('prettytags_field_name')},
            {dataIndex: 'alias', width: 250, header: _('prettytags_field_alias')},
            {dataIndex: 'description', width: 400, header: _('prettytags_field_description')},
            {
                dataIndex: 'active',
                width: 100,
                header: _('prettytags_field_active'),
                renderer: function(value) {
                    if (value) {
                        return '<span class="green">Да</span>';
                    } else {
                        return '<span class="red">Нет</span>';
                    }
                }
            },
        ],
        autoHeight: true,
        viewConfig: {
            forceFit: true,
            scrollOffset: 0
        },
        url: prettyTags.config.connector_url,
        action: 'mgr/item/getlist',
        fields: ['id','name', 'alias', 'description', 'active'],
        paging: true,
        pageSize: 10, // количество записей на странице
        listeners: {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                var w = MODx.load({
                    xtype: 'prettyTags-window-update',
                    listeners: {
                        success: {
                            fn: function () {
                                this.refresh();
                            }, scope: this
                        }
                    }
                });
                w.setValues({
                    id: row.data.id,
                    name: row.data.name,
                    alias: row.data.alias,
                    description: row.data.description,
                    active: row.data.active,
                });
                w.show();
            }
        },
        tbar: [
            {
                xtype: 'button',
                text: _('prettytags_add_tag'), // Меняем надпись
                cls: 'primary-button',
                handler: function() {
                    var w = MODx.load({ // Сохраним объект окна в переменную
                        xtype: 'prettyTags-window-create',
                        listeners: {
                            success: {
                                fn: function () {
                                    this.refresh();
                                }, scope: this
                            }
                        }
                    });
                    w.setValues({active: true}); // Устанавливаем нужные значения
                    w.show(); // Показываем окно пользователю
                }
            }
        ],
        getMenu: function(grid, rowIndex) {
            var m = [];
            var row = grid.getStore().getAt(rowIndex);
            m.push(
                {
                    text: _('prettytags_remove_tag'),
                    handler: function(){
                        MODx.msg.confirm({
                            title: _('prettytags_remove_tag'),
                            text: _('prettytags_remove_tag_confirm') + '<strong>' + row.data.name + '</strong>?',
                            url: prettyTags.config.connector_url,
                            params: {
                                action: 'mgr/item/remove',
                                id: row.data.id,
                            },
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                    }
                },
                {
                    text: _('prettytags_update_tag'),
                    handler: function(){
                        var row = grid.store.getAt(rowIndex);
                        var w = MODx.load({
                            xtype: 'prettyTags-window-update',
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                }
                            }
                        });
                        w.setValues({
                            id: row.data.id,
                            name: row.data.name,
                            alias: row.data.alias,
                            description: row.data.description,
                            active: row.data.active,
                        });
                        w.show();
                    }
                }
            );
            return m;
        }
    });
    prettyTags.grid.Names.superclass.constructor.call(this, config); // Магия
};

Ext.extend(prettyTags.grid.Names, MODx.grid.Grid);
Ext.reg('prettytags-grid-names', prettyTags.grid.Names); // Регистрируем новый xtype
