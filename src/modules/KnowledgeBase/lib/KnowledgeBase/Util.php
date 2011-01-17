<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2009, Zikula Development Team
 * @link http://www.zikula.org
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_Generated_Modules
 * @subpackage KnowledgeBase
 * @author Axel Guckelsberger
 * @url https://guite.de
 */

class KnowledgeBase_Util
{
    /**
     * returns an array of all allowed object types in KnowledgeBase
     */
    public static function getObjectTypes()
    {
        $allowedObjectTypes = array();
        $allowedObjectTypes[] = 'ticket';
        return $allowedObjectTypes;
    }

    /**
     * utility function for managing render templates
     */
    public static function processRenderTemplate($view, $type, $objectType, $func, $args=array())
    {
        $template = DataUtil::formatForOS('KnowledgeBase_' . $type);
        if (!empty($objectType)) $template .= '_' . DataUtil::formatForOS(strtolower($objectType));
        $template .= '_' . DataUtil::formatForOS($func);
        $tpl = FormUtil::getPassedValue('tpl', isset($args['tpl']) ? $args['tpl'] : '');
        if (!empty($tpl) && $view->template_exists($template . '_' . DataUtil::formatForOS($tpl) . '.tpl')) {
            $template .= '_' . DataUtil::formatForOS($tpl);
        }
        $template .= '.tpl';

        $raw = FormUtil::getPassedValue('raw', (isset($args['raw']) && is_bool($args['raw'])) ? $args['raw'] : false);
        if ($raw == true) {
            // standalone output
            $view->display($template);
            return true;
        }

        // normal output
        return $view->fetch($template);
    }

    /**
     * create nice permalinks
     */
    public static function createPermalink($name) {
        $name = str_replace(array('ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', 'ß', '.', '?', '"', '/'), array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '', '', '', '-'), $name);
        $name = DataUtil::formatPermalink($name);
        return strtolower($name);
    }
}