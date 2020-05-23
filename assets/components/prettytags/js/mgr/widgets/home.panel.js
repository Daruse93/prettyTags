prettyTags.panel.Home = function (config) {
    config = config || {};
    Ext.apply(config, {
        baseCls: 'modx-formpanel',
        layout: 'anchor',
        /*
         stateful: true,
         stateId: 'prettytags-panel-home',
         stateEvents: ['tabchange'],
         getState:function() {return {activeTab:this.items.indexOf(this.getActiveTab())};},
         */
        hideMode: 'offsets',
        items: [{
            html: '<h2>' + _('prettytags') + '</h2>',
            cls: '',
            style: {margin: '15px 0'}
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            hideMode: 'offsets',
            items: [{
                title: _('prettytags_items'),
                layout: 'anchor',
                items: [{
                    html: _('prettytags_intro_msg'),
                    cls: 'panel-desc',
                }, {
                    xtype: 'prettytags-grid-items',
                    cls: 'main-wrapper',
                }]
            }]
        }]
    });
    prettyTags.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(prettyTags.panel.Home, MODx.Panel);
Ext.reg('prettytags-panel-home', prettyTags.panel.Home);
