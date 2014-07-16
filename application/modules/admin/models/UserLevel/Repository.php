<?php

class Admin_Model_UserLevel_Repository implements Admin_Model_UserLevel_Interface, Zf_Model_RepositoryInterface
{
	protected $_data;
	protected $_mapper;

	/**
	 * @param unknown_type $data
	 */
	public function setData($data) {
		if (is_string($data)) {
            $data = new $data();
        }
        if (!$data instanceof Admin_Model_UserLevel_DataMapper) {
            throw new Admin_Model_UserLevel_Exception('Invalid data access object provided');
        }
        $this->_data = $data;

        return $this;
	}

	/**
	 * @return Zf_Model_Interface
	 */
	public function getData() {
		if (null === $this->_data) {
            $this->setData('Admin_Model_UserLevel_DataMapper');
        }
        return $this->_data;
	}

	/**
	 * @param unknown_type $mapper
	 */
	public function setMapper($mapper) {
		if (is_string($mapper)) {
            $mapper = new $mapper();
        }
        if (!$mapper instanceof Zf_Model_DataMapper) {
            throw new Admin_Model_UserLevel_Exception('Invalid data mapper provided');
        }
        $this->_mapper = $mapper;

        return $this;
	}

	/**
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper() {
		if (null === $this->_mapper) {
            $this->setMapper('Admin_Model_UserLevel_Mapper');
        }
        return $this->_mapper;
	}

	/**
	 * @param unknown_type $id
	 */
	public function fetchRow($id) {
		try {
			$row = $this->getData()->fetchRow($id);
			$level = $this->getMapper()->assign(new Admin_Model_UserLevel_Entity(), $row);
			return $level;
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}
	}

/**
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $count
	 * @param unknown_type $offset
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		try {
			$rows = $this->getData()->fetchAll($where, $order, $count, $offset);
			$levels = array();

			foreach ( $rows as $row ) {
				$levels[] = $this->getMapper()->assign(new Admin_Model_UserLevel_Entity(), $row);
			}

			return $levels;
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}

		return null;
	}

	/**
	 * @param unknown_type $data
	 */
	public function save($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getData()->save($dataArray);
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		}

		return null;
	}

	/**
	 * @param unknown_type $data
	 */
	public function delete($data) {
		try {
			$dataArray = $this->getMapper()->map($data);
			$this->getData()->delete($dataArray);
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		}

		return null;
	}

	/**
	 * @param unknown_type $order
	 */
	public function select($order = null) {
		try {
			return $this->getData()->select($order);
		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		}

		return null;
	}

	/**
	 * Get User level for list and filter
	 * @author DungNT
	 * @since 14/04/2014
	 * @param bool $the_b_IsAll
	 * @param bool $the_b_IsAdmin
	 * @param string $the_sz_AllLevels
	 * @return array
	 */
	public function a_fGetListUserLevel($the_b_IsAll = true, $the_b_IsAdmin = true, $the_sz_AllLevels = null)
	{
		$sz_Where = null;

		if(!$the_b_IsAll)
		{
			$i_IsAdmin = $the_b_IsAdmin ? 1 : 0;

			$sz_Where = 'USER_LEV_IsAdmin = ?' . $i_IsAdmin;
		}

		$a_UserLevels = $this->a_fGetUserLevel($sz_Where);

		$a_UserFilterLevels = array();

		foreach($a_UserLevels as $o_Level)
		{
			$a_UserFilterLevels[$o_Level->level] = $o_Level->alias;
		}

		if( !is_null($the_sz_AllLevels) )
		{
			$a_UserFilterLevels[0] = $the_sz_AllLevels;
		}

		ksort($a_UserFilterLevels);

		return $a_UserFilterLevels;
	}

	/**
	 * Get User level
	 * @author DungNT
	 * @since 14/04/2014
	 * @param string $the_sz_Where
	 * @param string $the_sz_Order
	 * @param int $the_i_Count
	 * @param int $the_i_Offset
	 * @return array
	 */
	public function a_fGetUserLevel($the_sz_Where = null, $the_sz_Order = null, $the_i_Count = null, $the_i_Offset = null)
	{
		try {
			$a_Rows = $this->getData()->a_fGetUserLevel($the_sz_Where, $the_sz_Order, $the_i_Count, $the_i_Offset);

			$a_Levels = array();

			foreach ( $a_Rows as $o_Row )
			{
				$a_Levels[] = $this->getMapper()->assign(new Admin_Model_UserLevel_Entity(), $o_Row);
			}

			return $a_Levels;

		} catch (Admin_Model_UserLevel_Exception $ex) {
			throw $ex;
		} catch (Zf_Model_DataMapperException $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}

		return null;
	}

	public function a_fMultiObjToArr($the_a_ArrayOfObj)
	{
		$a_Array = array();
		foreach($the_a_ArrayOfObj as $o_Obj)
		{
			$a_Array[$o_Obj->level] = $o_Obj->alias;
		}
		return $a_Array;
	}
}
