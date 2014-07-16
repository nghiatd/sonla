<?php

class Admin_LoginController extends Zend_Controller_Action
{
	protected $_params;

	protected $_userMessage;

	protected $_translate;

	protected $_o_UserRepository;

	protected function _setUserMessage($userMessage) {
		$this->_userMessage = $userMessage;
	}

	protected function _getUserMessage() {
		if (is_null($this->_userMessage)) {
			$this->_setUserMessage(new Admin_Model_User_Message());
		}
		return $this->_userMessage;
	}

	public function init()
	{
		// update the user's activity
		$this->_helper->Authentication->updateUserActivity();

		$this->_translate = Zend_Registry::get('Zend_Translate');

        // Get User repository
        $this->_o_UserRepository = new Admin_Model_User_Repository();
	}

	public function indexAction()
	{
		$this->view->errorMessage = null;
		$this->view->successMessage = null;

		if (!is_null($this->_getParam('status'))) {
			$this->view->successMessage = $this->_getUserMessage()->getMessage($this->_getParam('status'));
		}

		// Creates an instance of Zend_Auth
		$objAuth = Zend_Auth::getInstance();

		// Verifies that is already authenticated
		if ( !$objAuth->hasIdentity() ) {
			// Instantiates the login form
			$objFormLogin = new Admin_Form_Login();
			$this->view->objFormLogin = $objFormLogin;

			// Verifies that was submitted via POST
			if( !$this->_request->isPost() ) {
				$this->_helper->Authentication->createChallenge($this->view);
				return false;
			}

			// Gets the data passed via POST
			$this->_params = $this->_request->getPost();

			// If the data is not valid
			if(!$objFormLogin->isValid($this->_params)) {
				return false;
			}

			//Handle adapter DB
			$dbAdapter = Zend_Db_Table::getDefaultAdapter();

			/**
			 * Instancia o Auth Db Table Adapter
			 *
			 * When you instantiate this object, we need to tell the settings
			 * DB, table name where login information is, the name field
			 * User and password field in the table.
			*/
			$o_AuthAdapter = new Zend_Auth_Adapter_DbTable(
					$dbAdapter,
					'tbl_user_userslist',
					'USER_Name',
					'USER_Challenge'
			);

			/**
			 * Saves the authentication key
			*/
			//Takes the user to be authenticated
			$o_User = $this->_o_UserRepository->o_fGetUserByName($this->_params['loginname']);

			if ( $o_User != null )
			{
				// Check permission to access admin page
				if ( $o_User->isAdmin )
				{
					// Check status allowed or not
					if ( $o_User->status )
					{
						$o_AuthNamespace = new Zend_Session_Namespace('Zend_Auth');

						$sz_Challenge = $o_AuthNamespace->challenge;

						$o_UserMapper = new Admin_Model_User_Mapper();

						// Records the user code in the session
						$o_AuthNamespace->userId = $o_User->id;

						$sz_Key = hash('sha256', $sz_Challenge . $o_User->password);

						// Updates the object key
						$o_User->challenge = $sz_Key;

						// Updates the key user authentication
						$this->_o_UserRepository->b_fUpdateChallenge($o_User);

						// Sets the user_email and user_password credentials supplied by the user
						$o_AuthAdapter->setIdentity( $this->_params['loginname'] )
						->setCredential( $this->_params['loginchallenge'] );

						// Attempts to authenticate the user
						$o_Result = $objAuth->authenticate($o_AuthAdapter);

						/**
						 * If the user is authenticated redirects to the index and write your email,
						 * Otherwise displays an alert message on page
						*/
						if ( $o_Result->isValid() )
						{
							/**
							 * Handle user data, omitting the password
							 * http://framework.zend.com/manual/en/zend.auth.adapter.dbtable.html
							 */
							$authData = $o_AuthAdapter->getResultRowObject( null, 'USER_Challenge' );

							// Stores user data
							$objAuth->getStorage()->write( $authData );

							// Checks for failed login attempts

							$this->_helper->Authentication->v_fCheckLoginAttempts(true, $this->_params['loginname']);

							//COOKIE @todo do something with cookies

							// 			            $value = 'something from somewhere';
							// 						setcookie("TestCookie", $value);

							$this->_redirect('admin');

						} else {
							// Assigns the error message
							$this->view->errorMessage = $this->_translate->translate('ADMIN_USER_MSG_UsePassIncorrect');

							// Checks for failed login attempts
							$this->_helper->Authentication->v_fCheckLoginAttempts(false, $this->_params['loginname']);

							// Clean the identity authentication
							$objAuth->clearIdentity();

							// Creates new challenge
							$this->_helper->Authentication->createChallenge( $this->view );
						}

					} else {
						// Assigns the error message
						$this->view->errorMessage = $this->_translate->translate('ADMIN_USER_MSG_StatusNo');

						// Checks for failed login attempts
						$this->_helper->Authentication->v_fCheckLoginAttempts(false, $this->_params['loginname']);

						// Clean the identity authentication
						$objAuth->clearIdentity();

						// Creates new challenge
						$this->_helper->Authentication->createChallenge( $this->view );
					}

				} else {
					// Assigns the error message
					$this->view->errorMessage = $this->_translate->translate('ADMIN_USER_MSG_NoPermissionAccess');

					// Checks for failed login attempts
					$this->_helper->Authentication->v_fCheckLoginAttempts(false, $this->_params['loginname']);

					// Clean the identity authentication
					$objAuth->clearIdentity();

					// Creates new challenge
					$this->_helper->Authentication->createChallenge( $this->view );
				}
			} else {
				// Assigns the error message
				$this->view->errorMessage = $this->_translate->translate('ADMIN_USER_MSG_UsePassIncorrect');

				// Checks for failed login attempts
				$this->_helper->Authentication->v_fCheckLoginAttempts(false, $this->_params['loginname']);

				// Clean the identity authentication
				$objAuth->clearIdentity();

				// Creates new challenge
				$this->_helper->Authentication->createChallenge( $this->view );
			}
		} else {
			$this->_redirect('admin');
		}
	}


}

