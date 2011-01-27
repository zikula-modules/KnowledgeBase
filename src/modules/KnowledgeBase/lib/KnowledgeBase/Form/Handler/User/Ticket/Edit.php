
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
 * This handler class handles the page events of the Form called by the KnowledgeBase_user_edit() function.
 * It aims on the ticket object type.
 */
class KnowledgeBase_Form_Handler_User_Ticket_Edit extends KnowledgeBase_Form_Handler_Base_User_Ticket_Edit
{
    /**
     * Method stub for own additions in subclasses.
     */
    protected function initializeAdditions()
    {
        $allRegistries = CategoryRegistryUtil::getRegisteredModuleCategories('KnowledgeBase', 'kbase_ticket');

        $categories = array();
        $categories['TicketCategoryMain'] = $allRegistries['TicketCategoryMain'];

        $this->view->assign('categoryItems', $categories);


        if ($this->mode == 'create') {
            $templateTicketid = (int) FormUtil::getPassedValue('astemplate', 0, 'GET', FILTER_VALIDATE_INT);
            if ($templateTicketid > 0) {
            }
            else {
                $cat = FormUtil::getPassedValue('cat', 0, 'GET');
                if ($cat > 0) {
                    $object = KnowledgeBase_Factory::getBusinessEntity($this->objectType, 'actionHandler', false, array('controller' => 'user', 'action' => 'initializeAdditions'));
                    $objectData = $object->getNewArrayWithDefaultData();
                    $objectData['Categories'] = array('TicketCategoryMain' => $cat);
                    // reassign with given category default value
                    $this->view->assign('ticket', $objectData);
                }
            }
        }
    }
}