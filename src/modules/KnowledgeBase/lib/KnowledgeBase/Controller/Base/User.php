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
 * User controller class.
 */
class KnowledgeBase_Controller_Base_User extends Zikula_AbstractController
{
    /**
     * Post initialise.
     *
     * Run after construction.
     *
     * @return void
     */
    protected function postInitialize()
    {
        // Set caching to true by default.
        $this->view->setCaching(Zikula_View::CACHE_ENABLED);
    }


    /**
     * This method is the default function, and is called whenever the application's
     * User area is called without defining arguments.
     *
     * @return mixed Output.
     */
    public function main($args)
    {
// DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW));
// DEBUG: permission check aspect ends

        // return main template
        return $this->view->fetch('user/main.tpl');
    }

    /**
     * This method provides a generic item list overview.
     *
     * @param string  $ot           Treated object type.
     * @param string  $sort         Sorting field.
     * @param string  $sortdir      Sorting direction.
     * @param int     $pos          Current pager position.
     * @param int     $num          Amount of entries to display.
     * @param string  $tpl          Name of alternative template (for alternative display options, feeds and xml output)
     * @param boolean $raw          Optional way to display a template instead of fetching it (needed for standalone output)
     * @return mixed Output.
     */
    public function view($args)
    {
// DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ));
// DEBUG: permission check aspect ends

        // parameter specifying which type of objects we are treating
        $objectType = (isset($args['ot']) && !empty($args['ot'])) ? $args['ot'] : $this->request->getGet()->filter('ot', 'ticket', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'user', 'action' => 'view');
        if (!in_array($objectType, KnowledgeBase_Util_Controller::getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = KnowledgeBase_Util_Controller::getDefaultObjectType('controllerAction', $utilArgs);
        }
        $repository = $this->entityManager->getRepository('KnowledgeBase_Entity_' . ucfirst($objectType));

        $tpl = (isset($args['tpl']) && !empty($args['tpl'])) ? $args['tpl'] : $this->request->getGet()->filter('tpl', '', FILTER_SANITIZE_STRING);
        if ($tpl == 'tree') {
            $trees = ModUtil::apiFunc($this->name, 'selection', 'getAllTrees', array('ot' => $objectType));
            $this->view->assign('trees', $trees)
                       ->assign($repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));
            // fetch and return the appropriate template
            return KnowledgeBase_Util_View::processTemplate($this->view, 'user', $objectType, 'view', $args);
        }

        // parameter for used sorting field
        $sort = (isset($args['sort']) && !empty($args['sort'])) ? $args['sort'] : $this->request->getGet()->filter('sort', '', FILTER_SANITIZE_STRING);
        if (empty($sort) || !in_array($sort, $repository->getAllowedSortingFields())) {
            $sort = $repository->getDefaultSortingField();
        }

        // parameter for used sort order
        $sdir = (isset($args['sortdir']) && !empty($args['sortdir'])) ? $args['sortdir'] : $this->request->getGet()->filter('sortdir', '', FILTER_SANITIZE_STRING);
        $sdir = strtolower($sdir);
        if ($sdir != 'asc' && $sdir != 'desc') {
            $sdir = 'asc';
        }

        // convenience vars to make code clearer
        $currentUrlArgs = array('ot' => $objectType);

        $selectionArgs = array(
            'ot' => $objectType,
            'where' => '',
            'orderBy' => $sort . ' ' . $sdir
        );

        $showAllEntries = (int) (isset($args['all']) && !empty($args['all'])) ? $args['all'] : $this->request->getGet()->filter('all', 0, FILTER_VALIDATE_INT);
        $this->view->assign('showAllEntries', $showAllEntries);
        if ($showAllEntries == 1) {
            // item list without pagination
            $entities = ModUtil::apiFunc($this->name, 'selection', 'getEntities', $selectionArgs);
            $objectCount = count($entities);
            $currentUrlArgs['all'] = 1;
        } else {
            // item list with pagination

            // the current offset which is used to calculate the pagination
            $currentPage = (int) (isset($args['pos']) && !empty($args['pos'])) ? $args['pos'] : $this->request->getGet()->filter('pos', 1, FILTER_VALIDATE_INT);

            // the number of items displayed on a page for pagination
            $resultsPerPage = (int) (isset($args['num']) && !empty($args['num'])) ? $args['num'] : $this->request->getGet()->filter('num', 0, FILTER_VALIDATE_INT);
            if ($resultsPerPage == 0) {
                $csv = (int) (isset($args['usecsv']) && !empty($args['usecsv'])) ? $args['usecsv'] : $this->request->getGet()->filter('usecsvext', 0, FILTER_VALIDATE_INT);
                $resultsPerPage = ($csv == 1) ? 999999 : $this->getVar('pagesize', 10);
            }

            $selectionArgs['currentPage'] = $currentPage;
            $selectionArgs['resultsPerPage'] = $resultsPerPage;
            list($entities, $objectCount) = ModUtil::apiFunc($this->name, 'selection', 'getEntitiesPaginated', $selectionArgs);

            $this->view->assign('currentPage', $currentPage)
                       ->assign('pager', array('numitems'     => $objectCount,
                                               'itemsperpage' => $resultsPerPage));
        }

        // build ModUrl instance for display hooks
        $currentUrlObject = new Zikula_ModUrl($this->name, 'user', 'view', ZLanguage::getLanguageCode(), $currentUrlArgs);

        // assign the object data, sorting information and details for creating the pager
        $this->view->assign('items', $entities)
                   ->assign('sort', $sort)
                   ->assign('sdir', $sdir)
                   ->assign('currentUrlObject', $currentUrlObject)
                   ->assign($repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));

