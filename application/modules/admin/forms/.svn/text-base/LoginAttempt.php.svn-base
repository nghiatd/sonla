<?php

class Admin_Form_LoginAttempt extends Zend_Form
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

    	$this->setName('loginAttemptForm');
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
        // @todo
        $o_Name = new Zend_Form_Element_Text('username');
        $o_Name->setLabel('ADMIN_USER_FORM_LABELS_Username')
        	 ->addValidator('NotEmpty')
        	 ->addValidator('regex', false, array('/^[\w.-]*$/','messages'=>array('regexNotMatch'=>'There was some random custom error')))
        	 ->addValidator('stringLength', false, array(5, 150))
         	 ->setRequired(true)
             ->addFilter('StringToLower')
             ->setAttrib('class', 'form-control')
             ->setDecorators($this->_inputDecorator);

        $o_IP = new Zend_Form_Element_Text('ip');
        $o_IP->setLabel('ADMIN_LOGIN_ATT_IP')
        	  ->addValidator('NotEmpty')
        	  ->addValidator('stringLength', false, array(1, 100))
         	  ->setRequired(true)
              ->addFilter('StringToLower')
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
        	 ->setName('submit')
        	 ->setDecorators($this->_buttonDecorators);

        $o_Cancel = new Zend_Form_Element_Button('cancel');
        $o_Cancel->setLabel('ADMIN_FORM_BtnCancel')
	        ->setAttrib('class', 'btn btn-default btn-block')
	        ->setAttrib('onclick', 'window.history.back()')
	        ->setName('cancel')
	        ->setDecorators($this->_buttonDecorators);

       	$this->addElements(
            array(
                $o_Name,
                $o_IP,
            	$o_Reset,
                $o_Save,
            	$o_Cancel
            )
        );

       	$this->addDisplayGroup(array('reset', 'submit', 'cancel'), 'groupButtons', array(
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
    	$this->removeElement('reset');
    	$this->removeElement('submit');
    	$this->removeElement('cancel');
    	$this->removeDisplayGroup('groupButtons');

   		$o_Name = $this->getElement('username');
   		$o_Name->setLabel('ADMIN_USER_TABLE_TITLE_Name')
    		->removeValidator('NotEmpty')
    		->removeValidator('regex')
    		->removeValidator('stringLength')
    		->removeFilter('StringToLower')
    		->setRequired(false)
    		->setAttrib('class', 'form-control')
    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_USER_TABLE_TITLE_Name'))
    		->setDecorators($this->_filterDecorators);

   		$o_Ip = $this->getElement('ip');
    	$o_Ip->setLabel('ADMIN_LOGIN_ATT_IP')
    		->removeValidator('NotEmpty')
    		->removeValidator('stringLength')
    		->removeFilter('StringToLower')
    		->setRequired(false)
    		->setAttrib('class', 'form-control')
    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_LOGIN_ATT_IP'))
    		->setDecorators($this->_filterDecorators);

    	$o_StatusFilter = new Zend_Form_Element_Select('success');
    	$o_StatusFilter->setLabel('ADMIN_LOGIN_ATT_SUCCESS')
	    	->setMultiOptions(array('' => 'ADMIN_LOGIN_ATT_SUCCESS', 1 => 'ADMIN_LOGIN_ATT_LOGIN_SUCCESS', 0 => 'ADMIN_LOGIN_ATT_LOGIN_FAIL'))
	    	->setValue('')
	    	->setAttrib('class', 'form-control')
	    	->setDecorators($this->_filterDecorators);

    	$a_ElmIdList = array('username', 'ip', 'success');

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
