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
        $this->view->backlog = $this->_getBacklog($projectId);
    }

    /**
     * Returns the project backlog.
     *
     * @param   integer     $projectId      Id of current project.
     *
     * @return  array       $backlog        Backlog list with story-objects.
     */
    protected function _getBacklog($projectId)
    {
        $mockStory1 = new stdClass();
        $mockStory2 = new stdClass();

        $mockStory1->id                  = 1;
        $mockStory1->name                = 'Projekt Backlog anzeigen';
        $mockStory1->story               = 'Als Benutzer kann ich das Backlog eines Projekts sehen';
        $mockStory1->estimation          = null;
        $mockStory1->comment             = 'Kein Kommentar :)';
        $mockStory1->files               = array();
        $mockStory1->acceptanceCriteria = array();
        $mockStory1->status              = "Finished";

        $mockStory2->id                  = 2;
        $mockStory2->name                = 'Story PDF Export';
        $mockStory2->story               = 'Als Benutzer kann ich mir eine Auswahl an Stories aus dem Backlog als PDF '
                                         . ' exportieren um diese als Karten für die Pinwand auszudrucken';
        $mockStory2->estimation          = null;
        $mockStory2->comment             = '';
        $mockStory2->files               = array();
        $mockStory2->acceptanceCriteria = array('Alle Daten der Story sind auf der Karte vorhanden');
        $mockStory2->status              = "In progress";

        return array($mockStory1, $mockStory2);
    }
}

