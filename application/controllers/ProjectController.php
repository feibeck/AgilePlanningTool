<?php
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

    public function init()
    {
        /* Initialize action controller here */
    }

    /**
     * Shows the users project list.
     */
    public function indexAction()
    {
        $this->view->projectList = $this->_getProjectList();
    }

    /**
     * Returns the list of allowed projects for a user.
     * 
     * @return  array   $projectList    List of user-projects.
     */
    protected function _getProjectList()
    {
        $mockProject = new stdClass();
        
        $mockProject->id   = 1;
        $mockProject->name = 'AgilePlanningTool';
        
        $projectList = array($mockProject);
        
        return $projectList;
    }
}

