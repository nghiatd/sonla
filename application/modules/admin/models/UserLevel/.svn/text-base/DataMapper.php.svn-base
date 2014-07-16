<?php

class Admin_Model_UserLevel_DataMapper implements Zf_Model_Interface, Admin_Model_UserLevel_Interface
{
	/**
	 * @var Admin_Model_DbTable_UserLevel
	 */
	protected $_dbTable;

	/**
	 * @param unknown_type $dbTable
	 */
	public function setDbTable($dbTable) {
		if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Admin_Model_UserLevel_Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;

        return $this;
	}

	/**
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable() {
		if (null === $this->_dbTable) {
            $this->setDbTable('Admin_Model_DbTable_UserLevel');
        }
        return $this->_dbTable;
	}

	/**
	 * @param unknown_type $id
	 */
	public function fetchRow($id) {
		try {
	    	$result = $this->getDbTable()->find($id);

	        if (0 == count($result)) {
	            return null;
	        }

	        $row = $result->current()->toArray();

	        return $row;
		} catch(Exception $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}

		return null;
	}

/**
	 * @param unknown_type $where
	 * @param unknown_type $order
	 * @param unknown_type $count
	 * @param unknown_type $offset
	 */
	public function fetchAll($where = null, $order = null, $count = null, $offset = null) {
		try {
			$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
	        return $resultSet->toArray();
		} catch(Exception $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}

		return null;
	}

/**
	 * @param unknown_type $data
	 */
	public function save($data) {
		try {
	        if (null === $data['USER_LEV_Id']) {
	            unset($data['USER_LEV_Id']);
	            return $this->getDbTable()->insert($data);
	        } else {
	            $this->getDbTable()->update($data, array('USER_LEV_Id = ?' => $data['USER_LEV_Id']));
	        }
		} catch(Exception $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}

		return null;
	}

/**
	 * @param unknown_type $data
	 */
	public function delete($data) {
		try {
			$this->getDbTable()->delete(array('USER_LEV_Id = ?' => $data['USER_LEV_Id']));
		} catch(Exception $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}

		return null;
	}

	/**
	 * @param unknown_type $order
	 */
	public function select($order = null) {
		try {
			$select = $this->getDbTable()
	    		   ->select()
	    		   ->from('tbl_user_userlevels', array('USER_LEV_Id', 'USER_LEV_Alias'));

	    	if ( !is_null($order) ) {
	    		$select->order( $order );
	    	}

	    	return $select;
		} catch(Exception $ex) {
			throw new Admin_Model_UserLevel_Exception($ex);
		}

		return null;
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
	public function a_fGetUserLevel($the_sz_Where = null, $the_sz_Order = null, $the_i_Count = null, $the_i_Offset = null) {
		try {
			$o_ResultSet = $this->getDbTable()->fetchAll($the_sz_Where, $the_sz_Order, $the_i_Count, $the_i_Offset);

			return $o_ResultSet->toArray();

		} catch(Exception $ex) {

			throw new Admin_Model_UserLevel_Exception($ex);

		}

		return null;
	}
}
