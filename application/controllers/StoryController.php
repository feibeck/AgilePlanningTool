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
        /* @var $project Apt_Model_Project */
        $project = $this->_em->find('Apt_Model_Project', (int)$this->_getParam('project', 0));
        $form = new Apt_Form_Story(array('method' => 'POST'));
        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->getPost())) {
            $currentUser = $this->_em->find(
                'Apt_Model_User',
                Zend_Auth::getInstance()->getIdentity()->getId()
            );

            $story = new Apt_Model_Story();
            $story->setTitle($form->getValue('title'))
                  ->setEstimatedPoints($form->getValue('estimation'))
                  ->setDescription($form->getValue('description'))
                  ->setState(Apt_Model_Story::STATE_NEW)
                  ->setCurrentUser($currentUser)
                  ->setContainer($project->getBacklog());

            $this->_em->persist($story);
            $this->_em->flush();

            $this->_helper->redirector->gotoSimple(
                'index',
                'backlog',
                null,
                array(
                    'project' => $project->getId(),
                    'story'   => $story->getId()
                )
            );

            return;
        }

        $this->view->form = $form;
    }

    public function addCommentAction()
    {
        $storyId = (int)$this->_getParam('story', 0);
        $form = new Apt_Form_Comment(array('method' => 'POST'));
        $request = $this->getRequest();

        if ($request->isPost() && $form->isValid($request->getPost())) {
            /* @var $currentUser Apt_Model_User */
            $currentUser = $this->_em->find(
                'Apt_Model_User',
                Zend_Auth::getInstance()->getIdentity()->getId()
            );

            /* @var $story Apt_Model_Story */
            $story = $this->_em->find('Apt_Model_Story', $storyId);


            /* @var $comment Apt_Model_StoryComment */
            $comment = new Apt_Model_StoryComment();
            $comment->setComment($form->getValue('comment'))
                    ->setCurrentUser($currentUser)
                    ->setStory($story);

            $this->_em->persist($comment);
            $this->_em->flush();

            $this->_helper->redirector->gotoSimple(
                'index',
                'backlog',
                null,
                array(
                    'project' => $story->getContainer()->getProject()->getId(),
                    'story'   => $story->getId(),
                )
            );

            return;
        }

        $this->view->form = $form;
    }

    public function pdfExportAction()
    {
        $this->_helper->layout->disableLayout();
        $this->getResponse()->setHeader('Content-Type', 'application/pdf');

        /* @var $project Apt_Model_Project */
        $project = $this->_em->find('Apt_Model_Project', (int)$this->_getParam('project', 0));

        $storyCards = new Apt_Pdf_Story(new Zend_Pdf());
        $storyCards->setStories($project->getBacklog()->getStories());
        $this->view->pdf = $storyCards->render();
    }
}
