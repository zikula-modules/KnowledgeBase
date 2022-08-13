<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package KnowledgeBase
 * @author Axel Guckelsberger <info@guite.de>.
 * @link https://guite.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Wed Jan 04 20:13:48 CET 2012.
 */


use Doctrine\ORM\Mapping as ORM;

/**

 * Entity extension domain class storing ticket categories.
 *
 * This is the base category class for ticket entities.
 */
class KnowledgeBase_Entity_Base_TicketCategory extends Zikula_Doctrine2_Entity_EntityCategory
{
    /**
     * @ORM\ManyToOne(targetEntity="KnowledgeBase_Entity_Ticket", inversedBy="categories")
     * @ORM\JoinColumn(name="entityId", referencedColumnName="id")
     * @var KnowledgeBase_Entity_Ticket
     */
    protected $entity;

    /**
     * Get reference to owning entity.
     *
     * @return KnowledgeBase_Entity_Ticket
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set reference to owning entity.
     *
     * @param KnowledgeBase_Entity_Ticket $entity
     */
    public function setEntity(/*KnowledgeBase_Entity_Ticket */$entity)
    {
        $this->entity = $entity;
    }
}