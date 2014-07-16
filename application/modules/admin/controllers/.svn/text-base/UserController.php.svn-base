<?php

class Admin_UserController extends Zend_Controller_Action
{

	protected $_a_AllParams;

	protected $_sz_ActUrl;

	protected $_o_UserRepository;

	protected $_o_UserLevelRepository;

	protected $_o_UserEntity;

	protected $_o_UserForm;

	protected $_params;

	protected $_locale;

	protected $_translate;

	public function init ()
	{
		// Check if user is logged
		if (! $this->_helper->Authentication->hasIdentity()) {
			$this->_redirect("admin/login");
		}

		// update the user's activity
		$this->_helper->Authentication->updateUserActivity();

		// Get locale from session
		$o_SessionCommon = new Zend_Session_Namespace('COMMON');
		$this->_locale = $o_SessionCommon->language;

		$this->_translate = Zend_Registry::get('Zend_Translate');

		// Get all params
		$a_AllParams = $this->getAllParams();

		$this->_sz_ActUrl = '/' . $a_AllParams['module'] . '/' . $a_AllParams['controller'] . '/' . $a_AllParams['action'] . '/';

		unset($a_AllParams['module']);
		unset($a_AllParams['controller']);
		unset($a_AllParams['action']);

		$this->_a_AllParams = $a_AllParams;

		// Get User repository
		$this->_o_UserRepository = new Admin_Model_User_Repository();

		// Get User level repository
		$this->_o_UserLevelRepository = new Admin_Model_UserLevel_Repository();

		// Get category model entity
		$this->_o_UserEntity = new Admin_Model_User_Entity();

		// Get User form
		$this->_o_UserForm = new Admin_Form_User();

		$sz_Title = $this->_translate->translate('ADMIN_TITLE_PAGES_Users');
		$this->view->title = $sz_Title;
		$this->view->headTitle($sz_Title);
		$this->view->selectedMenu = 'users';
		$this->_helper->layout->setLayout('admin/layout');
	}

