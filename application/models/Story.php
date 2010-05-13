<?php

/**
 * @Entity
 * @Table(name="story")
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
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $_id;

    /** @Column(type="string", length=100, name="title") */
    private $_title;

    /** @Column(type="text", name="description") */
    private $_description;

    /** @Column(type="smallint", nullable=true, name="estimated") */
    private $_estimatedPoints;

    /** @Column(type="string", length=15, name="state") */
    private $_state;

    /**
     * @OneToMany(targetEntity="Apt_Model_StoryComment", mappedBy="story", cascade={"persist", "remove"})
     */
    private $comments;

    /**
     * Sets the story title.
     *
     * @param $_title
     * @return Apt_Model_Story fluent interface
     */
    public function setTitle($_title)
    {
        $this->_title = $_title;
        return $this;
    }

    /**
     * Sets the story description.
     *
     * @param $_description
     * @return Apt_Model_Story fluent interface
     */
    public function setDescription($_description)
    {
        $this->_description = $_description;
        return $this;
    }

    /**
     * Sets the estimated story points.
     *
     * @param integer $_estimatedPoints
     * @return Apt_Model_Story
     */
    public function setEstimatedPoints($_estimatedPoints)
    {
        $_estimatedPoints;
        if (null !== $_estimatedPoints
                && !in_array((int)$_estimatedPoints, array(0, 1, 2, 3, 5, 8, 13))) {
            throw new Apt_Exception_InvalidArgument('Invalid estimated points given.');
        }

        return $this;
    }

    /**
     * @param unknown_type $_state
     * @return Apt_Model_Story fluent interface
     */
    public function setState($_state)
    {
        if (!in_array($_state, self::$states)) {
            throw new Apt_Exception_InvalidArgument('Invalid state given.');
        }

        $this->_state = $_state;
        return $this;
    }

    /**
     * Adds a comment
     *
     * @param Apt_Model_StoryComment $_comment
     * @return Apt_Model_Story fluent interface
     */
    public function addComment(Apt_Model_StoryComment $_comment)
    {
        $this->comments[] = $_comment;
        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

}
