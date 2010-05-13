<?php
/**
 * Backlog Controller.
 *
 * Shows the backlog for a given project.
 *
 * @category  AgilePlanningTool
 * @package   BacklogController
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Backlog Controller.
 *
 * Shows the backlog for a given project.
 *
 * @category  AgilePlanningTool
 * @package   BacklogController
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class BacklogController extends Zend_Controller_Action
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
     * Shows the project backlog.
     */
    public function indexAction()
    {
        if ('' === $this->_getParam('project', '')) {
            $this->_forward('index', 'project');
        }

        $projectId = $this->_getParam('project');

        $this->view->project = $this->_em->find('Apt_Model_Project', $projectId);
    }

}

