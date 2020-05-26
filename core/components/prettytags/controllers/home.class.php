<?php

/**
 * The home manager controller for prettyTags.
 *
 */
class prettyTagsHomeManagerController extends modExtraManagerController
{
    /** @var prettyTags $prettyTags */
    public $prettyTags;


    /**
     *
     */
    public function initialize()
    {
        $this->prettyTags = $this->modx->getService('prettyTags', 'prettyTags', MODX_CORE_PATH . 'components/prettytags/model/');
        parent::initialize();
    }


    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['prettytags:default'];
    }


    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }


    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('prettytags');
    }


    /**
     * @return void
     */
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->prettyTags->config['jsUrl'] . 'mgr/prettytags.js');
        $this->addJavascript($this->prettyTags->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addJavascript($this->prettyTags->config['jsUrl'] . 'mgr/widgets/items.names.js');
        $this->addJavascript($this->prettyTags->config['jsUrl'] . 'mgr/widgets/items.windows.js');
        $this->addJavascript($this->prettyTags->config['jsUrl'] . 'mgr/sections/home.js');

        $this->addHtml('<script type="text/javascript">
        prettyTags.config = ' . json_encode($this->prettyTags->config) . ';
        prettyTags.config.connector_url = "' . $this->prettyTags->config['connectorUrl'] . '";
        Ext.onReady(function() {MODx.load({ xtype: "prettytags-page-home"});});
        </script>');
    }


    /**
     * @return string
     */
    public function getTemplateFile()
    {
        $this->content .= '<div id="prettytags-panel-home-div"></div>';

        return '';
    }
}
