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
			
			$editorActions = Configure::read('Wysiwyg.actions');
			if (!isset($editorActions[$action])) {
				return;
			}
			$actionItems = $editorActions[$action];
			$out = null;
			foreach ($actionItems as $actionItem) {
				$element = $actionItem['elements'];
				unset($actionItem['elements']);
				$defaults = Configure::read('Tinymce.defaults') ? Configure::read('Tinymce.defaults') : array();
				$config = array_merge($defaults, $actionItem);
				$config = empty($config) ? '{}' : $this->Js->object($config);
				$out .= sprintf(
					'Croogo.Wysiwyg.Tinymce.setup("%s", %s);',
					$element, $config
				);
			}
			$this->Js->buffer($out);
		}
	}
}
