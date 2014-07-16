<?php

class Admin_Model_User_DataMapper implements Zf_Model_Interface, Admin_Model_User_Interface
{

	/**
	 *
	 * @var Admin_Model_DbTable_User
	 */
	protected $_dbTable;

	/**
	 *
	 * @param string|Admin_Model_DbTable_User $dbTable
	 * @return Admin_Model_User_DataMapper
	 * @throws Admin_Model_User_Exception
	 */
	public function setDbTable ($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (! $dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Admin_Model_User_Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;

		return $this;
	}

	/**
	 *
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable ()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Admin_Model_DbTable_User');
		}
		return $this->_dbTable;
	}

	/**
	 * Get user by id
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param int $the_i_Id
	 * @return array
	 */
	public function a_fGetUserById ($the_i_Id)
	{
		try {
			$o_Result = $this->getDbTable()->find($the_i_Id);

			if (0 == count($o_Result)) {
				return null;
			}

			$a_Row = $o_Result->current()->toArray();

			return $a_Row;
		} catch (Exception $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 *
	 * @param string|array|Zend_Db_Table_Select $where
	 * @param string|array $order
	 * @param int $count
	 * @param int $offset
	 * @return array
	 */
	public function fetchAll ($where = null, $order = null, $count = null, $offset = null)
	{
		try {
			$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
			return $resultSet->toArray();
		} catch (Exception $ex) {
			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Get user by name
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param string $the_sz_Name
	 * @return array
	 */
	public function a_fGetUserByName ($the_sz_Name)
	{
		try {
			$o_Select = $this->o_fGetSelect(null, null, array(
					'USER_Name' => $the_sz_Name
			));

			$o_Row = $this->getDbTable()->fetchRow($o_Select);

			if (0 == count($o_Row)) {
				return null;
			}

			return $o_Row->toArray();
		} catch (Exception $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Get exists by name and challenge
	 *
	 * @author DungNT
	 * @since 19/04/2014
	 * @param string $the_sz_Name
	 * @param string $the_sz_Challenge
	 * @return bool
	 */
	public function o_fExistsByNameAndChallenge ($the_sz_Name, $the_sz_Challenge)
	{
		try {
			$o_Select = $this->getDbTable()
				->select()
				->from($this->getDbTable(), array(
					'count(*) as amount'
			))
				->where('USER_Name = ?', (string) $the_sz_Name)
				->where('USER_Challenge = ?', (string) $the_sz_Challenge);
			$a_Rows = $this->getDbTable()->fetchAll($o_Select);

			if ($a_Rows[0]->amount > 0) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return false;
	}

	/**
	 * Save data
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param array $the_a_Data
	 * @return null int
	 */
	public function i_fSaveData ($the_a_Data)
	{
		try {
			if (null === $the_a_Data['USER_Id']) {

				unset($the_a_Data['USER_Id']);

				return $this->getDbTable()->insert($the_a_Data);
			} else {

				$this->getDbTable()->update($the_a_Data, array(
						'USER_Id = ?' => $the_a_Data['USER_Id']
				));

				return $the_a_Data['USER_Id'];
			}
		} catch (Exception $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Delete User by array of Id
	 *
	 * @author DungNT
	 * @since 19/04/2014
	 * @param array $the_a_Data
	 * @return null boolean
	 */
	public function b_fDeleteUser ($the_a_Data)
	{
		try {

			if (count($the_a_Data) == 1) {
				$i_UserId = implode('', $the_a_Data);

				$this->getDbTable()->delete(array(
						'USER_Id = ?' => (int) $i_UserId
				));
			} else {
				$sz_UserIds = implode(',', $the_a_Data);

				$this->getDbTable()->delete(array(
						'USER_Id IN (?)' => (string) $sz_UserIds
				));
			}

			return true;
		} catch (Exception $ex) {

			return false;

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Get user select
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param string $the_sz_Order
	 * @param array $the_a_FilterWhere
	 * @param array $the_a_Where
	 * @return object
	 */
	public function o_fGetSelect ($the_sz_Order = null, $the_a_FilterWhere = null, $the_a_Where = null)
	{
		try {
			$o_Select = $this->getDbTable()
				->select()
				->from($this->getDbTable(), array(
					'USER_Id',
					'USER_Name',
					'USER_Email',
					'USER_Password',
					'USER_Challenge',
					'USER_Status',
					'USER_Level',
					'USER_LastActivity'
			))
				->setIntegrityCheck(false)
				->join('tbl_user_userlevels', 'tbl_user_userlevels.USER_LEV_Id = tbl_user_userslist.USER_Level', array(
					'USER_LEV_Alias',
					'USER_LEV_IsAdmin'
			));

			if (! is_null($the_a_Where)) {
				foreach ($the_a_Where as $sz_Field => $sz_Value) {
					$o_Select->where($sz_Field . ' = ?', (string) $sz_Value);
				}
			}

			if (! is_null($the_a_FilterWhere)) {
				foreach ($the_a_FilterWhere as $sz_Field => $sz_Value) {
					if ($sz_Field == 'USER_Status') {
						if ($sz_Value == 2) {
							$o_Select->where($sz_Field . ' < ?', (int) $sz_Value);
						} else {

							$o_Select->where($sz_Field . ' = ?', (int) $sz_Value);
						}
					} else
						if ($sz_Field == 'USER_Level') {
							if ($sz_Value > 0) {
								$o_Select->where($sz_Field . ' = ?', (int) $sz_Value);
							}
						} else {

							$o_Select->where($sz_Field . ' LIKE ?', '%' . (string) $sz_Value . '%');
						}
				}
			}
			if (! is_null($the_sz_Order)) {
				$o_Select->order($the_sz_Order);
			}

			return $o_Select;
		} catch (Exception $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 *
	 * @param int $id
	 * @param string $challenge
	 */
	public function b_fUpdateChallenge ($the_a_Data)
	{
		try {

			$i_UserId = $the_a_Data['USER_Id'];

			$a_Data = array(
					'USER_Challenge' => $the_a_Data['USER_Challenge']
			);

			$this->getDbTable()->update($a_Data, array(
					'USER_Id = ?' => $i_UserId
			));
		} catch (Exception $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Update last activity
	 *
	 * @author DungNT
	 * @since 19/04/2014
	 * @param array $the_a_Data
	 */
	public function v_fUpdateLastActivity ($the_a_Data)
	{
		try {
			$i_Id = $the_a_Data['USER_Id'];

			$a_Data = array(
					'USER_LastActivity' => $the_a_Data['USER_LastActivity']
			);

			$this->getDbTable()->update($a_Data, array(
					'USER_Id = ?' => (int) $i_Id
			));
		} catch (Exception $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}
}
