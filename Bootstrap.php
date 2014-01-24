<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload(){
		$moduleLoader = new Zend_Application_Module_Autoloader(array(
		'namespace' => '',
		'basePath' => APPLICATION_PATH));
		return $moduleLoader;
	}
    
	protected function _initDoctype(){ 
		$this->bootstrap('view'); 
		$view = $this->getResource('view'); 
        return $view;
	}
    
    protected function _initViewHelpers(){
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		$view->doctype('XHTML1_STRICT');
		$view->headTitle()->setSeparator(' - ');		
		$view->headTitle('Blood Donor\'s of Bangladesh');
		$view->headMeta()->appendHttpEquiv('Content-Type', CONTENT_TYPE );		
	}
    
    protected function _initDatabase(){   
        if( ! Zend_Registry::isRegistered('ezy_db')) {    
            $config = new Zend_Config_Ini(dirname(__FILE__).'/configs/application.ini', APPLICATION_ENV);        
            $adapter = $config->resources->db->adapter;
            $params = $config->resources->db->params;        
            $db = Zend_Db::factory($adapter, $params);        
            Zend_Registry::set('ezy_db', $db);      
        }
    }
    
    protected function _initUser(){
        // get the email address from the email got from graph.api         
        $mapper = new Model_Mapper_User();
        $user = $mapper->getUserByEmail("5@ezy.com");
        Zend_Registry::set('ezy_user', $user);
    }
    
    protected function _initLibrary() {
        $options = array(   'basePath'  => dirname(__FILE__).'/library',
                            'namespace' => '' );        
        $resourceLoader = new Zend_Loader_Autoloader_Resource($options);
        $resourceLoader->addResourceType('Ezy', '', 'Ezy');
    }
}

