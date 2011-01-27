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
 * @version Generated by ModuleStudio 0.5.2 (http://modulestudio.de) at Thu Jan 27 15:07:46 CET 2011.
 */

/**
 * Installer base class
 */
class KnowledgeBase_Base_Installer extends Zikula_Installer
{
    /**
     * Install the KnowledgeBase application.
     *
     * @return boolean True on success, or false.
     */
    public function install()
    {
        // create all tables from according model definitions
        try {
            DoctrineUtil::createTablesFromModels('KnowledgeBase');
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while creating the tables for the %1$s module.', array($this->getName())));
        }



        // Register persistent event handlers
        $this->registerPersistentEventHandlers();

        // register hook subscriber bundles
        HookUtil::registerHookSubscriberBundles($this->version);


        // create the default data for KnowledgeBase
        //$this->defaultdata();
        // TODO: deactivated for now because constraints prevent data creation in random order (see #64)

        // Initialisation successful
        return true;
    }

    /**
     * Upgrade the KnowledgeBase application from an older version.
     *
     * If the upgrade fails at some point, it returns the last upgraded version.
     *
     * @param integer $oldversion Version to upgrade from.
     *
     * @return boolean True on success, false otherwise.
     */
    public function upgrade($oldversion)
    {
    /*
        // Upgrade dependent on old version number
        switch ($oldversion) {
            case 1.0:
                // do something
                // DoctrineUtil::*() for adding/dropping columns/index and so on
                // last do DoctrineUtil::createTablesFromModels('KnowledgeBase');
                // to create any new tables
        }
    */


        // Update successful
        return true;
    }

    /**
     * Uninstall KnowledgeBase.
     *
     * @return boolean True on success, false otherwise.
     */
    public function uninstall()
    {
        try {
            $dbPrefix = System::getVar('prefix');

        $dbTables = DBUtil::getTables();
        // remove categorisable behavior data
        $table  = $dbTables['categories_mapobj'];
        $column = $dbTables['categories_mapobj_column'];
        $sql = 'DELETE FROM ' . $table . ' WHERE ' . $column['modname'] . ' = \'KnowledgeBase\' AND ' . $column['table'] . ' = \'kbase_ticket\'';
        $res = DBUtil::executeSQL($sql);

            // remove tables
            DoctrineUtil::dropIndex('kbase_ticket', $dbPrefix . '_kbase_ticket_sluggable');
            DoctrineUtil::dropTable('kbase_ticket');
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while dropping the tables for the %1$s module.', array($this->getName())));
        }


        // Unregister persistent event handlers
        $this->unregisterPersistentEventHandlers();


        // Deletion successful
        return true;
    }

    /**
     * Create the default data for KnowledgeBase.
     *
     * @return void
     */
    public function defaultdata()
    {
        // ensure that tables are cleared
        Doctrine_Core::getTable('KnowledgeBase_Model_Ticket')
            ->truncateTable();
        unset($doctrine);

        // TODO: test this, see http://code.zikula.org/generator/ticket/64
        //Doctrine_Parser::load('modules/KnowledgeBase/docs/exampleData.yml', 'yml');

        // Insertion successful
        return true;
    }

    /**
     * Register persistent event handlers.
     * These are listeners for external events of the core and other modules.
     */
    private function registerPersistentEventHandlers()
    {
        // core
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'api.method_not_found', array('KnowledgeBase_Listeners', 'coreApiMethodNotFound'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'core.preinit', array('KnowledgeBase_Listeners', 'corePreInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'core.init', array('KnowledgeBase_Listeners', 'coreInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'core.postinit', array('KnowledgeBase_Listeners', 'corePostInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'controller.method_not_found', array('KnowledgeBase_Listeners', 'coreControllerMethodNotFound'));

        // modules
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'installer.module.installed', array('KnowledgeBase_Listeners', 'installerModuleInstalled'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'installer.module.upgraded', array('KnowledgeBase_Listeners', 'installerModuleUpgraded'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'installer.module.uninstalled', array('KnowledgeBase_Listeners', 'installerModuleUninstalled'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.postloadgeneric', array('KnowledgeBase_Listeners', 'moduleDispatchPostLoadGeneric'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.preexecute', array('KnowledgeBase_Listeners', 'moduleDispatchPreExecute'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.postexecute', array('KnowledgeBase_Listeners', 'moduleDispatchPostExecute'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.custom_classname', array('KnowledgeBase_Listeners', 'moduleDispatchCustomClassname'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.mailer.api.sendmessage', array('KnowledgeBase_Listeners', 'moduleMailerApiSendmessage'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'pageutil.addvar_filter', array('KnowledgeBase_Listeners', 'pageutilAddvarFilter'));

        // errors
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'setup.errorreporting', array('KnowledgeBase_Listeners', 'setupErrorReporting'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'system.outputfilter', array('KnowledgeBase_Listeners', 'systemOutputfilter'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'systemerror', array('KnowledgeBase_Listeners', 'systemError'));

        // themes and views
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.init', array('KnowledgeBase_Listeners', 'themeInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.load_config', array('KnowledgeBase_Listeners', 'themeLoadConfig'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.prefooter', array('KnowledgeBase_Listeners', 'themePrefooter'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'view.init', array('KnowledgeBase_Listeners', 'viewInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'view.fetch', array('KnowledgeBase_Listeners', 'viewFetch'));

        // users and groups
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.login', array('KnowledgeBase_Listeners', 'userLogin'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.login.failed', array('KnowledgeBase_Listeners', 'userLoginFailed'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.logout', array('KnowledgeBase_Listeners', 'userLogout'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.logout.failed', array('KnowledgeBase_Listeners', 'userLogoutFailed'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.gettheme', array('KnowledgeBase_Listeners', 'userGetTheme'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.create', array('KnowledgeBase_Listeners', 'userCreate'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.update', array('KnowledgeBase_Listeners', 'userUpdate'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.delete', array('KnowledgeBase_Listeners', 'userDelete'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.create', array('KnowledgeBase_Listeners', 'groupCreate'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.update', array('KnowledgeBase_Listeners', 'groupUpdate'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.delete', array('KnowledgeBase_Listeners', 'groupDelete'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.adduser', array('KnowledgeBase_Listeners', 'groupAddUser'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.removeuser', array('KnowledgeBase_Listeners', 'groupRemoveUser'));

        // special purposes and 3rd party api support
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'get.pending_content', array('KnowledgeBase_Listeners', 'pendingContentListener'));
    }

    /**
     * Unregister persistent event handlers.
     * These are listeners for external events of the core and other modules.
     */
    private function unregisterPersistentEventHandlers()
    {
        // core
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'api.method_not_found', array('KnowledgeBase_Listeners', 'coreApiMethodNotFound'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'core.preinit', array('KnowledgeBase_Listeners', 'corePreInit'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'core.init', array('KnowledgeBase_Listeners', 'coreInit'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'core.postinit', array('KnowledgeBase_Listeners', 'corePostInit'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'controller.method_not_found', array('KnowledgeBase_Listeners', 'coreControllerMethodNotFound'));

        // modules
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'installer.module.installed', array('KnowledgeBase_Listeners', 'installerModuleInstalled'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'installer.module.upgraded', array('KnowledgeBase_Listeners', 'installerModuleUpgraded'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'installer.module.uninstalled', array('KnowledgeBase_Listeners', 'installerModuleUninstalled'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'module_dispatch.postloadgeneric', array('KnowledgeBase_Listeners', 'moduleDispatchPostLoadGeneric'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'module_dispatch.preexecute', array('KnowledgeBase_Listeners', 'moduleDispatchPreExecute'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'module_dispatch.postexecute', array('KnowledgeBase_Listeners', 'moduleDispatchPostExecute'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'module_dispatch.custom_classname', array('KnowledgeBase_Listeners', 'moduleDispatchCustomClassname'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'module.mailer.api.sendmessage', array('KnowledgeBase_Listeners', 'moduleMailerApiSendmessage'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'pageutil.addvar_filter', array('KnowledgeBase_Listeners', 'pageutilAddvarFilter'));

        // errors
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'setup.errorreporting', array('KnowledgeBase_Listeners', 'setupErrorReporting'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'system.outputfilter', array('KnowledgeBase_Listeners', 'systemOutputfilter'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'systemerror', array('KnowledgeBase_Listeners', 'systemError'));

        // themes and views
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'theme.init', array('KnowledgeBase_Listeners', 'themeInit'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'theme.load_config', array('KnowledgeBase_Listeners', 'themeLoadConfig'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'theme.prefooter', array('KnowledgeBase_Listeners', 'themePrefooter'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'view.init', array('KnowledgeBase_Listeners', 'viewInit'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'view.fetch', array('KnowledgeBase_Listeners', 'viewFetch'));

        // users and groups
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.login', array('KnowledgeBase_Listeners', 'userLogin'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.login.failed', array('KnowledgeBase_Listeners', 'userLoginFailed'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.logout', array('KnowledgeBase_Listeners', 'userLogout'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.logout.failed', array('KnowledgeBase_Listeners', 'userLogoutFailed'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.gettheme', array('KnowledgeBase_Listeners', 'userGetTheme'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.create', array('KnowledgeBase_Listeners', 'userCreate'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.update', array('KnowledgeBase_Listeners', 'userUpdate'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'user.delete', array('KnowledgeBase_Listeners', 'userDelete'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'group.create', array('KnowledgeBase_Listeners', 'groupCreate'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'group.update', array('KnowledgeBase_Listeners', 'groupUpdate'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'group.delete', array('KnowledgeBase_Listeners', 'groupDelete'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'group.adduser', array('KnowledgeBase_Listeners', 'groupAddUser'));
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'group.removeuser', array('KnowledgeBase_Listeners', 'groupRemoveUser'));

        // special purposes and 3rd party api support
        EventUtil::unregisterPersistentModuleHandler('KnowledgeBase', 'get.pending_content', array('KnowledgeBase_Listeners', 'pendingContentListener'));
    }
}