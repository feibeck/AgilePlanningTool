<?php
/**
 * Acl
 *
 * @category  AgilePlanningTool
 * @package   Apt_Acl
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * Acl
 *
 * @category  AgilePlanningTool
 * @package   Apt_Acl
 * @author    Tobias Schlüter <tobias.schlueter@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
 class Apt_Acl extends Zend_Acl
 {
     /**
      * Setup Acl.
      */
     public function __construct()
     {
         $this->_initRoles();
         $this->_initResources();
         $this->_initPermissions();
     }

     /**
      * Initialize roles.
      */
     protected function _initRoles()
     {
         $this->addRole(new Zend_Acl_Role('guest'));
         $this->addRole(new Zend_Acl_Role('user'), 'guest');
         $this->addRole(new Zend_Acl_Role('productowner'), 'user');
     }

     /**
      * Initialize resources.
      */
     protected function _initResources()
     {
         $this->add(new Zend_Acl_Resource('project'));
         $this->add(new Zend_Acl_Resource('backlog'));
     }

     /**
      * Initialize permissions.
      */
     protected function _initPermissions()
     {
         // guest
         $this->deny('guest', 'project', 'view');
         $this->deny('guest', 'project', 'edit');
         $this->deny('guest', 'backlog', 'view');
         $this->deny('guest', 'backlog', 'edit');

         // user
         $this->allow('user', 'project', 'view');
         $this->allow('user', 'backlog', 'view');

         // productowner
         $this->allow('productowner', 'project', 'edit');
         $this->allow('productowner', 'backlog', 'edit');
     }
 }