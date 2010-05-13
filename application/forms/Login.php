<?php
/**
 * Definition of Apt_Form_Login
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Login form
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Apt_Form_Login extends Zend_Form
{

    /**
     * Form initialisation
     *
     * @return void
     */
    public function init()
    {
        $this->addElement(
            'text',
            'username',
            array('label' => 'Username')
        );
        $this->addElement(
            'password',
            'password',
            array('label' => 'Password')
        );
        $this->addElement(
            'submit',
            'submit',
            array('label' => 'Login')
        );
    }

}