<?php

class Admin_Model_Citizen_Repository implements Zf_Model_RepositoryInterface, Admin_Model_Citizen_Interface
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

        if (!$the_o_data instanceof Admin_Model_Citizen_DataMapper) {

            throw new Admin_Model_Citizen_Exception('Invalid data access object provided');
        }

        $this->_data = $the_o_data;

        return $this;
    }

    /**
     * Get Data
     * @author DungNT
     * @since 04/01/2013
     * @return Admin_Model_Citizen_DataMapper
     */
    public function getData()
    {
        if (null === $this->_data) {

            $this->setData('Admin_Model_Citizen_DataMapper');
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

            throw new Admin_Model_Citizen_Exception('Invalid data mapper provided');
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

            $this->setMapper('Admin_Model_Citizen_Mapper');
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

        } catch (Admin_Model_Citizen_Exception $ex) {

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

        } catch (Admin_Model_Citizen_Exception $ex) {

            throw $ex;
        }

        return null;
    }

    /**
     * Get citizen by code
     * @author Cuonglv
     * @since 05/04/2014
     * @param string $the_sz_Key
     * @param string $the_sz_Value
     * @return array
     */
    public function a_fGetCatInfo($the_sz_Key, $the_sz_Value)
    {
        try
        {
            $a_Row = $this->getData()->a_fGetCatInfo($the_sz_Key, $the_sz_Value);

            if( $a_Row && is_array($a_Row) ) {

                // Assign data row to Entity and get back to used
                $a_Categories = $this->getMapper()->assign(new Admin_Model_Citizen_Entity(), $a_Row)->__toArray();

                return $a_Categories;

            } else {

                return null;
            }

        } catch (Admin_Model_Citizen_Exception $ex) {

            throw $ex;

        } catch (Zf_Model_DataMapperException $ex) {

            throw new Admin_Model_Citizen_Exception($ex);
        }
    }

    /**
     * Delete data
     * @author Cuonglv
     * @since 06/04/2014
     * @param array $the_o_Data
     */
    public function b_fDelete($the_o_Data)
    {
        try
        {
            $a_Data = $this->getMapper()->map($the_o_Data);

            $this->getData()->b_fDelete($a_Data);

            $a_CitizenInfo = $this->a_fGetCatById($a_Data['CITIZEN_id']);

            return !$a_CitizenInfo ? true : false;

        } catch (Admin_Model_Citizen_Exception $ex) {

            throw $ex;
        }

        return null;
    }

    /**
     * Get one row data
     * @author Cuonglv
     * @since 16/04/2014
     * @param int $the_i_Id
     * @return array
     */
    public function a_fGetCatById($the_i_Id)
    {
        try
        {
            $a_Row = $this->getData()->a_fGetCatById($the_i_Id);

            if( $a_Row && is_array($a_Row) )
            {
                $a_Categories = $this->getMapper()->assign(new Admin_Model_Citizen_Entity(), $a_Row);

                return $a_Categories;

            } else {

                return null;
            }

        } catch (Admin_Model_Citizen_Exception $ex) {

            throw $ex;

        } catch (Zf_Model_DataMapperException $ex) {

            throw new Admin_Model_Citizen_Exception($ex);
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
}