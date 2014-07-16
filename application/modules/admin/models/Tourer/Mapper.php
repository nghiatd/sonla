<?php

class Admin_Model_Tourer_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'TOURER_id'                    => 'id',
            	'TOURER_CategoryId'            => 'category_id',
                'TOURER_Alias'                 => 'alias',
                'TOURER_Name_en'			   => 'name_en',
            	'TOURER_Name_vi'			   => 'name_vi',
                'TOURER_Description_en'        => 'description_en',
            	'TOURER_Description_vi'        => 'description_vi',
                'TOURER_Content_vi'            => 'content_vi',
                'TOURER_Content_en'            => 'content_en',         	
            	'TOURER_Status'  			   => 'status',            	
                'TOURER_CreatedDate'           => 'createdDate',
                'TOURER_Deleted'               => 'delete',
                'TOURER_DeletedDate'           => 'deleteDate',
                'TOURER_CreatedUserId'         => 'createdUserId',
            	'TOURER_Sort'  				   => 'sort',
            	'TOURER_LastActivity'          => 'lastActivity',
            )
        );
    }
}
