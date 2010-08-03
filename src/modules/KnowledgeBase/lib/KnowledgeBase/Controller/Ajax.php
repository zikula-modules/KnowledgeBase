<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2009, Zikula Development Team
 * @link http://www.zikula.org
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_Generated_Modules
 * @subpackage KnowledgeBase
 * @author Axel Guckelsberger
 * @url https://guite.de
 */


class KnowledgeBase_Controller_Ajax extends Zikula_Controller
{
    public function _postSetup()
    {
        // override creation of view
    }

    /**
     * Even though we're handling objects for multiple tables, we only have one function for any use case.
     * The specific functionality for each object is encapsulated in the actual class implementation within the
     * module's classes directory while the handling code can remain identical for any number of entities.
     * This component-based approach allows you to have generic handler code which relies on the functionality
     * implemented in the object's class in order to achieve it's goals.
     */

    /**
     * This is a custom function. Documentation for this will be improved in later versions.
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     * /
     public function search($args)
     {
     // DEBUG: permission check aspect starts
     if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
     return LogUtil::registerPermissionError();
     }
     // DEBUG: permission check aspect ends

     // parameter specifying which type of objects we are treating
     $objectType = FormUtil::getPassedValue('ot', 'ticket', 'GET');

     if (!in_array($objectType, KnowledgeBase_getObjectTypes())) {
     $objectType = 'ticket';
     }
     //TODO: custom logic
     }
     */

    /**
     * This is a custom function. Documentation for this will be improved in later versions.
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function like($args)
    {
// DEBUG: permission check aspect starts
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
            return LogUtil::registerPermissionError();
        }
// DEBUG: permission check aspect ends

        $id = (int) FormUtil::getPassedValue('id', 0, 'POST');
        DBUtil::incrementObjectFieldByID('kbase_ticket', 'ratesup', $id, 'ticketid', 1);
        return true;
    }


    /**
     * This is a custom function. Documentation for this will be improved in later versions.
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function dislike($args)
    {
// DEBUG: permission check aspect starts
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
            return LogUtil::registerPermissionError();
        }
// DEBUG: permission check aspect ends

        $id = (int) FormUtil::getPassedValue('id', 0, 'POST');
        DBUtil::incrementObjectFieldByID('kbase_ticket', 'ratesdown', $id, 'ticketid', 1);
        return true;
    }

}