<?php
/**
 * Definition of Apt_Controller_Plugin_Auth
 *
 * @category   AgilePlanningTool
 * @package    Apt_Controller
 * @subpackage Apt_Controller_Plugin
 * @author     Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright  2010 Mayflower GmbH
 * @license    New BSD License
 */

/**
 * Controller plugin for checking authentication
 *
 * @category   AgilePlanningTool
 * @package    Apt_Controller
 * @subpackage Apt_Controller_Plugin
 * @author     Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright  2010 Mayflower GmbH
 * @license    New BSD License
 */
class Apt_Controller_Plugin_Auth extends Zend_Controller_Plugin_Abstract
{

    /**
     * Redirect target for unauthenticated users
     *
     * @var array
     */
    private $_noAuth = array('module'     => 'default',
                             'controller' => 'user',
                             'action'     => 'login');

    /**
     * Post dispatch hook checking for authenticated users
     *
     * @param Zend_Controller_Request_Abstract $request The request instance
     *
     * @return void
     */
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {

        $auth = Zend_Auth::getInstance();
        if (!$auth->hasIdentity()) {
            $request->setModuleName($this->_noAuth['module']);
            $request->setControllerName($this->_noAuth['controller']);
            $request->setActionName($this->_noAuth['action']);
            return;
        }

    }

}