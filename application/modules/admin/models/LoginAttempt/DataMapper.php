<?php

class Admin_Model_LoginAttempt_DataMapper implements Zf_Model_Interface, Admin_Model_LoginAttempt_Interface
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

        	throw new Admin_Model_LoginAttempt_Exception('Invalid table data gateway provided');

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

			$this->setDbTable('Admin_Model_DbTable_LoginAttempt');

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

			throw new Admin_Model_LoginAttempt_Exception($ex);

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

			throw new Admin_Model_LoginAttempt_Exception($ex);

		}

		return null;
	}

	/**
	 * @param array $the_a_Data
	 */
	public function save($the_a_Data)
	{
		try {

			if ( is_null( $this->fetchRow($the_a_Data['USER_ATT_DateTime'], $the_a_Data['USER_ATT_Ip']) ) ) {

				$this->getDbTable()->insert($the_a_Data);

			} else {

				$i_DateTime = $the_a_Data['USER_ATT_DateTime'];

				$sz_Ip = $the_a_Data['USER_ATT_Ip'];

	        	unset($the_a_Data['USER_ATT_DateTime']);

	        	unset($the_a_Data['USER_ATT_Ip']);

	        	$this->getDbTable()->update($the_a_Data, array(
    				'USER_ATT_DateTime' => $i_DateTime,
    				'USER_ATT_Ip' 	   	=> $sz_Ip
    			));
	        }
		} catch(Exception $ex) {

			throw new Admin_Model_LoginAttempt_Exception($ex);

		}

		return null;
	}

	/**
	 * @param array $the_a_Data
	 */
	public function delete($the_a_Data)
	{
		try {

			$this->getDbTable()->delete(array(
    			'USER_ATT_DateTime = ?' => (int) $the_a_Data[0],
    			'USER_ATT_Ip = ?' 	   	=> $the_a_Data[1]
			));

		}
		catch(Exception $ex)
		{

			throw new Admin_Model_LoginAttempt_Exception($ex);

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

			$this->getDbTable()->delete(array('CONCAT(USER_ATT_DateTime,"_",USER_ATT_Ip) IN (?)' => (array) $the_a_Data));

		} catch(Exception $ex) {

			throw new Admin_Model_Categories_Exception($ex);

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
	public function i_fCountLoginAttemptByIdList($the_a_Ids = null)
	{
		if (! is_null($the_a_Ids))
		{
			try {
				$o_Select = $this->getDbTable()->select()

				->from('tbl_user_loginattempts', 'COUNT(CONCAT(USER_ATT_DateTime,"_",USER_ATT_Ip)) as count')

				->where('CONCAT(USER_ATT_DateTime,"_",USER_ATT_Ip) IN (?)', (array) $the_a_Ids);

				$o_Result = $this->getDbTable()->fetchRow($o_Select);

				$a_Count = $o_Result->toArray();

				return (int) $a_Count['count'];

			} catch (Exception $ex) {

				throw new Admin_Model_Categories_Exception($ex);
			}
		}
		else
		{
			return null;
		}
	}


	/**
	 * @param string $the_sz_Order
	 * @param array $the_a_Where
	 * @return object
	 */
	public function select($the_sz_Order = null, $the_a_Where = null)
	{
		try {
			$o_Select = $this->getDbTable()
	    		   ->select()
	    		   ->from('tbl_user_loginattempts', array('USER_ATT_DateTime', 'USER_ATT_Ip', 'USER_ATT_Location', 'USER_ATT_Success', 'USER_ATT_UserName', 'USER_ATT_Area', 'CONCAT(USER_ATT_DateTime,"_", USER_ATT_Ip)'));
			if ( !is_null($the_a_Where) )
			{

				foreach($the_a_Where as $sz_Field => $sz_Value)
				{
					if($sz_Field == 'USER_ATT_Success' and $sz_Value != '')
					{
						if($sz_Field == 'USER_ATT_Success' && $sz_Value == Zf_Util_Const::STATUS_ACTIVE)
						{
							$o_Select->where($sz_Field . ' = ?', (int) $sz_Value);
						}
						else
						{
							$o_Select->where($sz_Field . ' != ?', (int) $sz_Value);
						}

					}
					else
					{
						$o_Select->where($sz_Field . ' LIKE ?', '%' . (string) $sz_Value . '%');
					}
				}

			}
			// @todo Need change these below
	    	if ( !is_null($the_sz_Order) ) {

	    		$o_Select->order( $the_sz_Order );

	    	}
	    	return $o_Select;

		} catch(Exception $ex) {

			throw new Admin_Model_LoginAttempt_Exception($ex);

		}

		return null;
	}

	/**
	 * Delete old data of user name
	 * @author LangDD
	 * @param array $the_a_Data
	 * @return void
	 *  */
	public function v_fDeleteOldRecord($the_a_Data)
	{
		try
		{
			$i_fromTime = (int) $the_a_Data['USER_ATT_DateTime'] - 2592000;
			$this->getDbTable()->delete(array(
					'USER_ATT_UserName = ?' => $the_a_Data['USER_ATT_UserName'],
					'USER_ATT_DateTime <= ?' => (int) $i_fromTime
			));

		}
		catch(Exception $ex)
		{
			throw new Admin_Model_LoginAttempt_Exception($ex);
		}

		return null;
	}
}
