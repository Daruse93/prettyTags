<?php
/** @var modX $modx */
/** @var array $scriptProperties */
/** @var prettyTags $prettyTags */
$prettyTags = $modx->getService('prettyTags', 'prettyTags', MODX_CORE_PATH . 'components/prettytags/model/', $scriptProperties);
if (!$prettyTags) {
    return 'Could not load prettyTags class!';
}

$pageTagsId = $modx->getOption('prettytags_resource_id');
if($pageTagsId){
    $pageTagsResource = $modx->getObject('modResource', $pageTagsId);
    $pageTagsUrl = str_replace('//', '/', $pageTagsResource->get('uri').'/');
}

// scriptProperties
$tpl = $modx->getOption('tpl', $scriptProperties, 'Item');
$sortby = $modx->getOption('sortby', $scriptProperties, 'name');
$sortdir = $modx->getOption('sortbir', $scriptProperties, 'ASC');
$limit = $modx->getOption('limit', $scriptProperties, 5);
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);

// Build query
$c = $modx->newQuery('prettyTagsItem');
$c->sortby($sortby, $sortdir);
$c->where(['active' => 1]);
$c->limit($limit);
$items = $modx->getIterator('prettyTagsItem', $c);

// Iterate through items
$list = [];
/** @var prettyTagsItem $item */
foreach ($items as $item) {
    if($pageTagsUrl && $item->get('alias')){
        $item->set('url', $pageTagsUrl.$item->get('alias'));
    }

    $list[] = $modx->getChunk($tpl, $item->toArray());
}

// Output
$output = implode($outputSeparator, $list);
if (!empty($toPlaceholder)) {
    // If using a placeholder, output nothing and set output to specified placeholder
    $modx->setPlaceholder($toPlaceholder, $output);

    return '';
}
// By default just return output
return $output;
