<?php
class Admin_BusinessController extends Zend_Controller_Action
{
	protected $_a_AllParams = array();
	
	protected $_sz_ActUrl = '';
	
	protected $_locale;
	
	protected $_o_BusinessRepository;
	
	protected $_o_BusinessForm;
	
	protected $_o_BusinessEntity;
	
    public function init()
    {
    	// Check if user is logged
    	if ( !$this->_helper->Authentication->hasIdentity() ) {
    		
    		$this->_redirect("admin/login");
    		
    	}

    	$o_SessionCommon = new Zend_Session_Namespace('COMMON');
    	$this->_locale = $o_SessionCommon->language;

    	$this->_translate = Zend_Registry::get('Zend_Translate');
		
    	$o_SessionAuth = new Zend_Session_Namespace('Zend_Auth');

        $this->_SessionUserId= $o_SessionAuth->userId;
        
    	// Get all params
    	$a_AllParams = $this->getAllParams();

    	$this->_sz_ActUrl = '/' . $a_AllParams['module'] . '/' . $a_AllParams['controller'] . '/' . $a_AllParams['action'] . '/';

    	unset($a_AllParams['module']);
    	unset($a_AllParams['controller']);
    	unset($a_AllParams['action']);

    	// Get buziness model repository
    	$this->_o_BusinessRepository = new Admin_Model_Business_Repository();

    	// Get buziness form
    	$this->_o_BusinessForm = new Admin_Form_Business();
    	
    	// Get category model repository
    	$this->_o_CatRepository = new Admin_Model_Categories_Repository();
    	
    	// Get buziness model entity
        $this->_o_BusinessEntity = new Admin_Model_Business_Entity();

    	$this->_a_AllParams = $a_AllParams;
    	
    	$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Business');
    	
        $this->view->title = $sz_Title;
        
    	$this->view->headTitle($sz_Title);
    	
    	$this->view->selectedMenu = 'business';
    	
    	$this->_helper->layout->setLayout('admin/layout');
    }

