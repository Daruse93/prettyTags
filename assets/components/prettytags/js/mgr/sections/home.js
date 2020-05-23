prettyTags.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        components: [{
            xtype: 'prettytags-panel-home',
            renderTo: 'prettytags-panel-home-div'
        }]
    });
    prettyTags.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(prettyTags.page.Home, MODx.Component);
Ext.reg('prettytags-page-home', prettyTags.page.Home);