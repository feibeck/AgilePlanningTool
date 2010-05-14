<?php
use Doctrine\Common\Collections;

/**
 * @Entity
 * @HasLifecycleCallbacks
 * @Table(name="story", indexes={@index(name="search_idx", columns={"priority", "title"})})
 */
class Apt_Model_Story
{
    const STATE_NEW = 'new';
    const STATE_READY = 'ready';
    const STATE_DONE = 'done';
    const STATE_ACCEPTED = 'accepted';
    const STATE_REJECTED = 'rejected';

    /**
     * Story states
     *
     * @var array
     */
    protected static $states = array(
        self::STATE_NEW,
        self::STATE_READY,
        self::STATE_DONE,
        self::STATE_ACCEPTED,
        self::STATE_REJECTED,
    );

    /**
     * @var Apt_Model_User
     */
    protected $_currentUser = null;

    /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ManyToOne(targetEntity="Apt_Model_Project", cascade={"persist"})) */
    protected $project;

    /** @Column(type="string", length=100) */
    protected $title;

    /** @Column(type="text") */
    protected $description;

    /** @Column(type="smallint", nullable=true) */
    protected $estimatedPoints;

    /** @Column(type="string", length=15) */
    protected $state = self::STATE_NEW;

    /** @Column(type="integer", nullable=true) */
    protected $priority = null;

    /**
     * @OneToMany(targetEntity="Apt_Model_StoryComment", mappedBy="story", cascade={"persist", "remove"})
     * @OrderBy({"createdOn"="ASC"})
     */
    protected $comments;

    /**
     * @OneToMany(targetEntity="Apt_Model_StoryCriterion", mappedBy="story", cascade={"persist", "remove"})
     * @OrderBy({"createdOn"="ASC"})
     */
    protected $criteria;

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
        $this->comments = new Collections\ArrayCollection();
        $this->criterias = new Collections\ArrayCollection();
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
     * Sets the story title.
     *
     * @param $_title
     * @return Apt_Model_Story fluent interface
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
     * @return Apt_Model_Story fluent interface
     */
    public function setDescription($_description)
    {
        $this->description = $_description;
        return $this;
    }

    /**
     * Sets the estimated story points.
     *
     * @param integer $_estimatedPoints
     * @return Apt_Model_Story
     * @throws Apt_Exception_InvalidArgument if invalid input
     */
    public function setEstimatedPoints($_estimatedPoints)
    {
        if (null !== $_estimatedPoints && false === $this->_isFibonacci($_estimatedPoints)) {
            throw new Apt_Exception_InvalidArgument('Invalid estimated points given.');
        }

        $this->estimatedPoints = $_estimatedPoints;
        return $this;
    }
    
    /**
     * Checks a number whether it is a Fibonacci number.
     * 
     * @param integer $givenValue Given value to check.
     * 
     * @return boolean
     */
    protected function _isFibonacci($givenValue)
    {
        $givenValue = (int) $givenValue;
        $loopLimit  = 20;
        
        $current    = 0;
        $next       = 1;
        
        for ($i = 0; $i < $loopLimit; $i++){
            if ($givenValue == $current) {
                return true;
                
            } else {
                $sum     = $current + $next;
                $current = $next;
                $next    = $sum;
            }
        }
        
        return false;
    }

    /**
     * Sets the state.
     *
     * @param string $_state
     * @return Apt_Model_Story fluent interface
     * @throws Apt_Exception_InvalidArgument if invalid input
     */
    public function setState($_state)
    {
        if (!in_array($_state, self::$states)) {
            throw new Apt_Exception_InvalidArgument('Invalid state given.');
        }

        $this->state = $_state;
        return $this;
    }

    /**
     * Gets the story criteria
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * Adds a criterion
     *
     * @param Apt_Model_StoryCriteria $_criteria
     * @return Apt_Model_Story
     */
    public function addCriterion(Apt_Model_StoryCriterion $_criterion)
    {
        $this->criteria->add($_criterion);
        return $this;
    }

    /**
     * Gets the story comments
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Check if the story has any comments
     *
     * @return boolean True if the story has comments, false otherwise
     */
    public function hasComments()
    {
        return count($this->getComments()) > 0;
    }

    /**
     * Adds a comment
     *
     * @param Apt_Model_StoryComment $_comment
     * @return Apt_Model_Story
     */
    public function addComment(Apt_Model_StoryComment $_comment)
    {
        $this->comments->add($_comment);
        return $this;
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

    /**
     * @return the $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return the $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return the $estimatedPoints
     */
    public function getEstimatedPoints()
    {
        return $this->estimatedPoints;
    }

    /**
     * @return the $state
     */
    public function getState()
    {
        return $this->state;
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
     * Sets the project
     *
     * @param Apt_Model_Project $_project
     * @return Apt_Model_Story
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
     * Sets the priority
     *
     * @param integer $_priority
     * @return Apt_Model_Story
     */
    public function setPriority($_priority)
    {
        $this->priority = (int)$_priority;
        return $this;
    }

    /**
     * Gets the priority
     *
     * @return integer
     */
    public function getPriority()
    {
        return $this->priority;
    }
    
    /**
     * Returns an absolute Url to the story.
     * 
     * @return string $url
     */
    public function getAbsoluteUrl()
    {
        $urlHelper   = Zend_Controller_Action_HelperBroker::getStaticHelper('Url');
        $request     = Zend_Controller_Front::getInstance()->getRequest();
        $absoluteUrl = $request->getScheme() . '://' . $request->getHttpHost();
        
        $urlParams   = array(
            'story'      => $this->id,
            'project' => $this->project->getId()
        );
        
        return $absoluteUrl . $urlHelper->simple('index', 'story', null, $urlParams);
    }
}
