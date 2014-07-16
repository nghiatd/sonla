<?php
class Zend_View_Helper_DefaultReadyScriptHelper extends Zend_View_Helper_Abstract
{
	function defaultReadyScriptHelper() {
		$this->view->inlineScript()->prependFile(
				$this->view->baseUrl() . '/js/default/global.js'
		);
		$this->view->inlineScript()->prependFile(
				$this->view->baseUrl() . '/js/default/foundation.min.js'
		);
		$this->view->inlineScript()->prependFile(
				$this->view->baseUrl() . '/js/vendor/jquery.js'
		);
	}
}
?>