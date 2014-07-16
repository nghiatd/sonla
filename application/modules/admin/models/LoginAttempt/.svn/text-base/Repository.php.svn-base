<?php

class Admin_Model_LoginAttempt_Repository implements Zf_Model_RepositoryInterface, Admin_Model_LoginAttempt_Interface
{
	protected $_data;
	protected $_mapper;

	/**
	 * Set Data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param Admin_Model_LoginAttempt_DataMapper $the_o_data
	 * @return object
	 */
	public function setData($the_o_data)
	{
		if (is_string($the_o_data)) {

			$the_o_data = new $the_o_data();

		}

        if (!$the_o_data instanceof Admin_Model_LoginAttempt_DataMapper) {

        	throw new Admin_Model_LoginAttempt_Exception('Invalid data access object provided');

        }

        $this->_data = $the_o_data;

        return $this;
	}

	/**
	 * Get Data
	 * @author DungNT
	 * @since 04/01/2013
	 * @return Admin_Model_LoginAttempt_DataMapper
	 */
	public function getData()
	{
		if (null === $this->_data) {

			$this->setData('Admin_Model_LoginAttempt_DataMapper');

		}
		return $this->_data;
	}

	/**
	 * Set Mapper
	 * @author DungNT
	 * @since 04/01/2013
	 * @param object $the_o_Mapper
	 * @return object
	 */
	public function setMapper($the_o_Mapper)
	{
		if (is_string($the_o_Mapper)) {

            $the_o_Mapper = new $the_o_Mapper();

		}

        if (!$the_o_Mapper instanceof Zf_Model_DataMapper) {

        	throw new Admin_Model_LoginAttempt_Exception('Invalid data mapper provided');

        }

        $this->_mapper = $the_o_Mapper;

        return $this;
	}

	/**
	 * Get Mapper
	 * @author DungNT
	 * @since 04/01/2013
	 * @return Zf_Model_DataMapper
	 */
	public function getMapper()
	{
		if (null === $this->_mapper) {

            $this->setMapper('Admin_Model_LoginAttempt_Mapper');

		}

		return $this->_mapper;
	}

	/**
	 * Get one row data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param int $the_i_DateTime
	 * @param string $the_sz_Ip
	 * @return array
	 */
	public function fetchRow($the_i_DateTime, $the_sz_Ip)
	{
		try {

			$a_Row = $this->getData()->fetchRow($the_i_DateTime, $the_sz_Ip);

			if( $a_Row && is_array($a_Row) ) {

				$a_LoginAttempt = $this->getMapper()->assign(new Admin_Model_LoginAttempt_Entity(), $a_Row);

				return $a_LoginAttempt;

			} else {

				return null;

			}

		} catch (Admin_Model_LoginAttempt_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_LoginAttempt_Exception($ex);

		}
	}

	/**
	 * Get all data
	 * @author DungNT
	 * @since 04/01/2013
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

			$a_LoginAttempts = array();

			foreach ( $a_Rows as $a_Row ) {

				$a_LoginAttempts[] = $this->getMapper()->assign(new Admin_Model_LoginAttempt_Entity(), $a_Row);

			}

			return $a_LoginAttempts;

		} catch (Admin_Model_LoginAttempt_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_LoginAttempt_Exception($ex);

		}

		return null;
	}

	/**
	 * Save data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param array $the_a_Data
	 */
	public function save($the_a_Data)
	{
		try {

			$a_Data = $this->getMapper()->map($the_a_Data);

			// Unset this value from mapper before save data
			unset($a_Data['CONCAT(USER_ATT_DateTime,"_", USER_ATT_Ip)']);

			$this->getData()->save($a_Data);
			$this->v_fDeleteOldRecord($a_Data);

		} catch (Admin_Model_LoginAttempt_Exception $ex) {

			throw $ex;

		}

		return null;
	}

	/**
	 * Delete data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param array $the_a_Data
	 */
	public function delete($the_a_Data)
	{
		try
		{
			$this->getData()->delete($the_a_Data);
		}
		catch (Admin_Model_LoginAttempt_Exception $ex)
		{
			throw $ex;
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

			$this->getData()->b_fMultiDelete($the_a_Data);

			$i_CountCat = $this->i_fCountLoginAttemptByIdList($the_a_Data);

			return !$i_CountCat ? true : false;

		} catch (Admin_Model_LoginAttempt_Exception $ex) {

			throw $ex;
		}

		return null;
	}

	/**
	 * Count categories by ids list
	 * @author DungNT
	 * @since 19/12/2013
	 * @param 06/04/2014
	 * @return int
	 */
	public function i_fCountLoginAttemptByIdList($the_a_Ids = null)
	{
		try {

			return $this->getData()->i_fCountLoginAttemptByIdList($the_a_Ids);

		} catch (Admin_Model_LoginAttempt_Exception $ex) {

			throw $ex;

		}

		return null;
	}

	/**
	 * Select data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param string $the_sz_Order
	 * @return object
	 */
	public function select($the_sz_Order = null, $the_o_FilterWhere = null)
	{
		try {

			return $this->getData()->select($the_sz_Order, $the_o_FilterWhere);

		} catch (Admin_Model_LoginAttempt_Exception $ex) {

			throw $ex;

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
			$this->getData()->v_fDeleteOldRecord($the_a_Data);
		}
		catch (Admin_Model_LoginAttempt_Exception $ex)
		{
			throw $ex;
		}

		return null;
	}

}
