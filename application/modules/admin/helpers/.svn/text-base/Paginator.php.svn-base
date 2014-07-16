<?php

class Admin_Helper_Paginator extends Zend_Controller_Action_Helper_Abstract
{
	/**
	 * Add object paginator
	 * @author DungNT
	 * @since 13/12/2013
	 * @param object Zend_Db_Select $the_o_Select
	 * @param int $the_i_Page
	 * @param int $the_i_ItemPerPage
	 * @param int $the_i_PageRange
	 * @return object Zend_Paginator
	 */
	public function o_fAddPaginator(Zend_Db_Select $the_o_Select, $the_i_Page = 1, $the_i_ItemPerPage = 10, $the_i_PageRange = 5)
    {
        $o_Paginator = new Zend_Paginator(new Zend_Paginator_Adapter_DbSelect($the_o_Select));
        
        $o_Paginator->setItemCountPerPage($the_i_ItemPerPage)
                  ->setCurrentPageNumber($the_i_Page)
                  ->setPageRange($the_i_PageRange);
                  
        return $o_Paginator;
    }
}
