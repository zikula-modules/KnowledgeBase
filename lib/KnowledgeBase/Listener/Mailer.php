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

/**
 * Event handler implementation class for mailing events.
 */
class KnowledgeBase_Listener_Mailer
{
    /**
     * Listener for the `module.mailer.api.sendmessage` event.
     *
     * Invoked from `Mailer_Api_User#sendmessage`.
     * Subject is `Mailer_Api_User` with `$args`.
     * This is a notifyUntil event so the event must `$event->stop()` and set any
     * return data into `$event->data`, or `$event->setData()`.
     */
    public static function sendMessage(Zikula_Event $event)
    {
    }
}
