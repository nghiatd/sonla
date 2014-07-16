<?php

class Admin_Model_DbTable_User extends Zf_DbTable_Abstract
{
	protected $_name = 'tbl_user_userslist';
	protected $_primary = 'USER_Id';
	protected $_sequence = true;
	protected $_referenceMap    = array(
        'Level' => array(
            'columns'           => 'USER_Level',
            'refTableClass'     => 'UserLevel',
            'refColumns'        => 'USER_LEV_Id'
        )
    );
}