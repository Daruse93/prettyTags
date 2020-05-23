<?php
/** @var xPDOTransport $transport */
/** @var array $options */
/** @var modX $modx */
if ($transport->xpdo) {
    $modx =& $transport->xpdo;

    $dev = MODX_BASE_PATH . 'Extras/prettyTags/';
    /** @var xPDOCacheManager $cache */
    $cache = $modx->getCacheManager();
    if (file_exists($dev) && $cache) {
        if (!is_link($dev . 'assets/components/prettytags')) {
            $cache->deleteTree(
                $dev . 'assets/components/prettytags/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_ASSETS_PATH . 'components/prettytags/', $dev . 'assets/components/prettytags');
        }
        if (!is_link($dev . 'core/components/prettytags')) {
            $cache->deleteTree(
                $dev . 'core/components/prettytags/',
                ['deleteTop' => true, 'skipDirs' => false, 'extensions' => []]
            );
            symlink(MODX_CORE_PATH . 'components/prettytags/', $dev . 'core/components/prettytags');
        }
    }
}

return true;