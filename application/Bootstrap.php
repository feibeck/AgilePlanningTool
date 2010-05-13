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

        $connectionOptions = array(
            'driver' => $doctrineConfig['conn']['driver'],
            'path'   => $doctrineConfig['conn']['path'],
        );

        $em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);

        $registry = Zend_Registry::getInstance();
        $registry->entitymanager = $em;

        return $em;
    }

}