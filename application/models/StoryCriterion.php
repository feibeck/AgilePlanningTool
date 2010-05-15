<?php

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(name="story_criterion")
 */
class Apt_Model_StoryCriterion
{
    /**
     * @var Apt_Model_User
     */
    protected $_currentUser = null;

    /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @Column(type="text") */
    protected $criterion;

    /** @Column(type="boolean") */
    protected $isAccepted;

    /** @ManyToOne(targetEntity="Apt_Model_Story", inversedBy="criteria") */
    protected $story;

    /** @Column(type="datetime") */
    protected $createdOn;

    /** @ManyToOne(targetEntity="Apt_Model_User", cascade={"persist"})) */
    protected $createdBy;

    /** @Column(type="datetime", nullable=true) */
    protected $changedOn;

    /** @ManyToOne(targetEntity="Apt_Model_User", cascade={"persist"})) */
    protected $changedBy;

    /**
     * Gets the id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the id
     *
     * @param integer $_id
     * @return Apt_Model_StoryCriterion
     */
    public function setId($_id)
    {
        $this->id = $_id;
        return $this;
    }

    /**
     * Gets the criterion content
     *
     * @return string
     */
    public function getCriterion()
    {
        return $this->criterion;
    }

    /**
     * Sets the criterion.
     *
     * @param $_criterion
     * @return Apt_Model_StoryCriterion fluent interface
     */
    public function setCriterion($_criterion)
    {
        $this->criterion = $_criterion;
        return $this;
    }

    /**
     * Gets the associated story
     *
     * @return Apt_Model_Story
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Sets the associated story
     *
     * @param Apt_Model_Story $_story
     * @return Apt_Model_StoryCriterion
     */
    public function setStory(Apt_Model_Story $_story)
    {
        $this->story = $_story;
    }

    /**
     * Sets the isAccepted flag
     *
     * @param bool $_isAccepted
     * @return Apt_Model_StoryCriterion
     */
    public function setIsAccepted($_isAccepted = false)
    {
        $this->isAccepted = (bool)$_isAccepted;
        return $this;
    }

    /**
     * Gets the isAccepted flag
     *
     * @return boolean
     */
    public function getIsAccepted()
    {
        return $this->isAccepted;
    }

    /**
     * @return the $createdOn
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return the $createdBy
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return the $changedOn
     */
    public function getChangedOn()
    {
        return $this->changedOn;
    }

    /**
     * @return the $changedBy
     */
    public function getChangedBy()
    {
        return $this->changedBy;
    }

    /**
     * @PreUpdate
     */
    public function beforeUpdate()
    {
        $this->changedOn = new DateTime("now");
        $this->changedBy = $this->_currentUser;
    }

    /**
     * @PrePersist
     */
    public function beforePersist()
    {
        $this->createdOn = new DateTime("now");
        $this->createdBy = $this->_currentUser;
    }

    /**
     * Sets the current user
     *
     * @param Apt_Model_User $_user
     * @return Apt_Model_Story
     */
    public function setCurrentUser(Apt_Model_User $_user)
    {
        $this->_currentUser = $_user;
        return $this;
    }
}
