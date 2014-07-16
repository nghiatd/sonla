<?php

class Zend_View_Helper_ScreenStylesheetHelper extends Zend_View_Helper_Abstract
{
	function screenStylesheetHelper() {
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/default/style.css'
		);
		$this->view->headLink()->prependStylesheet(
				$this->view->baseUrl() . '/css/default/normalize.css'
		);
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/default/foundation.min.css'
		);
	}
}