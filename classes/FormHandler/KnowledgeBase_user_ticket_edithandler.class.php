
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
 * generated at Wed Apr 07 21:54:26 CEST 2010 by ModuleStudio 0.4.10 (http://modulestudio.de)
 */

/**
 * This handler class handles the page events of the pnForm called by the KnowledgeBase_admin_edit() function.
 * It aims on the ticket object type.
 *
 * Member variables in a form handler object are persisted accross different page requests. This means
 * a member variable $this->X can be set on one request and on the next request it will still contain
 * the same value.
 *
 * A form handler will be notified of various events that happens during it's life-cycle.
 * When a specific event occurs then the corresponding event handler (class method) will be executed. Handlers
 * are named exactly like their events - this is how the framework knows which methods to call.
 *
 * The list of events is:
 *
 * - <b>initialize</b>: this event fires before any of the events for the plugins and can be used to setup
 *   the form handler. The event handler typically takes care of reading URL variables, access control
 *   and reading of data from the database.
 *
 * - <b>handleCommand</b>: this event is fired by various plugins on the page. Typically it is done by the
 *   pnFormButton plugin to signal that the user activated a button.
 *
 * @package pnForm
 * @subpackage Base
 * @author       Axel Guckelsberger
 */
class KnowledgeBase_user_ticket_editHandler extends pnFormHandler
{
    // store ticket ID in (persistent) member variable
    var $ticketid;
    var $mode;
    var $dom;

    /**
     * Initialize form handler
     *
     * This method takes care of all necessary initialisation of our data and form states
     *
     * @return bool False in case of initialization errors, otherwise true
     * @author       Axel Guckelsberger
     */
    function initialize(&$render)
    {
        $this->dom = ZLanguage::getModuleDomain('KnowledgeBase');
        $dom = $this->dom;
        // retrieve the ID of the object we wish to edit
        // default to 0 (which is a numeric id but an invalid value)
        // no provided id means that we want to create a new object
        $this->ticketid = (int) FormUtil::getPassedValue('id', 0, 'GET');



        Loader::loadClass('CategoryRegistryUtil');
        $allRegistries = CategoryRegistryUtil::getRegisteredModuleCategories('KnowledgeBase', 'kbase_ticket');
        $categories = array();

        $categories['TicketCategoryMain'] = $allRegistries['TicketCategoryMain'];

        $render->assign('categories', $categories);



        $objectType = 'ticket';
    // load the object class corresponding to $objectType
    $class = Loader::loadClassFromModule('KnowledgeBase', $objectType);

        $this->mode = 'create';
        // if ticketid is not 0, we wish to edit an existing ticket
        if($this->ticketid) {
            $this->mode = 'edit';

            if (!SecurityUtil::checkPermission('KnowledgeBase:Ticket:', '::', ACCESS_EDIT)) {
                // set an error message and return false
                return $render->pnFormRegisterError(LogUtil::registerPermissionError());
            }

    // intantiate object model and get the object of the specified ID from the database
    $object = new $class('D', $this->ticketid);

    // assign object data fetched from the database during object instantiation
    // while the result will be saved within the object, we assign it to a local variable for convenience
    $objectData = $object->get();
            if (!is_array($objectData) || !isset($objectData['ticketid']) || !is_numeric($objectData['ticketid'])) {
                return $render->pnFormSetErrorMsg(__('No such ticket found.', $dom));
            }

            // try to guarantee that only one person at a time can be editing this ticket
            $returnUrl = ModUtil::url('KnowledgeBase', 'user', 'display', array('id' => $this->ticketid));
            ModUtil::apiFunc('PageLock', 'user', 'pageLock',
                                 array('lockName' => "KnowledgeBaseTicket{$this->ticketid}",
                                       'returnUrl' => $returnUrl));
        }
        else {
            if (!SecurityUtil::checkPermission('KnowledgeBase:Ticket:', '::', ACCESS_ADD)) {
                return $render->pnFormRegisterError(LogUtil::registerPermissionError());
            }


            $objectData = Array(
        'subject' => '',
        'content' => '',
        'views' => 0,
        'ratesup' => 0,
        'ratesdown' => 0);


            $cat = FormUtil::getPassedValue('cat', 0, 'GET');
            if ($cat > 0) {
                $objectData['__CATEGORIES__'] = array('TicketCategoryMain' => $cat);
            }


        }


        // assign data to template
        $render->assign($objectData);



        // assign mode var to referenced render instance
        $render->assign('mode', $this->mode);



        // everything okay, no initialization errors occured
        return true;
    }


    /**
     * Command event handler
     *
     * This event handler is called when a command is issued by the user. Commands are typically something
     * that originates from a {@link pnFormButton} plugin. The passed args contains different properties
     * depending on the command source, but you should at least find a <var>$args['commandName']</var>
     * value indicating the name of the command. The command name is normally specified by the plugin
     * that initiated the command.
     * @see pnFormButton
     * @see pnFormImageButton
     * @author       Axel Guckelsberger
     */
    function handleCommand(&$render, &$args)
    {
        $dom = $this->dom;
        // return url for redirecting
        $returnUrl = null;

        if ($args['commandName'] != 'delete' && $args['commandName'] != 'cancel') {
            // do forms validation including checking all validators on the page to validate their input
            if (!$render->pnFormIsValid()) {
                return false;
            }
        }

        $objectType = 'ticket';
    // load the object class corresponding to $objectType
    $class = Loader::loadClassFromModule('KnowledgeBase', $objectType);

        // instantiate the class we just loaded
        // it will be appropriately initialized but contain no data.
        $ticket = new $class();

        if ($args['commandName'] == 'create') {
            // event handling if user clicks on create

            // fetch posted data input values as an associative array
            $ticketData = $render->pnFormGetValues();

            // ensure that all permalink fields in this area have unique subjecturl fields
            $ticketData['subjecturl'] = $this->createUniquePermalink($ticketData['subject']);

            // usually one would use $ticket->getDataFromInput() to get the data, this is the way PNObject works
            // but since we want also use pnForm we simply assign the fetched data and call the post process functionality here
            $ticket->setData($ticketData);
            $ticket->getDataFromInputPostProcess();

            // save ticket
            $ticket->save();

            $this->ticketid = $ticket->getID();
            if ($this->ticketid === false) {
                return LogUtil::registerError(__('Error! Creation attempt failed.', $dom));
            }

            LogUtil::registerStatus(__('Done! Ticket created.', $dom));

            $returnUrl = ModUtil::url('KnowledgeBase', 'user', 'display', array('id' => $this->ticketid));
        }
        elseif ($args['commandName'] == 'update') {
            // event handling if user clicks on update

            // fetch posted data input values as an associative array
            $ticketData = $render->pnFormGetValues();

            // add persisted primary key to fetched values
            $ticketData['ticketid'] = $this->ticketid;

            // ensure that all permalink fields in this area have unique subjecturl fields
            $ticketData['subjecturl'] = $this->createUniquePermalink($ticketData['subject'], $this->ticketid);

            // usually one would use $ticket->getDataFromInput() to get the data, this is the way PNObject works
            // but since we want also use pnForm we simply assign the fetched data and call the post process functionality here
            $ticket->setData($ticketData);
            $ticket->getDataFromInputPostProcess();

            // save ticket
            $updateResult = $ticket->save();

            if ($updateResult === false) {
                return LogUtil::registerError(__('Error! Update attempt failed.', $dom));
            }

            LogUtil::registerStatus(__('Done! Ticket updated.', $dom));

            $returnUrl = ModUtil::url('KnowledgeBase', 'user', 'display', array('id' => $this->ticketid));
        }
        elseif ($args['commandName'] == 'delete') {
            // event handling if user clicks on delete

            // Note: No need to check validation when deleting

            if (!SecurityUtil::checkPermission('KnowledgeBase:Ticket:', '::', ACCESS_DELETE)) {
                return $render->pnFormRegisterError(LogUtil::registerPermissionError());
            }

            // fetch posted data input values as an associative array
            $ticketData = $render->pnFormGetValues();

            // add persisted primary key to fetched values
            $ticketData['ticketid'] = $this->ticketid;



            // usually one would use $ticket->getDataFromInput() to get the data, this is the way PNObject works
            // but since we want also use pnForm we simply assign the fetched data and call the post process functionality here
            $ticket->setData($ticketData);
            $ticket->getDataFromInputPostProcess();

            // add persisted primary key to fetched values
            $ticketData['ticketid'] = $this->ticketid;


            // delete ticket
            if ($ticket->delete() === false) {
                return LogUtil::registerError(__('Error! Deletion attempt failed.', $dom));
            }

            LogUtil::registerStatus(__('Done! Ticket deleted.', $dom));

            // redirect to the list of tickets
            $returnUrl = ModUtil::url('KnowledgeBase', 'user', 'view');
        }
        else if ($args['commandName'] == 'cancel') {
            // event handling if user clicks on cancel

            if ($this->mode == 'edit') {
                // redirect to the detail page of the treated ticket
                $returnUrl = ModUtil::url('KnowledgeBase', 'user', 'display', array('id' => $this->ticketid));
            }
            else {
                // redirect to the list of tickets
                $returnUrl = ModUtil::url('KnowledgeBase', 'user', 'view');
            }
        }


        if ($returnUrl != null) {
            if ($this->mode == 'edit') {
                ModUtil::apiFunc('PageLock', 'user', 'releaseLock',
                                 array('lockName' => "KnowledgeBaseTicket{$this->ticketid}"));
            }

            return $render->pnFormRedirect($returnUrl);
        }

        // We should in principle not end here at all, since the above command handlers should 
        // match all possible commands, but we return "ok" (true) for all cases.
        // You could also return $render->pnFormSetErrorMsg('Unexpected command') or just do a pn_die()
        return true;
    }

    function createUniquePermalink($title, $excludeid = 0)
    {
        $uniqueTitle = KnowledgeBase_createPermalink($title);
        $currentYear = date('Y');
        $uniqueCounter = 0;
        while ($this->uniquePermalinkExists($uniqueTitle, $excludeid)) {
            $uniqueTitle = KnowledgeBase_createPermalink($title . '-' . $currentYear . (($uniqueCounter > 0) ? '-' . $uniqueCounter : ''));
            $uniqueCounter++;
        }
        return $uniqueTitle;
    }

    /**
     * Validation helper method
     *
     * This method determines if there already exists an object with the same name.
     * Duplicate names are not allowed to ensure unique permalinks
     *
     * @param    name               string the name to check
     * @param    excludeid          int id of ticket to exclude (optional)
     * @return   boolean            true if the given name already does exist
     * @author       Axel Guckelsberger
     */
    function uniquePermalinkExists($nameurl, $excludeid = 0)
    {
        if (empty($nameurl)) {
            return false;
        }

        $objectType = 'ticket';
        $arrayClass = Loader::loadArrayClassFromModule('KnowledgeBase', $objectType);

        // instantiate the object-array
        $objectArray = new $arrayClass();

        $where = $objectArray->_columns['subjecturl'] . ' = \'' . DataUtil::formatForStore($nameurl) . '\'';
        if ($excludeid > 0) {
            $where .= ' AND ' . $objectArray->_columns[strtolower($objectType) . 'id'] . ' != \'' . (int) DataUtil::formatForStore($excludeid) . '\'';
        }
        return $objectArray->getCount($where);
    }
}
