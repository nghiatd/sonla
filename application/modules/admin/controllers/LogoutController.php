<?php

class Admin_LogoutController extends Zend_Controller_Action
{

    public function init()
    {
        // update the user's activity
        $this->_helper->Authentication->updateUserActivity();
    }

    public function indexAction()
    {
        $objAuth = Zend_Auth::getInstance();
 
        // clear the user identity
        $objAuth->clearIdentity();
        
        //clear the namespace
        $o_AuthNamespace = new Zend_Session_Namespace('Zend_Auth');
        
        $o_AuthNamespace->unsetAll();
        
        $this->_redirect("/admin/login/index/status/".Admin_Model_User_Message::SUCCESS_LOGOUT);
    }


}

