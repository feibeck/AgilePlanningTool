<?php
/**
 * Definition of Apt_Form_Criterion
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Editing a criterion
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Apt_Form_Criterion extends Zend_Form
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
            'criterion',
            array('label' => 'Acceptance criterion')
        );
        $this->addElement(
            'submit',
            'submit',
            array('label' => 'Save')
        );
    }

}