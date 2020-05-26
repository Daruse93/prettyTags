// Модалка создания объекта
prettyTags.window.create = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        title: _('prettytags_add_tag'),
        fields: [
            {
                xtype: 'textfield',
                name: 'label',
                fieldLabel: _('prettytags_field_label'),
                anchor: '100%'
            },
            {
                xtype: 'textfield',
                name: 'tag',
                fieldLabel: _('prettytags_field_tag'),
                anchor: '100%'
            },
            {
                xtype: 'textarea',
                name: 'description',
                fieldLabel: _('prettytags_field_description'),
                anchor: '100%'
            },
            {
                xtype: 'xcheckbox',
                name: 'active',
                fieldLabel: _('prettytags_field_active'),
                boxLabel: 'Да'
            }
        ],
        url: prettyTags.config.connector_url,
        action: 'mgr/item/create',
    });
    prettyTags.window.create.superclass.constructor.call(this, config); // Магия
};
Ext.extend(prettyTags.window.create, MODx.Window); // Расширяем MODX.Window
Ext.reg('prettyTags-window-create', prettyTags.window.create); // Регистрируем новый xtype


// Модалка обновления объекта
prettyTags.window.update = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        title: _('prettytags_update_tag'),
        fields: [
            {
                xtype: 'textfield',
                name: 'label',
                fieldLabel: _('prettytags_field_label'),
                anchor: '100%'
            },
            {
                xtype: 'textfield',
                name: 'tag',
                fieldLabel: _('prettytags_field_tag'),
                anchor: '100%'
            },
            {
                xtype: 'textarea',
                name: 'description',
                fieldLabel: _('prettytags_field_description'),
                anchor: '100%'
            },
            {
                xtype: 'xcheckbox',
                name: 'active',
                fieldLabel: _('prettytags_field_active'),
                boxLabel: 'Да'
            },
            {
                xtype: 'hidden',
                name: 'id',
                fieldLabel: 'Id',
                anchor: '100%'
            },
        ],
        url: prettyTags.config.connector_url,
        action: 'mgr/item/update',
    });
    prettyTags.window.update.superclass.constructor.call(this, config); // Магия
};
Ext.extend(prettyTags.window.update, MODx.Window); // Расширяем MODX.Window
Ext.reg('prettyTags-window-update', prettyTags.window.update); // Регистрируем новый xtype
