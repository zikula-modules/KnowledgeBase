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

use Guite\KnowledgeBaseModule\Listener\Base\InstallerListener as BaseInstallerListener;
use Zikula\Core\Event\GenericEvent;
use Zikula\Core\Event\ModuleStateEvent;

/**
 * Event handler implementation class for module installer events.
 */
class InstallerListener extends BaseInstallerListener
{
    /**
     * Listener for the `module.install` event.
     *
     * Called after a module has been successfully installed.
     * Receives `$modinfo` as args.
     *
     * @param ModuleStateEvent $event The event instance.
     */
    public static function moduleInstalled(ModuleStateEvent $event)
    {
        parent::moduleInstalled($event);
    }
    
    /**
     * Listener for the `module.upgrade` event.
     *
     * Called after a module has been successfully upgraded.
     * Receives `$modinfo` as args.
     *
     * @param ModuleStateEvent $event The event instance.
     */
    public static function moduleUpgraded(ModuleStateEvent $event)
    {
        parent::moduleUpgraded($event);
    }
    
    /**
     * Listener for the `module.enable` event.
     *
     * Called after a module has been successfully enabled.
     * Receives `$modinfo` as args.
     */
    public static function moduleEnabled(ModuleStateEvent $event)
    {
        parent::moduleActivated($event);
    }
    
    /**
     * Listener for the `module.disable` event.
     *
     * Called after a module has been successfully disabled.
     * Receives `$modinfo` as args.
     */
    public static function moduleDisabled(ModuleStateEvent $event)
    {
        parent::moduleDeactivated($event);
    }
    
    /**
     * Listener for the `module.remove` event.
     *
     * Called after a module has been successfully removed.
     * Receives `$modinfo` as args.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function moduleRemoved(ModuleStateEvent $event)
    {
        parent::moduleUninstalled($event);
    }
    
    /**
     * Listener for the `installer.subscriberarea.uninstalled` event.
     *
     * Called after a hook subscriber area has been unregistered.
     * Receives args['areaid'] as the areaId. Use this to remove orphan data associated with this area.
     *
     * @param GenericEvent $event The event instance.
     */
    public static function subscriberAreaUninstalled(GenericEvent $event)
    {
        parent::subscriberAreaUninstalled($event);
    }
    
    /**
     * Makes our handlers known to the event system.
     */
    public static function getSubscribedEvents()
    {
        return parent::getSubscribedEvents();
    }
}
