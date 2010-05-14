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

        $storyId = $this->_getParam('story', 0);
        $this->view->storyId = $storyId;

        $this->view->project = $this->_em->find('Apt_Model_Project', $projectId);
    }

    /**
     * Priorize stories
     *
     * @return void
     */
    public function priorizeAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $stories = $this->getRequest()->getPost('story');

        foreach ($stories AS $priority => $id) {
            $story = $this->_em->find('Apt_Model_Story', $id);
            $story->setPriority($priority + 1);
            $this->_em->persist($story);
        }

        $this->_em->flush();

        $this->_helper->json(true);
    }

}

