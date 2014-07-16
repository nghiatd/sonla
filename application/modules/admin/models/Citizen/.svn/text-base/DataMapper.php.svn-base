<?php

class Admin_Model_Citizen_DataMapper implements Zf_Model_Interface, Admin_Model_Citizen_Interface
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

            throw new Admin_Model_Citizen_Exception('Invalid table data gateway provided');
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

            $this->setDbTable('Admin_Model_DbTable_Citizen');
        }
        return $this->_dbTable;
    }

    /**
     * @param string $the_sz_Order
     * @param array $the_a_Where
     * @return object
     */
    public function o_fGetSelect($the_sz_Order = null, $the_a_Where = null)
    {
        try
        {
            $o_Select = $this->getDbTable()
                                ->select()
                                ->setIntegrityCheck(FALSE)
                                ->from(array('CITI'=>'tbl_citizen'),
                                        array('CITIZEN_id','CITIZEN_Name_en','CITIZEN_image', 'CITIZEN_CategoryId','CITIZEN_Name_vi', 'CITIZEN_Description_en', 'CITIZEN_Description_vi', 'CITIZEN_Status', 'CITIZEN_CreatedDate','CITIZEN_LastActivity'))
                                ->join(array('CAT'=>'tbl_cat_categories'),
                                        'CITI.CITIZEN_CategoryId = CAT.CAT_Id',array('CAT_Name_en'=>'CAT_Name_en','CAT_Name_vi'=>'CAT_Name_vi'));

            if (!is_null($the_a_Where))
            {
                foreach ($the_a_Where as $sz_Field => $sz_Value)
                {
                    if ($sz_Field == 'CITIZEN_CategoryId' || $sz_Field == 'CITIZEN_Sort' || $sz_Field == 'CITIZEN_Status')
                    {
                        if ($sz_Field == 'CITIZEN_Status' && $sz_Value == Zf_Util_Const::STATUS_All)
                        {
                            $o_Select->where($sz_Field . ' < ?', (int) $sz_Value);

                        } else {

                            $o_Select->where($sz_Field . ' = ?', (int) $sz_Value);
                        }

                    } else {

                        $o_Select->where($sz_Field . ' LIKE ?', '%' . (string) $sz_Value . '%');
                    }
                }
            }

            if (!is_null($the_sz_Order)) {

                $o_Select->order($the_sz_Order);
            }
            return $o_Select;

        } catch (Exception $ex) {

            throw new Admin_Model_Citizen_Exception($ex);
        }

        return null;
    }

    public function sz_fGetFieldMapper($the_sz_MapKey)
    {
        // This function is only used in Repository.
    }

    /**
     * Save data
     * @author Cuonglv
     * @since 06/04/2014
     * @param array $the_a_Data
     */
    public function v_fSave($the_a_Data)
    {
        try
        {
            if ( is_null( $this->a_fGetCatById($the_a_Data['CITIZEN_id']) ) )
            {
                $this->getDbTable()->insert($the_a_Data);

            } else {

                $i_CatId = $the_a_Data['CITIZEN_id'];

                unset($the_a_Data['CITIZEN_id']);

                $this->getDbTable()->update($the_a_Data, array('CITIZEN_id = ?' => (int) $i_CatId));
            }

        } catch(Exception $ex) {

            throw new Admin_Model_Citizen_Exception($ex);
        }

        return null;
    }

    /**
     * Get Category by id
     * @author Cuonglv
     * @since 06/04/2014
     * @param int $the_i_Id
     * @return array
     */
    public function a_fGetCatById($the_i_Id)
    {
        try
        {
            $o_Result = $this->getDbTable()->find($the_i_Id);

            if (0 == count($o_Result)) {

                return null;
            }

            $a_Row = $o_Result->current()->toArray();

            return $a_Row;

        } catch(Exception $ex) {

            throw new Admin_Model_Citizen_Exception($ex);
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
            $o_Select = $this->getDbTable()->select()->where($the_sz_Key . ' = ?', (string) $the_sz_Value);

            $o_Result = $this->getDbTable()->fetchRow($o_Select);

            if (0 == count($o_Result)) {

                return null;
            }

            $a_Row = $o_Result->toArray();

            return $a_Row;

        } catch(Exception $ex) {

            throw new Admin_Model_Citizen_Exception($ex);

        }
        return null;
    }

    /**
     * Delete data
     * @author Cuonglv
     * @since 15/04/2014
     * @param array $the_a_Data
     */
    public function b_fDelete($the_a_Data)
    {
        try
        {
            $this->getDbTable()->delete(array('CITIZEN_id = ?' => (int) $the_a_Data['CITIZEN_id']));

        } catch(Exception $ex) {

            throw new Admin_Model_Citizen_Exception($ex);
        }

        return null;
    }

}