<?php

class Admin_Model_User_Mapper extends Zf_Model_DataMapper
{

	public function __construct ()
	{
		$this->setMap(
				array(
						'USER_Id' => 'id',
						'USER_Name' => 'name',
						'USER_Email' => 'email',
						'USER_Password' => 'password',
						'USER_Challenge' => 'challenge',
						'USER_Level' => 'level',
						'USER_LEV_IsAdmin' => 'isAdmin',
						'USER_LEV_Alias' => 'alias',
						'USER_Status' => 'status',
						'USER_LastActivity' => 'lastActivity'
				));
	}
}
