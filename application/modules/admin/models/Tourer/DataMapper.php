<?php

class Admin_Model_Tourer_DataMapper implements Zf_Model_Interface, Admin_Model_Tourer_Interface
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

            throw new Admin_Model_Tourer_Exception('Invalid table data gateway provided');
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

            $this->setDbTable('Admin_Model_DbTable_Tourer');
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
                                ->from(array('T'=>'tbl_tourer'),array('TOURER_id','TOURER_Name_en', 'TOURER_CategoryId','TOURER_Name_vi', 'TOURER_Description_en', 'TOURER_Description_vi', 'TOURER_Status', 'TOURER_CreatedDate','TOURER_LastActivity'))
                                ->join(array('CAT'=>'tbl_cat_categories'),
                                        'T.TOURER_CategoryId = CAT.CAT_Id',array('CAT_Name_en'=>'CAT_Name_en','CAT_Name_vi'=>'CAT_Name_vi'));

            if (!is_null($the_a_Where))
            {
                foreach ($the_a_Where as $sz_Field => $sz_Value)
                {
                    if ($sz_Field == 'TOURER_CategoryId' || $sz_Field == 'TOURER_Sort' || $sz_Field == 'TOURER_Status')
                    {
                        if ($sz_Field == 'TOURER_Status' && $sz_Value == Zf_Util_Const::STATUS_All)
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

            throw new Admin_Model_Tourer_Exception($ex);
        }

        return null;
    }

    /**
     * Save data
     * @author Nhungnt
     * @since 23/04/2014
     * @param array $the_a_Data
     */
    public function v_fSave($the_a_Data)
    {
        try
        {
            if ( is_null( $this->a_fGetById($the_a_Data['TOURER_id']) ) )
            {
                $this->getDbTable()->insert($the_a_Data);

            } else {

                $i_Id = $the_a_Data['TOURER_id'];

                unset($the_a_Data['TOURER_id']);

                $this->getDbTable()->update($the_a_Data, array('TOURER_id = ?' => (int) $i_Id));
            }

        } catch(Exception $ex) {

            throw new Admin_Model_Tourer_Exception($ex);
        }

        return null;
    }

    /**
     * Get Tourer by id
     * @author Nhungnt
     * @since 23/04/2014
     * @param int $the_i_Id
     * @return array
     */
    public function a_fGetById($the_i_Id)
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

            throw new Admin_Model_Tourer_Exception($ex);
        }

        return null;
    }

    /**
     * Get tourer by code
     * @author nhungnt
     * @since 23/04/2014
     * @param string $the_sz_Key
     * @param string $the_sz_Value
     * @return array
     */
    public function a_fGetTourerInfo($the_sz_Key, $the_sz_Value)
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

            throw new Admin_Model_Tourer_Exception($ex);

        }
        return null;
    }

    /**
     * Delete data
     * @author nhungnt
     * @since 23/04/2014
     * @param array $the_a_Data
     */
    public function b_fDelete($the_a_Data)
    {
        try
        {
            $this->getDbTable()->delete(array('TOURER_id = ?' => (int) $the_a_Data['TOURER_id']));

        } catch(Exception $ex) {

            throw new Admin_Model_Tourer_Exception($ex);
        }

        return null;
    }

}