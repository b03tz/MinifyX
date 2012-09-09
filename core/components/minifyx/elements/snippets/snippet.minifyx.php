<?php
$minifyX = $modx->getService('minifyx','MinifyX', MODX_CORE_PATH.'components/minifyx/model/minifyx/',$scriptProperties);
if (!($minifyX instanceof MinifyX)) return '';

$minifyX->minify();

return '';