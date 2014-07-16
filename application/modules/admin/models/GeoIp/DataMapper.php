<?php

class Admin_Model_GeoIp_DataMapper implements Zf_Model_Interface, Admin_Model_GeoIp_Interface
{
	/**
	 * @var Login_Model_DbTable_GeoIp
	 */
	protected $_dbTable;
	
	/**
	 * Set DbTable
	 * @author DungNT
	 * @since 04/01/2013
	 * @param object $dbTable
	 * @return object
	 */
	public function setDbTable($dbTable)
	{		
		if (is_string($dbTable)) {

			$dbTable = new $dbTable();
        
		}
        
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {

        	throw new Admin_Model_GeoIp_Exception('Invalid table data gateway provided');
        
        }
        
        $this->_dbTable = $dbTable;
        
        return $this;
	}

	/**
	 * Get DbTable
	 * @author DungNT
	 * @since 04/01/2013
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable() 
	{		
		if (null === $this->_dbTable) {

			$this->setDbTable('Admin_Model_DbTable_GeoIp');
        
		}
        
		return $this->_dbTable;
	}
	
	/**
	 * Get one row data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param string $the_sz_IpAddr
	 * @return array
	 */
	public function fetchRow($the_sz_IpAddr) 
	{		
		try {
			
	    	$o_Result = $this->getDbTable()->find($the_sz_IpAddr);
	    	
	        if (0 == count($o_Result)) {
	        	
	            return null;
	        
	        }
	        
	        $a_Row = $o_Result->current()->toArray();
	     
	        return $a_Row;
	        
		} catch(Exception $ex) {
			
			throw new Admin_Model_GeoIp_Exception($ex);
		
		}
		
		return null;
	}

	/**
	 * Get all data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param string $the_sz_Where
	 * @param string $the_sz_Order
	 * @param int $the_i_Count
	 * @param int $the_i_Offset
	 * @return array
	 */
	public function fetchAll($the_sz_Where = null, $the_sz_Order = null, $the_i_Count = null, $the_i_Offset = null) 
	{		
		try {
			
			$o_ResultSet = $this->getDbTable()->fetchAll($the_sz_Where, $the_sz_Order, $the_i_Count, $the_i_Offset);
	        
			return $o_ResultSet->toArray();
		
		} catch(Exception $ex) {

			throw new Admin_Model_GeoIp_Exception($ex);
		
		}
		
		return null;
	}

	/**
	 * Insert or Update data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param array $the_a_Data
	 */
	public function save($the_a_Data) 
	{		
		try {

			if ( is_null( $this->fetchRow($the_a_Data['USER_GEO_Ip']) ) ) {

				$this->getDbTable()->insert($the_a_Data);
	        
			} else {

				$sz_Ip = $the_a_Data['USER_GEO_Ip'];
	        	
	        	unset($the_a_Data['USER_GEO_Ip']);
	        	
	        	$this->getDbTable()->update($the_a_Data, array('USER_GEO_Ip' => $sz_Ip));
	        }
	        
		} catch(Exception $ex) {
			
			throw new Admin_Model_GeoIp_Exception($ex);
		
		}
		
		return null;
	}

	/**
	 * Delete data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param array $the_a_Data
	 */
	public function delete($the_a_Data) 
	{	
		try {

			$this->getDbTable()->delete(array('USER_GEO_Ip' => $the_a_Data['USER_GEO_Ip']));
		
		} catch(Exception $ex) {

			throw new Admin_Model_GeoIp_Exception($ex);
		
		}
		
		return null;
	}

	/**
	 * Select data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param string $the_sz_Order
	 * @return object
	 */
	public function select($the_sz_Order = null) 
	{		
		try {

			$o_Select = $this->getDbTable()
	    		   ->select()
	    		   ->from('tbl_user_geoip', array('USER_GEO_Ip', 'USER_GEO_Country', 'USER_GEO_State', 'USER_GEO_City'));
	    		   
	    	if ( !is_null($the_sz_Order) ) {

	    		$select->order( $the_sz_Order );
	    	
	    	}
	
	    	return $o_Select;
		
		} catch(Exception $ex) {

			throw new Admin_Model_GeoIp_Exception($ex);
		
		}
		
		return null;
	}
}
