<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger
 * @link http://zikula.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package KnowledgeBase
 * @author Axel Guckelsberger.
 * @url https://guite.de
 * @version Generated by ModuleStudio 0.5.2 (http://modulestudio.de) at Thu Feb 17 14:43:00 CET 2011.
 */

/**
 * Event handler base class
 */
class KnowledgeBase_Base_Listeners
{
    // core

    /**
     * Listener for the `api.method_not_found` event.
     *
     * Called in instances of Zikula_AbstractApi from __call().
     * Receives arguments from __call($method, argument) as $args.
     *     $event['method'] is the method which didn't exist in the main class.
     *     $event['args'] is the arguments that were passed.
     * The event subject is the class where the method was not found.
     * Must exit if $event['method'] does not match whatever the handler expects.
     * Modify $event->data and $event->setNotify().
     */
    public static function coreApiMethodNotFound(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `core.preinit` event.
     *
     * Occurs after the config.php is loaded.
     */
    public static function corePreInit(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `core.init` event.
     *
     * Occurs after each `System::init()` stage, `$event['stage']` contains the stage.
     * To check if the handler should execute, do `if($event['stage'] & System::CORE_STAGES_*)`.
     */
    public static function coreInit(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `core.postinit` event.
     *
     * Occurs just before System::init() exits from normal execution.
     */
    public static function corePostInit(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `controller.method_not_found` event.
     *
     * Called in instances of `Zikula_AbstractController` from `__call()`.
     * Receives arguments from `__call($method, argument)` as `$args`.
     *    `$event['method']` is the method which didn't exist in the main class.
     *    `$event['args']` is the arguments that were passed.
     * The event subject is the class where the method was not found.
     * Must exit if `$event['method']` does not match whatever the handler expects.
     * Modify `$event->data` and `$event->setNotify()`.
     */
    public static function coreControllerMethodNotFound(Zikula_Event $event)
    {
        // You can have multiple of these methods.
        // See system/Modules/lib/Modules/HookUI.php for an example.
        }

    // modules

    /**
     * Listener for the `installer.module.installed` event.
     *
     * Called after a module is successfully installed.
     * Receives `$modinfo` as args.
     */
    public static function installerModuleInstalled(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `installer.module.upgraded` event.
     *
     * Called after a module is successfully upgraded.
     * Receives `$modinfo` as args.
     */
    public static function installerModuleUpgraded(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `installer.module.uninstalled` event.
     *
     * Called after a module is successfully uninstalled.
     * Receives `$modinfo` as args.
     */
    public static function installerModuleUninstalled(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `module_dispatch.postloadgeneric` event.
     *
     * Called after a module api or controller has been loaded.
     * Receives the args `array('modinfo' => $modinfo, 'type' => $type, 'force' => $force, 'api' => $api)`.
     */
    public static function moduleDispatchPostLoadGeneric(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `module_dispatch.preexecute` event.
     *
     * Occurs in `ModUtil::exec()` after function call with the following args:
     * `array('modname' => $modname, 'modfunc' => $modfunc, 'args' => $args, 'modinfo' => $modinfo, 'type' => $type, 'api' => $api)`.
     */
    public static function moduleDispatchPreExecute(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `module_dispatch.postexecute` event.
     *
     * Occurs in `ModUtil::exec()` after function call with the following args:
     * `array('modname' => $modname, 'modfunc' => $modfunc, 'args' => $args, 'modinfo' => $modinfo, 'type' => $type, 'api' => $api)`.
     * Receives the modules output with `$event->getData();`.
     * Can modify this output with `$event->setData($data);`.
     */
    public static function moduleDispatchPostExecute(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `module_dispatch.custom_classname` event.
     *
     * In order to override the classname calculated in `ModUtil::exec()`.
     * In order to override a pre-existing controller/api method, use this event type to override the class name that is loaded.
     * This allows to override the methods using inheritance.
     * Receives no subject, args of `array('modname' => $modname, 'modinfo' => $modinfo, 'type' => $type, 'api' => $api)`
     * and 'event data' of `$className`. This can be altered by setting `$event->setData()` followed by `$event->setNotified()`.
     */
    public static function moduleDispatchCustomClassname(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `module.mailer.api.sendmessage` event.
     *
     * Invoked from `Mailer_Api_User#sendmessage`.
     * Subject is `Mailer_Api_User` with `$args`.
     * This is a notifyUntil event so the event must `$event->setNotified()` and set any
     * return data into `$event->data`, or `$event->setData()`.
     */
    public static function moduleMailerApiSendmessage(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `pageutil.addvar_filter` event.
     *
     * Used to override things like system or module stylesheets or javascript.
     * Subject is the `$varname`, and `$event->data` an array of values to be modified by the filter.
     *
     * This single filter can be used to override all css or js scripts or any other var types
     * sent to `PageUtil::addVar()`.
     */
    public static function pageutilAddvarFilter(Zikula_Event $event)
    {
        // Simply test with something like
        /*
         if (($key = array_search('system/Users/javascript/somescript.js', $event->data)) !== false) {
         $event->data[$key] = 'config/javascript/myoverride.js';
         }
         */
    }

    // errors

    /**
     * Listener for the `setup.errorreporting` event.
     *
     * Invoked during `System::init()`.
     * Used to activate `set_error_handler()`.
     * Event must `setNotified()`.
     */
    public static function setupErrorReporting(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `system.outputfilter` event.
     *
     * Filter type event for output filter HTML sanitisation.
     */
    public static function systemOutputFilter(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `systemerror` event.
     *
     * Invoked on any system error.
     * args gets `array('errorno' => $errno, 'errstr' => $errstr, 'errfile' => $errfile, 'errline' => $errline, 'errcontext' => $errcontext)`.
     */
    public static function systemError(Zikula_Event $event)
    {
    }

    // themes and views

    /**
     * Listener for the `theme.init` event.
     *
     * Occurs just before `Theme#__construct()` exits. Subject is `$this`, args are
     * `array('theme' => $theme, 'usefilters' => $usefilters, 'themeinfo' => $themeinfo)`.
     */
    public static function themeInit(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `theme.load_config` event.
     *
     * Runs just before `Theme#_load_config()` completed.
     * Subject is the Theme instance.
     */
    public static function themeLoadConfig(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `theme.prefetch` event.
     *
     * Occurs in `Theme::themefooter()` just after getting the `$maincontent`.
     * The event subject is `$this` (Theme instance) and has $maincontent as the event data
     * which you can modify with `$event->setData()` in the event handler.
     */
    public static function themePreFooter(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `theme.postfetch` event.
     *
     * Occurs in `Theme::themefooter()` just after rendering the theme.
     * The event subject is `$this` (Theme instance) and the event data is the rendered
     * output which you can modify with `$event->setData()` in the event handler.
     */
    public static function themePostFooter(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `view.init` event.
     *
     * Occurs just before `Zikula_View#__construct()` exits. Subject is `$this`, args are
     * `array('module' => $module, 'modinfo' => $modinfo, 'themeinfo' => $themeinfo)`.
     */
    public static function viewInit(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `view.postfetch` event.
     *
     * Filter of result of a fetch. Receives `Zikula_View` instance as subject, args are
     * `array('template' => $template)`, $data was the result of the fetch to be filtered.
     */
    public static function viewFetch(Zikula_Event $event)
    {
    }

    // users and groups

    /**
     * Listener for the `user.login` event.
     *
     * Occurs right after login, `$event['user']` is the UID of the logged in user.
     *    `$event['authmodule']` with the name of the module that authenticated.
     *    `$event['loginid']` with the equivalent of the user name that authenticated
     (not all authmodules use loginid, and therefore this may not be supplied).
     *           If authentication was attempted with Zikula's Users module, then
     *           `$event['loginid']` will contain the uname logged in.
     */
    public static function userLogin(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `user.login.failed` event.
     *
     * Occurs on login failure.
     *    `$event['authmodule']` with the name of the module that attempted to authenticate.
     *    `$event['loginid']` with the equivalent of the user name that was attempted
     *           (not all authmodules use loginid, and therefore this may not be supplied).
     *           If authentication was attempted with Zikula's Users module, then
     *           `$event['loginid']` will contain the uname attempted.
     */
    public static function userLoginFailed(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `user.logout` event.
     *
     * Occurs right after logout.
     *     `$event['user']` is the UID of the user who logged out.
     *     `$event['authmodule']` with the name of the module that logged out (in addition to Zikula core).
     */
    public static function userLogout(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `user.logout.failed` event.
     *
     * Occurs right after logout.
     *     `$event['user']` is the UID of the user who attempted to log out.
     *     `$event['authmodule']` with the name of the module that attempted and failed to log out.
     */
    public static function userLogoutFailed(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `user.gettheme` event.
     *
     * This is invoked with notifyUntil so you should execute `$event->setNotified()` in the event handler.
     * Receives `$event['name']` the chosen theme name, it can modify the name.
     */
    public static function userGetTheme(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `user.create` event.
     *
     * Occurs after a user is created.
     * It does not apply to creation of a pending registration.
     * The full user record created is available as the subject.
     */
    public static function userCreate(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `user.update` event.
     *
     * Occurs after a user is updated.
     * The full updated user record is available as the subject.
     */
    public static function userUpdate(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `user.delete` event.
     *
     * Occurs after a user is deleted from the system.
     * The full user record deleted is available as the subject.
     */
    public static function userDelete(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `group.create` event.
     *
     * Occurs after a group is created.
     * The full group record created is available as the subject.
     */
    public static function groupCreate(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `group.update` event.
     *
     * Occurs after a group is updated.
     * The full updated group record is available as the subject.
     */
    public static function groupUpdate(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `group.delete` event.
     *
     * Occurs after a group is deleted from the system.
     * The full group record deleted is available as the subject.
     */
    public static function groupDelete(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `group.adduser` event.
     *
     * Occurs after a user is added to a group.
     * It does not apply to pending membership requests.
     * The uid and gid are available as the subject.
     */
    public static function groupAddUser(Zikula_Event $event)
    {
    }

    /**
     * Listener for the `group.removeuser` event.
     *
     * Occurs after a user is removed from a group.
     * The uid and gid are available as the subject.
     */
    public static function groupRemoveUser(Zikula_Event $event)
    {
    }

    // special purposes and 3rd party api support

    /**
     * Listener for pending content items.
     */
    public static function pendingContentListener(Zikula_Event $event)
    {
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_MODERATE)) {
            return;
        }
        /** this is an example implementation from the Users module
         $approvalOrder = ModUtil::getVar('Users', 'moderation_order', UserUtil::APPROVAL_ANY);
         $filter = array('approved_by' => 0);
         if ($approvalOrder == UserUtil::APPROVAL_AFTER) {
         $filter['isverified'] = true;
         }
         $numPendingApproval = ModUtil::apiFunc('Users', 'registration', 'countAll', array('filter' => $filter));

         if (!empty($numPendingApproval)) {
         $collection = new Zikula_Collection_Container('Users');
         $collection->add(new Zikula_Provider_AggregateItem('registrations', __('Registrations pending approval'), $numPendingApproval, 'admin', 'viewRegistrations'));
         $event->getSubject()->add($collection);
         }
         */
    }
}
