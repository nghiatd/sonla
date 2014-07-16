<?php

class Zend_View_Helper_TableHelper extends Zend_View_Helper_Abstract
{
	public function tableHelper(array $the_a_Config, $the_o_Paginator)
	{
		//Allowed orders
        $a_OrderType = array('asc', 'desc');

        //Get the order column and type
        $a_Order = explode('-', $the_a_Config['order']);

        //Check if the column exists
        if ( !isset( $the_a_Config['columns'][ $a_Order[0] ] ) ) {
        	$a_Order[0] = $the_a_Config['default-order'][0];
        }

        //Check if the order type exists
        if ( !in_array($a_Order[1], $a_OrderType) ) {
        	$a_Order[1] = $the_a_Config['default-order'][1];
        }

        //Set as selected the given order column
        $the_a_Config['columns'][$a_Order[0]]['selected'] = true;

        $a_Setting = $the_a_Config['setting'];

        //Set the variables for setting
        $this->view->filter			= $a_Setting['filter'];
        $this->view->multidelete	= $a_Setting['multidelete'];
        /*
         * LangDD
         * option to hide add action for login attempt screen
         * without effect to the others screen
         * */
        $this->view->not_allow_add_action	= isset($a_Setting['not_allow_add_action'])? $a_Setting['not_allow_add_action']: false;

        //Set the variables
        if($a_Setting['filter'])
        {
        	$this->view->filterform 		= isset($the_a_Config['filterform']) ? $the_a_Config['filterform'] : '';
        }
        $this->view->paginator 		= $the_o_Paginator;
        $this->view->orderCol  		= $a_Order[0];
        $this->view->orderType 		= $a_Order[1];
        $this->view->columns   		= $the_a_Config['columns'];
        $this->view->mapper    		= $the_a_Config['mapper'];
        $this->view->url 	   		= $the_a_Config['url'];
        $this->view->info 	   		= $the_a_Config['info'];
        $this->view->deletefunc		= $the_a_Config['deletefunc'];


        return $this->view->render('TableHelper.phtml');
	}
}