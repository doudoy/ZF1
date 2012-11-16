<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function config() {
        $config = new Zend_Config_Ini(
                        'application/configs/application.ini', 'production');
        return $config;
    }

    protected function _initAutoload() {
        //autochargement des class de la librairie
        require_once 'include/Zend/Loader/Autoloader.php';
        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('Application_');
        $loader->setFallbackAutoloader(true);
        return $loader;
    }
    protected function _initResources() {
        //autochargement des class de la librairie
        require_once 'include/Zend/Loader/Autoloader/Resource.php';

     $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
        'basePath'      => 'application',
        'namespace'     => 'Application',
        'resourceTypes' => array(
            'form' => array(
                'path'      => 'forms/',
                'namespace' => 'Forms',
            ),
            'model' => array(
                'path'      => 'models/',
                'namespace' => 'Models',
            ),
        ),
    ));
        return $resourceLoader;
    }
    protected function _initFrontController() {
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->throwExceptions(true);
        $frontController->setControllerDirectory($this->config()->resources->frontController->controllerDirectory);
        return $frontController;
    }

    protected function _initView() {
        $view = new Zend_View;
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view);
        $view->addHelperPath('application/views/helpers/');
        $view->addHelperPath('include/ZendX/JQuery/View/Helper', 'ZendX_JQuery_View_Helper');
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        Zend_Layout::startMvc(array('layoutPath' => 'application/layouts/scripts'));
    }

    protected function _initDatabase() {

        $config = new Zend_Config_Ini(
                        'application/configs/application.ini', 'production');
        $db = Zend_Db::factory($config->resources->db);
        Zend_Db_Table::setDefaultAdapter($db);

    }

}