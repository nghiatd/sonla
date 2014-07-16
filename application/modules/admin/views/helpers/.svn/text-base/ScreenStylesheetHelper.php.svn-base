<?php

class Zend_View_Helper_ScreenStylesheetHelper extends Zend_View_Helper_Abstract
{
	function screenStylesheetHelper() {
                // Add fancybox css
                $this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/js/fancybox/source/jquery.fancybox.css?v=2.1.5'
		);
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/login/signin.css'
		);
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/admin/screen.css'
		);
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/bootstrap/bootstrap-formhelpers.min.css'
		);
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/bootstrap/bootstrap.min.css'
		);
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/bootstrap/bootstrap-theme.min.css'
		);
		$this->view->headLink()->prependStylesheet(
			$this->view->baseUrl() . '/css/ui/jquery-ui-1.8.18.custom.css'
		);
	}
}