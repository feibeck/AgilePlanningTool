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
    protected $id;

    /**
     * @Column(type="string")
     */
    protected $name;

    /**
     * @Column(type="string")
     */
    protected $email;

    /**
     * @Column(type="string")
     */
    protected $username;

    /**
     * @Column(type="string")
     */
    protected $password;

    /**
     * Set the id
     *
     * @param int $id The id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the id
     *
     * @return int The id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the email
     *
     * @param string $email The email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get the email
     *
     * @return string The email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the name
     *
     * @param string $name The name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the name
     *
     * @return string The name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the username
     *
     * @param string $username The username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Get the username
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the password
     *
     * @param string $password The Password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get the password
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

}