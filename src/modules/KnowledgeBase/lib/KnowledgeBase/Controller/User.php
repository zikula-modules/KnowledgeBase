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


class KnowledgeBase_Controller_User extends Zikula_Controller
{

    /**
     * Even though we're handling objects for multiple tables, we only have one function for any use case.
     * The specific functionality for each object is encapsulated in the actual class implementation within the
     * module's classes directory while the handling code can remain identical for any number of entities.
     * This component-based approach allows you to have generic handler code which relies on the functionality
     * implemented in the object's class in order to achieve it's goals.
     */


    /**
     * This function is the default function, and is called whenever the
     * module's User area is called without defining arguments.
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function main($args)
    {
        // DEBUG: permission check aspect starts
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
            return LogUtil::registerPermissionError();
        }
        // DEBUG: permission check aspect ends

        $this->view->assign('categories', ModUtil::apiFunc('KnowledgeBase', 'user', 'getCategories', array('full' => false)));

        // fetch and return the appropriate template
        return KnowledgeBase_Util::processRenderTemplate($this->view, 'user', '', 'main', $args);
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
    public function view($args)
    {
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        $objectType = 'ticket';

        list($objectData, $objcount) = ModUtil::apiFunc('KnowledgeBase', 'user', 'getTickets', array());

        // parameter for used sorting field
        $sort = FormUtil::getPassedValue('sort', '', 'GET');

        // parameter for used sort order
        $sdir = FormUtil::getPassedValue('sdir', '', 'GET');
        if ($sdir != 'asc' && $sdir != 'desc') $sdir = 'asc';

        // pagesize is the number of items displayed on a page for pagination
        $pagesize = (int) ((isset($args['amount']) ? $args['amount'] : 100));//ModUtil::getVar('KnowledgeBase', 'pagesize', 10);

        // assign the object-array we loaded above
        $this->view->assign('objectArray', $objectData);

        // assign current sorting information
        $this->view->assign('sort', $sort);
        $this->view->assign('sdir', ($sdir == 'asc') ? 'desc' : 'asc'); // reverted for links

        // assign the information required to create the pager
        $this->view->assign('pager', array('numitems'     => $objcount,
                'itemsperpage' => $pagesize));

        // fetch and return the appropriate template
        return KnowledgeBase_Util::processRenderTemplate($this->view, 'user', $objectType, 'view', $args);
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
    public function display($args)
    {
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }

        $objectType = 'ticket';

        // retrieve the ID of the object we wish to view
        $id = (int) FormUtil::getPassedValue('id', 0, 'GET');
        if (!$id) {
            z_exit('Invalid ' . $idField . ' [' . DataUtil::formatForDisplay($id) . '] received ...');
        }

        $objectData = ModUtil::apiFunc('KnowledgeBase', 'user', 'getTicket', array('id' => $id));

        // assign the object we loaded above.
        // since the same code is used the handle the entry of the new object,
        // we need to check wether we have a valid object.
        // If not, we just pass in an empty data-array.
        $this->view->assign($objectType, $objectData);

        // fetch and return the appropriate template
        return KnowledgeBase_Util::processRenderTemplate($this->view, 'user', $objectType, 'display', $args);
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
    public function edit($args)
    {
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_EDIT)) {
            return LogUtil::registerPermissionError();
        }

        // create new pnForm reference
        $this->view = FormUtil::newForm('KnowledgeBase');

        // Execute form using supplied template and page event handler
        return $this->view->execute('KnowledgeBase_user_ticket_edit.tpl', new KnowledgeBase_Form_Handler_TicketEdit());
    }

    /**
     * This is a custom function. Documentation for this will be improved in later versions.
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function assign($args)
    {
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW)) {
            return LogUtil::registerPermissionError();
        }
    }
}