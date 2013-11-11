<?php

class MinifyX {
	/** @var modX $modx */
	public $modx = null;
	protected $current = array('js' => array(), 'css' => array());


	function __construct(modX &$modx,array $config = array()) {
		$this->modx =& $modx;

		$corePath = $this->modx->getOption('core_path').'components/minifyx/';
		$assetsPath = $this->modx->getOption('assets_path').'components/minifyx/';
		$this->config = array_merge(array(
			'corePath' => $corePath,
			'modelPath' => $corePath.'model/',
			'basePath' => MODX_BASE_PATH,

			'cacheFolder' => $assetsPath,

			'jsSources' => '',
			'cssSource' => '',

			'cssFilename' => 'styles',
			'jsFilename' => 'scripts',

			'minifyJs' => true,
			'minifyCss' => true,

			'forceUpdate' => false

		),$config);

		$this->config['jsExt'] = $this->config['minifyJs'] ? '.min.js' : '.js';
		$this->config['cssExt'] = $this->config['minifyCss'] ? '.min.css' : '.css';

		if (empty($this->config['cacheFolder'])) {
			$this->config['cacheFolder'] = $assetsPath;
		}
	}


	/**
	 * Does the actual minifying, combining files and setting placeholders
	 *
	 * @return void
	 */
	public function minify() {
		if (!$this->cacheFolder()) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[MinifyX] Could not create cache dir "'.$this->config['cacheFolder'].'"');
			return;
		}

		$time = time();
		$cacheFolderUrl = DIRECTORY_SEPARATOR . str_replace(MODX_BASE_PATH, '', $this->config['cacheFolder']);
		if ($js = $this->prepareFiles($this->config['jsSources'], 'js')) {
			$js = $this->Munee($js, array(
				'minify' => $this->config['minifyJs'] ? 'true' : 'false',
			));

			if (!empty($js)) {
				$file = $this->config['jsFilename'] . '_' . $time . $this->config['jsExt'];
				file_put_contents($this->config['cacheFolder'] . $file, $js);
			}
			elseif (count($this->current['js'])) {
				$tmp = array_pop($this->current['js']);
				$file = $tmp['file'];
			}

			if (!empty($file)) {
				$this->modx->regClientScript($cacheFolderUrl . $file);
			}
		}

		if ($css = $this->prepareFiles($this->config['cssSources'], 'css')) {
			var_dump($css);
			$css = $this->Munee($css, array(
				'minify' => $this->config['minifyCss'] ? 'true' : 'false',
			));

			if (!empty($css)) {
				$file = $this->config['cssFilename'] . '_' . $time . $this->config['cssExt'];
				file_put_contents($this->config['cacheFolder'] . $file, $css);
			}
			elseif (count($this->current['css'])) {
				$tmp = array_pop($this->current['css']);
				$file = $tmp['file'];
			}

			if (!empty($file)) {
				$this->modx->regClientCSS($cacheFolderUrl . $file);
			}
		}

		foreach ($this->current as $tmp) {
			foreach ($tmp as $tmp2) {
				unlink($this->config['cacheFolder'] . $tmp2['file']);
			}
		}

		return;
	}


	/**
	 * Prepare string or array of files fo send in Munee
	 *
	 * @param array|string $files
	 * @param string $type Type of files
	 *
	 * @return string
	 */
	protected function prepareFiles($files) {
		$output = array();
		if (is_string($files)) {
			$files = array_map('trim', explode(',', $files));
		}

		if (is_array($files)) {
			foreach ($files as $file) {
				if (!empty($file)) {
					$output[] = $file;
				}
			}
		}

		return implode(',', $output);
	}


	/**
	 * Process files with Munee library
	 * http://mun.ee
	 *
	 * @param string $files
	 * @param array $options
	 *
	 * @return string
	 */
	public function Munee($files, $options = array()) {
		define('WEBROOT', MODX_BASE_PATH);
		define('MUNEE_CACHE', MODX_CORE_PATH . 'cache/default/munee/');

		require $this->config['corePath'] . 'munee/munee.phar';

		try {
			$Request = new \Munee\Request($options);
			$Request->setFiles($files);
			foreach ($options as $k => $v) {
				$Request->setRawParam($k, $v);
			}
			$Request->init();

			/** @var \Munee\Asset\Type $AssetType */
			$AssetType = \Munee\Asset\Registry::getClass($Request);
			$AssetType->init();

			$modified = true;
			if (!empty($this->current[$Request->ext])) {
				$cache_time = $AssetType->getLastModifiedDate();
				$tmp = end($this->current[$Request->ext]);
				$current_time = $tmp['time'];
				if ($cache_time <= $current_time) {
					$modified = false;
				}
			}
			return $modified || $this->config['forceUpdate']
				? $AssetType->getContent()
				: '';
		}
		catch (\Munee\ErrorException $e) {
			$this->modx->log(modX::LOG_LEVEL_ERROR, '[MinifyX] ' . $e->getMessage());
			return '';
		}
	}


	/**
	 * Checks and creates cache dir
	 *
	 * @return bool|string
	 */
	public function cacheFolder() {
		$full_path = ltrim(str_replace(MODX_BASE_PATH, '', $this->config['cacheFolder']), DIRECTORY_SEPARATOR);

		if (!file_exists(MODX_BASE_PATH . $full_path)) {
			$tmp = explode(DIRECTORY_SEPARATOR, $full_path);
			$path = MODX_BASE_PATH;
			foreach ($tmp as $v) {
				if (!empty($v)) {
					$path .= $v . DIRECTORY_SEPARATOR;
					if (!file_exists($path)) {
						mkdir($path);
					}
				}
			}
		}

		if (substr($full_path, -1) !== DIRECTORY_SEPARATOR) {
			$full_path .= DIRECTORY_SEPARATOR;
		}

		// Could not create cache directory
		if (!file_exists(MODX_BASE_PATH . $full_path)) {
			return false;
		}

		// Get the latest cache files
		$this->config['cacheFolder'] = $cacheFolder = MODX_BASE_PATH . $full_path;
		$regexp = '('.$this->config['jsFilename'].'|'.$this->config['cssFilename'].')';
		$regexp .= '_(\d{10})';
		$regexp .= '('.$this->config['jsExt'].'|'.$this->config['cssExt'].')';

		$files = scandir($cacheFolder);
		foreach ($files as $file) {
			if ($file == '.' || $file == '..') {continue;}

			if (preg_match("/^$regexp$/iu", $file, $matches)) {
				if ($matches[3] == $this->config['jsExt']) {
					$this->current['js'][] = array(
						'file' => $matches[0],
						'time' => filemtime($cacheFolder . $file),
					);
				}
				else {
					$this->current['css'][] = array(
						'file' => $matches[0],
						'time' => filemtime($cacheFolder . $file),
					);
				}
			}
		}

		return true;
	}

}
