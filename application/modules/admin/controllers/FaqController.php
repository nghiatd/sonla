<?php

class Admin_FaqController extends Zend_Controller_Action
{
	protected $_a_AllParams;

	protected $_sz_ActUrl;

	protected $_sz_Action;

	protected $_o_FaqRepository;

	protected $_o_FaqEntity;

	protected $_o_FaqForm;

	protected $_locale;

	protected $_translate;

    public function init()
    {
        // Check if user is logged
        if ( !$this->_helper->Authentication->hasIdentity() ) {
    		$this->_redirect("admin/login");
    	}

    	// update the user's activity
        $this->_helper->Authentication->updateUserActivity();

        // Get locale from session
        $o_SessionCommon = new Zend_Session_Namespace('COMMON');
        $this->_locale = $o_SessionCommon->language;

        // Get translate
        $this->_translate = Zend_Registry::get('Zend_Translate');

        // Get all params
        $a_AllParams = $this->getAllParams();

        $this->_sz_ActUrl = '/' . $a_AllParams['module'] . '/' . $a_AllParams['controller'] . '/' . $a_AllParams['action'] . '/';

        $this->_sz_Action = $a_AllParams['action'];

        unset($a_AllParams['module']);
        unset($a_AllParams['controller']);
        unset($a_AllParams['action']);

        $this->_a_AllParams = $a_AllParams;

        // Get faq model repository
        $this->_o_FaqRepository = new Admin_Model_Faq_Repository();

        // Get faq model entity
        $this->_o_FaqEntity = new Admin_Model_Faq_Entity();

        // Get faq form
        $this->_o_FaqForm = new Admin_Form_Faq();

        /* nhungnt - Update title & layout */
        switch ($this->_sz_Action)
        {
        	case 'business':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_FaqBusiness');
        		break;
        	case 'citizen':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_FaqCitizen');
        		break;
        	case 'tourer':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_FaqTourer');
        		break;
        	default:
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Faq');
				break;

        }
        $this->view->title = $sz_Title;
        $this->view->headTitle($sz_Title);
        $this->view->selectedMenu = 'faq';
        $this->_helper->layout->setLayout('admin/layout');
    }

    /**
     * Index action
     * @author nhungnt
     * @since 26/04/2014
     */
    public function indexAction()
    {
    	$this->v_fFaqManager(Zf_Util_Const::FAQ_CODE_INTRO);
    }

    /**
     * Introduce action
     * @author nhungnt
     * @since 26/04/2014
     */
    public function introAction()
    {
    	$this->v_fFaqManager(Zf_Util_Const::FAQ_CODE_INTRO);
    }

    /**
     * Business action
     * @author nhungnt
     * @since 26/04/2014
     */
    public function businessAction()
    {
    	$this->v_fFaqManager(Zf_Util_Const::FAQ_CODE_BUSINESS);
    }

    /**
     * Citizen action
     * @author nhungnt
     * @since 26/04/2014
     */
    public function citizenAction()
    {
    	$this->v_fFaqManager(Zf_Util_Const::FAQ_CODE_CITIZEN);
    }

	 /**
     * Tourer action
     * @author nhungnt
     * @since 26/04/2014
     */
    public function tourerAction()
    {
    	$this->v_fFaqManager(Zf_Util_Const::FAQ_CODE_TOURER);
    }

