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

            $project = new Apt_Model_Project();
            $project->name = $form->getValue('name');
            $project->sprintLength = $form->getValue('length');
            $project->defaultVelocity  = $form->getValue('velocity');

            $this->_em->persist($project);
            $this->_em->flush();

            $this->_helper->redirector->gotoSimple('index');

        }

        $this->view->form = $form;
    }
}

