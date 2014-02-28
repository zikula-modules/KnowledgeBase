<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger (Guite)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Axel Guckelsberger <info@guite.de>.
 * @link https://guite.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.6.1 (http://modulestudio.de).
 */

namespace Guite\KnowledgeBaseModule\Entity;

use Guite\KnowledgeBaseModule\Entity\Base\AbstractTicketCategoryEntity as BaseAbstractTicketCategoryEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity extension domain class storing ticket categories.
 *
 * This is the concrete category class for ticket entities.
* @ORM\Entity(repositoryClass="\Guite\KnowledgeBaseModule\Entity\Repository\TicketCategory")
   * @ORM\Table(name="guite_kbase_ticket_category",
   *     uniqueConstraints={
   *         @ORM\UniqueConstraint(name="cat_unq", columns={"registryId", "categoryId", "entityId"})
   *     }
   * )
 */
class TicketCategoryEntity extends BaseAbstractTicketCategoryEntity
{
    // feel free to add your own methods here
}