<?php

class Admin_Form_User extends Zend_Form
{
	protected $_translate;

	protected $_inputDecorator = array(
		    'ViewHelper',
            'CustomErrors',
            array(array('data'=>'HtmlTag'), array('tag'=>'div', 'class'=>'col-xs-12 col-sm-8 col-md-10 col-lg-9')),
            array('Label',array('tag'=>'div', 'tagClass'=>'col-xs-12 col-sm-4 col-md-2 col-lg-3', 'requiredSuffix' => ' *')),
            array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class'=>'col-xs-12 add-edit-row')),
	);

	protected $_checkboxDecorator = array(
		    'ViewHelper',
            'CustomErrors',
            array(array('data'=>'HtmlTag'), array('tag'=>'div', 'class'=>'col-xs-12 col-sm-8 col-md-10 col-lg-9')),
            array('Label',array('tag'=>'div', 'tagClass'=>'col-xs-12 col-sm-4 col-md-2 col-lg-3', 'requiredSuffix' => '')),
            array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class'=>'col-xs-12 add-edit-row')),
	);

	protected $_buttonDecorators = array(
		   'ViewHelper',
            array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class'=>'col-xs-4 col-md-2')),
    );

	protected $_filterDecorators = array(
			'ViewHelper',
			array('Label',array('class'=>'sr-only')),
			array(array('row'=>'HtmlTag'), array('tag'=>'div', 'class'=>'col-sm-2 add-edit-row')),
	);