        // fetch and return the appropriate template
        return KnowledgeBase_Util_View::processTemplate($this->view, 'user', $objectType, 'view', $args);
    }

    /**
     * This method provides a generic item detail view.
     *
     * @param string  $ot           Treated object type.
     * @param string  $tpl          Name of alternative template (for alternative display options, feeds and xml output)
     * @param boolean $raw          Optional way to display a template instead of fetching it (needed for standalone output)
     * @return mixed Output.
     */
    public function display($args)
    {
// DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ));
// DEBUG: permission check aspect ends

        // parameter specifying which type of objects we are treating
        $objectType = (isset($args['ot']) && !empty($args['ot'])) ? $args['ot'] : $this->request->getGet()->filter('ot', 'ticket', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'user', 'action' => 'display');
        if (!in_array($objectType, KnowledgeBase_Util_Controller::getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = KnowledgeBase_Util_Controller::getDefaultObjectType('controllerAction', $utilArgs);
        }
        $repository = $this->entityManager->getRepository('KnowledgeBase_Entity_' . ucfirst($objectType));

        $idFields = ModUtil::apiFunc($this->name, 'selection', 'getIdFields', array('ot' => $objectType));

        // retrieve identifier of the object we wish to view
        $idValues = KnowledgeBase_Util_Controller::retrieveIdentifier($this->request, $args, $objectType, $idFields);
        $hasIdentifier = KnowledgeBase_Util_Controller::isValidIdentifier($idValues);

        // check for unique permalinks (without id)
        $hasSlug = false;
        $slugTitle = '';
        if ($hasIdentifier === false) {
            $entityClass = 'KnowledgeBase_Entity_' . ucfirst($objectType);
            $objectTemp = new $entityClass();
            $hasSlug = $objectTemp->get_hasUniqueSlug();
            if ($hasSlug) {
                $slugTitle = (isset($args['title']) && !empty($args['title'])) ? $args['title'] : $this->request->getGet()->filter('title', '', FILTER_SANITIZE_STRING);
                $hasSlug = (!empty($slugTitle));
            }
        }
        $hasIdentifier |= $hasSlug;
        $this->throwNotFoundUnless($hasIdentifier, $this->__('Error! Invalid identifier received.'));

        $entity = ModUtil::apiFunc($this->name, 'selection', 'getEntity', array('ot' => $objectType, 'id' => $idValues, 'slug' => $slugTitle));
        $this->throwNotFoundUnless($entity != null, $this->__('No such item.'));

        // increase amount of views
        ModUtil::apiFunc($this->name, 'manual', 'incrementViews', array('id' => $id));

        // build ModUrl instance for display hooks
        $currentUrlArgs = array('ot' => $objectType);
        foreach ($idFields as $idField) {
            $currentUrlArgs[$idField] = $idValues[$idField];
        }
        $currentUrlObject = new Zikula_ModUrl($this->name, 'user', 'display', ZLanguage::getLanguageCode(), $currentUrlArgs);

        // assign output data to view object.
        $this->view->assign($objectType, $entity)
                   ->assign('currentUrlObject', $currentUrlObject)
                   ->assign($repository->getAdditionalTemplateParameters('controllerAction', $utilArgs));

        // fetch and return the appropriate template
        return KnowledgeBase_Util_View::processTemplate($this->view, 'user', $objectType, 'display', $args);
    }

    /**
     * This method provides a generic handling of all edit requests.
     *
     * @param string  $ot           Treated object type.
     * @param string  $tpl          Name of alternative template (for alternative display options, feeds and xml output)
     * @param boolean $raw          Optional way to display a template instead of fetching it (needed for standalone output)
     * @return mixed Output.
     */
    public function edit($args)
    {
// DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_EDIT));
// DEBUG: permission check aspect ends

        // parameter specifying which type of objects we are treating
        $objectType = (isset($args['ot']) && !empty($args['ot'])) ? $args['ot'] : $this->request->getGet()->filter('ot', 'ticket', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'user', 'action' => 'edit');
        if (!in_array($objectType, KnowledgeBase_Util_Controller::getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = KnowledgeBase_Util_Controller::getDefaultObjectType('controllerAction', $utilArgs);
        }

        // create new Form reference
        $view = FormUtil::newForm($this->name, $this);

        // build form handler class name
        $handlerClass = 'KnowledgeBase_Form_Handler_User_' . ucfirst($objectType) . '_Edit';

        // execute form using supplied template and page event handler
        return $view->execute('user/' . $objectType . '/edit.tpl', new $handlerClass());
    }

    /**
     * This is a custom method. Documentation for this will be improved in later versions.
     *
     * @return mixed Output.
     */
    public function assign($args)
    {
// DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW));
// DEBUG: permission check aspect ends

        // parameter specifying which type of objects we are treating
        $objectType = (isset($args['ot']) && !empty($args['ot'])) ? $args['ot'] : $this->request->getGet()->filter('ot', 'ticket', FILTER_SANITIZE_STRING);
        $utilArgs = array('controller' => 'user', 'action' => 'assign');
        if (!in_array($objectType, KnowledgeBase_Util_Controller::getObjectTypes('controllerAction', $utilArgs))) {
            $objectType = KnowledgeBase_Util_Controller::getDefaultObjectType('controllerAction', $utilArgs);
        }
        /** TODO: custom logic */

        // return template
        return $this->view->fetch('user/assign.tpl');
    }

    /**
     * This method cares for a redirect within an inline frame.
     */
    public function handleInlineRedirect()
    {
        $itemId = (int) $this->request->getGet()->filter('id', 0, FILTER_VALIDATE_INT);
        $idPrefix = $this->request->getGet()->filter('idp', '', FILTER_SANITIZE_STRING);
        $commandName = $this->request->getGet()->filter('com', '', FILTER_SANITIZE_STRING);
        if (empty($idPrefix)) {
            return false;
        }

        $this->view->assign('itemId', $itemId)
                   ->assign('idPrefix', $idPrefix)
                   ->assign('commandName', $commandName)
                   ->assign('jcssConfig', JCSSUtil::getJSConfig())
                   ->display('user/inlineRedirectHandler.tpl');
        return true;
    }
}
