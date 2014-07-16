<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function initResourceLoader()
    {
        $loader = $this->getResourceLoader();
        $loader->addResourceType('helper', 'helpers', 'Helper');
    }

    protected function _initConfig()
    {
        $env = $this->getEnvironment();
        $config = new Zend_Config_Ini(
            dirname(__FILE__) . '/configs/default.ini', 
            $this->getEnvironment()
        );
                
        Zend_Registry::set('default_config', $config);
                
        return $config;
    }

    protected function _initHelpers()
    {
        $this->bootstrap('config');
        $config = $this->getResource('config');

        Zend_Controller_Action_HelperBroker::addHelper(
            new Default_Helper_Authentication()
        );
        
        Zend_Controller_Action_HelperBroker::addHelper(
            new Default_Helper_Paginator()
        );
        
        Zend_Controller_Action_HelperBroker::addHelper(
            new Default_Helper_UrlOrderBy()
        );
        
        Zend_Controller_Action_HelperBroker::addHelper(
            new Default_Helper_UrlFilterBy()
        );
    }
    
}
