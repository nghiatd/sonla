<?php

class Admin_Model_Intro_DataMapper implements Zf_Model_Interface, Admin_Model_Intro_Interface
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

        	throw new Admin_Model_Intro_Exception('Invalid table data gateway provided');

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

			$this->setDbTable('Admin_Model_DbTable_Intro');
		}
		return $this->_dbTable;
	}
	/**
	 * @author Ulquiorra
	 * @see Admin_Model_Intro_Interface::a_fGetIntroById()
	 */
	public function a_fGetIntroById($the_i_Id)
	{
		try {
			$o_Result = $this->getDbTable()->find($the_i_Id);
			if (0==count($o_Result)) {
				return null;
			}
			$a_Rows = $o_Result->current()->toArray();
			return $a_Rows;
		} catch (Exception $ex) {
			throw new Admin_Model_Intro_Exception($ex);
		}

		return null;
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

			throw new Admin_Model_Intro_Exception($ex);

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
			throw new Admin_Model_Intro_Exception($ex);

		}

		return null;
	}

	/**
	 * @author Ulquiorra
	 * @param array $the_a_Data
	 */

	public function v_fSave($the_a_Data)
	{
		try {
			if (is_null($this->a_fGetIntroById($the_a_Data['INTRO_id']))) {
				$this->getDbTable()->insert($the_a_Data);
			}else {
				$i_IntroId = $the_a_Data['INTRO_id'];
				unset($the_a_Data['INTRO_id']);
				$this->getDbTable()->update($the_a_Data, array('INTRO_id = ?' => (int) $i_IntroId));
			}
		} catch (Exception $ex) {
			throw new Admin_Model_Intro_Exception($ex);
		}
		return null;
	}

	/**
	 * @param array $the_a_Data
	 */
	public function b_fDelete($the_a_Data)
	{
		try {
			$this->getDbTable()->delete(array('INTRO_id = ?' => (int)$the_a_Data['INTRO_id']));
			
		} catch (Exception $ex) {
			
			throw new Admin_Model_Intro_Exception($ex);
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
	 * Get category by code
	 * @author DungNT
	 * @since 05/04/2014
	 * @param string $the_sz_Key
	 * @param string $the_sz_Value
	 * @return array
	 */
	public function a_fGetIntroInfo($the_sz_Key, $the_sz_Value)
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

			throw new Admin_Model_Intro_Exception($ex);

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
			->setIntegrityCheck(FALSE)	
			->from('tbl_intro', array('INTRO_id', 'INTRO_Name_en', 'INTRO_Name_vi','INTRO_Alias', 'INTRO_Description_en', 'INTRO_Description_vi','INTRO_Content_en','INTRO_Content_vi','INTRO_CategoryId', 'INTRO_Status', 'INTRO_CreatedDate'))
			->join('tbl_cat_categories','tbl_intro.INTRO_CategoryId = tbl_cat_categories.CAT_Id', array('CAT_Name_en','CAT_Name_vi'));

			if ( !is_null($the_a_Where) ) {

				foreach($the_a_Where as $sz_Field => $sz_Value)
				{
					if($sz_Field == 'INTRO_CategoryId' || $sz_Field == 'INTRO_Sort' || $sz_Field == 'INTRO_Status')
					{
						if($sz_Field == 'INTRO_Status' && $sz_Value == Zf_Util_Const::STATUS_All)
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

			throw new Admin_Model_Intro_Exception($ex);

		}

		return null;
	}
	public function sz_fGetFieldMapper($the_sz_MapKey)
	{
		// This function is only used in Repository.
	}
}
