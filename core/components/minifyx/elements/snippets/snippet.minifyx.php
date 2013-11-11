<?php
/** @var array $scriptProperties */
/** @var MinifyX $MinifyX */
if (!$modx->getService('minifyx','MinifyX', MODX_CORE_PATH.'components/minifyx/model/minifyx/')) {return false;}

$MinifyX = new MinifyX($modx, $scriptProperties);
$MinifyX->minify();

// Set old placeholders so MODX can quick replace them
$modx->setPlaceholders(array(
	'MinifyX.javascript' => '',
	'MinifyX.css' => '',
));