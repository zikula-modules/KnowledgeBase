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
 * This is the Ajax controller class providing navigation and interaction functionality.
 */
class KnowledgeBase_Controller_Base_Ajax extends Zikula_Controller
{
    public function _postSetup()
    {
        // no need for a view so override it.
    }


    /**
     * This is a custom method. Documentation for this will be improved in later versions.
     *
     * @params       TODO
     * @return mixed Output.
     */
    public function search($args)
    {
// DEBUG: permission check aspect starts
        $this->throwForbiddenUnless(SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_OVERVIEW));
// DEBUG: permission check aspect ends

        // parameter specifying which type of objects we are treating
        $objectType = FormUtil::getPassedValue('ot', 'ticket', 'GET');
        if (!in_array($objectType, KnowledgeBase_Util::getObjectTypes('controllerAction', array('controller' => 'ajax', 'action' => 'Search')))) {
            $objectType = KnowledgeBase_Util::getDefaultObjectType('controllerAction', array('controller' => 'ajax', 'action' => 'Search'));
        }
        /** TODO: custom logic */
    }


}
