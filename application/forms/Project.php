<?php
/**
 * Definition of Apt_Form_Project
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Project editing form
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Apt_Form_Project extends Zend_Form
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
            'name',
            array('label' => 'Project name')
        );
        $this->addElement(
            'text',
            'length',
            array('label' => 'Sprint length (Weeks)')
        );
        $this->addElement(
            'text',
            'velocity',
            array('label' => 'Default sprint velocity')
        );
        $this->addElement(
            'submit',
            'submit',
            array('label' => 'Save')
        );
    }

}