<?php

class Default_Helper_Navigator extends Zend_Controller_Action_Helper_Abstract
{
	public function createChallenge( $view )
	{
    	$authNamespace = new Zend_Session_Namespace('Zend_Auth');
	        	
        $challenge = Zf_Util_String::generateRandomString();
        $authNamespace->challenge = $challenge;
                	
        $view->challenge = $challenge;
    }
}