    /**
     *
     * Index action
     * @author NgocNV
     * @since 31/03/2014
     */
    public function indexAction()
    {
    	$sz_Order = $this->_getParam('order', 'name_' . $this->_locale . '-asc');

    	$i_Page = $this->_getParam('page', Zf_Util_Const::PAGE_NUM);

    	$i_ItemPerPage = $this->_getParam('perpage', Zf_Util_Const::ITEMS_PER_PAGE);

    	// Get table config
    	$a_TableConfig = $this->a_fGetTableConfig('index', $sz_Order);

    	// Parse filter with param and data from table config
    	$a_FilterWhere = $this->_helper->UrlFilterBy->a_fParseFilter($this->_a_AllParams, $a_TableConfig);

    	// Parse order with param and table config
    	$sz_OrderStr = $this->_helper->UrlOrderBy->sz_fParseOrder($sz_Order, $a_TableConfig);

    	// Get select object from repository
    	$o_Select = $this->_o_BusinessRepository->o_fGetSelect($sz_OrderStr, $a_FilterWhere);

    	// Parse paginator to select object
    	$this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);
    	$this->view->tableConfig = $a_TableConfig;
    }

    /**
     * Get Table config
     * @author QuyetDN
     * @since 14/12/2013
     * @param string $the_sz_CatCode
     * @param string $the_sz_Order
     * @return array
     */
    public function a_fGetTableConfig($the_sz_ActionName, $the_sz_Order)
    {
    	// Function confirm delete when click on delete btn
    	$sz_ConfirmDeleteCat = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/business/delete\', \'index\',\'' . $this->_translate->translate('ADMIN_BUSINESS_ALERT_MSG_DeleteCatConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_BUSINESS_ALERT_MSG_SureDeleteThisBusiness') . '\')';
    	
    	// Set action url and param to filter form
    	$this->_o_BusinessForm->v_fBusiFilterForm($this->_sz_ActUrl, $this->getAllParams());

    	// Array table config
    	$a_TableConfig = array(
    			'setting' => array('filter' => true, 'multidelete' => true, 'locale' => $this->_locale),
    			'filterform' => $this->_o_BusinessForm,
    			'columns' => array(
    					'name_' . $this->_locale		=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_BUSINESS_TABLE_TITLE_Name')),
    					'description_' . $this->_locale => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_BUSINESS_TABLE_Description')),
    					'category_id'  					=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_BUSINESS_TABLE_ParentBusiName'),'field' => 'CAT_Name_'.$this->_locale),
    					'status' 						=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Status')),
    					'lastActivity' 					=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_LastVisit'), 'filter' => create_function('$value', 'return date("d/m/Y H:i:s", $value);')),
    			),
    			'mapper' => new Admin_Model_Business_Mapper(),
    			'order' => $the_sz_Order,
    			'default-order' => array('name_' . $this->_locale, 'asc'),
    			'url' => array(
    							'module' => 'admin',
    							'controller' => 'business',
    							'action' => $the_sz_ActionName,
    							'id' => 'id'
    					),
    					'info' => array(
    									'module' => array('name' => 'admin', 'trans' => 'Admin'),
    									'controller' => array('name' => 'business', 'trans' => $this->_translate->translate('ADMIN_NAV_MENU_Business')),
    									'action' => array('name' => $the_sz_ActionName,'trans' => ''),
    					),
    					'deletefunc' => $sz_ConfirmDeleteCat,
    	);

    	return $a_TableConfig;
    }
    
	/**
     * Add action to add new buziness
     * @author QuyetDN
     * @since 16/12/2013
     * @return boolean
     */
    public function addAction()
    {
    	// Get all params
        $a_AllParams = $this->getAllParams();

        // Get CAT_Code
        $sz_CatCode= $a_AllParams['controller'];

        $o_CategoriesRepository = new Admin_Model_Categories_Repository();
		
        $a_CategoryData = $o_CategoriesRepository->a_fGetParentCatForForm($sz_CatCode, $this->_translate->translate('ADMIN_BUSINESS_TABLE_ParentBusi'));

        $this->_o_BusinessForm->getElement('category_id')->setMultiOptions($a_CategoryData);
    	
    	$this->view->o_BuzinessForm = $this->_o_BusinessForm;

    	if( $this->_request->isPost() ) {
	    	// Gets the data passed via POST
	    	$this->_params = $this->_request->getPost();

	    	// If the data is not valid
	    	if( !$this->_o_BusinessForm->isValid($this->_params) ) {

	    		return false;

	    	} else {
				 // Set value to entity
                $this->_o_BusinessEntity ->setName_vi( $this->_params['name_vi'] )
                						 ->setName_en( $this->_params['name_en'] )
                                         ->setAlias( $this->_params['alias'] )
                                         ->setDescription_en( $this->_params['description_en'] )
                                         ->setDescription_vi( $this->_params['description_vi'] )
                                         ->setContent_en( $this->_params['content_en'] )
                                         ->setContent_vi( $this->_params['content_vi'] )
                                         ->setCategory_id( $this->_params['category_id'] )
                                         ->setSort( $this->_params['sort'] )
                                         ->setCreatedUserId( $this->_SessionUserId )
                                         ->setStatus( $this->_params['status'] )
                                         ->setDelete(1)
                                         ->setCreatedDate( time())
                                         ->setLastActivity( time() );
	    		// Save data
	    		$this->_o_BusinessRepository->v_fSave($this->_o_BusinessEntity);

	    		// Return to list view
                $this->_redirect('/admin/business/');
	    	}
    	}
    }
    
    
