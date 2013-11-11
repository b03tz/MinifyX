<?php
$properties = array();

$tmp = array(
	'jsSources' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'cssSources' => array(
		'type' => 'textfield',
		'value' => '',
	),
	'minifyCss' => array(
		'type' => 'combo-boolean',
		'value' => false
	),
	'minifyJs' => array(
		'type' => 'combo-boolean',
		'value' => false
	),
	'cacheFolder' => array(
		'type' => 'textfield',
		'value' => '/assets/components/minifyx/cache/',
	),
	'jsFilename' => array(
		'type' => 'textfield',
		'value' => 'scripts',
	),
	'cssFilename' => array(
		'type' => 'textfield',
		'value' => 'styles',
	),
	'forceUpdate' => array(
		'type' => 'combo-boolean',
		'value' => false,
	),
);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(
		array(
			'name' => $k,
			'desc' => PKG_NAME_LOWER . '_prop_' . $k,
			'lexicon' => PKG_NAME_LOWER . ':properties',
		), $v
	);
}

return $properties;
