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

namespace Guite\KnowledgeBaseModule\Listener;

use Guite\KnowledgeBaseModule\Listener\Base\ModuleDispatchListener as BaseModuleDispatchListener;
use Zikula\Core\Event\GenericEvent;

/**
 * Event handler implementation class for dispatching modules.
 */
class ModuleDispatchListener extends BaseModuleDispatchListener
{
    /**
     * Listener for the `module_dispatch.postloadgeneric` event.
     *
     * Called after a module api or controller has been loaded.
     * Receives the args `array('modinfo' => $modinfo, 'type' => $type, 'force' => $force, 'api' => $api)`.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function postLoadGeneric(GenericEvent $event)
    {
        parent::postLoadGeneric($event);
    }
    
    /**
     * Listener for the `module_dispatch.preexecute` event.
     *
     * Occurs in `ModUtil::exec()` after function call with the following args:
     *     `array('modname' => $modname,
     *            'modfunc' => $modfunc,
     *            'args' => $args,
     *            'modinfo' => $modinfo,
     *            'type' => $type,
     *            'api' => $api)`
     * .
     *
     * @param GenericEvent $event The event instance.
     */
    public static function preExecute(GenericEvent $event)
    {
        parent::preExecute($event);
    }
    
    /**
     * Listener for the `module_dispatch.postexecute` event.
     *
     * Occurs in `ModUtil::exec()` after function call with the following args:
     *     `array('modname' => $modname,
     *            'modfunc' => $modfunc,
     *            'args' => $args,
     *            'modinfo' => $modinfo,
     *            'type' => $type,
     *            'api' => $api)`
     * .
     * Receives the modules output with `$event->getData();`.
     * Can modify this output with `$event->setData($data);`.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function postExecute(GenericEvent $event)
    {
        parent::postExecute($event);
    }
    
    /**
     * Listener for the `module_dispatch.custom_classname` event.
     *
     * In order to override the classname calculated in `ModUtil::exec()`.
     * In order to override a pre-existing controller/api method, use this event type to override the class name that is loaded.
     * This allows to override the methods using inheritance.
     * Receives no subject, args of `array('modname' => $modname, 'modinfo' => $modinfo, 'type' => $type, 'api' => $api)`
     * and 'event data' of `$className`. This can be altered by setting `$event->setData()` followed by `$event->stopPropagation()`.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function customClassname(GenericEvent $event)
    {
        parent::customClassName($event);
    }
    
    /**
     * Listener for the `module_dispatch.service_links` event.
     *
     * Occurs when building admin menu items.
     * Adds sublinks to a Services menu that is appended to all modules if populated.
     * Triggered by module_dispatch.postexecute in bootstrap.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function serviceLinks(GenericEvent $event)
    {
        parent::customClassName($event);
    
        // Format data like so:
        // $event->data[] = array('url' => ModUtil::url('GuiteKnowledgeBaseModule', 'user', 'index'), 'text' => __('Link Text'));
    }
    
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents();
    }
}
