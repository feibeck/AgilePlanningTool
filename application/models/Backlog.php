<?php

/**
 * @Entity
 * @Table(name="backlog")
 */
class Apt_Model_Backlog extends Apt_Model_StoryContainer
{
    /** @ManyToOne(targetEntity="Apt_Model_Project", cascade={"persist"})) */
    protected $project;

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
