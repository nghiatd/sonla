<?php

class Zend_View_Helper_JQueryHelper extends Zend_View_Helper_Abstract
{
	function jQueryHelper() {
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/bootstrap/bootstrap-hover-dropdown.js'
		);
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/bootstrap/bootstrap-formhelpers.min.js'
		);
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/bootstrap/bootstrap.min.js'
		);
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/ui/jquery-ui-1.8.18.min.js'
		);
		$this->view->headScript()->prependFile(
			$this->view->baseUrl() . '/js/jquery/jquery-1.7.min.js'
		);
	}
}