<?php

class Admin_Model_User_Message extends Zf_Model_Message
{
	const SUCCESS_LOGOUT = "logoutSuccess";
	const WRONG_USER_PASS = "wrongUserPass";
	
	protected $_messageTemplates = array(
        self::SUCCESS_LOGOUT => 'ADMIN_USER_MSG_LogoutSuccessfully',
        self::WRONG_USER_PASS => 'ADMIN_USER_MSG_UsePassIncorrect'
    );
}