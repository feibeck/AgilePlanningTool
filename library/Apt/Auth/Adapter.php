<?php
/**
 * Definition of Apt_Auth_Adapter
 *
 * @category   AgilePlanningTool
 * @package    Apt_Auth
 * @subpackage Apt_Auth_Adapter
 * @author     Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright  2010 Mayflower GmbH
 * @license    New BSD License
 */

/**
 * Authentication adapter accessing the user backend
 *
 * @category   AgilePlanningTool
 * @package    Apt_Auth
 * @subpackage Apt_Auth_Adapter
 * @author     Florian Eibeck <florian.eibeck@mayflower.de>
 * @copyright  2010 Mayflower GmbH
 * @license    New BSD License
 */
class Apt_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    /**
     * Username
     *
     * @var string
     */
    protected $_username;

    /**
     * Password
     *
     * @var string
     */
    protected $_password;

    /**
     * Doctrine Entity Manager instance
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;

    /**
     * Setting parameters for the login
     *
     * @param \Doctrine\ORM\EntityManager $em       Doctrine Entity Manager instance
     * @param string                      $username The username
     * @param string                      $password The password
     */
    public function __construct($em, $username, $password) {
        $this->_em = $em;
        $this->_username = $username;
        $this->_password = $password;
    }

    /**
     * Do the login
     *
     * @return Zend_Auth_Result Authentication result
     */
    public function authenticate() {
        try {

            $user = $this->_em->getRepository('Apt_Model_User')
                ->findOneBy(array('username' => $this->_username));

            if (!$user) {
                return new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND,
                    null
                );
            }

            if ($user->password != $this->_password) {
                return new Zend_Auth_Result(
                    Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID,
                    null
                );
            }

        } catch (Exception $e) {
            return new Zend_Auth_Result(
                Zend_Auth_Result::FAILURE,
                null
            );
        }

        return new Zend_Auth_Result(
            Zend_Auth_Result::SUCCESS,
            $user
        );
    }

}