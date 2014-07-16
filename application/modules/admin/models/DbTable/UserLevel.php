<?php

class Admin_Model_DbTable_UserLevel extends Zend_Db_Table_Abstract
{
    protected $_name = 'tbl_user_userlevels';
	protected $_primary = 'USER_LEV_Id';
	protected $_sequence = false;
	protected $_dependentTables = array('tbl_user_userslist');
}