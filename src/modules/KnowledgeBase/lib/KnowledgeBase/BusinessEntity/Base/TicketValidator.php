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
 * Business validator class for encapsulating validation methods.
 *
 * This is the base validation class for ticket entities.
 */
abstract class KnowledgeBase_BusinessEntity_Base_TicketValidator
{


    /**
     * @var KnowledgeBase_BusinessEntity_Ticket The entity class which is treated by this validator.
     */
    protected $entity = null;

    /**
     * Constructor.
     *
     * @param KnowledgeBase_BusinessEntity_Ticket $entity The entity to be validated.
     */
    function __construct(KnowledgeBase_BusinessEntity_Ticket $entity)
    {
        $this->entity = $entity;
    }


    /**
     * Check for unique values.
     *
     * This method determines if there already exist tickets with the same ticketid.
     *
     * @param integer  $value The ticketid to check.
     * @param int $excludeid      int    Id of tickets to exclude (optional).
     *
     * @return boolean true if the given ticketid does already exist
     */
    public function checkIfTicketidExists($value, $excludeid = 0)
    {
        if (empty($value)) {
            return false;
        }

        $objectType = 'ticket';
        // instantiate a new collection corresponding to $objectType
        $objectCollection = KnowledgeBase_Factory::getBusinessCollection($objectType, 'validator', array('controller' => 'ticket', 'action' => 'checkIfTicketidExists'));

        // TODO: move to KnowledgeBase_Model_Base_TicketTable
        $where = 'tbl.ticketid = \'' . DataUtil::formatForStore($value) . '\'';
        if ($excludeid > 0) {
            $where .= ' AND tbl.ticketid != \'' . (int) DataUtil::formatForStore($excludeid) . '\'';
        }
        return $objectCollection->selectCount($where);
    }

    /**
     * Get entity.
     *
     * @return KnowledgeBase_BusinessEntity_Ticket
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set entity.
     *
     * @param KnowledgeBase_BusinessEntity_Ticket $entity.
     *
     * @return void
     */
    public function setEntity($pEntity)
    {
        $this->entity = $pEntity;
    }


}
