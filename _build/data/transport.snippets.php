<?php
/**
 * Add snippets to build
 * 
 * @package minifyx
 * @subpackage build
 */
$snippets = array();
$properties = include $sources['build'].'properties/properties.minifyx.php';

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'MinifyX',
    'description' => 'MinifyX is a snippet the allows you to combine and minify JS and CSS files',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.minifyx.php'),
),'',true,true);
$snippets[0]->setProperties($properties[0]);

return $snippets;
