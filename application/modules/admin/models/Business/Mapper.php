<?php

class Admin_Model_Business_Mapper extends Zf_Model_DataMapper
{
public function __construct()
    {
        $this->setMap(
            array(
                'BUSINESS_id'                    => 'id',
            	'BUSINESS_Name_vi'				 => 'name_vi',
            	'BUSINESS_Name_en'				 => 'name_en',
            	'BUSINESS_Alias'                 => 'alias',
            	'BUSINESS_Description_en'        => 'description_en',
            	'BUSINESS_Description_vi'        => 'description_vi',
            	'BUSINESS_Content_vi'            => 'content_vi',
                'BUSINESS_Content_en'            => 'content_en',
            	'BUSINESS_CategoryId'            => 'category_id',
            	'BUSINESS_CreatedDate'           => 'createdDate',
            	'BUSINESS_Status'  				 => 'status',
            	'BUSINESS_Deleted'               => 'delete',
                'BUSINESS_DeletedDate'           => 'deleteDate',
                'BUSINESS_CreatedUserId'         => 'createdUserId',
            	'BUSINESS_Sort'                	 => 'sort',
            	'BUSINESS_LastActivity'			 => 'lastActivity'
            )
        );
    }
}
