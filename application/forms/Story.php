<?php
/**
 * Definition of Apt_Form_Story
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Story editing form
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Apt_Form_Story extends Zend_Form
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
            'title',
            array('label' => 'Story name')
        );
        $this->addElement(
            'textarea',
            'description',
            array('label' => 'Story')
        );
        $this->addElement(
            'text',
            'estimation',
            array('label' => 'Estimation')
        );
        $this->addElement(
            'submit',
            'submit',
            array('label' => 'Save')
        );
    }

}