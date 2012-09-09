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
		$corePath = $this->modx->getOption('core_path').'components/minifyx/';
		$assetsPath = $this->modx->getOption('assets_path').'components/minifyx/';
		$assetsUrl = $this->modx->getOption('assets_url').'components/minifyx/';

		$this->config = array_merge(array(
			'corePath' => $corePath
			,'modelPath' => $corePath.'model/'
			,'snippetsPath' => $corePath.'elements/snippets/'
			,'cacheFolder' => $assetsPath.'cache/'
			,'cacheFolderUrl' => $assetsUrl.'cache/'
			,'basePath' => MODX_BASE_PATH
			,'cssFilename' => 'styles'
			,'jsFilename' => 'scripts'
			,'jsSources' => ''
			,'cssSources' => ''
			,'minifyCss' => 1
			,'minifyJs' => 1
		),$config);
		if (!empty($config['jsSources'])) {$this->config['jsSources'] = explode(',', str_replace("\n",'', trim($config['jsSources'])));}
		if (!empty($config['cssSources'])) {$this->config['cssSources'] = explode(',', str_replace("\n",'', trim($config['cssSources'])));}
		if (!empty($config['cacheFolder'])) {
			$this->config['cacheFolderUrl'] = str_replace('//','/', $config['cacheFolder']);
			$this->config['cacheFolder'] = str_replace('//','/', MODX_BASE_PATH.$config['cacheFolder']);
		}
		
		$this->config['jsFile'] = $this->config['minifyJs'] ? $this->config['jsFilename'].'.min.js' : $this->config['jsFilename'].'.js';
		$this->config['cssFile'] = $this->config['minifyCss'] ? $this->config['cssFilename'].'.min.css' : $this->config['cssFilename'].'.css';
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
	
	/**
	 * Does the actual minifying, combining files and setting placeholders
	 *
	 * @access public
	 * @param array $options Script properties
	 * @return void 
	 */
	public function minify($options) {
		//echo '<pre>';print_r($this->config);echo'</pre>';
		
		// Javascript
		if ($jsOutput = $this->processJs($this->config['jsSources'])) {
			$this->modx->setPlaceholder('MinifyX.javascript', '<script type="text/javascript" src="'.$this->config['cacheFolderUrl'].$this->config['jsFile'].'?'.time().'"></script>');
		}
		
		//CSS
		if ($cssOutput = $this->processCss($this->config['cssSources'])) {
			$this->modx->setPlaceholder('MinifyX.css', '<link rel="stylesheet" type="text/css" href="'.$this->config['cacheFolderUrl'].$this->config['cssFile'].'?'.time().'" />');
		}
		
		return;
	}
	

	/**
	 * Check and create (if need) MinifyX js file 
	 *
	 * @access public
	 * @return boolean
	 */
	function processJs() {
		$file = $this->config['cacheFolder'].$this->config['jsFile'];
		$output = '';
		$maxtime = 0;
		foreach($this->config['jsSources'] as $source) {
			$source = str_replace('//', '/', $this->config['basePath'].trim($source));
			if (is_file($source)) {
				$output .= file_get_contents($source)."\n";	
				$filetime = filemtime($source);
				if ($filetime > $maxtime) {$maxtime = $filetime;}
			} else {
				$this->modx->log(modX::LOG_LEVEL_ERROR, '[MinifyX] Could not find file: '.$source);
			}
		}
		if (is_file($file)) {
			$mintime = filemtime($file);
			if ($mintime > $maxtime) {
				return true;
			}
		}
		if ($this->config['minifyJs']) {
			require_once 'jsmin.class.php';
			$output = JSMin::minify($output);
		}

		if (!file_put_contents($file, $output)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[MinifyX] Could not write JS cache file!');
			return false;
		}
		return true;
	}

	
	/**
	 * Check and create (if need) MinifyX css file 
	 *
	 * @access public
	 * @return boolean
	 */
	function processCss() {
		$file = $this->config['cacheFolder'].$this->config['cssFile'];
		$output = '';
		$maxtime = 0;
		foreach($this->config['cssSources'] as $source) {
			$source = str_replace('//', '/', $this->config['basePath'].trim($source));
			if (is_file($source)) {
				$output .= file_get_contents($source)."\n";
				$filetime = filemtime($source);
				if ($filetime > $maxtime) {$maxtime = $filetime;}
			} else {
				$this->modx->log(modX::LOG_LEVEL_ERROR, '[MinifyX] Could not find file: '.$source);
			}
		}
		if (is_file($file)) {
			$mintime = filemtime($file);
			if ($mintime > $maxtime) {
				return true;
			}
		}
		if ($this->config['minifyCss']) {
			require_once 'cssmin.class.php';
			$output = Minify_CSS_Compressor::process($output);
		}
		
		if (!file_put_contents($file, $output)) {
			$this->modx->log(modX::LOG_LEVEL_ERROR,'[MinifyX] Could not write CSS cache file!');
			return false;
		}
		return true;
	}
	
	
	/**
	 * Clears the cachefolder for the MinifyX snippet
	 *
	 * @access public
	 * @param array $options Script properties
	 * @return true 
	 */
	public function clearCache() {
		return true;
	}
}