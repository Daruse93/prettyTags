<?php
if (file_exists(dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/config.core.php';
} else {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/config.core.php';
}
/** @noinspection PhpIncludeInspection */
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
/** @noinspection PhpIncludeInspection */
require_once MODX_CONNECTORS_PATH . 'index.php';
/** @var prettyTags $prettyTags */
$prettyTags = $modx->getService('prettyTags', 'prettyTags', MODX_CORE_PATH . 'components/prettytags/model/');
$modx->lexicon->load('prettytags:default');

// handle request
$corePath = $modx->getOption('prettytags_core_path', null, $modx->getOption('core_path') . 'components/prettytags/');
$path = $modx->getOption('processorsPath', $prettyTags->config, $corePath . 'processors/');
$modx->getRequest();

/** @var modConnectorRequest $request */
$request = $modx->request;
$request->handleRequest([
    'processors_path' => $path,
    'location' => '',
]);