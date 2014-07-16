<?php

class Admin_Model_Faq_Mapper extends Zf_Model_DataMapper
{
	public function __construct()
    {
        $this->setMap(
            array(
                'FAQ_Id'        	=> 'id',
            	'FAQ_Name'			=> 'name',
                'FAQ_Title'			=> 'title',
            	'FAQ_Address'		=> 'address',
                'FAQ_Email'			=> 'email',
            	'FAQ_Status'		=> 'status',
            	'FAQ_CategoryId'  	=> 'faq_category_id',
            	'FAQ_Content'  		=> 'content',
            	'FAQ_Answer'  		=> 'answer',
            	'FAQ_LastActivity' 	=> 'lastActivity',
            	'FAQ_CreatedDate'	=> 'created_date'
            )
        );
    }
}
