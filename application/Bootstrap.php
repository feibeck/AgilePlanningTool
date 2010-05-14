<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Initialise the view
     *
     * @return Zend_View The view instance
     */
    protected function _initView()
    {
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('AgilePlanningTool');

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'ViewRenderer'
        );

        $viewRenderer->setView($view);

        $view->headScript()->appendFile(
            "http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"
        );
        $view->headScript()->appendFile(
            "http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/jquery-ui.min.js"
        );

        $view->headLink()->appendStylesheet(
            "http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/hot-sneaks/jquery-ui.css",
            "all"
        );

        return $view;
    }

    /**
     * Initialize auto loader of Doctrine
     *
     * @return Doctrine_Manager
     */
    public function _initDoctrine() {

        require_once('Doctrine/Common/ClassLoader.php');

        $doctrineConfig = $this->getOption('doctrine');

        $classLoader = new \Doctrine\Common\ClassLoader(
            'Doctrine', APPLICATION_PATH . '/../library/'
        );
        $classLoader->register();

        $config = new \Doctrine\ORM\Configuration();

        $cache = new \Doctrine\Common\Cache\ArrayCache;
        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $config->setProxyDir(APPLICATION_PATH . '/../Proxies');
        $config->setProxyNamespace('App\Proxies');

        $driverImpl = $config->newDefaultAnnotationDriver(
            array(APPLICATION_PATH . '/models')
        );
        $config->setMetadataDriverImpl($driverImpl);

        $sqlLogger = new \Doctrine\DBAL\Logging\DebugStack();
        $config->setSQLLogger($sqlLogger);

        $connectionOptions = array(
            'driver' => $doctrineConfig['conn']['driver'],
            'path'   => $doctrineConfig['conn']['path'],
        );

        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

        Zend_Registry::getInstance()->set('entitymanager', $em);

        return $em;
    }

    public function _initLogger()
    {
        $writer = new Zend_Log_Writer_Firebug();
        $writer->setPriorityStyle(8, 'TABLE');
        $writer->setEnabled(true);

        $logger = new Zend_Log();
        $logger->addWriter($writer);

        Zend_Registry::getInstance()->set('Zend_Log', $logger);

        return $logger;
    }
}
