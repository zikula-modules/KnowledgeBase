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
 * Event handler implementation class for view-related events.
 */
class KnowledgeBase_Listener_View
{
    /**
     * Listener for the `view.init` event.
     *
     * Occurs just before `Zikula_View#__construct()` finishes.
     * The subject is the Zikula_View instance.
     */
    public static function init(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `view.postfetch` event.
     *
     * Filter of result of a fetch. Receives `Zikula_View` instance as subject, args are
     * `array('template' => $template)`, $data was the result of the fetch to be filtered.
     */
    public static function postFetch(Zikula_Event $event)
    {
    }
}
