<?php

class Admin_Model_GeoIp_Repository implements Zf_Model_RepositoryInterface, Admin_Model_GeoIp_Interface
{
	protected $_data;
	protected $_mapper;
	
	/** 
	 * Set Data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param Admin_Model_GeoIp_DataMapper $the_o_Data
	 * @return object
	 */
	public function setData($the_o_Data)
	{
		if (is_string($the_o_Data)) {

			$the_o_Data = new $the_o_Data();
        
		}
        
        if (!$the_o_Data instanceof Admin_Model_GeoIp_DataMapper) {

        	throw new Admin_Model_GeoIp_Exception('Invalid data access object provided');
        
        }
        
        $this->_data = $the_o_Data;
        
        return $this;
	}

	/**
	 * Get Data
	 * @author DungNT
	 * @since 04/01/2013
	 * @return Admin_Model_GeoIp_DataMapper
	 */
	public function getData() 
	{
		if (null === $this->_data) {

			$this->setData('Admin_Model_GeoIp_DataMapper');
        
		}
        
		return $this->_data;
	}

	/**
	 * Set Mapper
	 * @author DungNT
	 * @since 04/01/2013
	 * @param object $the_o_Mapper
	 * @return object
	 */
	public function setMapper($the_o_Mapper) 
	{
		if (is_string($the_o_Mapper)) {

			$the_o_Mapper = new $the_o_Mapper();
        
		}
        
        if (!$the_o_Mapper instanceof Zf_Model_DataMapper) {

        	throw new Admin_Model_GeoIp_Exception('Invalid data mapper provided');
        
        }
        
        $this->_mapper = $the_o_Mapper;
        
        return $this;
	}

	/**
	 * Get Mapper
	 * @author DungNT
	 * @since 04/01/2013
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper() 
	{
		if (null === $this->_mapper) {

			$this->setMapper('Admin_Model_GeoIp_Mapper');
        
		}
        
		return $this->_mapper;
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
			
			$a_Row = $this->getData()->fetchRow($the_sz_IpAddr);
			
			if( $a_Row && is_array($a_Row) ) {
				
				$a_GeoIp = $this->getMapper()->assign(new Admin_Model_GeoIp_Entity(), $a_Row);
				
				return $a_GeoIp;
				
			} else {
				
				return null;
				
			}
		} catch (Admin_Model_GeoIp_Exception $ex) {
			
			throw $ex;
			
		} catch (Zf_Model_DataMapperException $ex) {
			
			throw new Admin_Model_GeoIp_Exception($ex);
			
		}
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

			$a_Rows = $this->getData()->fetchAll($the_sz_Where, $the_sz_Order, $the_i_Count, $the_i_Offset);
			
			$a_GeoIp = array();
			
			foreach ( $a_Rows as $a_Row ) {

				$a_GeoIp[] = $this->getMapper()->assign(new Admin_Model_GeoIp_Entity(), $a_Row);
			
			}
			
			return $a_GeoIp;
		
		} catch (Admin_Model_GeoIp_Exception $ex) {

			throw $ex;
		
		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_GeoIp_Exception($ex);
		
		}
		
		return null;
	}

	/**
	 * Save data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param array $the_a_Data
	 */
	public function save($the_a_Data)
	{
		try {

			$a_Data = $this->getMapper()->map($the_a_Data);
			
			$this->getData()->save($a_Data);
		
		} catch (Admin_Model_GeoIp_Exception $ex) {

			throw $ex;
		
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

			$a_Data = $this->getMapper()->map($the_a_Data);
			
			$this->getData()->delete($a_Data);
		
		} catch (Admin_Model_GeoIp_Exception $ex) {

			throw $ex;
		
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

			return $this->getData()->select($the_sz_Order);
		
		} catch (Admin_Model_GeoIp_Exception $ex) {

			throw $ex;
		
		}
		
		return null;
	}
}
