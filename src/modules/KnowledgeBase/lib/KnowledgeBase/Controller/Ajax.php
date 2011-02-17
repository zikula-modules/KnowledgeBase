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
 * This is the Ajax controller class providing navigation and interaction functionality.
 */
class KnowledgeBase_Controller_Ajax extends KnowledgeBase_Controller_Base_Ajax
{
    /**
     * Perform a "like this" operation increasing the ratesup field of corresponding ticket.
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function like($args)
    {
        // DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW));
        // DEBUG: permission check aspect ends

        $id = (int) FormUtil::getPassedValue('id', 0, 'POST', FILTER_VALIDATE_INT);
        if ($id > 0) {
            // increase amount of ratesup
            Doctrine::getTable('KnowledgeBase_Model_Ticket')->incrementRatesUp($data[$idField]);
        }
        return true;
    }


    /**
     * Perform a "dislike this" operation increasing the ratesdown field of corresponding ticket.
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function dislike($args)
    {
        // DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW));
        // DEBUG: permission check aspect ends

        $id = (int) FormUtil::getPassedValue('id', 0, 'POST', FILTER_VALIDATE_INT);
        if ($id > 0) {
            // increase amount of ratesdown
            Doctrine::getTable('KnowledgeBase_Model_Ticket')->incrementRatesDown($data[$idField]);
        }
        return true;
    }
}
