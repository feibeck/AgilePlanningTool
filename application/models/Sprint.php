<?php
use Doctrine\Common\Collections;

/**
 * @Entity
 * @Table(name="sprint")
 */
class Apt_Model_Sprint extends Apt_Model_StoryContainer
{
    /**
     * @ManyToOne(targetEntity="Apt_Model_Project", cascade={"persist"}))
     */
    protected $project;

    /** @Column(type="date", nullable=true) */
    protected $startDate;

    /** @Column(type="date", nullable=true) */
    protected $endDate;

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
     * @return Apt_Model_Sprint
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

    /**
     * Sets the sprint start date.
     *
     * @param DateTime $_startDate
     * @return Apt_Model_Sprint
     */
    public function setStartDate(DateTime $_startDate)
    {
        $this->startDate = $_startDate;
        return $this;
    }

    /**
     * Gets the sprint start date.
     *
     * @return DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Sets the sprint end date.
     *
     * @param DateTime $_endDate
     * @return Apt_Model_Sprint
     */
    public function setEndDate(DateTime $_endDate)
    {
        $this->endDate = $_endDate;
        return $this;
    }

    /**
     * Gets the sprint end date.
     *
     * @return DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}
