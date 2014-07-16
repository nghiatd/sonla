<?php

class Admin_Model_Business_DataMapper implements Zf_Model_Interface, Admin_Model_Business_Interface
{
	/**
	 * @var Login_Model_DbTable_LoginAttempt
	 */
	protected $_dbTable;

	/**
	 * @param object $dbTable
	 * @return object
	 */
	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {

			$dbTable = new $dbTable();

		}

        if (!$dbTable instanceof Zend_Db_Table_Abstract) {

        	throw new Admin_Model_Business_Exception('Invalid table data gateway provided');

        }

        $this->_dbTable = $dbTable;

        return $this;
	}

	/**
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable()
	{
		if (null === $this->_dbTable) {

			$this->setDbTable('Admin_Model_DbTable_Business');
		}
		return $this->_dbTable;
	}

	/**
	 *
	 * @param int $the_i_DateTime
	 * @param string $the_sz_Ip
	 * @return array
	 */
	public function fetchRow($the_i_DateTime, $the_sz_Ip)
	{
		try {

			$o_Result = $this->getDbTable()->find($the_i_DateTime, $the_sz_Ip);
			
	        if (0 == count($o_Result)) {
	        	return null;
	        }
	        
	        $a_Row = $o_Result->current()->toArray();
	        
	        return $a_Row;
	        
		} catch(Exception $ex) {
			throw new Admin_Model_Business_Exception($ex);
		}
		return null;
	}

/**
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
			throw new Admin_Model_Business_Exception($ex);

		}

		return null;
	}

	/**
	 * @param string $the_sz_Order
	 * @param array $the_a_Where
	 * @return object
	 */
	public function select($the_sz_Order = null, $the_a_Where = null)
	{
		return null;
	}
	/**
	 * Get business by code
	 * @author QuyetDN
	 * @since 06/05/2014
	 * @param string $the_sz_Key
	 * @param string $the_sz_Value
	 * @return array
	 */
	public function a_fGetBusinessInfo($the_sz_Key, $the_sz_Value)
	{
		try {
			$o_Select = $this->getDbTable()->select()->where($the_sz_Key . ' = ?', (string) $the_sz_Value);

			$o_Result = $this->getDbTable()->fetchRow($o_Select);

			if (0 == count($o_Result)) {

				return null;

			}

			$a_Row = $o_Result->toArray();

			return $a_Row;

		} catch(Exception $ex) {

			throw new Admin_Model_Business_Exception($ex);

		}

		return null;
	}

	/**
	 * @param string $the_sz_Order
	 * @param array $the_a_Where
	 * @return object
	 */
	public function o_fGetSelect($the_sz_Order = null, $the_a_Where = null)
	{
		try {
			$o_Select = $this->getDbTable()
			->select()
			->from('tbl_business', array('BUSINESS_id', 'BUSINESS_Name_en', 'BUSINESS_Name_vi', 'BUSINESS_Description_en', 'BUSINESS_Description_vi', 'BUSINESS_Status', 'BUSINESS_LastActivity'))
			->setIntegrityCheck(false)
			->join('tbl_cat_categories', 'tbl_cat_categories.CAT_id = tbl_business.BUSINESS_CategoryId', array('CAT_Name_en','CAT_Name_vi'));

			if ( !is_null($the_a_Where) ) {
				foreach($the_a_Where as $sz_Field => $sz_Value)
				{
					if($sz_Field == 'BUSINESS_CategoryId' || $sz_Field == 'BUSINESS_Sort' || $sz_Field == 'BUSINESS_Status')
					{
						if($sz_Field == 'BUSINESS_Status' && $sz_Value == Zf_Util_Const::STATUS_All)
						{
							$o_Select->where($sz_Field . ' < ?', (int) $sz_Value);

						} else {

							$o_Select->where($sz_Field . ' = ?', (int) $sz_Value);
						}

					} else {

						$o_Select->where($sz_Field . ' LIKE ?', '%' . (string) $sz_Value . '%');
					}
				}

			}

			if ( !is_null($the_sz_Order) ) {

				$o_Select->order( $the_sz_Order );

			}
			return $o_Select;

		} catch(Exception $ex) {

			throw new Admin_Model_Business_Exception($ex);

		}

		return null;
	}
	public function sz_fGetFieldMapper($the_sz_MapKey)
	{
		// This function is only used in Repository.
	}
	
	
	/**
     * Save data
     * @author QuyetDN
     * @since 06/04/2014
     * @param array $the_a_Data
     */
    public function v_fSave($the_a_Data)
    {
        try
        {
            if ( is_null( $this->a_fGetCatById($the_a_Data['BUSINESS_id']) ) )
            {
                $this->getDbTable()->insert($the_a_Data);

            } else {

                $i_CatId = $the_a_Data['BUSINESS_id'];

                unset($the_a_Data['BUSINESS_id']);

                $this->getDbTable()->update($the_a_Data, array('BUSINESS_id = ?' => (int) $i_CatId));
            }

        } catch(Exception $ex) {

            throw new Admin_Model_Citizen_Exception($ex);
        }

        return null;
    }
    
    /**
    * Get Category by id
    * @author QuyetDN
    * @since 06/05/2014
    * @param int $the_i_Id
    * @return array
    */
    public function a_fGetCatById($the_i_Id)
    {
    	try
    	{
    		$o_Result = $this->getDbTable()->find($the_i_Id);
    
    		if (0 == count($o_Result)) {
    
    			return null;
    		}
    
    		$a_Row = $o_Result->current()->toArray();
    
    		return $a_Row;
    
    	} catch(Exception $ex) {
    
    		throw new Admin_Model_Business_Exception($ex);
    	}
    
    	return null;
    }
    
