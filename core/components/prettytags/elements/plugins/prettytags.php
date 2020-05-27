<?php
/** @var modX $modx */

$corePath = $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/prettytags/';

switch ($modx->event->name) {
    case 'OnTVInputRenderList':
        $modx->event->output($corePath . 'tv/input/');
        break;
}
