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
 * Event handler base class for core events.
 */
class CoreListener implements EventSubscriberInterface
{
    /**
     * Listener for the `api.method_not_found` event.
     *
     * Called in instances of Zikula_Api from __call().
     * Receives arguments from __call($method, argument) as $args.
     *     $event['method'] is the method which didn't exist in the main class.
     *     $event['args'] is the arguments that were passed.
     * The event subject is the class where the method was not found.
     * Must exit if $event['method'] does not match whatever the handler expects.
     * Modify $event->data and $event->stopPropagation().
     *
     * @param GenericEvent $event The event instance.
     */
    public static function apiMethodNotFound(GenericEvent $event)
    {
    }
    
    /**
     * Listener for the `core.preinit` event.
     *
     * Occurs after the config.php is loaded.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function preInit(GenericEvent $event)
    {
    }
    
    /**
     * Listener for the `core.init` event.
     *
     * Occurs after each `System::init()` stage, `$event['stage']` contains the stage.
     * To check if the handler should execute, do `if($event['stage'] & System::CORE_STAGES_*)`.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function init(GenericEvent $event)
    {
    }
    
    /**
     * Listener for the `core.postinit` event.
     *
     * Occurs just before System::init() exits from normal execution.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function postInit(GenericEvent $event)
    {
    }
    
    /**
     * Listener for the `controller.method_not_found` event.
     *
     * Called in instances of `Zikula_Controller` from `__call()`.
     * Receives arguments from `__call($method, argument)` as `$args`.
     *    `$event['method']` is the method which didn't exist in the main class.
     *    `$event['args']` is the arguments that were passed.
     * The event subject is the class where the method was not found.
     * Must exit if `$event['method']` does not match whatever the handler expects.
     * Modify `$event->data` and `$event->stopPropagation()`.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function controllerMethodNotFound(GenericEvent $event)
    {
        // You can have multiple of these methods.
        // See system/Extensions/HookUI.php for an example.
    }
    
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return array(
            'api.method_not_found'          => array('apiMethodNotFound', 5),
            'core.preinit'                  => array('preInit', 5),
            'core.init'                     => array('init', 5),
            'core.postinit'                 => array('postInit', 5),
            'controller.method_not_found'   => array('controllerMethodNotFound', 5)
        );
    }
}