<?php
/**
* defaultcomponent
*
* Copyright 2010-11 by SCHERP Ontwikkeling <info@scherpontwikkeling.nl>
*
* This file is part of defaultComponent, a simple commenting component for MODx Revolution.
*
* defaultComponent is free software; you can redistribute it and/or modify it under the
* terms of the GNU General Public License as published by the Free Software
* Foundation; either version 2 of the License, or (at your option) any later
* version.
*
* defaultComponent is distributed in the hope that it will be useful, but WITHOUT ANY
* WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
* A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License along with
* defaultComponent; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
* Suite 330, Boston, MA 02111-1307 USA
*
* @package defaultcomponent
*/
/**
* @package defaultcomponent
* @subpackage build
*/
$snippets = array();

/*

// Example from Quip by Shaun:
// (increase array key "1" for every new snippet, 2, 3 etc)

$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'defaultComponent',
    'description' => 'A simple commenting component.',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.defaultcomponent.php'),
));
$properties = include $sources['data'].'properties/properties.defaultcomponent.php';
$snippets[1]->setProperties($properties);

*/

return $snippets;