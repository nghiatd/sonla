<?php

class Admin_Form_Login extends Zend_Form
{

	protected $_translate;

	protected $_decorNull = array('ViewHelper');

	protected $_checkboxDecorator = array(
			'ViewHelper',
			array('Description', array('escape' => false, 'tag' => false)),
			array(array('row'=>'HtmlTag'), array('tag'=>'label', 'class'=>'checkbox', 'for'=>'login-check')),
	);

    public function init()
    {
    	// Get translate
    	$this->_translate = Zend_Registry::get('Zend_Translate');

    	$this->setName('loginform')
    		->setAction('')
        	->setMethod('POST')
    		->setAttrib('role', 'form')
    		->removeDecorator('HtmlTag');

        $o_Name = new Zend_Form_Element_Text('login-name');
        $o_Name->removeDecorator('Label')
        		->removeDecorator('HtmlTag')
	        	->setRequired(true)
	            ->addFilter('StringToLower')
	            ->setAttrib('class', 'form-control')
	        	->setAttrib('placeholder', $this->_translate->translate('ADMIN_USER_FORM_LABELS_Username'))
	        	->setAttrib('autofocus', '');

        $o_Password = new Zend_Form_Element_Password('login-password');
        $o_Password->removeDecorator('Label')
        		->removeDecorator('HtmlTag')
        		->setAttrib('placeholder', $this->_translate->translate('ADMIN_USER_FORM_LABELS_Password'))
        		->setAttrib('class', 'form-control');

        $o_Challenge = new Zend_Form_Element_Hidden('login-challenge');
        $o_Challenge->removeDecorator('Label')
        		->removeDecorator('HtmlTag');

        $o_Remember = new Zend_Form_Element_Checkbox('login-check');
        $o_Remember->setLabel('ADMIN_USER_FORM_LABELS_RememberMe')
        		->setAttrib('id', 'login-check')
        		->setDescription('ADMIN_USER_FORM_LABELS_RememberMe')
        		->setDecorators($this->_checkboxDecorator);

        $o_Login = new Zend_Form_Element_Submit('login');
        $o_Login->setLabel('ADMIN_USER_FORM_LABELS_Login')
        	  	->setName('submitLogin')
        	  	->setAttrib('class', 'btn btn-lg btn-primary btn-block')
        		->setDecorators($this->_decorNull);

        $this->addElements(
            array(
                $o_Name,
                $o_Password,
                $o_Challenge,
                $o_Remember,
                $o_Login
            )
        );
    }
}

