<?php

class Admin_Model_User_Repository implements Admin_Model_User_Interface, Zf_Model_RepositoryInterface
{

	protected $_data;

	protected $_mapper;

	/**
	 *
	 * @param Admin_Model_User_DataMapper $dbTable
	 */
	public function setData ($data)
	{
		if (is_string($data)) {
			$data = new $data();
		}
		if (! $data instanceof Admin_Model_User_DataMapper) {
			throw new Admin_Model_User_Exception('Invalid data access object provided');
		}
		$this->_data = $data;

		return $this;
	}

	/**
	 *
	 * @return Admin_Model_User_DataMapper
	 */
	public function getData ()
	{
		if (null === $this->_data) {
			$this->setData('Admin_Model_User_DataMapper');
		}
		return $this->_data;
	}

	/**
	 *
	 * @param string|Admin_Model_User_Mapper $mapper
	 */
	public function setMapper ($mapper)
	{
		if (is_string($mapper)) {
			$mapper = new $mapper();
		}
		if (! $mapper instanceof Zf_Model_DataMapper) {
			throw new Admin_Model_User_Exception('Invalid data mapper provided');
		}
		$this->_mapper = $mapper;

		return $this;
	}

	/**
	 *
	 * @return Admin_Model_User_Mapper
	 */
	public function getMapper ()
	{
		if (null === $this->_mapper) {
			$this->setMapper('Admin_Model_User_Mapper');
		}
		return $this->_mapper;
	}

	/**
	 * Get user by id
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param int $the_i_Id
	 * @return object Admin_Model_User_Entity
	 */
	public function o_fGetUserById ($the_i_Id)
	{
		try {
			$a_Row = $this->getData()->a_fGetUserById($the_i_Id);

			$o_User = $this->getMapper()->assign(new Admin_Model_User_Entity(), $a_Row);

			return $o_User;
		} catch (Admin_Model_User_Exception $ex) {

			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_User_Exception($ex);
		}
	}

	/**
	 *
	 * @param string|array|Zend_Db_Table_Select $where
	 * @param string|array $order
	 * @param int $count
	 * @param int $offset
	 * @return array of Admin_Model_User_Entity
	 */
	public function fetchAll ($where = null, $order = null, $count = null, $offset = null)
	{
		try {
			$rows = $this->getData()->fetchAll($where, $order, $count, $offset);
			$users = array();

			foreach ($rows as $row) {
				$users[] = $this->getMapper()->assign(new Admin_Model_User_Entity(), $row);
			}

			return $users;
		} catch (Admin_Model_User_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
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
	 * @return Admin_Model_User_Entity null
	 */
	public function o_fGetUserByName ($the_sz_Name)
	{
		try {
			$a_Row = $this->getData()->a_fGetUserByName($the_sz_Name);

			if (! is_null($a_Row)) {
				$o_User = $this->getMapper()->assign(new Admin_Model_User_Entity(), $a_Row);

				return $o_User;
			}
		} catch (Admin_Model_User_Exception $ex) {

			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {

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
	 * @return Admin_Model_User_Entity null
	 */
	public function o_fExistsByNameAndChallenge ($the_sz_Name, $the_sz_Challenge)
	{
		try {

			return $this->getData()->o_fExistsByNameAndChallenge($the_sz_Name, $the_sz_Challenge);
		} catch (Admin_Model_User_Exception $ex) {

			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Save data
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param Admin_Model_User_Entity $the_o_Data
	 * @return null int
	 */
	public function i_fSaveData ($the_o_Data)
	{
		try {

			$a_Data = $this->getMapper()->map($the_o_Data);

			// Unset not used value
			unset($a_Data['USER_LEV_IsAdmin']);
			unset($a_Data['USER_LEV_Alias']);

			return $this->getData()->i_fSaveData($a_Data);
		} catch (Admin_Model_User_Exception $ex) {

			throw $ex;
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
		if (! is_array($the_a_Data)) {
			return false;
		}
		try {

			return $this->getData()->b_fDeleteUser($the_a_Data);
		} catch (Admin_Model_User_Exception $ex) {

			throw $ex;
		}

		return null;
	}

	/**
	 * Update challenge
	 *
	 * @author DungNT
	 * @since 19/04/2014
	 * @param Admin_Model_User_Entity $the_o_Data
	 */
	public function b_fUpdateChallenge ($the_o_Data)
	{
		try {
			$a_Data = $this->getMapper()->map($the_o_Data);

			$this->getData()->b_fUpdateChallenge($a_Data);
		} catch (Admin_Model_User_Exception $ex) {

			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Update last activity
	 *
	 * @author DungNT
	 * @since 19/04/2014
	 * @param Admin_Model_User_Entity $the_o_Data
	 */
	public function v_fUpdateLastActivity ($the_o_Data)
	{
		try {

			$a_Data = $this->getMapper()->map($the_o_Data);

			$this->getData()->v_fUpdateLastActivity($a_Data);
		} catch (Admin_Model_User_Exception $ex) {

			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_User_Exception($ex);
		}

		return null;
	}

	/**
	 * Select data
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param string $the_sz_Order
	 * @param array $the_a_FilterWhere
	 * @return object
	 */
	public function o_fGetSelect ($the_sz_Order = null, $the_a_FilterWhere = null)
	{
		try {

			return $this->getData()->o_fGetSelect($the_sz_Order, $the_a_FilterWhere);
		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;
		}

		return null;
	}

	/**
	 * Check User name exist or not
	 *
	 * @author DungNT
	 * @since 14/04/2014
	 * @param string $the_sz_UserName
	 * @return boolean
	 */
	public function b_fCheckUserNameExist ($the_sz_UserName)
	{
		$i_UserId = $this->i_fGetUserIdByName($the_sz_UserName);

		return $i_UserId ? true : false;
	}
}
