<?php
/**
 * Definition of SprintController
 *
 * @category  AgilePlanningTool
 * @package   SprintController
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Sprint Controller.
 *
 * Shows the project sprints.
 *
 * @category  AgilePlanningTool
 * @package   SprintController
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class SprintController extends Zend_Controller_Action
{
    /**
     * Doctrine Entity Manager instance
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    public function init()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        $this->_em = $bootstrap->getResource('doctrine');
    }

    /**
     * Shows the project sprint list.
     */
    public function indexAction()
    {
        if (null === $this->_getParam('project', null)) {
            $this->_forward('index', 'project');
        }

        /* @var $nav Zend_Navigation */
        $nav = $this->getInvokeArg('bootstrap')->getResource('navigation');
        $nav->addPage(array(
            'label'        => 'Sprint List',
            'action'       => 'index',
            'controller'   => 'sprint',
            'module'       => 'default',
        ));

        $projectId = (int)$this->_getParam('project', 0);
        $project = $this->_em->find('Apt_Model_Project', $projectId);

        if (null === $project) {
            throw new Apt_Exception('Unknown project', 404);
        }

        $this->view->project = $project;
        $this->view->sprintList = $project->getSprints();
    }
}
