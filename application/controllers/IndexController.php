<?php
/**
 * Definition of IndexController
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Homepage controller
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class IndexController extends Zend_Controller_Action
{

    /**
     * Show the homepage
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->name = Zend_Auth::getInstance()->getIdentity()->name;
    }

}

