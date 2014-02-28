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
 * Event handler base class for user logout events.
 */
class UserLogoutListener implements EventSubscriberInterface
{
    /**
     * Listener for the `module.users.ui.logout.succeeded` event.
     *
     * Occurs right after a successful logout.
     * All handlers are notified.
     * The event's subject contains the user's user record.
     * Args contain array of `array('authentication_method' => $authenticationMethod,
     *                              'uid'                   => $uid));`
     *
     * @param GenericEvent $event The event instance.
     */
    public static function succeeded(GenericEvent $event)
    {
    }
    
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return array(
            'module.users.ui.logout.succeeded' => array('succeeded', 5)
        );
    }
}
