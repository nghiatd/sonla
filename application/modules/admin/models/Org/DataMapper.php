<?php

class Admin_Model_Org_DataMapper implements Zf_Model_Interface, Admin_Model_Org_Interface
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

        	throw new Admin_Model_Org_Exception('Invalid table data gateway provided');

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

			$this->setDbTable('Admin_Model_DbTable_Org');
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

			throw new Admin_Model_Org_Exception($ex);

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
			throw new Admin_Model_Org_Exception($ex);

		}

		return null;
	}

	/**
	 * @param array $the_a_Data
	 */
	public function save($the_a_Data)
	{
		return null;
	}

	/**
	 * @param array $the_a_Data
	 */
	public function delete($the_a_Data)
	{

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
	 * Get category by code
	 * @author DungNT
	 * @since 05/04/2014
	 * @param string $the_sz_Key
	 * @param string $the_sz_Value
	 * @return array
	 */
	public function a_fGetOrgInfo($the_sz_Key, $the_sz_Value)
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

			throw new Admin_Model_Org_Exception($ex);

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
			->from('tbl_org', array('ORG_Id', 'ORG_Name_en', 'ORG_Name_vi', 'ORG_Description_en', 'ORG_Description_vi', 'ORG_Status', 'ORG_CreatedDate'));

			if ( !is_null($the_a_Where) ) {

				foreach($the_a_Where as $sz_Field => $sz_Value)
				{
					if($sz_Field == 'ORG_ParentId' || $sz_Field == 'ORG_Sort' || $sz_Field == 'ORG_Status')
					{
						if($sz_Field == 'ORG_Status' && $sz_Value == Zf_Util_Const::STATUS_All)
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

			throw new Admin_Model_Org_Exception($ex);

		}

		return null;
	}
	public function sz_fGetFieldMapper($the_sz_MapKey)
	{
		// This function is only used in Repository.
	}
}
