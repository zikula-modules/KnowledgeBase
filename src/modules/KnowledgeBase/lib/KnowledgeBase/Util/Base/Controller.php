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
 * @version Generated by ModuleStudio 0.5.2 (http://modulestudio.de) at Thu Feb 17 15:26:09 CET 2011.
 */

/**
 * Utility base class for controller helper methods.
 */
class KnowledgeBase_Util_Base_Controller
{
    /**
     * Returns an array of all allowed object types in KnowledgeBase.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, actionHandler, block, contentType, mailz).
     * @param array  $args    Additional arguments.
     *
     * @return array List of allowed object types
     */
    public static function getObjectTypes($context = '', $args = array())
    {
        if (!in_array($context, array('controllerAction', 'api', 'actionHandler', 'block', 'contentType', 'mailz'))) {
            $context = 'controllerAction';
        }

        $allowedObjectTypes = array();
        $allowedObjectTypes[] = 'ticket';
        return $allowedObjectTypes;
    }

    /**
     * Returns the default object type in KnowledgeBase.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, actionHandler, block, contentType, mailz).
     * @param array  $args    Additional arguments.
     *
     * @return string The name of the default object type
     */
    public static function getDefaultObjectType($context = '', $args = array())
    {
        if (!in_array($context, array('controllerAction', 'api', 'actionHandler', 'block', 'contentType', 'mailz'))) {
            $context = 'controllerAction';
        }

        $defaultObjectType = 'ticket';
        return $defaultObjectType;
    }

    /**
     * Create nice permalinks
     */
    public static function formatPermalink($name)
    {
        $name = str_replace(array('ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', 'ß', '.', '?', '"', '/', ':', 'é', 'è', 'â'),
                            array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '', '', '', '-', '-', 'e', 'e', 'a'),
                            $name);
        $name = DataUtil::formatPermalink($name);
        return strtolower($name);
    }
}