/**
     * Edit citizen action
     * @author QuyetDN
     * @since 15/04/2014
     * @return boolean
     */
    public function  editAction()
    {
        // Get all params
        $a_AllParams = $this->getAllParams();

        // Get CAT_Code
        $sz_CatCode= $a_AllParams['controller'];

        $o_CategoriesRepository = new Admin_Model_Categories_Repository();

        $a_CategoryData = $o_CategoriesRepository->a_fGetParentCatForForm($sz_CatCode, $this->_translate->translate('ADMIN_TABLE_TITLE_BusinessCatList'));

        $this->_o_BusinessForm->getElement('category_id')->setMultiOptions($a_CategoryData);

    	$this->view->o_CatForm = $this->_o_BusinessForm;

    	// Verifies that was submitted via POST
    	if( !$this->_request->isPost() )
        {
            // Get citizen info by id
            $a_BusinessInfo = $this->_o_BusinessRepository->a_fGetBusiInfo( 'BUSINESS_id', $this->_request->getParam('id') );

            $this->_o_BusinessForm->populate($a_BusinessInfo);

            return false;

    	} else {
            // Gets the data passed valid POST
            $this->_params = $this->_request->getPost();

            // If the data is not valid
            if( !$this->_o_BusinessForm->isValid($this->_params) )
            {
                return false;

            } else {
                // Set value to entity
                $this->_o_BusinessEntity ->setId( $this->_params['id'] )
                						 ->setName_vi( $this->_params['name_vi'] )
                                         ->setName_en( $this->_params['name_en'] )
                                         ->setAlias( $this->_params['alias'] )
                                         ->setDescription_en( $this->_params['description_en'] )
                                         ->setDescription_vi( $this->_params['description_vi'] )
                                         ->setContent_en( $this->_params['content_en'] )
                                         ->setContent_vi( $this->_params['content_vi'] )
                                         ->setCategory_id( $this->_params['category_id'] )
                                         ->setSort( $this->_params['sort'] )
                                         ->setCreatedUserId( $this->_SessionUserId )
                                         ->setStatus( $this->_params['status'] )
                                         ->setDelete(1)
                                         ->setCreatedDate( time())
                                         ->setLastActivity( time() );
                // Save data
                $this->_o_BusinessRepository->v_fSave($this->_o_BusinessEntity);

                // Return to list view
                $this->_redirect('/admin/business');
            }
    	}
    }

    /**
     * Delete business action
     * @author QuyetDN
     * @since 06/05/2014
     * @return boolean
     */
    public function deleteAction()
    {
    	$i_Id = $this->_request->getParam('id');
    	
    	$sz_ActionName = $this->_request->getParam('act');
    	
    	$this->_o_BusinessEntity->setId( $i_Id );
    	
    	$b_Result = $this->_o_BusinessRepository->b_fDelete( $this->_o_BusinessEntity );
    	
    	$o_Result = new stdClass();
    	
    	$o_Result->sz_ResultMsg = '';
    	
    	$o_Result->sz_Url = '';

    	if( $b_Result )
    	{
            $o_Result->sz_ResultMsg = '';
            
            $o_Result->sz_Url = '/admin/business/' . $sz_ActionName . '/';
            
    	} else {
    		
            $o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_BUSINESS_ALERT_MSG_CannotDeleteThis');
            
    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	
    	$this->_helper->layout()->disableLayout();
    	
        $this->_helper->viewRenderer->setNoRender();
    }
    
    /**
     * Multi delete business action
     * @author QuyetDN
     * @since 20140506
     */
    public function multideleteAction()
    {
    	$a_IdsList = $this->_request->getParam('a_IdsList');
    	
    	$sz_ActionName = $this->_request->getParam('act');
    	
    	$b_Result = $this->_o_BusinessRepository->b_fMultiDelete( $a_IdsList );
    	
    	$o_Result = new stdClass();
    	
    	$o_Result->sz_ResultMsg = '';
    	
    	$o_Result->sz_Url = '';
    
    	if( $b_Result )
    	{
    		$o_Result->sz_ResultMsg = '';
    		
    		$o_Result->sz_Url = '/admin/business/' . $sz_ActionName . '/';
    		
    	} else {
    		
    		$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_ALERT_MSG_CannotDeleteThese');
    		
    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	
    	$this->_helper->layout()->disableLayout();
    	
    	$this->_helper->viewRenderer->setNoRender();
    }
}