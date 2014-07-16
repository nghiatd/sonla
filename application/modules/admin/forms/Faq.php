<?php

class Admin_Form_Faq extends Zend_Form
{
	protected $_translate;
	
	protected $_locale;
	
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
    	
    	// Get locale from session
    	$o_SessionCommon = new Zend_Session_Namespace('COMMON');
    	$this->_locale = $o_SessionCommon->language;
    	 
        $this->setName('categoriesform');
    	$this->setAction('');
        $this->setMethod('POST');
        $this->setAttrib('role', 'form');
        
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
                        
        $o_Title = new Zend_Form_Element_Text('title');
        $o_Title->setLabel('ADMIN_FAQ_FORM_LABELS_Title')
			->addValidator('NotEmpty')
        	->addValidator('stringLength', false, array(5, 50))
         	->setRequired(true)
            ->setAttrib('class', 'form-control')
          //  ->setAttrib('disabled', 'disabled')
            ->setDecorators($this->_inputDecorator);
            
        
        $o_Name = new Zend_Form_Element_Text('name');
        $o_Name->setLabel('ADMIN_FAQ_FORM_LABELS_Name')
	       
	        ->setRequired(true)
	        ->setAttrib('class', 'form-control')
	       // ->setAttrib('disabled', 'disabled')
	        ->setDecorators($this->_inputDecorator);
      	 
        $o_Address = new Zend_Form_Element_Text('address');
        $o_Address->setLabel('ADMIN_FAQ_FORM_LABELS_Address')
	        
	        ->setRequired(false)
	        ->setAttrib('class', 'form-control')
	        ->setDecorators($this->_inputDecorator);
        
        $o_Email = new Zend_Form_Element_Text('email');
        $o_Email->setLabel('ADMIN_FAQ_FORM_LABELS_Email')
	      
	        ->setRequired(false)
	        ->setAttrib('class', 'form-control')
	        ->setDecorators($this->_inputDecorator);

	    $o_Content = new Zend_Form_Element_Textarea('content');
        $o_Content->setLabel('ADMIN_FAQ_FORM_LABELS_Content')
        	
        	->addValidator('stringLength', false)
         	->setRequired(true)
                ->setAttrib('id', 'post-content-en')
                ->setAttribs(array('class'=>'post-content','cols' => 60, 'rows' => 6))
                ->setDecorators($this->_inputDecorator); 

        $o_Answer = new Zend_Form_Element_Textarea('answer');
        $o_Answer->setLabel('ADMIN_FAQ_FORM_LABELS_Answer')
        	->addValidator('NotEmpty')
        	->addValidator('stringLength', false)
         	->setRequired(true)
                ->setAttrib('id', 'post-content-en')
                ->setAttribs(array('class'=>'post-content','cols' => 60, 'rows' => 6))
                ->setDecorators($this->_inputDecorator);  
                      
        $o_ParentCat = new Zend_Form_Element_Select('category_id');
        $o_ParentCat->setLabel('ADMIN_FAQ_FORM_LABELS_ParentCat')
        	  ->setAttrib('class', 'form-control')
        	  ->setRequired(true)
        	  ->setDecorators($this->_inputDecorator);
        	  
        $o_Status = new Zend_Form_Element_Checkbox('status');
        $o_Status->setLabel('ADMIN_CAT_FORM_LABELS_Status')
	        ->addValidator('NotEmpty')
	        ->addValidator('stringLength', false, array(1, 5))
	        ->setRequired(true)
	        ->setValue(1)
	        ->setDecorators($this->_checkboxDecorator);
        
        $o_Reset = new Zend_Form_Element_Reset('reset');
        $o_Reset->setLabel('ADMIN_FORM_BtnReset')
        	->setAttrib('class', 'btn btn-warning btn-block')	        
	        ->setDecorators($this->_buttonDecorators);
        
        $o_Save = new Zend_Form_Element_Submit('submit');
        $o_Save->setLabel('ADMIN_FORM_BtnSubmit')
        	->setAttrib('class', 'btn btn-primary btn-block')
        	->setDecorators($this->_buttonDecorators);
        
        $o_Cancel = new Zend_Form_Element_Button('cancel');
        $o_Cancel->setLabel('ADMIN_FORM_BtnCancel')
        	->setAttrib('class', 'btn btn-default btn-block')
	        ->setAttrib('onclick', 'window.history.back()')	        
	        ->setDecorators($this->_buttonDecorators);
        	 
