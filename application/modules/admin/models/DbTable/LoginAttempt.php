<?php

class Admin_Model_DbTable_LoginAttempt extends Zend_Db_Table_Abstract
{
	protected $_name = 'tbl_user_loginattempts';
	protected $_primary = array('USER_ATT_DateTime', 'USER_ATT_Ip');
	protected $_sequence = false;
	
	//@todo
}