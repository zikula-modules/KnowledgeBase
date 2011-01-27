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
 * Business entity factory base class
 */
class KnowledgeBase_Base_Factory
{
    /**
     * Returns a business entity or a business collection object according given parameters.
     *
     * @param boolean $useCollection Whether to return a business or an entity class instance.
     * @param string  $objectType    Name of treated entity type.
     * @param string  $context       Usage context (allowed values: controllerAction, block, contentType, mailz).
     * @param array   $args          Additional arguments, for example array('controller' => 'admin', 'action' => 'view');.
     *
     * @return mixed Business entity or collection class instance.
     */
    public static function getBusinessObjectCommon($useCollection = false, $objectType = 'ticket', $context = '', $args = array())
    {
        if (!in_array($context, array('controllerAction', 'actionHandler', 'block', 'contentType', 'mailz'))) {
            $context = 'controllerAction';
        }
        if (!in_array($objectType, KnowledgeBase_Util::getObjectTypes($context, $args))) {
            $objectType = KnowledgeBase_Util::getDefaultObjectType($context, $args);
        }

        $class = 'KnowledgeBase_BusinessEntity_' . ucfirst($objectType) . (($useCollection === true) ? 'Collection' : '');
        return new $class();
    }

    /**
     * Returns a business entity object according given parameters.
     *
     * @param string  $objectType     Name of treated entity type.
     * @param string  $context        Usage context (allowed values: controllerAction, actionHandler, block, contentType, mailz).
     * @param boolean $useCollection  Whether to return a business or an entity class instance.
     * @param array   $args           Additional arguments, for example array('controller' => 'admin', 'action' => 'view');.
     *
     * @return mixed Business entity class instance.
     */
    public static function getBusinessEntity($objectType = 'ticket', $context = '', $useCollection = false, $args = array())
    {
        return self::getBusinessObjectCommon(false, $objectType, $context, $args);
    }

    /**
     * Returns a business collection object according given parameters.
     *
     * @param string  $objectType     Name of treated entity type.
     * @param string  $context        Usage context (allowed values: controllerAction, actionHandler, block, contentType, mailz).
     * @param boolean $useCollection  Whether to return a business or an entity class instance.
     * @param array   $args           Additional arguments, for example array('controller' => 'admin', 'action' => 'view');.
     *
     * @return mixed Business entity class instance.
     */
    public static function getBusinessCollection($objectType = 'ticket', $context = '', $args = array())
    {
        return self::getBusinessObjectCommon(true, $objectType, $context, $args);
    }
}
