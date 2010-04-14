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
 * This function is the default function, and is called whenever the
 * module's User area is called without defining arguments.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @return       Render output
 */
function KnowledgeBase_user_main($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }
// DEBUG: permission check aspect ends

    // get pnRender instance for this module
    $render = pnRender::getInstance('KnowledgeBase', false);

    $render->assign('categories', pnModAPIFunc('KnowledgeBase', 'user', 'getCategories', array('full' => false)));

    // fetch and return the appropriate template
    return KnowledgeBase_processRenderTemplate($render, 'user', '', 'main', $args);
}

/**
 * This function provides a generic item list overview.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @param        sort           string    sorting field
 * @param        sdir           string    sorting direction
 * @param        pos            int       current pager position
 * @param        tpl            string    name of alternative template (for alternative display options, feeds and xml output)
 * @param        raw            boolean   optional way to display a template instead of fetching it (needed for standalone output)
 * @return       Render output
 */
function KnowledgeBase_user_view($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }
// DEBUG: permission check aspect ends

    $objectType = 'ticket';

    list($objectData, $objcount) = pnModAPIFunc('KnowledgeBase', 'user', 'getTickets', array());

    // parameter for used sorting field
    $sort = FormUtil::getPassedValue('sort', '', 'GET');

    // parameter for used sort order
    $sdir = FormUtil::getPassedValue('sdir', '', 'GET');
    if ($sdir != 'asc' && $sdir != 'desc') $sdir = 'asc';

    // pagesize is the number of items displayed on a page for pagination
    $pagesize = (int) ((isset($args['amount']) ? $args['amount'] : 100));//pnModGetVar('KnowledgeBase', 'pagesize', 10);

    // get pnRender instance for this module
    $render = pnRender::getInstance('KnowledgeBase', false);

    // assign the object-array we loaded above
    $render->assign('objectArray', $objectData);

    // assign current sorting information
    $render->assign('sort', $sort);
    $render->assign('sdir', ($sdir == 'asc') ? 'desc' : 'asc'); // reverted for links

    // assign the information required to create the pager
    $render->assign('pager', array('numitems'     => $objcount,
                                   'itemsperpage' => $pagesize));

    // fetch and return the appropriate template
    return KnowledgeBase_processRenderTemplate($render, 'user', $objectType, 'view', $args);
}

/**
 * This function provides a generic item detail view.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @param        tpl            string    name of alternative template (for alternative display options, feeds and xml output)
 * @param        raw            boolean   optional way to display a template instead of fetching it (needed for standalone output)
 * @return       Render output
 */
function KnowledgeBase_user_display($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ)) {
        return LogUtil::registerPermissionError();
    }
// DEBUG: permission check aspect ends

    $objectType = 'ticket';

    // retrieve the ID of the object we wish to view
    $id = (int) FormUtil::getPassedValue('id', 0, 'GET');
    if (!$id) {
        pn_exit('Invalid ' . $idField . ' [' . DataUtil::formatForDisplay($id) . '] received ...');
    }

    $objectData = pnModAPIFunc('KnowledgeBase', 'user', 'getTicket', array('id' => $id));

    // get pnRender instance for this module
    $render = pnRender::getInstance('KnowledgeBase', false);

    // assign the object we loaded above.
    // since the same code is used the handle the entry of the new object,
    // we need to check wether we have a valid object.
    // If not, we just pass in an empty data-array.
    $render->assign($objectType, $objectData);

    // fetch and return the appropriate template
    return KnowledgeBase_processRenderTemplate($render, 'user', $objectType, 'display', $args);
}

/**
 * This function provides a generic handling of all edit requests.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @param        tpl            string    name of alternative template (for alternative display options, feeds and xml output)
 * @param        raw            boolean   optional way to display a template instead of fetching it (needed for standalone output)
 * @return       Render output
 */
function KnowledgeBase_user_edit($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_EDIT)) {
        return LogUtil::registerPermissionError();
    }
// DEBUG: permission check aspect ends

    // parameter specifying which type of objects we are treating
    $objectType = 'ticket';

    // create new pnForm reference
    $render = FormUtil::newpnForm('KnowledgeBase');

    // include event handler class
    Loader::requireOnce('modules/KnowledgeBase/classes/FormHandler/KnowledgeBase_user_' . $objectType . '_edithandler.class.php');

    // build form handler class name
    $handlerClass = 'KnowledgeBase_user_' . $objectType . '_editHandler';

    // Execute form using supplied template and page event handler
    return $render->pnFormExecute('KnowledgeBase_user_' . $objectType . '_edit.htm', new $handlerClass());
}

/**
 * This is a custom function. Documentation for this will be improved in later versions.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @return       Render output
 */
function KnowledgeBase_user_assign($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
        return LogUtil::registerPermissionError();
    }
// DEBUG: permission check aspect ends

    // parameter specifying which type of objects we are treating
    $objectType = 'ticket';

//TODO: custom logic
}
