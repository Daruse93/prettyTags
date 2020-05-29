<?php
require_once MODX_CORE_PATH . 'components/prettytags/controllers/router.class.php';

$corePath = $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/prettytags/';
$pageTagsId = $modx->getOption('prettytags_resource_id');
$routerName = 'PrettyTagsRouter';
$fieldName = 'tag';

switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        // Add new TV for tags
        $modx->event->output($corePath . 'tv/input/');
        break;
    case 'OnPageNotFound':
        // redirect to tags page
        $router = new PrettyTagsRouter($modx);

        if ($router->needDispatch()) {
            $router->clearCache();
            $router->dispatch();
        }

        break;
    case 'OnLoadWebDocument':
        // Set Placeholders on Tags page
        if(
            $modx->resource->id == $pageTagsId &&
            $_REQUEST[$routerName] &&
            $_REQUEST[$routerName][$fieldName]
        ){
            $alias = $_REQUEST[$routerName][$fieldName];

            $prefix = 'pretty_tags_';

            $modx->addPackage('prettytags', MODX_CORE_PATH . 'components/prettytags/model/');

            $where = array(
                'alias' => $alias
            );

            $res = $modx->getObject('prettyTagsItem', $where);

            $modx->setPlaceholder($prefix . 'id', $res->id);
            $modx->setPlaceholder($prefix . 'name', $res->name);
            $modx->setPlaceholder($prefix . 'description', $res->description);
            $modx->setPlaceholder($prefix . 'alias', $alias);
        }
        break;
}
