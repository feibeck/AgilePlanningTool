<?php

/**
 * @Entity
 * @Table(name="story_comment")
 */
class Apt_Model_StoryComment
{
    /**
     * @Id @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @Column(type="text", name="comment") */
    private $comment;

    /**
     * @ManyToOne(targetEntity="Apt_Model_Story", inversedBy="comments")
     */
    private $story;

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
}