	/**
	 * Index action
	 *
	 * @author DungNT
	 * @since 03/12/2013
	 */
	public function indexAction ()
	{
		$sz_Order = $this->_getParam('order', 'name-asc');

		$i_Page = $this->_getParam('page', 1);

		$i_ItemPerPage = $this->_getParam('perpage', 10);

		$sz_ConfirmDeleteUser = 'COMMON.v_fConfirmDelete(this.getAttribute(\'sz_Value\'), \'/admin/user/delete\', \'index\', \'' . $this->_translate->translate('ADMIN_USER_ALERT_MSG_DeleteUserConfirmTitle') . '\', \'' . $this->_translate->translate('ADMIN_USER_ALERT_MSG_SureDeleteThisUser') . '\')';

		$this->_o_UserForm->v_fUserFilterForm($this->_sz_ActUrl, $this->_a_AllParams);

		$a_UserFilterLevels = $this->_o_UserLevelRepository->a_fGetListUserLevel(true, false, $this->_translate->translate('ADMIN_FORM_FILTER_All'));

		$this->_o_UserForm->getElement('level')->setMultiOptions($a_UserFilterLevels);

		$a_TableConfig = array(
				'setting' => array(
						'filter' => true,
						'multidelete' => false,
						'locale' => $this->_locale
				),
				'filterform' => $this->_o_UserForm,
				'columns' => array(
						'name' => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_USER_TABLE_TITLE_Name')
						),
						'email' => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_USER_TABLE_TITLE_Email')
						),
						'level' => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_USER_TABLE_TITLE_Level'),
								'field' => 'USER_LEV_Alias',
								'translate' => $this->_translate /* Use for field want to translate */
						),
						'status' => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_Status')
						),
						'lastActivity' => array(
								'selected' => false,
								'title' => $this->_translate->translate('ADMIN_TABLE_TITLE_LastVisit'),
								'filter' => create_function('$value', 'return date("d/m/Y H:i:s", $value);')
						)
				),
				'mapper' => new Admin_Model_User_Mapper(),
				'order' => $sz_Order,
				'default-order' => array(
						'name',
						'asc'
				),
				'url' => array(
						'module' => 'admin',
						'controller' => 'user',
						'action' => 'index',
						'id' => 'id'
				),
				'info' => array(
						'module' => array(
								'name' => 'admin',
								'trans' => 'Admin'
						),
						'controller' => array(
								'name' => 'user',
								'trans' => $this->_translate->translate('ADMIN_NAV_MENU_Users')
						),
						'action' => array(
								'name' => 'index',
								'trans' => $this->_translate->translate('ADMIN_NAV_MENU_ViewAll')
						)
				),
				'deletefunc' => $sz_ConfirmDeleteUser
		);

		$a_FilterWhere = $this->_helper->UrlFilterBy->a_fParseFilter($this->_a_AllParams, $a_TableConfig);

		$sz_OrderStr = $this->_helper->UrlOrderBy->sz_fParseOrder($sz_Order, $a_TableConfig);

		$o_Select = $this->_o_UserRepository->o_fGetSelect($sz_OrderStr, $a_FilterWhere);

		$this->view->paginator = $this->_helper->Paginator->o_fAddPaginator($o_Select, $i_Page, $i_ItemPerPage);

		$this->view->tableConfig = $a_TableConfig;
	}

	/**
	 * Add action to add new user
	 *
	 * @author DungNT
	 * @since 03/12/2013
	 * @return boolean
	 */
	public function addAction ()
	{
		$a_UserLevels = $this->_o_UserLevelRepository->a_fGetListUserLevel(true, false);

		$this->_o_UserForm->getElement('level')->setMultiOptions($a_UserLevels);

		$this->_o_UserForm->getElement('name')->setAttrib('onblur', 'USER.v_fCheckUserName(this.value);');

		$this->view->o_UserForm = $this->_o_UserForm;

		if ($this->_request->isPost()) {
			// Gets the data passed via POST
			$this->_params = $this->_request->getPost();

			// If the data is not valid
			if (! $this->_o_UserForm->isValid($this->_params)) {

				return false;
			} else {

				// Set value to entity
				$this->_o_UserEntity->setName($this->_params['name'])
					->setEmail($this->_params['email'])
					->setPassword(hash('sha256', $this->_params['password']))
					->setChallenge(Zf_Util_String::generateRandomString())
					->setLevel($this->_params['level'])
					->setStatus(1)
					->setLastActivity(time());

				$b_Result = $this->_o_UserRepository->i_fSaveData($this->_o_UserEntity);

				if ($b_Result) {

					$this->_redirect('admin/user/');
				} else {

					return false;
				}
			}
		}
	}

	/**
	 * Edit user action
	 *
	 * @author DungNT
	 * @since 03/12/2013
	 * @return boolean
	 */
	public function editAction ()
	{
		$a_UserLevels = $this->_o_UserLevelRepository->a_fGetListUserLevel(true, false);

		$this->_o_UserForm->getElement('level')->setMultiOptions($a_UserLevels);

		$this->_o_UserForm->v_fRemoverNameValidators();

		$this->_o_UserForm->getElement('name')->setAttrib('readonly', 'readonly');

		$this->_o_UserForm->getElement('name')->setDescription('');

		$this->view->o_UserForm = $this->_o_UserForm;

		// Verifies that was submitted via POST
		if (! $this->_request->isPost()) {
			$o_UserInfo = $this->_o_UserRepository->o_fGetUserById($this->_request->getParam('id'));

			$this->_o_UserForm->populate($o_UserInfo->__toArray());

			return false;
		}

		// Gets the data passed via POST
		$this->_params = $this->_request->getPost();

		// If the data is not valid
		if (! $this->_o_UserForm->isValid($this->_params)) {
			return false;
		} else {

			// Set value to entity
			$this->_o_UserEntity->setId($this->_params['id'])
				->setName($this->_params['name'])
				->setEmail($this->_params['email'])
				->setPassword(hash('sha256', $this->_params['password']))
				->setChallenge(Zf_Util_String::generateRandomString())
				->setLevel($this->_params['level'])
				->setStatus(1)
				->setLastActivity(time());

			$b_Result = $this->_o_UserRepository->i_fSaveData($this->_o_UserEntity);

			if ($b_Result) {
				$this->_redirect('admin/user/');
			} else {

				return false;
			}
		}
	}

	/**
	 * Delete action to delete user
	 *
	 * @author DungNT
	 * @since 03/12/2013
	 * @return boolean
	 */
	public function deleteAction ()
	{
		$o_Result = new stdClass();

		$o_Result->sz_ResultMsg = '';

		$o_Result->sz_Url = '';

		$o_LoginUserInfo = Zend_Auth::getInstance()->getStorage()->read();

		$i_LoginUserId = $o_LoginUserInfo->USER_Id;

		$i_LoginUserLevel = $o_LoginUserInfo->USER_Level;

		$i_UserId = $this->_request->getParam('id');

		$sz_ActionName = $this->_request->getParam('act');

		$o_UserInfo = $this->_o_UserRepository->o_fGetUserById($i_UserId);

		$i_DeletedUserLevel = $o_UserInfo->level;

		$b_Result = true;

		if ($i_LoginUserId == $i_UserId) {
			$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_USER_ALERT_MSG_CannotDeleteYourself');

			$b_Result = false;
		}

		// Level 1 is highest user level
		if ($b_Result && $i_DeletedUserLevel <= $i_LoginUserLevel) {
			$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_USER_ALERT_MSG_OnlyDeleteLowerLevel');

			$b_Result = false;
		}

		if ($b_Result) {
			$b_DelResult = $this->_o_UserRepository->b_fDeleteUser(array(
					$i_UserId
			));

			if ($b_DelResult) {

				$o_Result->sz_ResultMsg = '';

				$o_Result->sz_Url = '/admin/user/' . $sz_ActionName . '/';
			} else {

				$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_USER_ALERT_MSG_CannotDeleteThis');
			}
		}
		$this->_response->setBody(Zend_Json::encode($o_Result));
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}

	/**
	 * Action view and update personal detail
	 *
	 * @author DungNT
	 * @since 20/12/2013
	 */
	public function personaldetailAction ()
	{}

	/**
	 * Action check User name is existed or not
	 *
	 * @author DungNT
	 * @since 03/12/2013
	 */
	public function checkusernameAction ()
	{
		$o_Result = new stdClass();

		$o_Result->sz_ResultMsg = '';

		$o_User = $this->_o_UserRepository->o_fGetUserByName($this->_request->getParam('user_name'));

		if ($o_User) {
			$o_Result->sz_ResultMsg = $this->_translate->translate('ADMIN_USER_ALERT_MSG_NameAlreadyExisted');
		} else {

			$o_Result->sz_ResultMsg = '';
		}
		$this->_response->setBody(Zend_Json::encode($o_Result));
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
	}
}





