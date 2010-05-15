<?php
/**
 * Definition of IndexController
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Homepage controller
 *
 * @category  AgilePlanningTool
 * @package   Default
 * @author    Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class IndexController extends Zend_Controller_Action
{

    /**
     * Show the homepage
     *
     * @return void
     */
    public function indexAction()
    {
        $this->view->name = Zend_Auth::getInstance()->getIdentity()->getName();
    }

    public function testAction()
    {
        $backlog = new Apt_Model_Backlog();
        $backlog->setTitle('Backlog')
                ->setDescription('Das ist das Backlog');

        $sprint15 = new Apt_Model_Sprint();
        $sprint15->setTitle('Sprint 15')
                 ->setDescription('Das ist Sprint 15')
                 ->setStartDate(new DateTime('2010-05-01'))
                 ->setEndDate(new DateTime('2010-05-15'));

        $sprint16 = new Apt_Model_Sprint();
        $sprint16->setTitle('Sprint 16')
                ->setDescription('Das ist Sprint 16')
                ->setStartDate(new DateTime('2010-05-16'))
                ->setEndDate(new DateTime('2010-05-30'));

        $project = new Apt_Model_Project();
        $project->setName('TestProj')
                ->setBacklog($backlog)
                ->addSprint($sprint15)
                ->addSprint($sprint16)
                ->setDefaultVelocity(60);

        $em = Zend_Registry::get('entitymanager');
        $em->persist($project);

        $story1 = new Apt_Model_Story();
        $story1->setTitle('Admin')
               ->setDescription('Das ist Story1')
               ->setEstimatedPoints(5)
               ->setContainer($sprint15);

        $story2 = new Apt_Model_Story();
        $story2->setTitle('Frontend')
               ->setDescription('Das ist Story2')
               ->setEstimatedPoints(2)
               ->setContainer($sprint15);

        $story3 = new Apt_Model_Story();
        $story3->setTitle('TBD')
               ->setDescription('Das ist Story3')
               ->setEstimatedPoints(8)
               ->setContainer($backlog);

        $em->persist($story1);
        $em->persist($story2);
        $em->persist($story3);

        $em->flush();
        exit();
    }
}