    public function init()
    {
    	// Get translate
    	$this->_translate = Zend_Registry::get('Zend_Translate');

    	$this->setName('userform');
    	$this->setAction('');
        $this->setMethod('POST');

        $this->addElementPrefixPath('Zf_Form_Decorator',
                            'Zf/Form/Decorator/',
                            'decorator');

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array(
            	'tag' => 'div',
            	'class' => 'add-edit-form')),
            'Form',
        ));

        $o_Id = new Zend_Form_Element_Hidden('id');
        $o_Id->setDecorators(array('ViewHelper'));

        $o_IsRequiredMsg = new Zend_Form_Element_Hidden('requiredMsg');
        $o_IsRequiredMsg->setValue($this->_translate->translate('ADMIN_FORM_WARNING_MSG_Required'))
        				->setDecorators(array('ViewHelper'));

        $o_IsInvalidMsg = new Zend_Form_Element_Hidden('invalidMsg');
        $o_IsInvalidMsg->setValue($this->_translate->translate('ADMIN_FORM_WARNING_MSG_Invalid'))
        				->setDecorators(array('ViewHelper'));

        $o_MaxLengthMsg = new Zend_Form_Element_Hidden('maxlengthMsg');
        $o_MaxLengthMsg->setValue($this->_translate->translate('ADMIN_FORM_WARNING_MSG_MaxLength'))
        				->setDecorators(array('ViewHelper'));

        $o_MinLengthMsg = new Zend_Form_Element_Hidden('minlengthMsg');
        $o_MinLengthMsg->setValue($this->_translate->translate('ADMIN_FORM_WARNING_MSG_MinLength'))
        				->setDecorators(array('ViewHelper'));

        $o_Name = new Zend_Form_Element_Text('name');
        $o_Name->setLabel('ADMIN_USER_FORM_LABELS_Username')
        	 ->addValidator('NotEmpty')
        	 ->addValidator('regex', false, array('/^[\w.-]*$/','messages'=>array('regexNotMatch'=>'There was some random custom error')))
        	 ->addValidator('stringLength', false, array(5, 150))
         	 ->setRequired(true)
             ->addFilter('StringToLower')
             ->setAttrib('class', 'form-control')
             ->setDecorators($this->_inputDecorator);

        $o_Email = new Zend_Form_Element_Text('email');
        $o_Email->setLabel('ADMIN_USER_FORM_LABELS_Email')
        	  ->addValidator('NotEmpty')
        	  ->addValidator('EmailAddress')
        	  ->addValidator('stringLength', false, array(1, 100))
         	  ->setRequired(true)
              ->addFilter('StringToLower')
             ->setAttrib('class', 'form-control')
             ->setDecorators($this->_inputDecorator);

        $o_Password = new Zend_Form_Element_Password('password');
        $o_Password->setLabel('ADMIN_USER_FORM_LABELS_Password')
        	  	 ->addValidator('NotEmpty')
        	  	 ->addValidator('stringLength', false, array(6))
         	  	 ->setRequired(true)
             	 ->setAttrib('class', 'form-control')
             	 ->setDecorators($this->_inputDecorator);

        $o_Password2 = new Zend_Form_Element_Password('password2');
        $o_Password2->setLabel('ADMIN_USER_FORM_LABELS_RePassword')
        	  	  ->addValidator('NotEmpty')
        	  	  ->addValidator('stringLength', false, array(6))
         	  	  ->setRequired(true)
             	  ->setAttrib('class', 'form-control')
             	  ->setDecorators($this->_inputDecorator);

        $o_Level = new Zend_Form_Element_Select('level');
        $o_Level->setLabel('ADMIN_USER_FORM_LABELS_Level')
        	  ->setAttrib('class', 'form-control')
        	  ->setDecorators($this->_inputDecorator);

        $o_Reset = new Zend_Form_Element_Reset('reset');
        $o_Reset->setLabel('ADMIN_FORM_BtnReset')
	        ->setAttrib('class', 'btn btn-warning btn-block')
	        ->setName('reset')
	        ->setDecorators($this->_buttonDecorators);

        $o_Save = new Zend_Form_Element_Submit('submit');
        $o_Save->setLabel('ADMIN_FORM_BtnSubmit')
        	 ->setAttrib('class', 'btn btn-primary btn-block')
        	 ->setName('submitUser')
        	 ->setDecorators($this->_buttonDecorators);

        $o_Cancel = new Zend_Form_Element_Button('cancel');
        $o_Cancel->setLabel('ADMIN_FORM_BtnCancel')
	        ->setAttrib('class', 'btn btn-default btn-block')
	        ->setAttrib('onclick', 'window.history.back()')
	        ->setName('cancel')
	        ->setDecorators($this->_buttonDecorators);

       	$this->addElements(
            array(
                $o_Id,
            	$o_IsRequiredMsg,
            	$o_IsInvalidMsg,
            	$o_MaxLengthMsg,
            	$o_MinLengthMsg,
                $o_Name,
                $o_Email,
                $o_Password,
                $o_Password2,
                $o_Level,
            	$o_Reset,
                $o_Save,
            	$o_Cancel
            )
        );

       	$this->addDisplayGroup(array('reset', 'submitUser', 'cancel'), 'groupButtons', array(
       			'decorators' => array(
       					'FormElements',
       					array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class'=>'submit-group-btn col-xs-12')),
       			),
       	));
    }

    /**
     * Remover name validators
     * @author DungNT
     * @since 18/12/2013
     */
    public function v_fRemoverNameValidators() {
    	$o_Name = $this->getElement('name');
    	$o_Name->removeValidator('NotEmpty');
    	$o_Name->removeValidator('Alpha');
    	$o_Name->removeValidator('stringLength');
    	$o_Name->setRequired(false);
    }

    /**
     * User filter criteria form
     * @author DungNT
     * @since 18/12/2013
     * @param $the_sz_ActUrl
     * @param $the_a_AllParams
     */
    public function v_fUserFilterForm($the_sz_ActUrl, $the_a_AllParams)
    {
    	$this->removeElement('id');
    	$this->removeElement('password');
    	$this->removeElement('password2');
    	$this->removeElement('reset');
    	$this->removeElement('submitUser');
    	$this->removeElement('cancel');
    	$this->removeDisplayGroup('groupButtons');

   		$o_Name = $this->getElement('name');
   		$o_Name->setLabel('ADMIN_USER_TABLE_TITLE_Name')
    		->removeValidator('NotEmpty')
    		->removeValidator('regex')
    		->removeValidator('stringLength')
    		->removeFilter('StringToLower')
    		->setRequired(false)
    		->setAttrib('class', 'form-control')
    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_USER_TABLE_TITLE_Name'))
    		->setDecorators($this->_filterDecorators);

   		$o_Email = $this->getElement('email');
    	$o_Email->setLabel('ADMIN_USER_TABLE_TITLE_Email')
    		->removeValidator('NotEmpty')
    		->removeValidator('EmailAddress')
    		->removeValidator('stringLength')
    		->removeFilter('StringToLower')
    		->setRequired(false)
    		->setAttrib('class', 'form-control')
    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_USER_TABLE_TITLE_Email'))
    		->setDecorators($this->_filterDecorators);

    	$o_Level = $this->getElement('level');
    	$o_Level->setLabel('ADMIN_USER_FORM_LABELS_Level')
    		->setAttrib('class', 'form-control')
    		->setDecorators($this->_filterDecorators);

    	$o_StatusFilter = new Zend_Form_Element_Select('status');
    	$o_StatusFilter->setLabel('ADMIN_TABLE_TITLE_Status')
	    	->setMultiOptions(array(2 => 'ADMIN_TABLE_TITLE_Status', 1 => 'ADMIN_TABLE_TITLE_StatusOn', 0 => 'ADMIN_TABLE_TITLE_StatusOff'))
	    	->setValue(2)
	    	->setAttrib('class', 'form-control')
	    	->setDecorators($this->_filterDecorators);

    	$a_ElmIdList = array('name', 'email', 'level', 'status');

    	$o_Reset = new Zend_Form_Element_Button('resetdata');
    	$o_Reset->setAttrib('class', 'btn btn-default btn-block')
	    	->setAttrib('sz_Url', $the_sz_ActUrl)
	    	->setAttrib('onclick', 'COMMON.v_fResetAction(\'userform\');')
	    	->setName('ADMIN_FORM_BtnReset')
	    	->setDecorators($this->_filterDecorators);

    	$o_Search = new Zend_Form_Element_Button('search');
    	$o_Search->setAttrib('class', 'btn btn-primary btn-block')
	    	->setAttrib('sz_Url', $the_sz_ActUrl)
	    	->setAttrib('onclick', 'COMMON.v_fFilterAction(this.id, ' . json_encode($a_ElmIdList) .');')
	    	->setName('ADMIN_FORM_FILTER_BtnSearch')
	    	->setDecorators($this->_filterDecorators);

    	$this->addElements(array($o_StatusFilter, $o_Reset, $o_Search));

    	foreach($the_a_AllParams as $sz_Field => $sz_Value)
    	{
    		$o_Element = $this->getElement($sz_Field);

    		if($o_Element)
    		{
    			$o_Element->setValue($sz_Value);
    		}
    	}
    }
}