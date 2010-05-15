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
     * Initialising main navigation
     *
     * @return Zend_Navigation Navigation container
     */
    protected function _initNavigation()
    {

        $this->bootstrap('View');
        $view = $this->getResource('View');

        $container = new Zend_Navigation(
            array(
                array(
                    'label'        => 'Home',
                    'action'       => 'index',
                    'controller'   => 'index',
                    'module'       => 'default',
                ),
                array(
                    'label'        => 'Project List',
                    'action'       => 'index',
                    'controller'   => 'project',
                    'module'       => 'default',
                ),
            )
        );

        $view->navigation()->setContainer($container);

        return $container;
    }

    /**
     * Initialise jQuery
     *
     * @return void
     */
    protected function _initJquery()
    {
        $this->bootstrap('View');
        $view = $this->getResource('View');

        $view->headScript()->appendFile(
            "/jquery/js/jquery-1.4.2.min.js"
        );
        $view->headScript()->appendFile(
            "/jquery/js/jquery-ui-1.8.1.custom.min.js"
        );

        $view->headLink()->appendStylesheet(
            "/jquery/css/hot-sneaks/jquery-ui-1.8.1.custom.css",
            "all"
        );
    }

    /**
     * Initialise CSS Grid Layout
     *
     * @return void
     */
    protected function _initCssGrid()
    {
        $this->bootstrap('View');
        $view = $this->getResource('View');

        $view->headLink()
            ->appendStylesheet(
                "/fluid960gs/css/reset.css",
                "screen"
            )
            ->appendStylesheet(
                "/fluid960gs/css/text.css",
                "screen"
            )
            ->appendStylesheet(
                "/fluid960gs/css/grid.css",
                "screen"
            )
            ->appendStylesheet(
                "/fluid960gs/css/layout.css",
                "screen"
            )
            ->appendStylesheet(
                "/fluid960gs/css/nav.css",
                "screen"
            )
            ->appendStylesheet(
                "/fluid960gs/css/ie6.css",
                "screen",
                'IE 6'
            )
            ->appendStylesheet(
                "/fluid960gs/css/ie.css",
                "screen",
                'IE 7'
            );

            $view->headScript()->appendFile(
                "/fluid960gs/jquery-fluid16.js"
            );

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
            'driver'  => $doctrineConfig['conn']['driver'],
            'path'    => $doctrineConfig['conn']['path'],
            'charset' => 'UTF8',
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
