<?php

/**
 * @Entity
 * HasLifecycleCallbacks
 * @Table(name="story_comment")
 */
class Apt_Model_StoryComment
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

    /** @Column(type="text", name="comment") */
    protected $comment;

    /** @ManyToOne(targetEntity="Apt_Model_Story", inversedBy="comments") */
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
     * @return Apt_Model_StoryComment
     */
    public function setId($_id)
    {
        $this->id = $_id;
        return $this;
    }

    /**
     * Gets the comment content
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Sets the comment.
     *
     * @param $_comment
     * @return Apt_Model_Story fluent interface
     */
    public function setComment($_comment)
    {
        $this->comment = $_comment;
        return $this;
    }

    /**
     * Gets the story
     *
     * @return Apt_Model_Story
     */
    public function getStory()
    {
        return $this->story;
    }

    /**
     * Sets the story
     *
     * @param Apt_Model_Story $_story
     * @return Apt_Model_StoryComment
     */
    public function setStory(Apt_Model_Story $_story)
    {
        $this->story = $_story;
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
}
