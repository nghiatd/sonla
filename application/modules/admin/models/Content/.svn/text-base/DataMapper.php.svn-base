<?php

class Admin_Model_Content_DataMapper implements Zf_Model_Interface, Admin_Model_Content_Interface
{
	/**
	 * @var Login_Model_DbTable_Content
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

        	throw new Admin_Model_Content_Exception('Invalid table data gateway provided');

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

			$this->setDbTable('Admin_Model_DbTable_Content');

		}

		return $this->_dbTable;
	}

	/**
	 * Get Category by id
	 * @author DungNT
	 * @since 06/04/2014
	 * @param int $the_i_Id
	 * @return array
	 */
	public function a_fGetCatById($the_i_Id)
	{
		try {

			$o_Result = $this->getDbTable()->find($the_i_Id);

	        if (0 == count($o_Result)) {

	        	return null;

	        }

	        $a_Row = $o_Result->current()->toArray();

	        return $a_Row;

		} catch(Exception $ex) {

			throw new Admin_Model_Content_Exception($ex);

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
	public function a_fGetAllCat($the_sz_Where = null, $the_sz_Order = null, $the_i_Count = null, $the_i_Offset = null)
	{
		try {

			$o_ResultSet = $this->getDbTable()->fetchAll($the_sz_Where, $the_sz_Order, $the_i_Count, $the_i_Offset);

			return $o_ResultSet->toArray();

		} catch(Exception $ex) {

			throw new Admin_Model_Content_Exception($ex);

		}

		return null;
	}

	/**
	 * Save data
	 * @author DungNT
	 * @since 06/04/2014
	 * @param array $the_a_Data
	 */
	public function v_fSave($the_a_Data)
	{
		try {

			if ( is_null( $this->a_fGetCatById($the_a_Data['CONTENT_Id']) ) ) {

				$this->getDbTable()->insert($the_a_Data);

			} else {

				$i_CatId = $the_a_Data['CONTENT_Id'];

	        	unset($the_a_Data['CONTENT_Id']);

	        	$this->getDbTable()->update($the_a_Data, array('CONTENT_Id = ?' => (int) $i_CatId));
	        }
		} catch(Exception $ex) {

			throw new Admin_Model_Content_Exception($ex);

		}

		return null;
	}

	/**
	 * Delete data
	 * @author DungNT
	 * @since 06/04/2014
	 * @param array $the_a_Data
	 */
	public function b_fDelete($the_a_Data)
	{
		try {

			$this->getDbTable()->delete(array('CONTENT_Id = ?' => (int) $the_a_Data['CONTENT_Id']));

		} catch(Exception $ex) {

			throw new Admin_Model_Content_Exception($ex);

		}

		return null;
	}

	/**
	 * Delete multi data
	 * @author DungNT
	 * @since 06/04/2014
	 * @param array $the_a_Data
	 */
	public function b_fMultiDelete($the_a_Data)
	{
		try {

			$this->getDbTable()->delete(array('CONTENT_Id IN (?)' => (array) $the_a_Data));

		} catch(Exception $ex) {

			throw new Admin_Model_Content_Exception($ex);

		}

		return null;
	}

	/**
	 * Count categories by ids list
	 * @author DungNT
	 * @since 06/04/2014
	 * @param array $the_a_Ids
	 * @return int
	 */
	public function i_fCountCatByIdList($the_a_Ids = null)
	{
		if (! is_null($the_a_Ids))
		{
			try {
				$o_Select = $this->getDbTable()->select()

					->from('tbl_cat_categories', 'COUNT(CONTENT_Id) as count')

					->where('CONTENT_Id IN (?)', (array) $the_a_Ids);

				$o_Result = $this->getDbTable()->fetchRow($o_Select);

				$a_Count = $o_Result->toArray();

				return (int) $a_Count['count'];

			} catch (Exception $ex) {

				throw new Admin_Model_Content_Exception($ex);
			}
		}
		else
		{
			return null;
		}
	}

	/**
	 * Get parent category list with id and name
	 * @author DungNT
	 * @since 05/04/2014
	 * @param int $the_i_Status
	 * @param int $the_i_ParentId
	 * @return array
	 */
	public function a_fGetParentCatList($the_i_Status = null, $the_i_ParentId = null)
	{
		if ( !is_null($the_i_Status) )
		{
			try {

				$o_Select = $this->getDbTable()->select();

				if(!is_null($the_i_ParentId))
				{
					$o_Select->where('CONTENT_ParentId = ?', (int) $the_i_ParentId);
				}

				if($the_i_Status != Zf_Util_Const::STATUS_All)
				{
					$o_Select->where('CONTENT_Status = ?', (int) $the_i_Status);
				}

				$o_ResultSet = $this->getDbTable()->fetchAll($o_Select);

				return $o_ResultSet->toArray();

			} catch(Exception $ex) {

				throw new Admin_Model_Content_Exception($ex);

			}
		}
		else
		{
			return null;
		}
	}

	/**
	 * Get category by code
	 * @author DungNT
	 * @since 05/04/2014
	 * @param string $the_sz_Key
	 * @param string $the_sz_Value
	 * @return array
	 */
	public function a_fGetCatInfo($the_sz_Key, $the_sz_Value)
	{
//            echo $the_sz_Key.'/'.$the_sz_Value;
//            die;
		try {
			$o_Select = $this->getDbTable()->select()->where($the_sz_Key . ' = ?', (string) $the_sz_Value);

			$o_Result = $this->getDbTable()->fetchRow($o_Select);

			if (0 == count($o_Result)) {

				return null;

			}

			$a_Row = $o_Result->toArray();

			return $a_Row;

		} catch(Exception $ex) {

			throw new Admin_Model_Content_Exception($ex);

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
	    		   ->from('tbl_content', array('CONTENT_Id', 'CONTENT_Name_en', 'CONTENT_Name_vi', 'CONTENT_Description_en', 'CONTENT_Description_vi', 'CONTENT_Sort', 'CONTENT_Status', 'CONTENT_LastActivity'));

			if ( !is_null($the_a_Where) ) {

				foreach($the_a_Where as $sz_Field => $sz_Value)
				{
					if($sz_Field == 'CONTENT_CategoryId' || $sz_Field == 'CONTENT_Sort' || $sz_Field == 'CONTENT_Status')
					{
						if($sz_Field == 'CONTENT_Status' && $sz_Value == Zf_Util_Const::STATUS_All)
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

			throw new Admin_Model_Content_Exception($ex);

		}

		return null;
	}
}
