<?php
use Doctrine\Common\Collections;

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(name="story_container")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="containerType", type="string")
 * @DiscriminatorMap({"sprint" = "Apt_Model_Sprint", "backlog" = "Apt_Model_Backlog"})
 */
class Apt_Model_StoryContainer
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

    /** @Column(type="string", length=100) */
    protected $title;

    /** @Column(type="string", nullable=true) */
    protected $description;

    /**
     * @OneToMany(targetEntity="Apt_Model_Story", mappedBy="container", cascade={"persist", "remove"})
     * @OrderBy({"priority"="ASC"})
     */
    protected $stories;

    /** @Column(type="datetime") */
    protected $createdOn;

    /** @ManyToOne(targetEntity="Apt_Model_User", cascade={"persist"})) */
    protected $createdBy;

    /** @Column(type="datetime", nullable=true) */
    protected $changedOn;

    /** @ManyToOne(targetEntity="Apt_Model_User", cascade={"persist"})) */
    protected $changedBy;

    /**
     * Contructor
     */
    public function __construct()
    {
        $this->stories = new Collections\ArrayCollection();
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
     * @return Apt_Model_StoryContainer
     */
    public function setCurrentUser(Apt_Model_User $_user)
    {
        $this->_currentUser = $_user;
        return $this;
    }

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the story title.
     *
     * @param $_title
     * @return Apt_Model_StoryContainer fluent interface
     */
    public function setTitle($_title)
    {
        $this->title = $_title;
        return $this;
    }

    /**
     * Gets the title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Sets the story description.
     *
     * @param $_description
     * @return Apt_Model_StoryContainer fluent interface
     */
    public function setDescription($_description)
    {
        $this->description = $_description;
        return $this;
    }

    /**
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Gets the stories
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getStories()
    {
        return $this->stories;
    }

    /**
     * Adds a criteria
     *
     * @param Apt_Model_Story $_story
     * @return Apt_Model_StoryContainer
     */
    public function addStory(Apt_Model_Story $_story)
    {
        $this->stories->add($_story);
        return $this;
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
}
