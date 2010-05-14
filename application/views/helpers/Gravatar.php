<?php
/**
 * Definition of Zend_View_Helper_Gravatar
 *
 * @category  AgilePlanningTool
 * @package   View_Helper
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */

/**
 * View helper for displaying a gravatar image
 *
 * @category  AgilePlanningTool
 * @package   View_Helper
 * @copyright 2010 Mayflower GmbH
 * @license   New BSD License
 */
class Zend_View_Helper_Gravatar extends Zend_View_Helper_Abstract
{

    /**
     * Display gravatar image
     *
     * @param string $emailAddress E-Mail adress of the user
     * @param string $size         Size of the icon
     */
    public function gravatar($emailAddress, $size = "40")
    {
        $gravatarId = md5(strtolower(trim($emailAddress)));

        $url = "http://www.gravatar.com/avatar/"
             . $gravatarId
             . "?d=identicon"
             . "&s=" . $size;

        return '<img class="gravatar" src="' . $url . '" alt=""/>';
    }

}