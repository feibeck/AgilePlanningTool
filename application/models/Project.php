<?php

/**
 * @Entity
 * @Table(name="project")
 */
class Apt_Model_Project implements Zend_Acl_Resource_Interface
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /** @Column(type="string") */
    public $name;

    /** @Column(type="integer") */
    public $defaultVelocity;

    /** @Column(type="integer") */
    public $sprintLength;

    /**
     * @ManyToOne(targetEntity="Apt_Model_User", cascade={"persist", "remove"}))
     */
    protected $productOwner;

    public function setProductOwner($productOwner)
    {
        $this->productOwner = $productOwner;
    }

    public function getProductOwner()
    {
        return $this->productOwner;
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
}