<?php
require_once MODX_CORE_PATH . 'components/prettytags/controllers/router.class.php';

$corePath = $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/prettytags/';

switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath . 'tv/input/');
        break;
    case 'OnPageNotFound':
        $router = new PrettyTagsRouter($modx);

        if ($router->needDispatch()) {
            $router->clearCache();
            $router->dispatch();
        }

        break;
}
