<?php

class Admin_Model_Categories_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'CAT_Id'        	=> 'id',
            	'CAT_Code'			=> 'code',
                'CAT_Name_en'		=> 'name_en',
            	'CAT_Name_vi'		=> 'name_vi',
                'CAT_Description_en'=> 'description_en',
            	'CAT_Description_vi'=> 'description_vi',
            	'CAT_ParentId'  	=> 'parent_id',
            	'CAT_Sort'  		=> 'sort',
            	'CAT_Status'  		=> 'status',
            	'CAT_LastActivity' 	=> 'lastActivity'
            )
        );
    }
}
