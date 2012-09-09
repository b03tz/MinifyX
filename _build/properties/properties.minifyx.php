<?php
/**
 * Properties for the MinifyX snippet.
 *
 * @package minifyx
 * @subpackage build
 */
$properties = array();

$properties[0] = array(
	array(
		'name' => 'jsSources',
		'value' => '',
		'type' => 'textfield',
		'desc' => 'Comma separated list to your JS files from the site base URL',
	),
	array(
		'name' => 'cssSources',
		'value' => '',
		'type' => 'textfield',
		'desc' => 'Comma separated list to your CSS files from the site base URL',
	),
	array(
		'name' => 'minifyCss',
		'value' => false,
		'type' => 'combo-boolean',
		'desc' => 'Whether to minify the CSS or not',
	),
	array(
		'name' => 'minifyJs',
		'value' => false,
		'type' => 'combo-boolean',
		'desc' => 'Whether to minify the JS or not',
	),
	array(
		'name' => 'cacheFolder',
		'value' => '/assets/components/minifyx/cache/',
		'type' => 'textfield',
		'desc' => 'The folder to the cache files from the site base URL',
	),
	array(
		'name' => 'jsFilename',
		'value' => 'scripts',
		'type' => 'textfield',
		'desc' => 'Base name of destination js file, without extension',
	),
	array(
		'name' => 'cssFilename',
		'value' => 'styles',
		'type' => 'textfield',
		'desc' => 'Base name of destination css file, without extension',
	),
);

return $properties;
?>