    /**
     * Faq managerment
     * @author nhungnt
     * @since 26/04/2014
     * @param string $the_sz_ActionName
     */
    public function v_fFaqManager($the_sz_ActionName)
    {
    	$sz_Order = $this->_getParam('order', 'id' . '-asc');

    	$i_Page = $this->_getParam('page', Zf_Util_Const::PAGE_NUM);

    	$i_ItemPerPage = $this->_getParam('perpage', Zf_Util_Const::ITEMS_PER_PAGE);

    	// Get table config
    	$a_TableConfig = $this->a_fGetTableConfig($the_sz_ActionName, $sz_Order);

    	// Parse filter with param and data from table config
    	$a_FilterWhere = $this->_helper->UrlFilterBy->a_fParseFilter($this->_a_AllParams, $a_TableConfig);

    	// Parse order with param and table config
    	$sz_OrderStr = $this->_helper->UrlOrderBy->sz_fParseOrder($sz_Order, $a_TableConfig);

    	// Set action name to filter
    	
    	$a_FilterWhere['F.FAQ_CategoryId'] = $the_sz_ActionName;

    	// Get select object from repository
    	$o_Select = $this->_o_FaqRepository->o_fGetSelect($sz_OrderStr, $a_FilterWhere);
		print_r($a_TableConfig);die;
    	// Parse paginator to select object
    	$this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);

