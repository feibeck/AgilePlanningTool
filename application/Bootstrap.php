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

}