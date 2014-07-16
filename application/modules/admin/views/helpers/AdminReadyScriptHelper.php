<?php
class Zend_View_Helper_AdminReadyScriptHelper extends Zend_View_Helper_Abstract
{
	function adminReadyScriptHelper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/admin/user.js'
		);
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/admin/common.js'
		);
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/admin/global.js'
		);
	}
}
?>