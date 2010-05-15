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
     * Shows the users project list.
     */
    public function indexAction()
    {
        $this->view->projectList = $this->_em->getRepository('Apt_Model_Project')->findAll();
    }

    /**
     * Add a new Project
     */
    public function addAction()
    {
        $form = new Apt_Form_Project(array('method' => 'POST'));

        $request = $this->getRequest();
        if ($request->isPost() && $form->isValid($request->getPost())) {

            $currentUser = $this->_em->find(
                'Apt_Model_User',
                Zend_Auth::getInstance()->getIdentity()->getId()
            );
            $projectName = $form->getValue('name');

            $backlog = new Apt_Model_Backlog();
            $backlog->setTitle($projectName . ' Backlog')
                    ->setCurrentUser($currentUser);

            $project = new Apt_Model_Project();
            $project->setBacklog($backlog)
                    ->setName($projectName)
                    ->setSprintLength($form->getValue('length'))
                    ->setDefaultVelocity($form->getValue('velocity'))
                    ->setProductOwner($currentUser)
                    ->setCurrentUser($currentUser);

            $this->_em->persist($project);

            $backlog->setProject($project);
            $this->_em->persist($backlog);

            $this->_em->flush();

            $this->_helper->redirector->gotoSimple('index');
            return;
        }

        $this->view->form = $form;
    }
}

