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

/*
 * generated at Thu Apr 08 22:42:13 CEST 2010 by ModuleStudio 0.4.10 (http://modulestudio.de)
 */


/**
 * Even though we're handling objects for multiple tables, we only have one function for any use case.
 * The specific functionality for each object is encapsulated in the actual class implementation within the
 * module's classes directory while the handling code can remain identical for any number of entities.
 * This component-based approach allows you to have generic handler code which relies on the functionality
 * implemented in the object's class in order to achieve it's goals.
 */

// preload common used classes
Loader::requireOnce('modules/KnowledgeBase/common.php');


/**
 * This is a custom function. Documentation for this will be improved in later versions.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @return       Render output
 * /
function KnowledgeBase_ajax_search($args)
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
function KnowledgeBase_ajax_like($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }
// DEBUG: permission check aspect ends

    // parameter specifying which type of objects we are treating
    $objectType = 'ticket';

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
function KnowledgeBase_ajax_dislike($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }
// DEBUG: permission check aspect ends

    // parameter specifying which type of objects we are treating
    $objectType = 'ticket';

    $id = (int) FormUtil::getPassedValue('id', 0, 'POST');
    DBUtil::incrementObjectFieldByID('kbase_ticket', 'ratesdown', $id, 'ticketid', 1);
    return true;
}