/**
     * Delete data
     * @author QuyetDN
     * @since 15/04/2014
     * @param array $the_a_Data
     */
    public function b_fDelete($the_a_Data)
    {
        try
        {
            $this->getDbTable()->delete(array('BUSINESS_id = ?' => (int) $the_a_Data['BUSINESS_id']));

        } catch(Exception $ex) {

            throw new Admin_Model_Business_Exception($ex);
        }

        return null;
    }
    
 	/**
     * Get business by code
     * @author QuyetDN
     * @since 05/04/2014
     * @param string $the_sz_Key
     * @param string $the_sz_Value
     * @return array
     */
    public function a_fGetBusiInfo($the_sz_Key, $the_sz_Value)
    {
        try
        {
            $o_Select = $this->getDbTable()->select()->where($the_sz_Key . ' = ?', (string) $the_sz_Value);

            $o_Result = $this->getDbTable()->fetchRow($o_Select);

            if (0 == count($o_Result)) {

                return null;
            }

            $a_Row = $o_Result->toArray();

            return $a_Row;

        } catch(Exception $ex) {

            throw new Admin_Model_Business_Exception($ex);

        }
        return null;
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
    
    		$this->getDbTable()->delete(array('BUSINESS_Id IN (?)' => (array) $the_a_Data));
    
    	} catch(Exception $ex) {
    
    		throw new Admin_Model_Business_Exception($ex);
    
    	}
    
    	return null;
    }
    /**
     * Count business by ids list
     * @author QuyetDN
     * @since 06/05/2014
     * @param array $the_a_Ids
     * @return int
     */
    public function i_fCountBusiByIdList($the_a_Ids = null)
    {
    	if (! is_null($the_a_Ids))
    	{
    		try {
    			$o_Select = $this->getDbTable()->select()
    
    			->from('tbl_business', 'COUNT(BUSINESS_Id) as count')
    
    			->where('BUSINESS_Id IN (?)', (array) $the_a_Ids);
    
    			$o_Result = $this->getDbTable()->fetchRow($o_Select);
    
    			$a_Count = $o_Result->toArray();
    
    			return (int) $a_Count['count'];
    
    		} catch (Exception $ex) {
    
    			throw new Admin_Model_Business_Exception($ex);
    		}
    	}
    	else
    	{
    		return null;
    	}
    }
}
