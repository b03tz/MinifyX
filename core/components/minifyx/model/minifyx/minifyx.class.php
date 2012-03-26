<?php
/**
 * MinifyX
 *
 * Copyright 2011-12 by SCHERP Ontwikkeling <info@scherpontwikkeling.nl>
 *
 * This file is part of MinifyX.
 *
 * MinifyX is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * MinifyX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MinifyX; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package MinifyX
 */
/**
 * This file is the main class file for MinifyX.
 *
 * @copyright Copyright (C) 2011, SCHERP Ontwikkeling <info@scherpontwikkeling.nl>
 * @author SCHERP Ontwikkeling <info@scherpontwikkeling.nl>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License v2
 * @package MinifyX
 */
class MinifyX {
    /**
     * A reference to the modX object.
     * @var modX $modx
     */
    public $modx = null;

    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        /* allows you to set paths in different environments
         * this allows for easier SVN management of files
         */
        $corePath = $this->modx->getOption('minifyx.core_path',null,$modx->getOption('core_path').'components/minifyx/');
        $assetsPath = $this->modx->getOption('minifyx.assets_path',null,$modx->getOption('assets_path').'components/minifyx/');
        $assetsUrl = $this->modx->getOption('minifyx.assets_url',null,$modx->getOption('assets_url').'components/minifyx/');

        $this->config = array_merge(array(
            'corePath' => $corePath,
            'modelPath' => $corePath.'model/',
            'processorsPath' => $corePath.'processors/',
            'controllersPath' => $corePath.'controllers/',
            'chunksPath' => $corePath.'elements/chunks/',
            'snippetsPath' => $corePath.'elements/snippets/',
            'baseUrl' => $assetsUrl,
            'cssUrl' => $assetsUrl.'css/',
            'jsUrl' => $assetsUrl.'js/',
            'connectorUrl' => $assetsUrl.'connector.php'
        ),$config);
    }

    /**
     * Initializes MinifyX based on a specific context.
     *
     * @access public
     * @param string $ctx The context to initialize in.
     * @return string The processed content.
     */
    public function initialize($ctx = 'mgr') {
        $output = '';

        return $output;
    }
}