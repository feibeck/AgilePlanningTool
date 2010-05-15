<?php
use Doctrine\Common\Collections;

/**
 * @Entity
 * @Table(name="backlog")
 */
class Apt_Model_Backlog extends Apt_Model_StoryContainer
{
    /**
     * @OneToOne(targetEntity="Apt_Model_Project", inversedBy="backlog", cascade={"persist", "remove"})
     * @JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * Contructor
     */
    public function __construct()
    {
        $this->stories = new Collections\ArrayCollection();
    }

    /**
     * Sets the project
     *
     * @param Apt_Model_Project $_project
     * @return Apt_Model_Backlog
     */
    public function setProject(Apt_Model_Project $_project)
    {
        $this->project = $_project;
        return $this;
    }

    /**
     * Gets the associated project
     *
     * @return Apt_Model_Project
     */
    public function getProject()
    {
        return $this->project;
    }
}
