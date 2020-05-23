Ext.onReady(function () {
    prettyTags.config.connector_url = OfficeConfig.actionUrl;

    var grid = new prettyTags.panel.Home();
    grid.render('office-prettytags-wrapper');

    var preloader = document.getElementById('office-preloader');
    if (preloader) {
        preloader.parentNode.removeChild(preloader);
    }
});