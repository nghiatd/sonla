<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	
    	// Set this controller is only used for ajax
    	$this->_helper->ajaxContext->addActionContext('changelanguage', 'json')->initContext();
    	
    }

    public function indexAction()
    {
        // action body
    }

    /**
     * Change language action
     * @author DungNT
     * @since 06/12/2013
     */
	public function changelanguageAction()
	{
		// Get param
		$sz_Locale = $this->_request->getParam('sz_Locale');
		// Init session
		$o_SessionCommon = new Zend_Session_Namespace('COMMON');
		// Set session language data
		$o_SessionCommon->language = $sz_Locale;
	}
}

