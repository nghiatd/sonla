<?php

class Admin_Helper_UrlFilterBy extends Zend_Controller_Action_Helper_Abstract
{
/**
	 * Parse filter url
	 * @author DungNT
	 * @since 18/12/2013
	 * @param string $the_sz_OrderBy
	 * @param array $the_a_Config
	 * @return array
	 */
	public function a_fParseFilter($the_a_Params, $the_a_Config)
    {
    	$a_FilterWhere = array();
    	
    	foreach($the_a_Config['columns'] as $sz_Key => $sz_Value)
    	{
    		foreach($the_a_Params as $sz_Name => $sz_Data)
    		{
    			if($sz_Key == $sz_Name)
    			{
    				$a_FilterWhere[$the_a_Config['mapper']->getField( $sz_Key )] = $sz_Data;
    			}
    		}
    	}
    	
    	return $a_FilterWhere;
    }
}
