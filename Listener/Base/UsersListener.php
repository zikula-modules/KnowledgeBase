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

namespace Guite\KnowledgeBaseModule\Listener\Base;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Zikula\Core\Event\GenericEvent;

/**
 * Event handler base class for events of the Users module.
 */
class UsersListener implements EventSubscriberInterface
{
    /**
     * Listener for the `module.users.config.updated` event.
     *
     * Occurs after the Users module configuration has been
     * updated via the administration interface.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function configUpdated(GenericEvent $event)
    {
    }
    
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return array(
            'module.users.config.updated' => array('configUpdated', 5)
        );
    }
}