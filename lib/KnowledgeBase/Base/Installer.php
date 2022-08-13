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
 * Installer base class
 */
class KnowledgeBase_Base_Installer extends Zikula_AbstractInstaller
{
    /**
     * Install the KnowledgeBase application.
     *
     * @return boolean True on success, or false.
     */
    public function install()
    {
        // create all tables from according entity definitions
        try {
            DoctrineHelper::createSchema($this->entityManager, $this->listEntityClasses());
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while creating the tables for the %s module.', array($this->getName())));
        }

        // create the default data for KnowledgeBase
        $this->createDefaultData();

        // add entries to category registry
        $rootcat = CategoryUtil::getCategoryByPath('/__SYSTEM__/Modules/Global');
        CategoryRegistryUtil::insertEntry('KnowledgeBase', 'Ticket', 'Main', $rootcat['id']);

        // register persistent event handlers
        $this->registerPersistentEventHandlers();

        // register hook subscriber bundles
        HookUtil::registerSubscriberBundles($this->version->getHookSubscriberBundles());


        // initialisation successful
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
            case 1.0.0:
                // do something
                // ...
                // update the database schema
                try {
                    DoctrineHelper::updateSchema($this->entityManager, $this->listEntityClasses());
                } catch (Exception $e) {
                    if (System::isDevelopmentMode()) {
                        LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
                    }
                    return LogUtil::registerError($this->__f('An error was encountered while dropping the tables for the %s module.', array($this->getName())));
                }
        }
    */

