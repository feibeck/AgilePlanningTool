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

            $this->_helper->redirector->gotoSimple(
                'index',
                'backlog',
                null,
                array(
                    'project' => $projectId,
                    'story' => $story->getId()
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

            $comment = new Apt_Model_StoryComment();
            $comment->setComment($form->getValue('comment'));

            $user = $this->_em->find(
                'Apt_Model_User',
                Zend_Auth::getInstance()->getIdentity()->getId()
            );
            $comment->setCurrentUser($user);

            $story = $this->_em->find(
                'Apt_Model_Story',
                $storyId
            );
            $comment->setStory($story);

            $this->_em->persist($comment);
            $this->_em->flush();

            $this->_helper->redirector->gotoSimple(
                'index',
                'backlog',
                null,
                array(
                    'project' => $story->getProject()->getId(),
                    'story'   => $story->getId()
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

        $projectId = (int) $this->_getParam('project', 0);
        $storyId   = (int) $this->_getParam('story', 0);

        $storyCards = new Apt_Pdf_Story(new Zend_Pdf());
        
        
        if (!empty($storyId)) {
            $story = $this->_em->find(
                'Apt_Model_Story',
                $storyId
            );
            
            if ($projectId == $story->getProject()->getId()) {
                $storyCards->addStory($story);
            }
            
        } else {
            $project = $this->_em->find(
                'Apt_Model_Project',
                $projectId
            );
            $storyCards->setStories($project->getStories());
        }
        
        $this->view->pdf = $storyCards->render();
    }
}
