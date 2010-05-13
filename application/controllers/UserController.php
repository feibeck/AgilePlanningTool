<?php
/**
 * Definition of UserController
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Controller handling login and logout
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class UserController extends Zend_Controller_Action
{

    /**
     * Logout of the currently logged in user
     *
     * @return void
     */
    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();
        $this->_helper->redirector->gotoSimple(
            'login'
        );
        return;
    }

    /**
     * Show login form and handle login process
     *
     * @return void
     */
    public function loginAction()
    {

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $this->_helper->redirector->gotoSimple(
                'index',
                'index'
            );
            return;
        }

        $bootstrap = $this->getInvokeArg('bootstrap');
        $em = $bootstrap->getResource('doctrine');

        $form = new Apt_Form_Login(array('method' => 'POST'));

        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->getPost())) {

            $authAdapter = new Apt_Auth_Adapter(
                $em,
                $form->getValue('username'),
                $form->getValue('password')
            );

            if($auth->authenticate($authAdapter)->isValid()) {

                $this->_helper->redirector->gotoSimple(
                    'index',
                    'index'
                );
                return;

            } else {

                $form->username->addError("Credentials invalid");

            }
        }

        $this->view->form = $form;

    }

}