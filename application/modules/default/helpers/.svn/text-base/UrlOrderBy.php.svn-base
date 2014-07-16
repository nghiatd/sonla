<?php

class Default_Helper_UrlOrderBy extends Zend_Controller_Action_Helper_Abstract
{	
	/**
	 * Parse order url
	 * @author DungNT
	 * @since 18/12/2013
	 * @param string $the_sz_OrderBy
	 * @param array $the_a_Config
	 * @return string
	 */
	public function sz_fParseOrder($the_sz_OrderBy, $the_a_Config)
    {
        // Sort Type
    	$a_OrderType = array('asc', 'desc');
    	
    	// Gets the column and sort order
    	$a_Order = explode('-', $the_sz_OrderBy);
    	
    	// Checks whether the column exists
    	if ( !isset( $the_a_Config['columns'][ $a_Order[0] ] ) ) {
    		$a_Order[0] = 'name';
    	}
    	
    	// Checks whether the order type exists
    	if ( !in_array($a_Order[1], $a_OrderType) ) {
    		$a_Order[1] = 'asc';
    	}
    	
    	// String the ordination
    	$sz_OrderStr = $the_a_Config['mapper']->getField( $a_Order[0] ) . ' ' . $a_Order[1];
    	
    	return $sz_OrderStr;
    }
}
