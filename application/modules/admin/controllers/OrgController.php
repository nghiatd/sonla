<?php
class Admin_OrgController extends Zend_Controller_Action
{
	/*  */
	protected $_a_AllParams = array();
	protected $_sz_ActUrl = '';
	protected $_locale;
	protected $_o_OrgRepository;
	protected $_o_OrgForm;

    public function init()
    {
    	// Check if user is logged
    	if ( !$this->_helper->Authentication->hasIdentity() ) {
    		$this->_redirect("admin/login");
    	}

    	$o_SessionCommon = new Zend_Session_Namespace('COMMON');
    	$this->_locale = $o_SessionCommon->language;

    	$this->_translate = Zend_Registry::get('Zend_Translate');

    	// Get all params
    	$a_AllParams = $this->getAllParams();

    	$this->_sz_ActUrl = '/' . $a_AllParams['module'] . '/' . $a_AllParams['controller'] . '/' . $a_AllParams['action'] . '/';

    	unset($a_AllParams['module']);
    	unset($a_AllParams['controller']);
    	unset($a_AllParams['action']);

    	// Get category model repository
    	$this->_o_OrgRepository = new Admin_Model_Org_Repository();

    	// Get category form
    	$this->_o_OrgForm = new Admin_Form_Org();

    	$this->_a_AllParams = $a_AllParams;
    	$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Org');
    	$this->view->title = $sz_Title;
    	$this->view->headTitle($sz_Title);
    	$this->view->selectedMenu = 'org';
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

    	// Set action name to filter

    	// Get select object from repository
    	$o_Select = $this->_o_OrgRepository->o_fGetSelect($sz_OrderStr, $a_FilterWhere);

    	// Parse paginator to select object

    	$this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);
    	$this->view->tableConfig = $a_TableConfig;


    }

    /**
     * Detail action
     * @author NgocNV
     * @since 31/03/2014
     */
    public function detailAction()
    {
    	// @todo
    }

    /**
     * Product action
     * @author DungNT
     * @since 14/12/2013
     */
    public function saveAction()
    {
    	// @todo
    }

    /**
     * Get Table config
     * @author DungNT
     * @since 14/12/2013
     * @param string $the_sz_CatCode
     * @param string $the_sz_Order
     * @return array
     */
    public function a_fGetTableConfig($the_sz_ActionName, $the_sz_Order)
    {
    	// Function confirm delete when click on delete btn
    	$sz_ConfirmDeleteCat = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/org/delete\', \'' . $this->_translate->translate('ADMIN_CAT_ALERT_MSG_DeleteCatConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_CAT_ALERT_MSG_SureDeleteThisCat') . '\')';

    	// Set action url and param to filter form
    	$this->_o_OrgForm->v_fCatFilterForm($this->_sz_ActUrl, $this->_a_AllParams);

    	// Array table config
    	$a_TableConfig = array(
    			'setting' => array('filter' => true, 'multidelete' => true, 'locale' => $this->_locale),
    			'filterform' => $this->_o_OrgForm,
    			'columns' => array(
    					'name_' . $this->_locale		=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_NEWS_TABLE_TITLE_Name')),
    					'category_name' 				=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_OrgCatList')),
    					'status' 						=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Status')),
    					'lastActivity' 					=> array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_LastVisit'), 'filter' => create_function('$value', 'return date("d/m/Y H:i:s", $value);')),
    			),
    			'mapper' => new Admin_Model_Org_Mapper(),
    			'order' => $the_sz_Order,
    			'default-order' => array('name_' . $this->_locale, 'asc'),
    			'url' => array(
    			'module' => 'admin',
    			'controller' => 'org',
    			'id' => 'id'
    					),
    					'info' => array(
    					'module' => array('name' => 'admin', 'trans' => 'Admin'),
    					'controller' => array('name' => 'org', 'trans' => $this->_translate->translate('ADMIN_NAV_MENU_Org')),
    					),
    					'deletefunc' => $sz_ConfirmDeleteCat,
    	);

    	return $a_TableConfig;
    }
}