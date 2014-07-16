<?php

class Admin_LoginAttemptController extends Zend_Controller_Action
{
	protected $_a_AllParams;

	protected $_sz_ActUrl;

	protected $_o_LoginAttemptModel;

	protected $_o_LoginAttemptForm;

	protected $_params;

	protected $_translate;

    public function init()
    {
        // Check if user is logged
        if ( !$this->_helper->Authentication->hasIdentity() ) {
    		$this->_redirect("admin/login");
    	}

    	// update the user's activity
        $this->_helper->Authentication->updateUserActivity();

        // To action return json instead of html
        $this->_helper->ajaxContext->addActionContext('delete', 'json')->initContext();

        $this->_translate = Zend_Registry::get('Zend_Translate');

        // Get all params
        $a_AllParams = $this->getAllParams();

        $this->_sz_ActUrl = '/' . $a_AllParams['module'] . '/' . $a_AllParams['controller'] . '/' . $a_AllParams['action'] . '/';

        unset($a_AllParams['module']);
        unset($a_AllParams['controller']);
        unset($a_AllParams['action']);

        $this->_a_AllParams = $a_AllParams;

        // Get User model
        $this->_o_LoginAttemptModel = new Admin_Model_LoginAttempt_Repository();

        // Get User form
        $this->_o_LoginAttemptForm = new Admin_Form_LoginAttempt();

        $sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_LoginAttempt');
        $this->view->title = $sz_Title;
        $this->view->headTitle($sz_Title);
        $this->view->selectedMenu = 'users';
        $this->_helper->layout->setLayout('admin/layout');
    }

    /**
     * Index action
     * @author DungNT
     * @since 31/12/2013
     */
    public function indexAction()
    {
    	$sz_Order = $this->_getParam('order', 'username-asc');

    	$i_Page = $this->_getParam('page', 1);

    	$i_ItemPerPage = $this->_getParam('perpage', 10);

    	$sz_ConfirmDeleteLoginAttempt = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/loginattempt/delete\', \'index\', \'' . $this->_translate->translate('ADMIN_LOGIN_ATT_DeleteUserConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_LOGIN_ATT_SureDeleteThisLoginAttempt') . '\')';

    	$this->_o_LoginAttemptForm->v_fUserFilterForm($this->_sz_ActUrl, $this->_a_AllParams);

    	$a_TableConfig = array(
    		'setting' => array('filter' => true, 'multidelete' => true, 'not_allow_add_action' => true),
    		'filterform' => $this->_o_LoginAttemptForm,
    		'columns' => array(
    			'username' 	 	   => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_LOGIN_ATT_USER_NAME')),
			    'area' 	   => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_LOGIN_ATT_AREA')),
			    'ip' 	   => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_LOGIN_ATT_IP')),
    			'location' 	   => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_LOGIN_ATT_LOCATION')),
    			'success' 	   => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_LOGIN_ATT_SUCCESS'), 'filter' => create_function('$value', 'return $value = 1? \''.$this->_translate->translate('ADMIN_LOGIN_ATT_LOGIN_SUCCESS').'\':\''.$this->_translate->translate('ADMIN_LOGIN_ATT_LOGIN_FAIL').'\';')),
			    'datetime' => array('selected' => false, 'title' => $this->_translate->translate('ADMIN_LOGIN_ATT_DATETIME'), 'filter' => create_function('$value', 'return date("d/m/Y H:i:s", $value);')),
    		),
    		'mapper' => new Admin_Model_LoginAttempt_Mapper(),
    		'order' => $sz_Order,
    		'default-order' => array('username', 'desc'),
    		'url' => array(
    			'module' => 'admin',
    			'controller' => 'loginattempt',
    			'action' => 'index',
    			'id' => 'id'
    		),
   			'info' => array(
 				'module' => array('name' => 'admin', 'trans' => 'Admin'),
 				'controller' => array('name' => 'loginattempt', 'trans' => $this->_translate->translate('ADMIN_NAV_MENU_LoginAttempt')),
    			'action' => array('name' => 'index', 'trans' => $this->_translate->translate('ADMIN_NAV_MENU_LoginAttempt'))
    		),
    		'deletefunc' => $sz_ConfirmDeleteLoginAttempt,
    	);
    	$a_FilterWhere = $this->_helper->UrlFilterBy->a_fParseFilter($this->_a_AllParams, $a_TableConfig);

    	$sz_OrderStr = $this->_helper->UrlOrderBy->sz_fParseOrder($sz_Order, $a_TableConfig, true);

    	$o_Repository = new Admin_Model_LoginAttempt_Repository();

    	$o_Select = $o_Repository->select($sz_OrderStr, $a_FilterWhere);

        $this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);

    	$this->view->tableConfig = $a_TableConfig;
    }

    /**
     * Delete action to delete user
     * @author DungNT
     * @since 31/12/2013
     * @return boolean
     */
    public function deleteAction()
    {
    	$i_Id = $this->_request->getParam('id');
    	$the_a_Data = explode('_', $i_Id);
    	$sz_ActionName = $this->_request->getParam('act');
    	if( count($the_a_Data) == 2 )
    	{
    		$b_Result = $this->_o_LoginAttemptModel->delete( $the_a_Data );
    		$this->view->sz_ResultMsg = '';
    		$this->view->sz_Url = '/admin/loginattempt/' . $sz_ActionName . '/';
    	}
    	else
    	{
    		$this->view->sz_ResultMsg = $this->_translate->translate('ADMIN_USER_ALERT_MSG_CannotDeleteThis');
    	}
    }
    /**
     * Multi delete category action
     * @author LangDD
     * @since 13/04/2014
     */
    public function multideleteAction()
    {
    	$a_IdsList = $this->_request->getParam('a_IdsList');

    	$sz_ActionName = $this->_request->getParam('act');

    	$b_Result = $this->_o_LoginAttemptModel->b_fMultiDelete( $a_IdsList );

    	$o_Result = new stdClass();

    	$o_Result->sz_ResultMsg = '';

    	$o_Result->sz_Url = '';

    	if( $b_Result )
    	{
    		$o_Result->sz_ResultMsg = '';

    		$o_Result->sz_Url = '/admin/loginattempt/' . $sz_ActionName . '/';

    	} else {

    		$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_ALERT_MSG_CannotDeleteThese');

    	}
    	$this->_response->setBody(Zend_Json::encode($o_Result));
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender();
    }
}
