<?php

class Admin_Model_Categories_Repository implements Zf_Model_RepositoryInterface, Admin_Model_Categories_Interface
{
	protected $_data;

	protected $_mapper;

	protected $_locale;

	protected $_translate;

	public function __construct()
	{
		// Get locale from session
		$o_SessionCommon = new Zend_Session_Namespace('COMMON');
		$this->_locale = $o_SessionCommon->language;

		// Get translate
		$this->_translate = Zend_Registry::get('Zend_Translate');
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

        if (!$the_o_data instanceof Admin_Model_Categories_DataMapper) {

        	throw new Admin_Model_Categories_Exception('Invalid data access object provided');

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

			$this->setData('Admin_Model_Categories_DataMapper');

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

        	throw new Admin_Model_Categories_Exception('Invalid data mapper provided');

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

            $this->setMapper('Admin_Model_Categories_Mapper');

		}

		return $this->_mapper;
	}

	/**
	 * Get one row data
	 * @author DungNT
	 * @since 04/01/2013
	 * @param int $the_i_Id
	 * @return array
	 */
	public function a_fGetCatById($the_i_Id)
	{
		try {

			$a_Row = $this->getData()->a_fGetCatById($the_i_Id);

			if( $a_Row && is_array($a_Row) ) {

				$a_Categories = $this->getMapper()->assign(new Admin_Model_Categories_Entity(), $a_Row);

				return $a_Categories;

			} else {

				return null;

			}

		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_Categories_Exception($ex);

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
	public function a_fGetAllCat($the_sz_Where = null, $the_sz_Order = null, $the_i_Count = null, $the_i_Offset = null)
	{
		try {

			$a_Rows = $this->getData()->a_fGetAllCat($the_sz_Where, $the_sz_Order, $the_i_Count, $the_i_Offset);

			$a_Categories = array();

			foreach ( $a_Rows as $a_Row ) {

				$a_Categories[] = $this->getMapper()->assign(new Admin_Model_Categories_Entity(), $a_Row);

			}

			return $a_Categories;

		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_Categories_Exception($ex);

		}

		return null;
	}

	/**
	 * Save data
	 * @author DungNT
	 * @since 06/04/2014
	 * @param object $the_o_Data
	 */
	public function v_fSave($the_o_Data)
	{
		try {

			$a_Data = $this->getMapper()->map($the_o_Data);

			$this->getData()->v_fSave($a_Data);

		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;

		}

		return null;
	}

	/**
	 * Delete data
	 * @author DungNT
	 * @since 06/04/2014
	 * @param array $the_o_Data
	 */
	public function b_fDelete($the_o_Data)
	{
		try {

			$a_Data = $this->getMapper()->map($the_o_Data);

			$this->getData()->b_fDelete($a_Data);

			$a_CatInfo = $this->a_fGetCatById($a_Data['CAT_Id']);

			return !$a_CatInfo ? true : false;

		} catch (Admin_Model_Categories_Exception $ex) {

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

			$i_CountCat = $this->i_fCountCatByIdList($the_a_Data);

			return !$i_CountCat ? true : false;

		} catch (Admin_Model_Categories_Exception $ex) {

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
	public function i_fCountCatByIdList($the_a_Ids = null)
	{
		try {

			return $this->getData()->i_fCountCatByIdList($the_a_Ids);

		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;

		}

		return null;
	}

	/**
	 * Get parent category list full data
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

				$a_Rows = $this->getData()->a_fGetParentCatList($the_i_Status, $the_i_ParentId);

				$a_Categories = array();

				foreach ( $a_Rows as $a_Row ) {

					// Assign row by row to mapper
					$a_Categories[] = $this->getMapper()->assign(new Admin_Model_Categories_Entity(), $a_Row);

				}

				return $a_Categories;

			} catch (Admin_Model_Categories_Exception $ex) {

				throw $ex;

			} catch (Zf_Model_DataMapperException $ex) {

				throw new Admin_Model_Categories_Exception($ex);

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
	 * @param int $the_i_ParentId
	 * @return array
	 */
	public function a_fGetParentCatForForm($the_sz_CatCode = null, $the_sz_AllOptionMsg = null)
	{
		$i_ParentId = Zf_Util_Const::TOP_PARENT_ID;

		if ( !is_null($the_sz_CatCode) )
		{
			// Get Category
			$a_CategoryInfo = $this->a_fGetCatInfo($this->sz_fGetFieldMapper('code'), $the_sz_CatCode);

			$i_ParentId= $a_CategoryInfo['id'];
		}

		// Get parent category with full data
		$a_ParentCatList = $this->a_fGetParentCatList(Zf_Util_Const::STATUS_ACTIVE, $i_ParentId);

		$sz_AllOptionMsg = $this->_translate->translate('ADMIN_CAT_TABLE_TITLE_SelectParent');

		if ( !is_null($the_sz_AllOptionMsg) )
		{
			$sz_AllOptionMsg = $the_sz_AllOptionMsg;
		}

		$a_CategoryData = array('' => $sz_AllOptionMsg);

		if($a_ParentCatList && is_array($a_ParentCatList))
		{
			$a_ParentCatForm = array();

			foreach($a_ParentCatList as $o_CatInfo)
			{
				$sz_Name = 'name_' . $this->_locale;

				$a_CategoryData[$o_CatInfo->id] = $o_CatInfo->$sz_Name;
			}
		}

		return $a_CategoryData;
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
		try {

			$a_Row = $this->getData()->a_fGetCatInfo($the_sz_Key, $the_sz_Value);

			if( $a_Row && is_array($a_Row) ) {

				// Assign data row to Entity and get back to used
				$a_Categories = $this->getMapper()->assign(new Admin_Model_Categories_Entity(), $a_Row)->__toArray();

				return $a_Categories;

			} else {

				return null;

			}

		} catch (Admin_Model_Categories_Exception $ex) {

			throw $ex;

		} catch (Zf_Model_DataMapperException $ex) {

			throw new Admin_Model_Categories_Exception($ex);

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
			$a_CatParentEntity = $this->a_fGetCatInfo($this->sz_fGetFieldMapper('code'), $the_a_FilterWhere[$this->sz_fGetFieldMapper('code')]);

			// Remore parent code from filter
			unset($the_a_FilterWhere[$this->sz_fGetFieldMapper('code')]);

			// Set parent id to filter
			$the_a_FilterWhere[$this->sz_fGetFieldMapper('parent_id')] = $a_CatParentEntity['id'];

			return $this->getData()->o_fGetSelect($the_sz_Order, $the_a_FilterWhere);

		} catch (Admin_Model_Categories_Exception $ex) {

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
