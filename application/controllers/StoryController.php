<?php
/**
 * Definition of StoryController
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Story Controller.
 *
 * Shows the projects.
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class StoryController extends Zend_Controller_Action
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
     * Add a story
     *
     * @return void
     */
    public function addAction()
    {
        $projectId = (int)$this->_getParam('project', 0);

        $form = new Apt_Form_Story(array('method' => 'POST'));

        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->getPost())) {

            $story = new Apt_Model_Story();
            $story->setTitle($form->getValue('title'));
            $story->setEstimatedPoints($form->getValue('estimation'));
            $story->setDescription($form->getValue('description'));
            $story->setState(Apt_Model_Story::STATE_NEW);

            $user = $this->_em->find(
                'Apt_Model_User',
                Zend_Auth::getInstance()->getIdentity()->getId()
            );
            $story->setCurrentUser($user);

            $project = $this->_em->find(
                'Apt_Model_Project',
                $projectId
            );
            $story->setProject($project);

            $this->_em->persist($story);
            $this->_em->flush();

            $this->_helper->redirector->gotoSimple('index', 'backlog');

        }

        $this->view->form = $form;
    }

}