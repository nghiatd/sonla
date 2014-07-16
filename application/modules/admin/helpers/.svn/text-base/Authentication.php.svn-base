<?php

class Admin_Helper_Authentication extends Zend_Controller_Action_Helper_Abstract
{
	public function createChallenge( $view )
	{
    	$authNamespace = new Zend_Session_Namespace('Zend_Auth');
	        	
        $challenge = Zf_Util_String::generateRandomString();
        $authNamespace->challenge = $challenge;
                	
        $view->challenge = $challenge;
    }
    
    public function hasIdentity() 
    {
    	// Creates an instance of Zend_Auth
        $objAuth = Zend_Auth::getInstance();
    
        // Verifies that is already authenticated
        if ($objAuth->hasIdentity()) {
        	return true;
        } else {
        	if(Zf_Util_Cookie::cookieExists( Zend_Registry::get('admin_config')->resources->cookie->name )) {
        		
        	}
        }
    }
    
    /**
     * Check login attempt
     * @author DungNT
     * @since 04/01/2013
     * @param bool $the_b_IsSuccess
     * @param string $the_sz_Username
     */
	public function v_fCheckLoginAttempts($the_b_IsSuccess, $the_sz_Username) {  	
		
    	$o_LoginAttempt = new Admin_Model_LoginAttempt_Entity();
    	
    	$o_LoginAttempt->setDatetime( time() )
			    	->setIp( Zf_Util_Ip::sz_fGetIp() )
			    	->setLocation( $this->sz_fGetUserLocation() )
			    	->setUsername( $the_sz_Username )
			    	->setSuccess( $the_b_IsSuccess )
    				->setArea( Zf_Util_Const::AREA_ADMIN );
		
    	$o_Repository = new Admin_Model_LoginAttempt_Repository();
		
    	$o_Repository->save($o_LoginAttempt);
    }
    
    /**
     * Get user location by Ip
     * @author DungNT
     * @since 04/01/2013
     * @return string
     */
    public function sz_fGetUserLocation()
    {
    	$sz_IpAddr = Zf_Util_Ip::sz_fGetIp();
    	
    	if( $sz_IpAddr == '127.0.0.1' ) {
    		
    		return 'localhost';
    	
    	} else {
    		
	    	$o_Repository = new Admin_Model_GeoIp_Repository();
	    	
	    	$o_GeoIp = $o_Repository->fetchRow( $sz_IpAddr );
	    	
	    	if( $o_GeoIp ) {
	    		
	    		return $o_GeoIp->city . ' - ' . $o_GeoIp->country;
	    		
	    	} else {
	    		
	    		$a_GeoData = Zf_Util_Ip::a_fGetGeoIP();
	    		
		    	$o_GeoIp = new Admin_Model_GeoIp_Entity();
		    	
		    	$o_GeoIp->setIp( $sz_IpAddr )
		    			->setCountry( $a_GeoData['country'] )
		    			->setState( $a_GeoData['state'] )
		    			->setCity( $a_GeoData['city'] );
		    	
		    	$o_Repository = new Admin_Model_GeoIp_Repository();
		    	
		    	$o_Repository->save($o_GeoIp);
		    	
		    	return $a_GeoData['city'] . ' - ' . $a_GeoData['country'];
	    	}
    	}
    }
    
    public function updateUserActivity() 
    {
    	if ($this->hasIdentity()) {
    		$authNamespace = new Zend_Session_Namespace('Zend_Auth');
    	
	    	$user = new Admin_Model_User_Entity();
	    	$user->setId( $authNamespace->userId );
	    	$user->setLastActivity( time() );
	    	
	    	$userRepository = new Admin_Model_User_Repository();
	    	$userRepository->v_fUpdateLastActivity($user);
    	}
    }
}