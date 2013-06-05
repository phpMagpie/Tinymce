<?php

App::uses('AppHelper', 'View/Helper');

/**
 * Tinymce Helper
 *
 * PHP version 5
 *
 * @category Tinymce.Helper
 * @package  Tinymce.View.Helper
 * @version  1.5
 * @author   Paul Gardner <phpmagpie@webbedit.co.uk>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.croogo.org
 */
class TinymceHelper extends AppHelper {

/**
 * Other helpers used by this helper
 *
 * @var array
 * @access public
 */
	public $helpers = array(
		'Html',
		'Js',
	);

/**
 * Actions
 *
 * Format: ControllerName/action_name => settings
 *
 * @var array
 */
	public $actions = array();
	
/**
 * Default settings for tinymce
 *
 * @var array
 * @access public
 */
  public $settings = array(
    'mode' => 'exact',
    'elements' => '',
    'relative_urls' => false,
    'plugins' => 'advlist paste searchreplace spellchecker link anchor autolink image table charmap fullscreen code',
    'tools' => 'inserttable',
    'toolbar' => 'undo redo | searchreplace spellchecker | bold italic underline strikethrough remove format | bullist numlist outdent indent blockquote hr | link unlink anchor',
    'style_formats' => array(
      array(
        'title' => 'Image Left',
        'selector' => 'img',
        'styles' => array(
          'float' => 'left',
          'margin'=> '0 10px 0 10px'
        )
      ),
      array(
        'title' => 'Image Right',
        'selector' => 'img',
        'styles' => array(
          'float' => 'right',
          'margin'=> '0 10px 0 10px'
        )
      ),
    ),
  );

/**
 * getSettings
 *
 * @param array $settings
 * @return array
 */
	public function getSettings($settings = array()) {
	  $_settings = $this->settings;
		$action = Inflector::camelize($this->params['controller']) . '/' . $this->params['action'];
		$wysiwygActions = Configure::read('Wysiwyg.actions');
		if (isset($wysiwygActions[$action])) {
			$settings = array();
			foreach ($wysiwygActions[$action] as $action) {
				$settings[] = Hash::merge($_settings, $action);
			}
		}
		return $settings;
	}


/**
 * beforeRender
 *
 * @param string $viewFile
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->Html->script(array('/Tinymce/js/wysiwyg'), array('inline' => false));
		
		if (is_array(Configure::read('Wysiwyg.actions'))) {
			$this->actions = Hash::merge($this->actions, Configure::read('Wysiwyg.actions'));
		}
		$action = Inflector::camelize($this->params['controller']) . '/' . $this->params['action'];
		if (Configure::read('Writing.wysiwyg') && isset($this->actions[$action])) {
			$this->Html->script(array('/Tinymce/js/tinymce.min'), array('inline' => false));
			
			$this->_CroogoPlugin = new CroogoPlugin();
			
			// setup file manager part1
			if($this->_CroogoPlugin->isActive('el_finder')) {
				$this->Html->css(
				  array('http://code.jquery.com/ui/1.8.18/themes/smoothness/jquery-ui.css', '/ElFinder/elfinder/css/elfinder.min'),
				  null, array('inline' => false)
				);
				$this->Html->script(array('/ElFinder/elfinder/js/tinymce.plugin'), array('inline' => false));
			} elseif ($this->_CroogoPlugin->isActive('moxie_manager')) {
  			$this->Html->scriptBlock('$(document).ready(function() {
  			  tinymce.PluginManager.load("moxiemanager", "/MoxieManager/plugin.min.js");
  			});', array('inline' => false));
			}
			
			$settings = $this->getSettings();
			foreach ($settings as $setting) {
			  // setup file manager part2
			  if($this->_CroogoPlugin->isActive('el_finder')) {
			  	$setting['plugins'] = $setting['plugins'] . ' elfinder';
			  } elseif($this->_CroogoPlugin->isActive('moxie_manager')) {
			  	$setting['plugins'] = $setting['plugins'] . ' moxiemanager';
			  } else {
			    $setting['file_browser_callback'] = "fileBrowserCallback";
			  }
			  
				$this->Html->scriptBlock('$(document).ready(function() {
				  tinymce.init(' . str_replace('"fileBrowserCallback"', 'fileBrowserCallback', $this->Js->object($setting)) . ');
				});', array('inline' => false));
			}
		}
	}
}
