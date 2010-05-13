<?php
/**
 * Apt
 *
 * @category  AgilePlanningTool
 * @package   Apt_Exception
 * @author    Marco Arnold <marco.arnold@mayflower.de>
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * UnexpectedValue exception
 *
 * @category  AgilePlanningTool
 * @package   Apt_Exception
 */
class Apt_Exception_UnexpectedValue extends Apt_Exception
{
    public function __construct($_message, $_code = 505)
    {
        parent::__construct($_message, $_code);
    }
}
