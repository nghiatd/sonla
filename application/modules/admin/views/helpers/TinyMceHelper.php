<?php
class Zend_View_Helper_TinyMceHelper extends Zend_View_Helper_Abstract
{

    function TinyMceHelper()
    {
        $this->view->headScript()->prependFile(
                $this->view->baseUrl() . '/tinymce/tinymce.min.js?v=20111006'
        );
        $this->view->headScript()->prependFile(
                $this->view->baseUrl() . '/js/fancybox/source/jquery.fancybox.js?v=2.1.5'
        );
        $this->view->headScript()->prependFile(
                $this->view->baseUrl() . '/js/admin/citizen.js'
        );
    }
}