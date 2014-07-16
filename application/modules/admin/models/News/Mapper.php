<?php

class Admin_Model_News_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'NEWS_Id'        	=> 'id',
            	'NEWS_CategoryId'	=> 'category_id',
                'NEWS_Name_en'		=> 'name_en',
            	'NEWS_Name_vi'		=> 'name_vi',
                'NEWS_Description_en'=> 'description_en',
            	'NEWS_Description_vi'=> 'description_vi',
            	'NEWS_Sort'  		=> 'sort',
            	'NEWS_Status'  		=> 'status',
            	'NEWS_LastActivity' => 'lastActivity'
            )
        );
    }
}
