<?php

class Admin_Model_LoginAttempt_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
            	'CONCAT(USER_ATT_DateTime,"_", USER_ATT_Ip)'	=> 'id',
                'USER_ATT_DateTime'	=> 'datetime',
                'USER_ATT_Ip' 	 	=> 'ip',
            	'USER_ATT_Location'	=> 'location',
                'USER_ATT_Success'  => 'success',
            	'USER_ATT_UserName' => 'username',
            	'USER_ATT_Area'		=> 'area'
            )
        );
    }
}
