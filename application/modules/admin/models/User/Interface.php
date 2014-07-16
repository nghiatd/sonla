<?php

interface Admin_Model_User_Interface
{

	public function fetchAll ($where = null, $order = null, $count = null, $offset = null);

	public function o_fExistsByNameAndChallenge ($the_sz_Name, $the_sz_Challenge);

	public function i_fSaveData ($the_o_Data);

	public function b_fDeleteUser ($the_a_Data);

	public function o_fGetSelect ($the_sz_Order = null, $the_a_FilterWhere = null);

	public function b_fUpdateChallenge ($the_o_Data);

	public function v_fUpdateLastActivity ($the_o_Data);
}
