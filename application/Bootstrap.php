<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initAutoLoad()
	{
		$modelLoader = new Zend_Application_Module_Autoloader(array(
						'namespace' => '',
						'basePath' => APPLICATION_PATH));
	}

	
	function _initViewHelpers()
	{
		//$view = new Zend_View();
		
		
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		
		$view->addHelperPath('ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
		
		ZendX_JQuery::enableView($view);
	}
}

