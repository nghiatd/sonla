<?php

class Admin_Model_News_Repository implements Zf_Model_RepositoryInterface, Admin_Model_News_Interface
{
	protected $_data;

	protected $_mapper;

	protected $_locale;

	public function __construct()
	{
		// Get locale from session
		$o_SessionCommon = new Zend_Session_Namespace('COMMON');
		$this->_locale = $o_SessionCommon->language;
	}
	/**
	 * Set Data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param Admin_Model_Categories_DataMapper $the_o_data
	 * @return object
	 */
	public function setData($the_o_data)
	{
		if (is_string($the_o_data)) {

			$the_o_data = new $the_o_data();

		}

        if (!$the_o_data instanceof Admin_Model_News_DataMapper) {

        	throw new Admin_Model_News_Exception('Invalid data access object provided');

        }

        $this->_data = $the_o_data;

        return $this;
	}

	/**
	 * Get Data
	 * @author DungNT
	 * @since 04/01/2013
	 * @return Admin_Model_Categories_DataMapper
	 */
	public function getData()
	{
		if (null === $this->_data) {

			$this->setData('Admin_Model_News_DataMapper');

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

        	throw new Admin_Model_News_Exception('Invalid data mapper provided');

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

            $this->setMapper('Admin_Model_News_Mapper');
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

				$a_Categories = $this->getMapper()->assign(new Admin_Model_News_Entity(), $a_Row);

				return $a_Categories;

			} else {

				return null;

			}

		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_News_Exception($ex);

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

			$a_Categoriess = array();

			foreach ( $a_Rows as $a_Row ) {

				$a_Categoriess[] = $this->getMapper()->assign(new Admin_Model_News_Entity(), $a_Row);

			}

			return $a_Categoriess;

		} catch (Admin_Model_News_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_News_Exception($ex);

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

			$this->getData()->save($a_Data);

		} catch (Admin_Model_News_Exception $ex) {

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
		try {

			$a_Data = $this->getMapper()->map($the_a_Data);

			$this->getData()->delete($a_Data);

		} catch (Admin_Model_News_Exception $ex) {

			throw $ex;

		}

		return null;
	}


	/**
	 * Get parent category list full data
	 * @author DungNT
	 * @since 05/04/2014
	 * @param int $the_i_Status
	 * @return array
	 */
	public function a_fGetParentCatList($the_i_Status = null)
	{
		if ( !is_null($the_i_Status) )
		{
			try {

				$a_Rows = $this->getData()->a_fGetParentCatList($the_i_Status);

				$a_Categoriess = array();

				foreach ( $a_Rows as $a_Row ) {

					// Assign row by row to mapper
					$a_Categoriess[] = $this->getMapper()->assign(new Admin_Model_News_Entity(), $a_Row);

				}

				return $a_Categoriess;

			} catch (Admin_Model_News_Exception $ex) {

				throw $ex;

			} catch (Zf_Model_DataMapperException $ex) {

				throw new Admin_Model_News_Exception($ex);

			}

		}
		else
		{
			return null;
		}
	}

	/**
	 * Get parent category list for form
	 * @author DungNT
	 * @since 05/04/2014
	 * @param int $the_i_Status
	 * @return array
	 */
	public function a_fGetParentCatForForm($the_i_Status = null)
	{
		if ( !is_null($the_i_Status) )
		{
			// Get parent category with full data
			$a_ParentCatList = $this->a_fGetParentCatList($the_i_Status);

			if($a_ParentCatList && is_array($a_ParentCatList))
			{
				$a_ParentCatForm = array();

				foreach($a_ParentCatList as $o_CatInfo)
				{
					$sz_Name = 'name_' . $this->_locale;

					$a_ParentCatForm[$o_CatInfo->id] = $o_CatInfo->$sz_Name;
				}

				return $a_ParentCatForm;
			}
			else
			{
				return null;
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
	public function a_fGetNewsInfo($the_sz_Key, $the_sz_Value)
	{
		try {

			$a_Row = $this->getData()->a_fGetNewsInfo($the_sz_Key, $the_sz_Value);

			if( $a_Row && is_array($a_Row) ) {

				// Assign data row to Entity and get back to used
				$a_Categories = $this->getMapper()->assign(new Admin_Model_News_Entity(), $a_Row)->__toArray();

				return $a_Categories;

			} else {

				return null;

			}

		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_News_Exception($ex);

		}
	}

	/**
	 * Select data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param string $the_sz_Order
	 * @param array $the_a_FilterWhere
	 * @return object
	 */
	public function o_fGetSelect($the_sz_Order = null, $the_a_FilterWhere = null)
	{
		try {
			// Get Category by code from Entity
			$a_CatParentEntity = $this->a_fGetNewsInfo($this->sz_fGetFieldMapper('category_id'), isset($the_a_FilterWhere[$this->sz_fGetFieldMapper('category_id')]) ? $the_a_FilterWhere[$this->sz_fGetFieldMapper('category_id')]: null);

			// Remore parent code from filter
			unset($the_a_FilterWhere[$this->sz_fGetFieldMapper('category_id')]);

			// Set parent id to filter
			return $this->getData()->o_fGetSelect($the_sz_Order, $the_a_FilterWhere);

		} catch (Admin_Model_News_Exception $ex) {

			throw $ex;

		}

		return null;
	}

	/**
	 * Get field from mapper by key
	 * @author DungNT
	 * @since 05/04/2014
	 * @param string $the_sz_MapKey
	 * @return string
	 */
	public function sz_fGetFieldMapper($the_sz_MapKey)
	{
		return $this->getMapper()->getField($the_sz_MapKey);
	}
}