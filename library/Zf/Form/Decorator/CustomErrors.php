<?php

class Zf_Form_Decorator_CustomErrors extends Zend_Form_Decorator_Abstract
{
 	public function render($sz_Content)
    {
    	$o_Element = $this->getElement();
        $o_View    = $o_Element->getView();
        if (null === $o_View) {
            return $sz_Content;
        }

        $sz_Errors = $o_Element->getMessages();
        if (empty($sz_Errors)) {
            return '<div class="add-edit-input col-xs-12 col-md-4">' . $sz_Content . '</div>';
        }

        $sz_Separator = $this->getSeparator();
        $sz_Placement = $this->getPlacement();
        $sz_Errors    = $o_View->formErrors($sz_Errors, $this->getOptions());

        $sz_Errors = str_replace('<li>', '', $sz_Errors);
        $sz_Errors = str_replace('</li>', '. ', $sz_Errors);
        $sz_Errors = str_replace('<ul class="errors">', '<div class="alert alert-warning col-xs-12 col-md-8">', $sz_Errors);
		$sz_Errors = str_replace('</ul>', '</div>', $sz_Errors);
        
		$sz_Content = '<div class="add-edit-input col-xs-12 col-md-4">' . $sz_Content . '</div>';
		
        switch ($sz_Placement) {
            case self::APPEND:
                return $sz_Content . $sz_Separator . $sz_Errors;
            case self::PREPEND:
                return $sz_Errors . $sz_Separator . $sz_Content;
        }
    }
}