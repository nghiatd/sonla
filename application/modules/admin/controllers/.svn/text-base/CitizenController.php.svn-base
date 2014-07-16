<?php
class Admin_CitizenController extends Zend_Controller_Action
{
    /*  */
    protected $_a_AllParams = array();
    protected $_sz_ActUrl = '';
    protected $_locale;
    protected $_o_CitizenRepository;
    protected $_o_CitizenForm;
    protected $__o_CatEntity;
    protected $_sz_Action;
    protected $_o_Upload;

    public function init()
    {
    	// Check if user is logged
    	if ( !$this->_helper->Authentication->hasIdentity() ) {
            $this->_redirect("admin/login");
    	}

    	$o_SessionCommon = new Zend_Session_Namespace('COMMON');

    	$this->_locale = $o_SessionCommon->language;

        $o_SessionAuth = new Zend_Session_Namespace('Zend_Auth');

        $this->_SessionUserId= $o_SessionAuth->userId;

    	$this->_translate = Zend_Registry::get('Zend_Translate');

    	// Get all params
    	$a_AllParams = $this->getAllParams();

    	$this->_sz_ActUrl = '/' . $a_AllParams['module'] . '/' . $a_AllParams['controller'] . '/' . $a_AllParams['action'] . '/';

        // Get action
        $this->_sz_Action = $a_AllParams['action'];

    	unset($a_AllParams['module']);
    	unset($a_AllParams['controller']);
    	unset($a_AllParams['action']);

        $this->_o_Upload= new Zend_File_Transfer();

    	// Get citizen model repository
    	$this->_o_CitizenRepository = new Admin_Model_Citizen_Repository();

        // Get category model repository
    	$this->_o_CatRepository = new Admin_Model_Categories_Repository();

    	// Get citizen form
    	$this->_o_CitizenForm = new Admin_Form_Citizen();

        // Get entity model Citizen
        $this->_o_CitizenEntity = new Admin_Model_Citizen_Entity();

        // Get sz_Title by action
        switch ($this->_sz_Action)
        {
            case 'index':
                $sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Citizen');
                break;
            case 'add':
                $sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_AddCitizen');
                break;
            case 'edit':
                $sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_EditCitizen');
                break;
            default:
                $sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Citizen');
                break;

        }

    	$this->_a_AllParams = $a_AllParams;
        $this->view->title = $sz_Title;
    	$this->view->headTitle($sz_Title);
    	$this->view->selectedMenu = 'citizen';
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
    	$o_Select = $this->_o_CitizenRepository->o_fGetSelect($sz_OrderStr, $a_FilterWhere);

    	// Parse paginator to select object
    	$this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);

