prettyTags.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        cls: 'container', // Добавляем отступы
        items: [{
            html: '<h2>'+_('prettytags')+'</h2>'
        }, {
            xtype: 'modx-tabs',
            items: [{
                title: _('prettytags_control_page'), // Заголовок первого таба
                items: [
                    {
                        html: _('prettytags_control_page_desc'),
                        cls: 'panel-desc',
                    },
                    {
                        xtype: 'prettytags-grid-names',
                        cls: 'container',
                        id: 'prettytags-grid-names'
                    }
                ]
            }]
        } ]
    });
    prettyTags.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(prettyTags.panel.Home, MODx.Panel);
Ext.reg('prettytags-panel-home', prettyTags.panel.Home);
