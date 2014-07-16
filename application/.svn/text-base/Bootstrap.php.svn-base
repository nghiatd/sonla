<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initConfig()
	{
	    $env = $this->getEnvironment();
        $o_Config = new Zend_Config_Ini(
            dirname(__FILE__) . '/configs/application.ini', 
            $this->getEnvironment()
        );
                
        Zend_Registry::set('config', $o_Config);
                
        return $o_Config;
	}

	/**
	 * Initialize the DB config
	 * @author DungNT
	 * @return void
	 */
	protected function _initDb ()
	{
		$this->bootstrap('config');
		$o_Config = $this->getResource('config');
		 
		$o_Db = $o_Config->resources->db;
		
		if ( !$o_Db )
			return;
		
		$o_dbAdapter = new stdClass();
		
		if ( Zend_Registry::isRegistered('dbAdapters') )
		{
			$o_dbAdapter = Zend_Registry::get('dbAdapters');
			if ( isset($o_dbAdapter) )
				return;
		}
		
		$a_DbConfig = $o_Db->params->toArray();
		
		/* Configures PDO to execute the SET NAMES UTF8 at first */
		$sz_MySQLinit = "SET NAMES UTF8;";
		/* Get timezone */
		
		$sz_timezone = $o_Config->settings->get('default_timezone');
		if(!empty($sz_timezone))
		{	//If a timezone is defined then add timezone to MySQL too
		$sz_offset = $this->getTimeOffset($sz_timezone);
		$sz_MySQLinit .= "SET time_zone = '$sz_offset';";
		}
		$a_DbConfig['driver_options'][PDO::MYSQL_ATTR_INIT_COMMAND] = $sz_MySQLinit;
		$o_dbAdapter = Zend_Db::factory($o_Db->adapter, $a_DbConfig);
		
		/* Default fetch mode */
		$o_dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
		
		/* Default adapter must be OSS Customer */
		if ( (boolean) $o_Db->isDefaultTableAdapter )
		{
			Zend_Db_Table::setDefaultAdapter($o_dbAdapter);
			Zend_Registry::set('db', $o_dbAdapter);
		}
		
		/* Save into registry */
		Zend_Registry::set('dbAdapters', $o_dbAdapter);		
	}

	/**
	 * Get time offset between server and timezone used
	 *
	 * @author DungNT
	 */
	private function getTimeOffset($the_timezone)
	{
		$dateTimeZone_customer = new DateTimeZone($the_timezone);
		$dateTime_server = new DateTime("now");
		$i_timeOffset = $dateTimeZone_customer->getOffset($dateTime_server);
		return sprintf("%s%02d:00",(($i_timeOffset<0)?'':'+'),$i_timeOffset/3600);
	}
	
	protected function _initLayout()
    {
    	$this->bootstrap('config');
    	$o_Config = $this->getResource('config');
    	$o_Layout = $o_Config->resources->layout;
        $a_Options = array('layout'   => $o_Layout->layout,
                         	'layoutPath' => $o_Layout->layoutPath,
                         	'content'    => $o_Layout->content,
        					'nav'    => $o_Layout->nav);
        Zend_Layout::startMvc($a_Options);
	}
	
	protected function _initTranslator()
	{
		$o_ZendTranslate = new Zend_Translate(
			array(
				'adapter' => 'array',
				'content' => APPLICATION_PATH . '/language/en_US.php',
				'locale'  => Zf_Util_Const::LANG_EN
			)
		);
		$o_ZendTranslate->addTranslation(
			array(
				'content' => APPLICATION_PATH . '/language/vi_VN.php',
				'locale'  => Zf_Util_Const::LANG_VI
			)
		);
		
		// Get locale setting from session
		$o_SessionCommon = new Zend_Session_Namespace('COMMON');
		if(!$o_SessionCommon->language || !in_array($o_SessionCommon->language, array(Zf_Util_Const::LANG_EN, Zf_Util_Const::LANG_VI)))
		{
			$o_SessionCommon->language = Zf_Util_Const::LANG_EN;
		}		
		$o_ZendTranslate->setLocale($o_SessionCommon->language);
		
		Zend_Registry::set('Zend_Translate', $o_ZendTranslate);
	}
}