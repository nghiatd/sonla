<?php

interface Admin_Model_Org_Interface
{
	public function fetchRow($the_i_DateTime, $the_sz_Ip);
    public function fetchAll($the_sz_Where = null, $the_sz_Order = null, $the_i_Count = null, $the_i_Offset = null);

    public function save($the_a_Data);
    public function delete($the_a_Data);

    public function a_fGetOrgInfo($the_sz_Key, $the_sz_Value);

    public function o_fGetSelect($the_sz_Order = null, $the_a_FilterWhere = null);

    public function sz_fGetFieldMapper($the_sz_MapKey);
}
