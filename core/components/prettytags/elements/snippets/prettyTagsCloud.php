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
$sortdir = $modx->getOption('sortdir', $scriptProperties, 'ASC');
$limit = $modx->getOption('limit', $scriptProperties, 10);
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);
$tvId = $modx->getOption('tvId', $scriptProperties, '');

if(!$tvId) {
    return 'ERROR: set property `tvId` in call snippet `prettyTagsCloud`';
}

/* get TV values */
$c = $modx->newQuery('modTemplateVarResource');
// add resources to query
$c->leftJoin('modResource', 'modResource', array(
    '`modResource`.`id` = `modTemplateVarResource`.`contentId`'
));

$c->limit($limit);

$c->where(['tmplvarid' => $tvId]);

// show with deleted resources
if (!$modx->getOption('includeDeleted',$scriptProperties,false)) {
    $c->where(array('modResource`.`deleted' => 0));
}
// show with unpublished resources
if (!$modx->getOption('includeUnpublished',$scriptProperties,false)) {
    $c->where(array('modResource`.`published' => 1));
}

$resourceTags = $modx->getCollection('modTemplateVarResource',$c);

/* parse TV values */
$tagIdList = [];
$tvDelimiter = ',';
foreach ($resourceTags as $tag) {
    $v = $tag->get('value');
    $vs = explode($tvDelimiter,$v);
    foreach ($vs as $key) {
        $key = trim($key);
        if (empty($key)) continue;

        /* increment tag count */
        if (empty($tagIdList[$key])) {
            $tagIdList[$key] = 1;
        } else {
            $tagIdList[$key]++;
        }
    }
}

/* add props */
$tagList = [];

$tags = $modx->getCollection('prettyTagsItem', [
    'id:IN' => array_keys($tagIdList)
]);

foreach($tags as $tag){
    $url = '';
    $id = $tag->get('id');
    $alias = $tag->get('alias');

    if (!empty($pageTagsUrl) && $alias) {
        $url = $pageTagsUrl.$alias;
    }

    $tagArray = array(
        'id' => $id,
        'count' => $tagIdList[$id],
        'name' => $tag->get('name'),
        'alias' => $alias,
        'description' => $tag->get('description'),
        'active' => $tag->get('active'),
        'url' => $url,
    );

    $tagList[] = $tagArray;
}

/* sorts */

function sortTagsIdDESC($a, $b) { return $b['id'] - $a['id']; }
function sortTagsIdASC($a, $b)  { return $a['id'] - $b['id']; }
function sortTagsCountDESC($a, $b) { return $b['count'] - $a['count']; }
function sortTagsCountASC($a, $b)  { return $a['count'] - $b['count']; }
function sortTagsNameDESC($a, $b) { if ($a['name'] == $b['name']) { return 0; } return ($b['name'] < $a['name']) ? -1 : 1; }
function sortTagsNameASC($a, $b)  { if ($a['name'] == $b['name']) { return 0; } return ($a['name'] < $b['name']) ? -1 : 1; }
function sortTagsAliasDESC($a, $b) { if ($a['alias'] == $b['alias']) { return 0; } return ($b['alias'] < $a['alias']) ? -1 : 1; }
function sortTagsAliasASC($a, $b)  { if ($a['alias'] == $b['alias']) { return 0; } return ($a['alias'] < $b['alias']) ? -1 : 1; }
function sortTagsDescriptionDESC($a, $b) { if ($a['description'] == $b['description']) { return 0; } return ($b['description'] < $a['description']) ? -1 : 1; }
function sortTagsDescriptionASC($a, $b)  { if ($a['description'] == $b['description']) { return 0; } return ($a['description'] < $b['description']) ? -1 : 1; }
function sortTagsActiveDESC($a, $b) { return $b['active'] - $a['active']; }
function sortTagsActiveASC($a, $b)  { return $a['active'] - $b['active']; }

switch ($sortby.'-'.$sortdir) {
    case 'id-DESC'         : uasort($tagList, 'sortTagsIdDESC');          break;
    case 'id-ASC'          : uasort($tagList, 'sortTagsIdASC');           break;
    case 'count-DESC'      : uasort($tagList, 'sortTagsCountDESC');       break;
    case 'count-ASC'       : uasort($tagList, 'sortTagsCountASC');        break;
    case 'name-DESC'       : uasort($tagList, 'sortTagsNameDESC');        break;
    case 'name-ASC'        : uasort($tagList, 'sortTagsNameASC');         break;
    case 'alias-DESC'      : uasort($tagList, 'sortTagsAliasDESC');       break;
    case 'alias-ASC'       : uasort($tagList, 'sortTagsAliasASC');        break;
    case 'description-DESC': uasort($tagList, 'sortTagsDescriptionDESC'); break;
    case 'description-ASC' : uasort($tagList, 'sortTagsDescriptionASC');  break;
    case 'active-DESC': uasort($tagList, 'sortTagsActiveDESC');           break;
    case 'active-ASC' : uasort($tagList, 'sortTagsActiveASC');            break;
}

// to chunk
$list = array();
foreach ($tagList as $item) {
    $list[] = $modx->getChunk($tpl, $item);
}


// Output
$output = implode($outputSeparator, $list);
if (!empty($toPlaceholder)) {
    // If using a placeholder, output nothing and set output to specified placeholder
    $modx->setPlaceholder($toPlaceholder, $output);

    return '';
}

return $output;