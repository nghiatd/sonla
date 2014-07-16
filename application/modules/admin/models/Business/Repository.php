<?php

class Admin_Model_Business_Repository implements Zf_Model_RepositoryInterface, Admin_Model_Business_Interface
{
	protected $_data;

	protected $_mapper;

	protected $_locale;

	public function __construct()
	{
		// Get locale from session
		$o_SessionCommon = new Zend_Session_Namespace('COMMON');
		$this->_locale = $o_SessionCommon->language;
	}
	/**
	 * Set Data
	 * @author QuyetDN
	 * @since 06/05/2014
	 * @param Admin_Model_Business_DataMapper $the_o_data
	 * @return object
	 */
	public function setData($the_o_data)
	{
		if (is_string($the_o_data)) {

			$the_o_data = new $the_o_data();

		}

        if (!$the_o_data instanceof Admin_Model_Business_DataMapper) {

        	throw new Admin_Model_Business_Exception('Invalid data access object provided');

        }

        $this->_data = $the_o_data;

        return $this;
	}

	/**
	 * Get Data
	 * @author QuyetDN
	 * @since 06/05/2014
	 * @return Admin_Model_Business_DataMapper
	 */
	public function getData()
	{
		if (null === $this->_data) {

			$this->setData('Admin_Model_Business_DataMapper');

		}

		return $this->_data;
	}

	/**
	 * Set Mapper
	 * @author QuyetDN
	 * @since 06/05/2014
	 * @param object $the_o_Mapper
	 * @return object
	 */
	public function setMapper($the_o_Mapper)
	{
		if (is_string($the_o_Mapper)) {
            $the_o_Mapper = new $the_o_Mapper();
		}
        if (!$the_o_Mapper instanceof Zf_Model_DataMapper) {
        	throw new Admin_Model_Business_Exception('Invalid data mapper provided');
        }
        $this->_mapper = $the_o_Mapper;
        return $this;
	}

	/**
	 * Get Mapper
	 * @author QuyetDN
	 * @since 06/05/2014
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper()
	{
		if (null === $this->_mapper) {

            $this->setMapper('Admin_Model_Business_Mapper');
		}

		return $this->_mapper;
	}

	/**
	 * Get one row data
	 * @author QuyetDN
	 * @since 06/05/2014
	 * @param int $the_i_DateTime
	 * @param string $the_sz_Ip
	 * @return array
	 */
	public function fetchRow($the_i_DateTime, $the_sz_Ip)
	{
		try {

			$a_Row = $this->getData()->fetchRow($the_i_DateTime, $the_sz_Ip);

			if( $a_Row && is_array($a_Row) ) {

				$a_Business = $this->getMapper()->assign(new Admin_Model_Business_Entity(), $a_Row);

				return $a_Business;

			} else {

				return null;

			}

		} catch (Admin_Model_Business_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_Business_Exception($ex);

		}
	}

	/**
	 * Get all data
	 * @author QuyetDN
	 * @since 06/05/2014
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

			$a_Business = array();

			foreach ( $a_Rows as $a_Row ) {

				$a_Business[] = $this->getMapper()->assign(new Admin_Model_Business_Entity(), $a_Row);

			}

			return $a_Business;

		} catch (Admin_Model_Business_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_Business_Exception($ex);

		}

		return null;
	}



	/**
	 * Select data
	 * @author QuyetDN
	 * @param string $the_sz_Order
	 * @param array $the_a_FilterWhere
	 * @return object
	 */
	public function o_fGetSelect($the_sz_Order = null, $the_a_FilterWhere = null)
	{
		try {
			// Get business data
			return $this->getData()->o_fGetSelect($the_sz_Order, $the_a_FilterWhere);
			
		} catch (Admin_Model_Business_Exception $ex) {
			
			throw $ex;
			
		}
		
		return null;
	}

