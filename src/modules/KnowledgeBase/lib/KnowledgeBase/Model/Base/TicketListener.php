<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger
 * @link http://zikula.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package KnowledgeBase
 * @author Axel Guckelsberger.
 * @url https://guite.de
 * @version Generated by ModuleStudio 0.5.2 (http://modulestudio.de) at Thu Jan 27 15:07:46 CET 2011.
 */


/**
 * Doctrine_Record_Listener class used to listen for and hook into events.
 *
 * This is the base listener class for ticket entities.
 */
class KnowledgeBase_Model_Base_TicketListener extends Doctrine_Record_Listener
{

    /**
     * Pre-Process the data prior to a hydrate operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    public function preHydrate(Doctrine_Event $event)
    {
        // echo 'selecting a record ...';
    }

    /**
     * Post-Process the data after a hydrate operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    public function postHydrate(Doctrine_Event $event)
    {
        // echo 'selected a record ...';

        $data = $event->data;

        $data['ticketid'] = ((isset($data['ticketid']) && !empty($data['ticketid'])) ? DataUtil::formatForDisplay($data['ticketid']) : '');
        $data['subject'] = ((isset($data['subject']) && !empty($data['subject'])) ? DataUtil::formatForDisplayHTML($data['subject']) : '');
        $data['content'] = ((isset($data['content']) && !empty($data['content'])) ? DataUtil::formatForDisplayHTML($data['content']) : '');
        $data['views'] = ((isset($data['views']) && !empty($data['views'])) ? DataUtil::formatForDisplay($data['views']) : '');
        $data['ratesUp'] = ((isset($data['ratesUp']) && !empty($data['ratesUp'])) ? DataUtil::formatForDisplay($data['ratesUp']) : '');
        $data['ratesDown'] = ((isset($data['ratesDown']) && !empty($data['ratesDown'])) ? DataUtil::formatForDisplay($data['ratesDown']) : '');


        $event->data = $data;
    }

    /**
     * Pre-Process the data prior to a save operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    public function preSave(Doctrine_Event $event)
    {
        // echo 'saving a record ...';
    }

    /**
     * Post-Process the data after a save operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    public function postSave(Doctrine_Event $event)
    {
        // echo 'saved a record ...';
    }

    /**
     * Pre-Process the data prior to an update operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    function preUpdate(Doctrine_Event $event)
    {
        // echo 'updating a record ...';
    }

    /**
     * Post-Process the data after an update operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    function postUpdate(Doctrine_Event $event)
    {
        // echo 'updated a record ...';
    }

    /**
     * Pre-Process the data prior to an insert operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    function preInsert(Doctrine_Event $event)
    {
        // echo 'inserting a record ...';
    }

    /**
     * Post-Process the data after an insert operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    function postInsert(Doctrine_Event $event)
    {
        // echo 'inserted a record ...';
    }

    /**
     * Pre-Process the data prior a delete operation.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    function preDelete(Doctrine_Event $event)
    {
        // echo 'deleting a record ...';
    }

    /**
     * Post-Process the data after a delete.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void
     */
    function postDelete(Doctrine_Event $event)
    {
        // echo 'deleted a record ...';
    }

    /**
     * Pre-Process the validation process with class specific logic.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    function preValidate(Doctrine_Event $event)
    {
        // echo 'validating a record ...';
    }

    /**
     * Post-Process the validation process with class specific logic.
     *
     * @param Doctrine_Event $event Event object
     *
     * @return void.
     */
    function postValidate(Doctrine_Event $event)
    {
        // echo 'validated a record ...';
    }
}