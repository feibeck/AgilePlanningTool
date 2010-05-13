<?php

/**
 * @Entity
 * @Table(name="user")
 */
class Apt_Model_User
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

    /** @Column(type="string") */
    public $name;

    /** @Column(type="string") */
    public $username;

    /** @Column(type="string") */
    public $password;


}