      	$this->addElements(
            array(
                $o_Id,
                $o_Title,
            	$o_Name,
                $o_Answer,
            	$o_Status,
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
     * @author nhungnt
     * @since 8/5/2014
     */
    public function v_fRemoverTitleValidators() {
    	$o_Title = $this->getElement('title');
    	$o_Title->removeValidator('NotEmpty');
    	$o_Title->removeValidator('Alpha');
    	$o_Title->removeValidator('stringLength');
    	$o_Title->setRequired(false);
    }
    
    /**
     * Faq filter criteria form
     * @author nhungnt
     * @since 26/04/2014
     * @param $the_sz_ActUrl
     * @param $the_a_AllParams
     */
    public function v_fFaqFilterForm($the_sz_ActUrl, $the_a_AllParams)
    {
    	$this->removeElement('id');
    	$this->removeElement('parent_id');
    	$this->removeElement('status');
    	$this->removeElement('reset');
    	$this->removeElement('submit');
    	$this->removeElement('cancel');
    	$this->removeDisplayGroup('groupButtons');
    	
    //	if( $this->_locale == Zf_Util_Const::LANG_EN )
    //	{
    		$o_Title = new Zend_Form_Element_Text('title');
    		$o_Title->setLabel('ADMIN_FAQ_TABLE_TITLE_title')
    				->removeValidator('NotEmpty')
		    		->setRequired(false)
		    		->setAttrib('class', 'form-control')
		    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_FAQ_TABLE_TITLE_title'))
		    		->setDecorators($this->_filterDecorators);
    		
    	//} 
    	/*
    	else if( $this->_locale == Zf_Util_Const::LANG_VI )
    	{
    		$o_NameVi = $this->getElement('name_vi');
    		$o_NameVi->setLabel('ADMIN_CAT_TABLE_TITLE_Name')
    				->removeValidator('NotEmpty')
		    		->setRequired(false)
		    		->setAttrib('class', 'form-control')
		    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_CAT_TABLE_TITLE_Name'))
		    		->setDecorators($this->_filterDecorators);
    		
    		$o_DescVi = $this->getElement('description_vi');
    		$o_DescVi->setLabel('ADMIN_CAT_TABLE_TITLE_Desc')
    				->setAttrib('class', 'form-control')
		    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_CAT_TABLE_TITLE_Desc'))
    				->setDecorators($this->_filterDecorators);
    		
    		$this->removeElement('name_en');
    		$this->removeElement('description_en');
    	}*/
    	

    	$o_StatusFilter = new Zend_Form_Element_Select('status');
    	$o_StatusFilter->setLabel('ADMIN_TABLE_TITLE_Status')
    			->setMultiOptions(array(2 => 'ADMIN_TABLE_TITLE_Status', 1 => 'ADMIN_TABLE_TITLE_StatusOn', 0 => 'ADMIN_TABLE_TITLE_StatusOff'))
    			->setValue(2)
		    	->setAttrib('class', 'form-control')
    			->setDecorators($this->_filterDecorators);
    	
    	$a_ElmIdList = array('title', 'status');
    	
    	$o_Reset = new Zend_Form_Element_Button('resetdata');
    	$o_Reset->setAttrib('class', 'btn btn-default btn-block')
		    	->setAttrib('sz_Url', $the_sz_ActUrl)
		    	->setAttrib('onclick', 'COMMON.v_fResetAction(\'categoriesform\');')
		    	->setName('ADMIN_FORM_BtnReset')
		    	->setDecorators($this->_filterDecorators);
    	
    	$o_Search = new Zend_Form_Element_Button('search');
    	$o_Search->setAttrib('class', 'btn btn-primary btn-block')
    			->setAttrib('sz_Url', $the_sz_ActUrl)
		    	->setAttrib('onclick', 'COMMON.v_fFilterAction(this.id, ' . json_encode($a_ElmIdList) .');')
		    	->setName('ADMIN_FORM_FILTER_BtnSearch')
		    	->setDecorators($this->_filterDecorators);

    	$this->addElements(array($o_Title, $o_StatusFilter, $o_Reset, $o_Search));
    	 
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