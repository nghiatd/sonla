<?php

class Admin_Form_Business extends Zend_Form
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

        $o_NameEn = new Zend_Form_Element_Text('name_en');
        $o_NameEn->setLabel('ADMIN_BUSINESS_FORM_LABELS_NameEn')
        	->addValidator('NotEmpty')
        	->addValidator('Alnum', true, array('allowWhiteSpace' => true))
        	->addValidator('stringLength', false, array(0, 255))
         	->setRequired(true)
            ->setAttrib('class', 'form-control')
            ->setDecorators($this->_inputDecorator);

        $o_NameVi = new Zend_Form_Element_Text('name_vi');
        $o_NameVi->setLabel('ADMIN_BUSINESS_FORM_LABELS_NameVi')
	        ->addValidator('NotEmpty')
	        ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
	        ->addValidator('stringLength', false, array(0, 255))
	        ->setRequired(true)
	        ->setAttrib('class', 'form-control')
	        ->setDecorators($this->_inputDecorator);

	    $o_Alias = new Zend_Form_Element_Text('alias');
        $o_Alias->setLabel('ADMIN_BUSINESS_FORM_LABELS_Alias')
        	->addValidator('NotEmpty')
        	->addValidator('Alnum', true, array('allowWhiteSpace' => true))
        	->addValidator('stringLength', false, array(0, 255))
         	->setRequired(true)
                ->setAttrib('class', 'form-control')
                ->setDecorators($this->_inputDecorator);    
	    
        $o_DescEn = new Zend_Form_Element_Text('description_en');
        $o_DescEn->setLabel('ADMIN_BUSINESS_FORM_LABELS_DescEn')
	        ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
	        ->addValidator('stringLength', false, array(0, 255))
	        ->setRequired(false)
	        ->setAttrib('class', 'form-control')
	        ->setDecorators($this->_inputDecorator);

        $o_DescVi = new Zend_Form_Element_Text('description_vi');
        $o_DescVi->setLabel('ADMIN_BUSINESS_FORM_LABELS_DescVi')
	        ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
	        ->addValidator('stringLength', false, array(0, 255))
	        ->setRequired(false)
	        ->setAttrib('class', 'form-control')
	        ->setDecorators($this->_inputDecorator);
	        
	    $o_ContentEn = new Zend_Form_Element_Textarea('content_en');
        $o_ContentEn->setLabel('ADMIN_BUSINESS_FORM_LABELS_ContentEn')
        	->addValidator('NotEmpty')
        	->addValidator('Alnum', true, array('allowWhiteSpace' => true))
        	->addValidator('stringLength', false, array(5, 50))
         	->setRequired(true)
            ->setAttribs(array('class'=>'','cols' => 60, 'rows' => 6))
            ->setDecorators($this->_inputDecorator);

        $o_ContentVi = new Zend_Form_Element_Textarea('content_vi');
        $o_ContentVi->setLabel('ADMIN_BUSINESS_FORM_LABELS_ContentVi')
	        ->addValidator('NotEmpty')
	        ->addValidator('Alnum', true, array('allowWhiteSpace' => true))
	        ->addValidator('stringLength', false, array(5, 50))
	        ->setRequired(true)
                ->setAttribs(array('class'=>'','cols' => 60, 'rows' => 6))
	        ->setDecorators($this->_inputDecorator);    
	      
        $o_ParentBusi = new Zend_Form_Element_Select('category_id');
        $o_ParentBusi->setLabel('ADMIN_BUSINESS_FORM_LABELS_ParentBusi')
        	  ->setAttrib('class', 'form-control')
        	  ->setRequired(true)
        	  ->setDecorators($this->_inputDecorator);
		
        $o_Sort = new Zend_Form_Element_Text('sort');
        $o_Sort->setLabel('ADMIN_BUSINESS_FORM_LABELS_Sort')
	        ->addValidator('NotEmpty')
	        ->addValidator('Digits')
	        ->addValidator('stringLength', false, array(1, 5))
	        ->setRequired(true)
	        ->setAttrib('class', 'form-control')
	        ->setValue('9999')
	        ->setDecorators($this->_inputDecorator);

        $o_Status = new Zend_Form_Element_Checkbox('status');
        $o_Status->setLabel('ADMIN_BUSINESS_FORM_LABELS_Status')
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
                $o_NameEn,
            	$o_NameVi,
                $o_ContentEn,
            	$o_ContentVi,
                $o_DescEn,
                $o_DescVi,
            	$o_Alias,
                $o_ParentBusi,
                $o_Sort,
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
     * Business filter
     * @author QuyetDN
     * @since 09/05/2014
     * @param $the_sz_ActUrl
     * @param $the_a_AllParams
     */
    public function v_fBusiFilterForm($the_sz_ActUrl, $the_a_AllParams)
    {
    	$this->removeElement('id');
    	$this->removeElement('category_id');
    	$this->removeElement('status');
    	$this->removeElement('content_vi');
    	$this->removeElement('content_en');
    	$this->removeElement('alias');
    	$this->removeElement('sort');
    	$this->removeElement('reset');
    	$this->removeElement('submit');
    	$this->removeElement('cancel');
    	$this->removeDisplayGroup('groupButtons');

    	$sz_CatCode= $the_a_AllParams['controller'];

        $o_CategoriesRepository = new Admin_Model_Categories_Repository();

        $a_CategoryData = $o_CategoriesRepository->a_fGetParentCatForForm($sz_CatCode, $this->_translate->translate('ADMIN_BUSINESS_TABLE_ParentBusi'));
    	
    	if( $this->_locale == Zf_Util_Const::LANG_EN )
    	{
    		$o_NameEn = $this->getElement('name_en');
    		$o_NameEn->setLabel('ADMIN_BUSINESS_TABLE_TITLE_Name')
    				->removeValidator('NotEmpty')
		    		->setRequired(false)
		    		->setAttrib('class', 'form-control')
		    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_BUSINESS_TABLE_TITLE_Name'))
		    		->setDecorators($this->_filterDecorators);

    		$o_DescEn = $this->getElement('description_en');
    		$o_DescEn->setLabel('ADMIN_CAT_TABLE_TITLE_Desc')
    				->setAttrib('class', 'form-control')
		    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_BUSINESS_TABLE_Description'))
    				->setDecorators($this->_filterDecorators);

    		$this->removeElement('name_vi');
    		$this->removeElement('description_vi');
    	}
    	else if( $this->_locale == Zf_Util_Const::LANG_VI )
    	{
    		$o_NameVi = $this->getElement('name_vi');
    		$o_NameVi->setLabel('ADMIN_BUSINESS_TABLE_TITLE_Name')
    				->removeValidator('NotEmpty')
		    		->setRequired(false)
		    		->setAttrib('class', 'form-control')
		    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_BUSINESS_TABLE_TITLE_Name'))
		    		->setDecorators($this->_filterDecorators);

    		$o_DescVi = $this->getElement('description_vi');
    		$o_DescVi->setLabel('ADMIN_BUSINESS_TABLE_Description')
    				->setAttrib('class', 'form-control')
		    		->setAttrib('placeholder', $this->_translate->translate('ADMIN_BUSINESS_TABLE_Description'))
    				->setDecorators($this->_filterDecorators);

    		$this->removeElement('name_en');
    		$this->removeElement('description_en');
    	}
    	
    	$o_CategoryFilter = new Zend_Form_Element_Select('category_id');
    	$o_CategoryFilter->setLabel('ADMIN_BUSINESS_TABLE_ParentBusi')
		    	->setMultiOptions($a_CategoryData)
		    	->setValue('')
		    	->setAttrib('class', 'form-control')
		    	->setDecorators($this->_filterDecorators);
		
    	$o_StatusFilter = new Zend_Form_Element_Select('status');
    	$o_StatusFilter->setLabel('ADMIN_TABLE_TITLE_Status')
    			->setMultiOptions(array('' => 'ADMIN_TABLE_TITLE_Status', 1 => 'ADMIN_TABLE_TITLE_StatusOn', 0 => 'ADMIN_TABLE_TITLE_StatusOff'))
    			->setValue(2)
		    	->setAttrib('class', 'form-control')
    			->setDecorators($this->_filterDecorators);

    	$a_ElmIdList = array('name_' . $this->_locale, 'description_' . $this->_locale, 'sort', 'status', 'category_id');

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

    	$this->addElements(array($o_CategoryFilter ,$o_StatusFilter, $o_Reset, $o_Search));
    	
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