    	$this->view->tableConfig = $a_TableConfig;
    }

    /**
     * Get Table config
     * @author Cuonglv
     * @since 14/04/2014
     * @param string $the_sz_ActionName
     * @param string $the_sz_Order
     * @return array
     */
    public function a_fGetTableConfig($the_sz_ActionName, $the_sz_Order)
    {
    	// Function confirm delete when click on delete btn
    	$sz_ConfirmDeleteCat = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/citizen/delete\', \'index\',\'' . $this->_translate->translate('ADMIN_CITIZEN_ALERT_MSG_DeleteCatConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_CITIZEN_ALERT_MSG_SureDeleteThisCitizen') . '\')';

    	// Set action url and param to filter form
        $this->_o_CitizenForm->v_fCatFilterForm($this->_sz_ActUrl, $this->getAllParams());

    	// Array table config
    	$a_TableConfig = array(
    			'setting' => array('filter' => true, 'multidelete' => true, 'locale' => $this->_locale),
    			'filterform' => $this->_o_CitizenForm,
    			'columns' => array(
                                    'name_' . $this->_locale => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_CITIZEN_TABLE_TITLE_Name')),
                                    'description_' . $this->_locale => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_CITIZEN_TABLE_TITLE_Desc')),
                                    'category_id' => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_CITIZEN_TABLE_TITLE_CAT'),'field' => 'CAT_Name_' . $this->_locale),
                                    'status' => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Status')),
                                    'lastActivity' => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_LastVisit'), 'filter' => create_function('$value', 'return date("d/m/Y H:i:s", $value);')),
    			),
    			'mapper' => new Admin_Model_Citizen_Mapper(),
    			'order' => $the_sz_Order,
    			'default-order' => array('name_' . $this->_locale, 'asc'),
    			'url' => array(
                                'module' => 'admin',
                                'controller' => 'citizen',
                                'action' => $the_sz_ActionName,
                                'id' => 'id'
                        ),
                        'info' => array(
                                'module' => array('name' => 'admin', 'trans' => 'Admin'),
                                'controller' => array('name' => 'citizen', 'trans' => $this->_translate->translate('ADMIN_NAV_MENU_Citizen')),
                                'action' => array('name' => $the_sz_ActionName,'trans' => ''),
                        ),
                        'deletefunc' => $sz_ConfirmDeleteCat,
    	);

    	return $a_TableConfig;
    }

    /**
     * Add action to add citizen
     * @author Cuonglv
     * @since 15/04/2014
     * @return boolean
     */
    public function addAction()
    {
        // Get all params
        $a_AllParams = $this->getAllParams();

        // Get CAT_Code
        $sz_CatCode= $a_AllParams['controller'];

        $o_CategoriesRepository = new Admin_Model_Categories_Repository();

        $a_CategoryData = $o_CategoriesRepository->a_fGetParentCatForForm($sz_CatCode, $this->_translate->translate('ADMIN_TABLE_TITLE_CitizenCatList'));

    	$this->_o_CitizenForm->getElement('category_id')->setMultiOptions($a_CategoryData);

    	$this->view->o_CatForm = $this->_o_CitizenForm;

    	if( $this->_request->isPost() ) {
            // Gets the data passed via POST
            $this->_params = $this->_request->getPost();

            // If the data is not valid
            if( !$this->_o_CitizenForm->isValid($this->_params) ) {

                return false;
            } else {

            // Get info image upload
            $a_File = $this->_o_Upload->getFileInfo();

            // Check exits image
            if(empty($a_File['image']['name']))
            {
                // Show message not image
                return false;
            }  else {

                // Get name image upload
                $sz_NameImage= $this->sz_fUploadAndResizeImage($this->_o_CitizenForm,'image');
            }

                // Set value to entity
                $this->_o_CitizenEntity->setName_en( $this->_params['name_en'] )
                                        ->setName_vi( $this->_params['name_vi'] )
                                        ->setAlias( $this->_params['alias'] )
                                        ->setImage( $sz_NameImage )
                                        ->setDescription_en( $this->_params['description_en'] )
                                        ->setDescription_vi( $this->_params['description_vi'] )
                                        ->setContent_en( $this->_params['content_en'] )
                                        ->setContent_vi( $this->_params['content_vi'] )
                                        ->setCategory_id( $this->_params['category_id'] )
                                        ->setSort( $this->_params['sort'] )
                                        ->setCreatedUserId( $this->_SessionUserId )
                                        ->setStatus( $this->_params['status'] )
                                        ->setCreatedDate( time())
                                        ->setLastActivity( time() );

                // Save data
                $this->_o_CitizenRepository->v_fSave($this->_o_CitizenEntity);

                // Return to list view
                $this->_redirect('/admin/' . $sz_CatCode);
            }
    	}
    }

    /**
     * Edit citizen action
     * @author Cuonglv
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

        $a_CategoryData = $o_CategoriesRepository->a_fGetParentCatForForm($sz_CatCode, $this->_translate->translate('ADMIN_TABLE_TITLE_CitizenCatList'));

        $this->_o_CitizenForm->getElement('category_id')->setMultiOptions($a_CategoryData);

    	$this->view->o_CatForm = $this->_o_CitizenForm;

        // Get citizen info by id
        $a_CitizenInfo = $this->_o_CitizenRepository->a_fGetCatInfo( 'CITIZEN_id', $this->_request->getParam('id') );

    	// Verifies that was submitted via POST
    	if( !$this->_request->isPost() )
        {
            $this->_o_CitizenForm->populate($a_CitizenInfo);

            return false;

    	} else {

            // Gets the data passed valid POST
            $this->_params = $this->_request->getPost();

            // If the data is not valid
            if( !$this->_o_CitizenForm->isValid($this->_params) )
            {
                return false;

            } else {

                // Get info image upload
                $a_File = $this->_o_Upload->getFileInfo();

                // Get Image Name
                $sz_NameImage= $a_File['image']['name'];

                // Check exits image when edit
                if(empty($sz_NameImage) || $sz_NameImage== '')
                {
                    $sz_NameImage= $a_CitizenInfo['image'];

                }else{

                    // Get name image upload
                    $sz_NameImage= $this->sz_fUploadAndResizeImage($this->_o_CitizenForm,'image');
                }

                // Set value to entity
                $this->_o_CitizenEntity->setId( $this->_params['id'] )
                                        ->setName_en($this->_params['name_en'])
                                        ->setName_vi( $this->_params['name_vi'] )
                                        ->setImage( $sz_NameImage )
                                        ->setAlias( $this->_params['alias'] )
                                        ->setDescription_en( $this->_params['description_en'] )
                                        ->setDescription_vi( $this->_params['description_vi'] )
                                        ->setContent_en( $this->_params['content_en'] )
                                        ->setContent_vi( $this->_params['content_vi'] )
                                        ->setCategory_id( $this->_params['category_id'] )
                                        ->setSort( $this->_params['sort'] )
                                        ->setCreatedUserId( $this->_SessionUserId )
                                        ->setStatus( $this->_params['status'] )
                                        ->setLastActivity( time() );

                // Save data
                $this->_o_CitizenRepository->v_fSave($this->_o_CitizenEntity);

                // Return to list view
                $this->_redirect('/admin/' . $sz_CatCode);
            }
    	}
    }

    /**
     * Upload and resize image
     * @author Cuonglv
     * @since 25/04/2014
     * @return sz file upload
     */
    public function sz_fUploadAndResizeImage($the_o_Form,$sz_FileName)
    {
        try
        {
            // Get info image upload
            $a_File = $this->_o_Upload->getFileInfo();

            // Get type image
            $sz_TypeImage= end(explode('.', $a_File[$sz_FileName]['name']));

            // Rename image name
            $sz_NameImage = dechex((int)date('His')) .'.'. $sz_TypeImage;

            $the_o_Form->$sz_FileName->addFilter('Rename', $sz_NameImage);

            // Upload image when rename
            $the_o_Form->$sz_FileName->receive();

            return $sz_NameImage;

        }
        catch (Admin_CitizenController $ex) {

            throw $ex;
        }
    }

    /**
     * Delete citizen action
     * @author Cuonglv
     * @since 17/04/2014
     * @return boolean
     */
    public function deleteAction()
    {
    	$i_Id = $this->_request->getParam('id');

    	$sz_ActionName = $this->_request->getParam('act');

    	$this->_o_CitizenEntity->setId( $i_Id );

    	$b_Result = $this->_o_CitizenRepository->b_fDelete( $this->_o_CitizenEntity );

    	$o_Result = new stdClass();

    	$o_Result->sz_ResultMsg = '';

    	$o_Result->sz_Url = '';

    	if( $b_Result )
    	{
            $o_Result->sz_ResultMsg = '';

            $o_Result->sz_Url = '/admin/citizen/' . $sz_ActionName . '/';

    	} else {

            $o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_CITIZEN_ALERT_MSG_CannotDeleteThis');

    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
    }
}