<?php
/**
 * Definition of ProjectController
 *
 * @category  AgilePlanningTool
 * @package   ProjectController
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Project Controller.
 *
 * Shows the projects.
 *
 * @category  AgilePlanningTool
 * @package   ProjectController
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class ProjectController extends Zend_Controller_Action
{

    /**
     * Shows the users project list.
     */
    public function indexAction()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $em = $bootstrap->getResource('doctrine');
        $this->view->projectList = $em->getRepository('Apt_Model_Project')->findAll();
    }

}