    	$this->view->tableConfig = $a_TableConfig;
    }

    /**
     * Get Table config
     * @author nhungnt
     * @since 27/04/2014
     * @param string $the_sz_CatCode
     * @param string $the_sz_Order
     * @return array
     */
    public function a_fGetTableConfig($the_sz_FaqCatCode, $the_sz_Order)
    {
    	//print_r($this->getAllParams());
    	// Function confirm delete when click on delete btn
    	$sz_ConfirmDeleteCat = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/faq/delete\', \'' . $the_sz_FaqCatCode . '\', \'' . $this->_translate->translate('ADMIN_FAQ_ALERT_MSG_DeleteFaqConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_FAQ_ALERT_MSG_SureDeleteThisFaq') . '\')';

    	// Set action url and param to filter form
    	$this->_o_FaqForm->v_fFaqFilterForm($this->_sz_ActUrl, $this->_a_AllParams);

    	// Set translation to faq
    	$a_CatTrans = array(
    		Zf_Util_Const::FAQ_CODE_INTRO => $this->_translate->translate('ADMIN_NAV_MENU_FaqIntro'),
    		Zf_Util_Const::FAQ_CODE_BUSINESS => $this->_translate->translate('ADMIN_NAV_MENU_FaqBusiness'),
    		Zf_Util_Const::FAQ_CODE_CITIZEN => $this->_translate->translate('ADMIN_NAV_MENU_FaqCitizen'),
    		Zf_Util_Const::FAQ_CODE_TOURER => $this->_translate->translate('ADMIN_NAV_MENU_FaqTourer')
    	);

    	// Array table config
    	$a_TableConfig = array(
    		'setting' => array('filter' => true, 'multidelete' => true, 'locale' => $this->_locale,'not_allow_add_action'=> true),
    		//'filterform' => $this->_o_FaqForm,
    		'columns' => array(
    			'category' 		=> array('selected' => true, 'title' => $this->_translate->translate('ADMIN_FAQ_TABLE_TITLE_category')),
    			'title' 		=> array('selected' => true, 'title' => $this->_translate->translate('ADMIN_FAQ_TABLE_TITLE_title')),
    			'status' 		=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Status')),
    			//'lastActivity' 	=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_LastVisit'), 'filter' => create_function('$value', 'return date("d/m/Y H:i:s", $value);')),
    		),
    		'mapper' => new Admin_Model_Faq_Mapper(),
    		'order' => $the_sz_Order,
    		'default-order' => array('title', 'asc'),
    		'url' => array(
    			'module' => 'admin',
    			'controller' => 'faq',
    			'action' => $the_sz_FaqCatCode,
    			'id' => 'id',
    			'code'=>$the_sz_FaqCatCode
    		),
    		'info' => array(
    			'module' => array('name' => 'admin', 'trans' => 'Admin'),
    			'controller' => array('name' => 'faq', 'trans' => $this->_translate->translate('ADMIN_NAV_MENU_Faq')),
    			'action' => array('name' => $the_sz_FaqCatCode, 'trans' => $a_CatTrans[$the_sz_FaqCatCode])
    		),
    		'deletefunc' => $sz_ConfirmDeleteCat,

    	);
    	return $a_TableConfig;
    }

    /**
     * Answer faq action
     * @author nhungnt
     * @since 27/04/2014
     * @return boolean
     */
	public function  editAction()
    {
    	//print_r($this->getRequest()->getParams());die;
        // Get all params
        $a_AllParams = $this->getAllParams();

        // Get CAT_Code
        $sz_CatCode = $a_AllParams['controller'];

        $o_FaqRepository = new Admin_Model_Faq_Repository();
        $this->_o_FaqForm->v_fRemoverTitleValidators();
		$this->_o_FaqForm->getElement('title')->setAttrib('readonly', 'readonly');
		$this->_o_FaqForm->getElement('title')->setDescription('');
    	$this->view->o_CatForm = $this->_o_FaqForm;

		 // Get tourer info by id
        $a_FaqInfo = $this->_o_FaqRepository->a_fGetFaqInfo( 'FAQ_Id', $this->_request->getParam('id') );
	//	print_r($a_FaqInfo);
    	// Verifies that was submitted via POST
    	if( !$this->_request->isPost() )
        {
            $this->_o_FaqForm->populate($a_FaqInfo);

            return false;

    	} else {
            // Gets the data passed valid POST
            $this->_params = $this->_request->getPost();
		//	print_r($this->_request->getPost());
            // If the data is not valid
            if( !$this->_o_FaqForm->isValid($this->_params) )
            {
                return false;

            } else {
                // Set value to entity
    			$this->_o_FaqEntity->setId( $this->_params['id'] )
				    			->setTitle( $this->_params['title'] )
				    			->setName( $this->_params['name'] )
				    			->setAnswer( $this->_params['answer'] )
				    			->setAddress($a_FaqInfo['address'])
				    			->setEmail($a_FaqInfo['email'])
				    			->setFaq_category_id($a_FaqInfo['faq_category_id'])
				    			->setContent($a_FaqInfo['content'])
				    			->setStatus( $this->_params['status'] )
				    			->setCreated_date($a_FaqInfo['createdDate'])
				    			->setLastActivity( time() );

                // Save data
                $this->_o_FaqRepository->v_fSave($this->_o_FaqEntity);

                // Return to list view
                $this->_redirect('/admin/faq/' . $a_CatFaqInfo['code']);
            }
    	}
    }

    /**
     * Delete faq action
     * @author nhungnt
     * @since 27/04/2014
     * @return boolean
     */
    public function deleteAction()
    {
    	$i_Id = $this->_request->getParam('id');

    	$sz_ActionName = $this->_request->getParam('act');

    	$this->_o_FaqEntity->setId( $i_Id );

    	$b_Result = $this->_o_FaqRepository->b_fDelete( $this->_o_FaqEntity );

    	$o_Result = new stdClass();

    	$o_Result->sz_ResultMsg = '';

    	$o_Result->sz_Url = '';

    	if( $b_Result )
    	{
    		$o_Result->sz_ResultMsg = '';

    		$o_Result->sz_Url = '/admin/faq/' . $sz_ActionName . '/';

    	} else {

    		$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_FAQ_ALERT_MSG_CannotDeleteThis');

    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
    }

    /**
     * Multi delete faq action
     * @author nhungnt
     * @since 27/04/2014
     */
    public function multideleteAction()
    {
    	$a_IdsList = $this->_request->getParam('a_IdsList');

    	$sz_ActionName = $this->_request->getParam('act');

    	$b_Result = $this->_o_FaqRepository->b_fMultiDelete( $a_IdsList );

    	$o_Result = new stdClass();

    	$o_Result->sz_ResultMsg = '';

    	$o_Result->sz_Url = '';

    	if( $b_Result )
    	{
    		$o_Result->sz_ResultMsg = '';

    		$o_Result->sz_Url = '/admin/faq/' . $sz_ActionName . '/';

    	} else {

    		$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_ALERT_MSG_CannotDeleteThese');

    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
    }

}
