<?php
/**
 * Definition of Apt_Form_Comment
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Editing a comment
 *
 * @category  AgilePlanningTool
 * @package   Apt_Form
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Apt_Form_Comment extends Zend_Form
{

    /**
     * Form initialisation
     *
     * @return void
     */
    public function init()
    {
        $this->addElement(
            'textarea',
            'comment',
            array('label' => 'Your comment')
        );
        $this->addElement(
            'submit',
            'submit',
            array('label' => 'Save')
        );
    }

}