        // update successful
        return true;
    }

    /**
     * Uninstall KnowledgeBase.
     *
     * @return boolean True on success, false otherwise.
     */
    public function uninstall()
    {
        // delete stored object workflows
        $result = Zikula_Workflow_Util::deleteWorkflowsForModule($this->getName());
        if ($result === false) {
            return LogUtil::registerError($this->__f('An error was encountered while removing stored object workflows for the %s module.', array($this->getName())));
        }

        try {
            DoctrineHelper::dropSchema($this->entityManager, $this->listEntityClasses());
        } catch (Exception $e) {
            if (System::isDevelopmentMode()) {
                LogUtil::registerError($this->__('Doctrine Exception: ') . $e->getMessage());
            }
            return LogUtil::registerError($this->__f('An error was encountered while dropping the tables for the %s module.', array($this->getName())));
        }

        // unregister persistent event handlers
        EventUtil::unregisterPersistentModuleHandlers('KnowledgeBase');

        // unregister hook subscriber bundles
        HookUtil::unregisterSubscriberBundles($this->version->getHookSubscriberBundles());


        // remove category registry entries
        ModUtil::dbInfoLoad('Categories');
        DBUtil::deleteWhere('categories_registry', "modname = 'KnowledgeBase'");

        // deletion successful
        return true;
    }

    /**
     * Build array with all entity classes for KnowledgeBase.
     *
     * @return array list of class names.
     */
    protected function listEntityClasses()
    {
        $classNames = array();
        $classNames[] = 'KnowledgeBase_Entity_Ticket';
        $classNames[] = 'KnowledgeBase_Entity_TicketCategory';

        return $classNames;
    }
    /**
     * Create the default data for KnowledgeBase.
     *
     * @return void
     */
    protected function createDefaultData()
    {
        // Ensure that tables are cleared
        $this->entityManager->transactional(function($entityManager) {
            $entityManager->getRepository('KnowledgeBase_Entity_Ticket')->truncateTable();


            $ticket1 = new KnowledgeBase_Entity_Ticket();
            $ticket2 = new KnowledgeBase_Entity_Ticket();
            $ticket3 = new KnowledgeBase_Entity_Ticket();
            $ticket4 = new KnowledgeBase_Entity_Ticket();
            $ticket5 = new KnowledgeBase_Entity_Ticket();

            $ticket1->setSubject('Ticket subject 1');
            $ticket1->setContent('Ticket content 1');
            $ticket1->setViews(1);
            $ticket1->setRatesUp(1);
            $ticket1->setRatesDown(1);
            $ticket2->setSubject('Ticket subject 2');
            $ticket2->setContent('Ticket content 2');
            $ticket2->setViews(2);
            $ticket2->setRatesUp(2);
            $ticket2->setRatesDown(2);
            $ticket3->setSubject('Ticket subject 3');
            $ticket3->setContent('Ticket content 3');
            $ticket3->setViews(3);
            $ticket3->setRatesUp(3);
            $ticket3->setRatesDown(3);
            $ticket4->setSubject('Ticket subject 4');
            $ticket4->setContent('Ticket content 4');
            $ticket4->setViews(4);
            $ticket4->setRatesUp(4);
            $ticket4->setRatesDown(4);
            $ticket5->setSubject('Ticket subject 5');
            $ticket5->setContent('Ticket content 5');
            $ticket5->setViews(5);
            $ticket5->setRatesUp(5);
            $ticket5->setRatesDown(5);

            $entityManager->persist($ticket1);
            $entityManager->persist($ticket2);
            $entityManager->persist($ticket3);
            $entityManager->persist($ticket4);
            $entityManager->persist($ticket5);
        });

        // Insertion successful
        return true;
    }

    /**
     * Register persistent event handlers.
     * These are listeners for external events of the core and other modules.
     */
    protected function registerPersistentEventHandlers()
    {
        // core
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'api.method_not_found', array('KnowledgeBase_Listener_Core', 'apiMethodNotFound'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'core.preinit', array('KnowledgeBase_Listener_Core', 'preInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'core.init', array('KnowledgeBase_Listener_Core', 'init'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'core.postinit', array('KnowledgeBase_Listener_Core', 'postInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'controller.method_not_found', array('KnowledgeBase_Listener_Core', 'controllerMethodNotFound'));

        // installer
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'installer.module.installed', array('KnowledgeBase_Listener_Installer', 'moduleInstalled'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'installer.module.upgraded', array('KnowledgeBase_Listener_Installer', 'moduleUpgraded'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'installer.module.uninstalled', array('KnowledgeBase_Listener_Installer', 'moduleUninstalled'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'installer.subscriberarea.uninstalled', array('KnowledgeBase_Listener_Installer', 'subscriberAreaUninstalled'));

        // modules
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.postloadgeneric', array('KnowledgeBase_Listener_ModuleDispatch', 'postLoadGeneric'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.preexecute', array('KnowledgeBase_Listener_ModuleDispatch', 'preExecute'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.postexecute', array('KnowledgeBase_Listener_ModuleDispatch', 'postExecute'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module_dispatch.custom_classname', array('KnowledgeBase_Listener_ModuleDispatch', 'customClassname'));

        // mailer
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.mailer.api.sendmessage', array('KnowledgeBase_Listener_Mailer', 'sendMessage'));

        // page
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'pageutil.addvar_filter', array('KnowledgeBase_Listener_Page', 'pageutilAddvarFilter'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'system.outputfilter', array('KnowledgeBase_Listener_Page', 'systemOutputfilter'));

        // errors
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'setup.errorreporting', array('KnowledgeBase_Listener_Errors', 'setupErrorReporting'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'systemerror', array('KnowledgeBase_Listener_Errors', 'systemError'));

        // theme
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.preinit', array('KnowledgeBase_Listener_Theme', 'preInit'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.init', array('KnowledgeBase_Listener_Theme', 'init'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.load_config', array('KnowledgeBase_Listener_Theme', 'loadConfig'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.prefetch', array('KnowledgeBase_Listener_Theme', 'preFetch'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'theme.postfetch', array('KnowledgeBase_Listener_Theme', 'postFetch'));

        // view
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'view.init', array('KnowledgeBase_Listener_View', 'init'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'view.postfetch', array('KnowledgeBase_Listener_View', 'postFetch'));

        // user login
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.login.started', array('KnowledgeBase_Listener_UserLogin', 'started'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.login.veto', array('KnowledgeBase_Listener_UserLogin', 'veto'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.login.succeeded', array('KnowledgeBase_Listener_UserLogin', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.login.failed', array('KnowledgeBase_Listener_UserLogin', 'failed'));

        // user logout
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.logout.succeeded', array('KnowledgeBase_Listener_UserLogout', 'succeeded'));

        // user
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.gettheme', array('KnowledgeBase_Listener_User', 'getTheme'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.account.create', array('KnowledgeBase_Listener_User', 'create'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.account.update', array('KnowledgeBase_Listener_User', 'update'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.account.delete', array('KnowledgeBase_Listener_User', 'delete'));

        // registration
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.registration.started', array('KnowledgeBase_Listener_UserRegistration', 'started'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.registration.succeeded', array('KnowledgeBase_Listener_UserRegistration', 'succeeded'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.ui.registration.failed', array('KnowledgeBase_Listener_UserRegistration', 'failed'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.registration.create', array('KnowledgeBase_Listener_UserRegistration', 'create'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.registration.update', array('KnowledgeBase_Listener_UserRegistration', 'update'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'user.registration.delete', array('KnowledgeBase_Listener_UserRegistration', 'delete'));

        // users module
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.users.config.updated', array('KnowledgeBase_Listener_Users', 'configUpdated'));

        // group
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.create', array('KnowledgeBase_Listener_Group', 'create'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.update', array('KnowledgeBase_Listener_Group', 'update'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.delete', array('KnowledgeBase_Listener_Group', 'delete'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.adduser', array('KnowledgeBase_Listener_Group', 'addUser'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'group.removeuser', array('KnowledgeBase_Listener_Group', 'removeUser'));

        // special purposes and 3rd party api support
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'get.pending_content', array('KnowledgeBase_Listener_ThirdParty', 'pendingContentListener'));
        EventUtil::registerPersistentModuleHandler('KnowledgeBase', 'module.content.gettypes', array('KnowledgeBase_Listener_ThirdParty', 'contentGetTypes'));
    }
}