<?php
use Doctrine\Common\Collections;

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(name="project")
 */
class Apt_Model_Project implements Zend_Acl_Resource_Interface
{
    /**
     * @var Apt_Model_User
     */
    protected $_currentUser = null;

    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @Column(type="string", length=50) */
    protected $name;

    /** @Column(type="integer") */
    protected $defaultVelocity;

    /** @Column(type="integer") */
    protected $sprintLength = 2;

    /** @ManyToOne(targetEntity="Apt_Model_User", cascade={"persist"})) */
    protected $productOwner;

    /**
     * @OneToMany(targetEntity="Apt_Model_Sprint", mappedBy="project", cascade={"persist", "remove"})
     * @OrderBy({"startDate"="ASC"})
     */
    protected $sprints;

    /**
     * @OneToOne(targetEntity="Apt_Model_Backlog", mappedBy="project", cascade={"persist", "remove"})
     * @JoinColumn(name="backlog_id", referencedColumnName="id")
     */
    protected $backlog;

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
        $this->sprints = new Collections\ArrayCollection();
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
     * Returns the string identifier of the Resource
     *
     * @return string
     */
    public function getResourceId()
    {
        return 'project::' . $this->id;
    }

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
     * Sets the product owner.
     *
     * @param Apt_Model_User $productOwner
     * @return Apt_Model_Project
     */
    public function setProductOwner(Apt_Model_User $_productOwner)
    {
        $this->productOwner = $_productOwner;
        return $this;
    }

    /**
     * Gets the product owner.
     *
     * return Apt_Model_User
     */
    public function getProductOwner()
    {
        return $this->productOwner;
    }

    /**
     * Gets stories
     */
    public function getSprints()
    {
        return $this->sprints;
    }

    /**
     * Adds a sprint to the project.
     *
     * @param Apt_Model_Sprint $_sprint
     * @return Apt_Model_Project
     */
    public function addSprint(Apt_Model_Sprint $_sprint)
    {
        $this->sprints->add($_sprint);
        return $this;
    }

    /**
     * Sets the project backlog.
     *
     * @param Apt_Model_Backlog $_backlog
     * @return Apt_Model_Project
     */
    public function setBacklog(Apt_Model_Backlog $_backlog)
    {
        $this->backlog = $_backlog;
        return $this;
    }

    /**
     * Gets the project backlog.
     *
     * @return Apt_Model_Backlog
     */
    public function getBacklog()
    {
        return $this->backlog;
    }

    /**
     * Sets the project name.
     *
     * @param string $_name
     * @return Apt_Model_Project
     */
    public function setName($_name)
    {
        $this->name = $_name;
        return $this;
    }

    /**
     * Gets the project name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Gets the sprint length.
     *
     * @return int
     */
    public function getSprintLength()
    {
        return $this->sprintLength;
    }

    /**
     * Sets the sprint length.
     *
     * @param int $_length
     * @return Apt_Model_Project
     */
    public function setSprintLength($_length)
    {
        $this->sprintLength = (int)$_length;
        return $this;
    }

    /**
     * Get the default velocity.
     *
     * @return int The velocity
     */
    public function getDefaultVelocity()
    {
        return $this->defaultVelocity;
    }

    /**
     * Set the default velocity
     *
     * @param int $velocity The velocity
     * @return Apt_Model_Project
     */
    public function setDefaultVelocity($velocity)
    {
        $this->defaultVelocity = $velocity;
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
