<?php
class Admin_IntroController extends Zend_Controller_Action
{
	/*  */
	protected $_a_AllParams = array();
	protected $_sz_ActUrl = '';
	protected $_locale;
	protected $_sz_Action;
	protected $_o_IntroRepository;
	protected $_o_IntroForm;
	protected $_o_CateRepostory;
	protected $_o_IntroEntity;
	protected $_SessionUserId;

    public function init()
    {
    	// Check if user is logged
    	if ( !$this->_helper->Authentication->hasIdentity() ) {
    		$this->_redirect("admin/login");
    	}

    	$o_SessionCommon = new Zend_Session_Namespace('COMMON');
    	$this->_locale = $o_SessionCommon->language;

    	$this->_translate = Zend_Registry::get('Zend_Translate');
    	
    	$o_SessionAut = new Zend_Session_Namespace('Zend_Auth');
    	$this->_SessionUserId = $o_SessionAut->userId;

    	// Get all params
    	$a_AllParams = $this->getAllParams();

    	$this->_sz_ActUrl = '/' . $a_AllParams['module'] . '/' . $a_AllParams['controller'] . '/' . $a_AllParams['action'] . '/';
    	
    	// Get action
    	$this->_sz_Action = $a_AllParams['action'];
    	
    	unset($a_AllParams['module']);
    	unset($a_AllParams['controller']);
    	unset($a_AllParams['action']);

    	// Get intro model repository
    	$this->_o_IntroRepository = new Admin_Model_Intro_Repository();
    	
    	// Get category model repository
    	$this->_o_CateRepostory = new Admin_Model_Categories_Repository();
    	
    	// Get Intro model Entity
    	$this->_o_IntroEntity = new Admin_Model_Intro_Entity();

    	// Get intro form
    	$this->_o_IntroForm = new Admin_Form_Intro();

		// Get sz_Title
		switch ($this->_sz_Action){
			case 'index':
				$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Intro');
				break;
			case 'add':
				$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_AddIntro');
				break;
			case 'edit':
				$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_EditIntro');
				break;
			default:
				$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Intro');
				break;
		}
    	
    	$this->_a_AllParams = $a_AllParams;
        $this->view->title = $sz_Title;
    	$this->view->headTitle($sz_Title);
    	$this->view->selectedMenu = 'intro';
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
    	$o_Select = $this->_o_IntroRepository->o_fGetSelect($sz_OrderStr, $a_FilterWhere);
    	
    	// Parse paginator to select object

    	$this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);
    	$this->view->tableConfig = $a_TableConfig;

   
    }
   
    /**
     * Detail action
     * @author Ulquiorra
     * @since 27/04/2014
     */
    public function addAction()
    {
    	// Get all Params;
    	$a_AllParams = $this->getAllParams();
    	// Get Cat_code
    	$sz_Cat_code = $a_AllParams['controller'];
  
    	// Get Parent intro
    	$a_ParentCat = $this->_o_CateRepostory->a_fGetParentCatForForm($sz_Cat_code);

    	$this->_o_IntroForm->getElement('category_id')->setMultiOptions($a_ParentCat);
    	
    	$this->view->o_IntroForm = $this->_o_IntroForm;
    	
    		if ($this->_request->isPost()) {
    		// get data passed via Post
    		$this->_params = $this->_request->getPost();
    		
    		// if data is null
    		if (!$this->_o_IntroForm->isValid($this->_params)) {
    			return false;
    		}else {

    			// Set value to entity
    			$this->_o_IntroEntity->setName_en($this->_params['name_en'])
    								->setName_vi($this->_params['name_vi'])
    								->setAlias($this->_params['alias'])
    								->setDescription_en($this->_params['description_en'])
    								->setDescription_vi($this->_params['description_vi'])
    								->setContent_en($this->_params['content_en'])
    								->setContent_vi($this->_params['content_vi'])
    								->setCategory_id($this->_params['category_id'])
    								->setStatus($this->_params['status'])
    								->setCreatedDate(time())
    								->setCreatedUserId($this->_SessionUserId);
    			    			
    			//save data
    			$this->_o_IntroRepository->v_fSave($this->_o_IntroEntity);
    			// return to list view
    			$this->_redirect('/admin/'.$sz_Cat_code);
    								
    		}
    	}
    }
    /**
     * @author Ulquiorra
     */
    public function editAction()
    {
    	// Get All Param
    	$a_AllParams = $this->getAllParams();
    	//Get Cat_Code
    	$sz_Cat_Code = $a_AllParams['controller'];
    	// Get Parent Intro
    	$a_ParentCat = $this->_o_CateRepostory->a_fGetParentCatForForm($sz_Cat_Code);
    	
    	$this->_o_IntroForm->getElement('category_id')->setMultiOptions($a_ParentCat);
    	
    	$this->view->o_IntroForm = $this->_o_IntroForm;
    	// Get Intro data by id
    	
    	$a_IntroData = $this->_o_IntroRepository->a_fGetIntroInfo('INTRO_id', $this->_request->getParam('id'));
    	
    	if ($this->_request->isPost()) {
    		// Get data pass via Post
    		$this->_params = $this->_request->getPost();
    		// If data is Valid
    		if ($this->_o_IntroForm->isValid($this->_params)) {
    			// Set Value to entity
    			$this->_o_IntroEntity->setId($this->_params['id'])
    								->setName_en($this->_params['name_en'])
    								->setName_vi($this->_params['name_vi'])
    								->setAlias($this->_params['alias'])
    								->setDescription_en($this->_params['description_en'])
    								->setDescription_vi($this->_params['description_vi'])
    								->setContent_en($this->_params['content_en'])
    								->setContent_vi($this->_params['content_vi'])
    								->setCategory_id($this->_params['category_id'])
    								->setStatus($this->_params['status'])
    								->setCreatedDate(time())
    								->setCreatedUserId($this->_SessionUserId);
    			// Save data
    			$this->_o_IntroRepository->v_fSave($this->_o_IntroEntity);
    			
    			$this->_redirect('/admin/'.$sz_Cat_Code);
    		} else {
    			return false;
    		}
    	}else {
    		$this->_o_IntroForm->populate($a_IntroData);
    	}
    		
    }
    /**
     * @author Ulquiorra
     */
    public function deleteAction()
    {
    	$i_Id = $this->_request->getParam('id');
    	$sz_ActionName = $this->_request->getParam('act');
    	$this->_o_IntroEntity->setId($i_Id);
    	$b_Result = $this->_o_IntroRepository->b_fDelete($this->_o_IntroEntity);
    	$o_Result = new stdClass();
    	$o_Result->sz_ResultMsg = '';
    	$o_Result->sz_Url = '';
    	if ($b_Result) {
    		$o_Result->sz_ResultMsg = '';
    		$o_Result->sz_Url = '/admin/intro/' . $sz_ActionName . '/';
    	}else {
    		$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_INTRO_ALERT_MSG_CannotDeleteThis');
    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    		
    }

    /**
     * Get Table config
     * @author DungNT
     * @since 07/04/2014
     * @param string $the_sz_CatCode
     * @param string $the_sz_Order
     * @return array
     */
    public function a_fGetTableConfig($the_sz_ActionName, $the_sz_Order)
    {
    	// Function confirm delete when click on delete btn
    	$sz_ConfirmDeleteCat = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/intro/delete\', \'' . $this->_translate->translate('ADMIN_CAT_ALERT_MSG_DeleteCatConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_CAT_ALERT_MSG_SureDeleteThisCat') . '\')';
		
    	// Set action url and param to filter form
    	$this->_o_IntroForm->v_fCatFilterForm($this->_sz_ActUrl, $this->getAllParams());

			// Array table config
		$a_TableConfig = array(
				'setting' => array(
						'filter' => true,
						'multidelete' => true,
						'locale' => $this->_locale
				),
				'filterform' => $this->_o_IntroForm,
				'columns' => array(
						'name_' . $this->_locale => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_INTRO_TABLE_TITLE_Name')
						),
						'description_'.$this->_locale => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_INTRO_TABLE_TITLE_Desc')
						),
						'category_id' => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_INTRO_TABLE_TITLE_CAT'),'field'=>'CAT_Name_'.$this->_locale
						),
						
						'status' => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Status')
						),

				),
				'mapper' => new Admin_Model_Intro_Mapper(),
				'order' => $the_sz_Order,
				'default-order' => array(
						'name_' . $this->_locale,
						'asc'
				),
				'url' => array(
						'module' => 'admin',
						'controller' => 'intro',
						'action' => $the_sz_ActionName,
						'id' => 'id'
				),
				'info' => array(
						'module' => array(
								'name' => 'admin',
								'trans' => 'Admin'
						),
						'controller' => array(
								'name' => 'intro',
								'trans' => $this->_translate->translate('ADMIN_NAV_MENU_Intro'),
						'action' => array('name' => $the_sz_ActionName,'trans' =>'')
						)
				),
				'deletefunc' => $sz_ConfirmDeleteCat
		);
		
    	return $a_TableConfig;
    }
}