<?php

class Admin_ContentController extends Zend_Controller_Action
{
	protected $_a_AllParams;

	protected $_sz_ActUrl;

	protected $_sz_Action;

	protected $_o_ContentRepository;

	protected $_o_ContentEntity;

	protected $_o_ContentForm;

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

        // Get category model repository
        $this->_o_ContentRepository = new Admin_Model_Content_Repository();

        // Get category model entity
        $this->_o_ContentEntity = new Admin_Model_Content_Entity();

        // Get category form
        $this->_o_ContentForm = new Admin_Form_Content();

        /* NgocNV - Update title & layout */
        switch ($this->_sz_Action)
        {
        	case 'intro':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_CatIntro');
        		break;
        	case 'news':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_CatNews');
        		break;
        	case 'org':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_CatOrg');
        		break;
        	case 'business':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_CatBusiness');
        		break;
        	case 'citizen':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_ContentCitizen');
        		break;
        		case 'add':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_AddCat');
        		break;
        	case 'edit':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_EditCat');
        		break;
        	case 'tourer':
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_CatTourer');
        		break;
        	default:
        		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Content');
				break;

        }
        $this->view->title = $sz_Title;
        $this->view->headTitle($sz_Title);
        $this->view->selectedMenu = 'categories';
        $this->_helper->layout->setLayout('admin/layout');
    }

    /**
     * Index action
     * @author DungNT
     * @since 03/12/2013
     */
    public function indexAction()
    {
    	$this->v_fContentManager(Zf_Util_Const::CAT_CODE_INTRO);
    }

    /**
     * Introduce action
     * @author DungNT
     * @since 14/12/2013
     */
    public function introAction()
    {
    	$this->v_fContentManager(Zf_Util_Const::CAT_CODE_CITIZEN);
    }

    /**
     * Organize action
     * @author DungNT
     * @since 14/12/2013
     */
    public function orgAction()
    {
    	$this->v_fContentManager(Zf_Util_Const::CAT_CODE_ORG);
    }

    /**
     * News action
     * @author DungNT
     * @since 14/12/2013
     */
    public function newsAction()
    {
    	$this->v_fContentManager(Zf_Util_Const::CAT_CODE_NEWS);
    }

    /**
     * Business action
     * @author DungNT
     * @since 14/12/2013
     */
    public function businessAction()
    {
    	$this->v_fContentManager(Zf_Util_Const::CAT_CODE_BUSINESS);
    }

    /**
     * Citizen action
     * @author DungNT
     * @since 14/12/2013
     */
    public function citizenAction()
    {
    	$this->v_fContentManager(Zf_Util_Const::CAT_CODE_CITIZEN);
    }

	 /**
     * Tourer action
     * @author nhungnt
     * @since 23/04/2014
     */
    public function tourerAction()
    {
    	$this->v_fContentManager(Zf_Util_Const::CAT_CODE_TOURER);
    }

    /**
     * Content managerment
     * @author DungNT
     * @since 14/12/2013
     * @param string $the_sz_ActionName
     */
    public function v_fContentManager($the_sz_ActionName)
    {
    	$sz_Order = $this->_getParam('order', 'name_' . $this->_locale . '-asc');

    	$i_Page = $this->_getParam('page', Zf_Util_Const::PAGE_NUM);

    	$i_ItemPerPage = $this->_getParam('perpage', Zf_Util_Const::ITEMS_PER_PAGE);

    	// Get table config
    	$a_TableConfig = $this->a_fGetTableConfig($the_sz_ActionName, $sz_Order);

    	// Parse filter with param and data from table config
    	$a_FilterWhere = $this->_helper->UrlFilterBy->a_fParseFilter($this->_a_AllParams, $a_TableConfig);

    	// Parse order with param and table config
    	$sz_OrderStr = $this->_helper->UrlOrderBy->sz_fParseOrder($sz_Order, $a_TableConfig);

    	// Set action name to filter
    	$a_FilterWhere['CONTENT_Code'] = $the_sz_ActionName;

    	// Get select object from repository
    	$o_Select = $this->_o_ContentRepository->o_fGetSelect($sz_OrderStr, $a_FilterWhere);

    	// Parse paginator to select object
    	$this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);

    	$this->view->tableConfig = $a_TableConfig;
    }

    /**
     * Get Table config
     * @author DungNT
     * @since 14/12/2013
     * @param string $the_sz_CatCode
     * @param string $the_sz_Order
     * @return array
     */
    public function a_fGetTableConfig($the_sz_CatCode, $the_sz_Order)
    {
    	// Function confirm delete when click on delete btn
    	$sz_ConfirmDeleteCat = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/content/delete\', \'' . $the_sz_CatCode . '\', \'' . $this->_translate->translate('ADMIN_CAT_ALERT_MSG_DeleteCatConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_CAT_ALERT_MSG_SureDeleteThisCat') . '\')';

    	// Set action url and param to filter form
    	$this->_o_ContentForm->v_fContentFilterForm($this->_sz_ActUrl, $this->_a_AllParams);

    	// Set translation to category
    	$a_CatTrans = array(
    		Zf_Util_Const::CAT_CODE_INTRO => $this->_translate->translate('ADMIN_NAV_MENU_CatIntro'),
    		Zf_Util_Const::CAT_CODE_NEWS => $this->_translate->translate('ADMIN_NAV_MENU_CatNews'),
    		Zf_Util_Const::CAT_CODE_ORG => $this->_translate->translate('ADMIN_NAV_MENU_CatOrg'),
    		Zf_Util_Const::CAT_CODE_BUSINESS => $this->_translate->translate('ADMIN_NAV_MENU_CatBusiness'),
    		Zf_Util_Const::CAT_CODE_CITIZEN => $this->_translate->translate('ADMIN_NAV_MENU_ContentCitizen'),
    		Zf_Util_Const::CAT_CODE_TOURER => $this->_translate->translate('ADMIN_NAV_MENU_CatTourer')
    	);

    	// Array table config
    	$a_TableConfig = array(
    		'setting' => array('filter' => true, 'multidelete' => true, 'locale' => $this->_locale),
    		'filterform' => $this->_o_ContentForm,
    		'columns' => array(
    			'name_' . $this->_locale		=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_CONTENT_TABLE_TITLE_Name')),
    			'description_' . $this->_locale => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_CONTENT_TABLE_TITLE_Desc')),
    			'sort' 							=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Sort')),
    			'status' 						=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Status')),
    			'lastActivity' 					=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_LastVisit'), 'filter' => create_function('$value', 'return date("d/m/Y H:i:s", $value);')),
    		),
    		'mapper' => new Admin_Model_Content_Mapper(),
    		'order' => $the_sz_Order,
    		'default-order' => array('name_' . $this->_locale, 'asc'),
    		'url' => array(
    			'module' => 'admin',
    			'controller' => 'content',
    			'action' => $the_sz_CatCode,
    			'id' => 'id'
    		),
    		'info' => array(
    			'module' => array('name' => 'admin', 'trans' => 'Admin'),
    			'controller' => array('name' => 'content', 'trans' => $this->_translate->translate('ADMIN_NAV_MENU_Content')),
    			'action' => array('name' => $the_sz_CatCode, 'trans' => $a_CatTrans[$the_sz_CatCode])
    		),
    		'deletefunc' => $sz_ConfirmDeleteCat,
    	);

    	return $a_TableConfig;
    }

    /**
     * Add action to add new category
     * @author DungNT
     * @since 16/12/2013
     * @return boolean
     */
    public function addAction()
    {
    	$a_ParentCat = $this->_o_ContentRepository->a_fGetParentCatForForm();

    	$this->_o_ContentForm->getElement('parent_id')->setMultiOptions($a_ParentCat);

    	$this->view->o_CatForm = $this->_o_ContentForm;

    	if( $this->_request->isPost() ) {
	    	// Gets the data passed via POST
	    	$this->_params = $this->_request->getPost();

	    	// If the data is not valid
	    	if( !$this->_o_ContentForm->isValid($this->_params) ) {

	    		return false;

	    	} else {

	    		// Set value to entity
	    		$this->_o_ContentEntity->setName_en( $this->_params['name_en'] )
						    		->setName_vi( $this->_params['name_vi'] )
						    		->setDescription_en( $this->_params['description_en'] )
						    		->setDescription_vi( $this->_params['description_vi'] )
						    		->setParent_id( $this->_params['parent_id'] )
						    		->setSort( $this->_params['sort'] )
						    		->setStatus( $this->_params['status'] )
						    		->setLastActivity( time() );

	    		// Save data
	    		$this->_o_ContentRepository->v_fSave($this->_o_ContentEntity);

	    		// Get parent category info by parent id
	    		$a_ParentCatInfo = $this->_o_ContentRepository->a_fGetCatInfo( 'CAT_Id', $this->_request->getParam('parent_id') );

	    		// Return to list view
	    		$this->_redirect('/admin/categories/' . $a_ParentCatInfo['code']);
	    	}
    	}
    }

    /**
     * Edit category action
     * @author DungNT
     * @since 16/12/2013
     * @return boolean
     */
    public function editAction()
    {
    	$a_ParentCat = $this->_o_ContentRepository->a_fGetParentCatForForm();

    	$this->_o_ContentForm->getElement('parent_id')->setMultiOptions($a_ParentCat);

    	$this->view->o_CatForm = $this->_o_ContentForm;

    	// Verifies that was submitted via POST
    	if( !$this->_request->isPost() ) {

    		// Get category info by id
    		$a_CatInfo = $this->_o_ContentRepository->a_fGetCatInfo( 'CAT_Id', $this->_request->getParam('id') );

    		$this->_o_ContentForm->populate($a_CatInfo);

    		return false;

    	} else {

    		// Gets the data passed via POST
    		$this->_params = $this->_request->getPost();

    		// If the data is not valid
    		if( !$this->_o_ContentForm->isValid($this->_params) ) {

    			return false;

    		} else {

    			// Set value to entity
    			$this->_o_ContentEntity->setId( $this->_params['id'] )
				    			->setName_en( $this->_params['name_en'] )
				    			->setName_vi( $this->_params['name_vi'] )
				    			->setDescription_en( $this->_params['description_en'] )
				    			->setDescription_vi( $this->_params['description_vi'] )
				    			->setParent_id( $this->_params['parent_id'] )
				    			->setSort( $this->_params['sort'] )
				    			->setStatus( $this->_params['status'] )
				    			->setLastActivity( time() );

    			// Save data
    			$this->_o_ContentRepository->v_fSave($this->_o_ContentEntity);

    			// Get parent category info by parent id
    			$a_ParentCatInfo = $this->_o_ContentRepository->a_fGetCatInfo( 'CAT_Id', $this->_request->getParam('parent_id') );

    			// Return to list view
	    		$this->_redirect('/admin/categories/' . $a_ParentCatInfo['code']);
    		}
    	}
    }

    /**
     * Delete category action
     * @author DungNT
     * @since 19/12/2013
     * @return boolean
     */
    public function deleteAction()
    {
    	$i_Id = $this->_request->getParam('id');

    	$sz_ActionName = $this->_request->getParam('act');

    	$this->_o_ContentEntity->setId( $i_Id );

    	$b_Result = $this->_o_ContentRepository->b_fDelete( $this->_o_ContentEntity );

    	$o_Result = new stdClass();

    	$o_Result->sz_ResultMsg = '';

    	$o_Result->sz_Url = '';

    	if( $b_Result )
    	{
    		$o_Result->sz_ResultMsg = '';

    		$o_Result->sz_Url = '/admin/categories/' . $sz_ActionName . '/';

    	} else {

    		$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_CAT_ALERT_MSG_CannotDeleteThis');

    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
    }

    /**
     * Multi delete category action
     * @author DungNT
     * @since 19/12/2013
     */
    public function multideleteAction()
    {
    	$a_IdsList = $this->_request->getParam('a_IdsList');

    	$sz_ActionName = $this->_request->getParam('act');

    	$b_Result = $this->_o_ContentRepository->b_fMultiDelete( $a_IdsList );

    	$o_Result = new stdClass();

    	$o_Result->sz_ResultMsg = '';

    	$o_Result->sz_Url = '';

    	if( $b_Result )
    	{
    		$o_Result->sz_ResultMsg = '';

    		$o_Result->sz_Url = '/admin/categories/' . $sz_ActionName . '/';

    	} else {

    		$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_ALERT_MSG_CannotDeleteThese');

    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
    }

}