	/**
	 * Get field from mapper by key
	 * @author DungNT
	 * @since 05/04/2014
	 * @param string $the_sz_MapKey
	 * @return string
	 */
	public function sz_fGetFieldMapper($the_sz_MapKey)
	{
		
		return $this->getMapper()->getField($the_sz_MapKey);
		
	}
	
 /**
     * Save data
     * @author QuyetDN
     * @since 06/05/2014
     * @param object $the_o_Data
     */
    public function v_fSave($the_o_Data)
    {
        try
        {
        	
            $a_Data = $this->getMapper()->map($the_o_Data);
            
            $this->getData()->v_fSave($a_Data);
            
        } catch (Admin_Model_Business_Exception $ex) {
        	
            throw $ex;
            
        }
        
        return null;
        
    }
    
	/**
     * Delete data
     * @author QuyetDN
     * @since 06/05/2014
     * @param array $the_o_Data
     */
    public function b_fDelete($the_o_Data)
    {
        try
        {
            $a_Data = $this->getMapper()->map($the_o_Data);
            $this->getData()->b_fDelete($a_Data);

            $a_BusinessInfo = $this->a_fGetCatById($a_Data['BUSINESS_id']);

            return !$a_BusinessInfo ? true : false;

        } catch (Admin_Model_Business_Exception $ex) {

            throw $ex;
        }

        return null;
    }
    
    /**
     * Get one row data
     * @author QuyetDN
     * @since 06/05/2014
     * @param int $the_i_Id
     * @return array
     */
    public function a_fGetCatById($the_i_Id)
    {
    	try
    	{
    		$a_Row = $this->getData()->a_fGetCatById($the_i_Id);
    
    		if( $a_Row && is_array($a_Row) )
    		{
    			$a_Categories = $this->getMapper()->assign(new Admin_Model_Business_Entity(), $a_Row);
    
    			return $a_Categories;
    
    		} else {
    
    			return null;
    		}
    
    	} catch (Admin_Model_Business_Exception $ex) {
    
    		throw $ex;
    
    	} catch (Zf_Model_DataMapperException $ex) {
    
    		throw new Admin_Model_Business_Exception($ex);
    	}
    }
    
	/**
     * Get business by code
     * @author QuyetDN
     * @since 06/05/2014
     * @param string $the_sz_Key
     * @param string $the_sz_Value
     * @return array
     */
    public function a_fGetBusiInfo($the_sz_Key, $the_sz_Value)
    {
        try
        {
            $a_Row = $this->getData()->a_fGetBusiInfo($the_sz_Key, $the_sz_Value);

            if( $a_Row && is_array($a_Row) ) {

                // Assign data row to Entity and get back to used
                $a_Business = $this->getMapper()->assign(new Admin_Model_Business_Entity(), $a_Row)->__toArray();

                return $a_Business;

            } else {

                return null;
            }

        } catch (Admin_Model_Business_Exception $ex) {

            throw $ex;

        } catch (Zf_Model_DataMapperException $ex) {

            throw new Admin_Model_Business_Exception($ex);
        }
    }
    
    /**
     * Delete multi data
     * @author QuyetDN
     * @since 06/05/2014
     * @param array $the_a_Data
     */
    public function b_fMultiDelete($the_a_Data)
    {
    	try {
    
    		$this->getData()->b_fMultiDelete($the_a_Data);
    
    		$i_CountBusi = $this->i_fCountBusiByIdList($the_a_Data);
    
    		return !$i_CountBusi ? true : false;
    
    	} catch (Admin_Model_Categories_Exception $ex) {
    
    		throw $ex;
    
    	}
    
    	return null;
    }
    /**
     * Count business by ids list
     * @author QuyetDN
     * @since 06/05/2014
     * @return int
     */
    public function i_fCountBusiByIdList($the_a_Ids = null)
    {
    	try {
    
    		return $this->getData()->i_fCountBusiByIdList($the_a_Ids);
    
    	} catch (Admin_Model_Business_Exception $ex) {
    
    		throw $ex;
    
    	}
    
    	return null;
    }
}