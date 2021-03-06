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
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use DoctrineExtensions\StandardFields\Mapping\Annotation as ZK;

/**
 * Entity class that defines the entity structure and behaviours.
 *
 * This is the concrete entity class for ticket entities.
 * @ORM\Entity(repositoryClass="KnowledgeBase_Entity_Repository_Ticket")
 * @ORM\Table(name="kbase_ticket")
 * @ORM\HasLifecycleCallbacks
 */
class KnowledgeBase_Entity_Ticket extends KnowledgeBase_Entity_Base_Ticket
{
    // feel free to add your own methods here



    /**
     * Post-Process the data after the entity has been constructed by the entity manager.
     *
     * @ORM\PostLoad
     * @see KnowledgeBase_Entity_Base_Ticket::performPostLoadCallback()
     * @return void.
     */
    public function postLoadCallback()
    {
        $this->performPostLoadCallback();
    }

    /**
     * Pre-Process the data prior to an insert operation.
     *
     * @ORM\PrePersist
     * @see KnowledgeBase_Entity_Base_Ticket::performPrePersistCallback()
     * @return void.
     */
    public function prePersistCallback()
    {
        $this->performPrePersistCallback();
    }

    /**
     * Post-Process the data after an insert operation.
     *
     * @ORM\PostPersist
     * @see KnowledgeBase_Entity_Base_Ticket::performPostPersistCallback()
     * @return void.
     */
    public function postPersistCallback()
    {
        $this->performPostPersistCallback();
    }

    /**
     * Pre-Process the data prior a delete operation.
     *
     * @ORM\PreRemove
     * @see KnowledgeBase_Entity_Base_Ticket::performPreRemoveCallback()
     * @return void.
     */
    public function preRemoveCallback()
    {
        $this->performPreRemoveCallback();
    }

    /**
     * Post-Process the data after a delete.
     *
     * @ORM\PostRemove
     * @see KnowledgeBase_Entity_Base_Ticket::performPostRemoveCallback()
     * @return void
     */
    public function postRemoveCallback()
    {
        $this->performPostRemoveCallback();
    }

    /**
     * Pre-Process the data prior to an update operation.
     *
     * @ORM\PreUpdate
     * @see KnowledgeBase_Entity_Base_Ticket::performPreUpdateCallback()
     * @return void.
     */
    public function preUpdateCallback()
    {
        $this->performPreUpdateCallback();
    }

    /**
     * Post-Process the data after an update operation.
     *
     * @ORM\PostUpdate
     * @see KnowledgeBase_Entity_Base_Ticket::performPostUpdateCallback()
     * @return void.
     */
    public function postUpdateCallback()
    {
        $this->performPostUpdateCallback();
    }

    /**
     * Pre-Process the data prior to a save operation.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * @see KnowledgeBase_Entity_Base_Ticket::performPreSaveCallback()
     * @return void.
     */
    public function preSaveCallback()
    {
        $this->performPreSaveCallback();
    }

    /**
     * Post-Process the data after a save operation.
     *
     * @ORM\PostPersist
     * @ORM\PostUpdate
     * @see KnowledgeBase_Entity_Base_Ticket::performPostSaveCallback()
     * @return void.
     */
    public function postSaveCallback()
    {
        $this->performPostSaveCallback();
    }

}
