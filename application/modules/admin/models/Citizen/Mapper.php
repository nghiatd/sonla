<?php

class Admin_Model_Citizen_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'CITIZEN_id'                    => 'id',
            	'CITIZEN_CategoryId'            => 'category_id',
                'CITIZEN_Alias'                 => 'alias',
                'CITIZEN_image'                 => 'image',
                'CITIZEN_Name_en'		=> 'name_en',
            	'CITIZEN_Name_vi'		=> 'name_vi',
                'CITIZEN_Description_en'        => 'description_en',
            	'CITIZEN_Description_vi'        => 'description_vi',
                'CITIZEN_Content_vi'            => 'content_vi',
                'CITIZEN_Content_en'            => 'content_en',
            	'CITIZEN_Sort'  		=> 'sort',
            	'CITIZEN_Status'  		=> 'status',
            	'CITIZEN_LastActivity'          => 'lastActivity',
                'CITIZEN_CreatedDate'           => 'createdDate',
                'CITIZEN_Deleted'               => 'delete',
                'CITIZEN_DeletedDate'           => 'deleteDate',
                'CITIZEN_CreatedUserId'         => 'createdUserId',
            )
        );
    }
}
