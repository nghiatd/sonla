<?php

class Admin_Model_Faq_Repository implements Zf_Model_RepositoryInterface, Admin_Model_Faq_Interface
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
     * @author nhungnt
     * @since 26/04/2014
     * @param Admin_Model_Categories_DataMapper $the_o_data
     * @return object
     */
    public function setData($the_o_data)
    {
        if (is_string($the_o_data)) {

            $the_o_data = new $the_o_data();
        }

        if (!$the_o_data instanceof Admin_Model_Faq_DataMapper) {

            throw new Admin_Model_Faq_Exception('Invalid data access object provided');
        }

        $this->_data = $the_o_data;

        return $this;
    }

    /**
     * Get Data
     * @author nhungnt
     * @since 26/04/2014
     * @return Admin_Model_Faq_DataMapper
     */
    public function getData()
    {
        if (null === $this->_data) {

            $this->setData('Admin_Model_Faq_DataMapper');
        }

        return $this->_data;
    }

    /**
     * Set Mapper
     * @author nhungnt
     * @since 26/04/2014
     * @param object $the_o_Mapper
     * @return object
     */
    public function setMapper($the_o_Mapper)
    {
        if (is_string($the_o_Mapper)) {

            $the_o_Mapper = new $the_o_Mapper();
        }

        if (!$the_o_Mapper instanceof Zf_Model_DataMapper) {

            throw new Admin_Model_Faq_Exception('Invalid data mapper provided');
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

            $this->setMapper('Admin_Model_Faq_Mapper');
        }

        return $this->_mapper;
    }

    /**
     * Save data
     * @author DungNT
     * @since 06/04/2014
     * @param object $the_o_Data
     */
    public function v_fSave($the_o_Data)
    {
        try
        {
            $a_Data = $this->getMapper()->map($the_o_Data);

            $this->getData()->v_fSave($a_Data);

        } catch (Admin_Model_Faq_Exception $ex) {

            throw $ex;
        }

        return null;
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
        try
        {
            // Set parent id to filter
            return $this->getData()->o_fGetSelect($the_sz_Order, $the_a_FilterWhere);

        } catch (Admin_Model_Faq_Exception $ex) {

            throw $ex;
        }

        return null;
    }

    /**
     * Get Faq Info
     * @author nhungnt
     * @since 26/04/2014
     * @param string $the_sz_Key
     * @param string $the_sz_Value
     * @return array
     */
    public function a_fGetFaqInfo($the_sz_Key, $the_sz_Value)
    {
        try
        {
            $a_Row = $this->getData()->a_fGetFaqInfo($the_sz_Key, $the_sz_Value);

            if( $a_Row && is_array($a_Row) ) {

                // Assign data row to Entity and get back to used
                $a_Categories = $this->getMapper()->assign(new Admin_Model_Faq_Entity(), $a_Row)->__toArray();

                return $a_Categories;

            } else {

                return null;
            }

        } catch (Admin_Model_Faq_Exception $ex) {

            throw $ex;

        } catch (Zf_Model_DataMapperException $ex) {

            throw new Admin_Model_Faq_Exception($ex);
        }
    }

    /**
     * Delete data
     * @author nhungnt
     * @since 26/04/2014
     * @param array $the_o_Data
     */
    public function b_fDelete($the_o_Data)
    {
        try
        {
            $a_Data = $this->getMapper()->map($the_o_Data);

            $this->getData()->b_fDelete($a_Data);

            $a_FaqInfo = $this->a_fGetById($a_Data['FAQ_Id']);

            return !$a_FaqInfo ? true : false;

        } catch (Admin_Model_Faq_Exception $ex) {

            throw $ex;
        }

        return null;
    }

    /**
     * Get one row data
     * @author nhungnt
     * @since 26/04/2014
     * @param int $the_i_Id
     * @return array
     */
    public function a_fGetById($the_i_Id)
    {
        try
        {
            $a_Row = $this->getData()->a_fGetById($the_i_Id);

            if( $a_Row && is_array($a_Row) )
            {
                $a_Categories = $this->getMapper()->assign(new Admin_Model_Faq_Entity(), $a_Row);

                return $a_Categories;

            } else {

                return null;
            }

        } catch (Admin_Model_Faq_Exception $ex) {

            throw $ex;

        } catch (Zf_Model_DataMapperException $ex) {

            throw new Admin_Model_Faq_Exception($ex);
        }
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
    
    /**
	 * Get faq category list full data
	 * @author nhungnt
	 * @since 27/04/2014
	 * @param int $the_i_Status
	 * @return array
	 */
	public function a_fGetCatList($the_i_Status = null)
	{
		if ( !is_null($the_i_Status) )
		{
			try {

				$a_Rows = $this->getData()->a_fGetCatList($the_i_Status);

				$a_Categories = array();

				foreach ( $a_Rows as $a_Row ) {

					// Assign row by row to mapper
					$a_Categories[] = $this->getMapper()->assign(new Admin_Model_Faq_Entity(), $a_Row);

				}

				return $a_Categories;

			} catch (Admin_Model_Faq_Exception $ex) {

				throw $ex;

			} catch (Zf_Model_DataMapperException $ex) {

				throw new Admin_Model_Faq_Exception($ex);

			}

		}
		else
		{
			return null;
		}
	}
    
	
    /**
	 * Get faq category list for form
	 * @author nhungnt
	 * @since 27/04/2014
	 * @param int $the_i_Status
	 * @param int $the_i_CatId
	 * @return array
	 */
	public function a_fGetCatFaqForForm( $the_sz_AllOptionMsg = null)
	{
		$i_CatId = '';

		//if ( !is_null($the_sz_CatCode) )
	//	{
			// Get Category
			//$a_CategoryInfo = $this->a_fGetFaqInfo($this->sz_fGetFieldMapper('code'), $the_sz_CatCode);

			//$i_CatId = $a_CategoryInfo['id'];
	//	}

		// Get faq category with full data
		$a_CatList = $this->a_fGetCatList(Zf_Util_Const::STATUS_ACTIVE);

		$sz_AllOptionMsg = $this->_translate->translate('ADMIN_FAQ_TABLE_TITLE_SelectCat');

		if ( !is_null($the_sz_AllOptionMsg) )
		{
			$sz_AllOptionMsg = $the_sz_AllOptionMsg;
		}

		$a_CategoryData = array('' => $sz_AllOptionMsg);

		if($a_CatList && is_array($a_CatList))
		{
			$a_CatForm = array();

			foreach($a_CatList as $o_CatInfo)
			{
				$sz_Name = 'name_' . $this->_locale;

				$a_CategoryData[$o_CatInfo->id] = $o_CatInfo->$sz_Name;
			}
		}

		return $a_CategoryData;
	}
}