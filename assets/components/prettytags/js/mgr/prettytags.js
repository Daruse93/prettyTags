var prettyTags = function (config) {
    config = config || {};
    prettyTags.superclass.constructor.call(this, config);
};
Ext.extend(prettyTags, Ext.Component, {
    page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, utils: {}
});
Ext.reg('prettytags', prettyTags);

prettyTags = new prettyTags();