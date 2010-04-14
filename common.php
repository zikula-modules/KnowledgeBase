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

/*
 * generated at Thu Apr 08 22:42:13 CEST 2010 by ModuleStudio 0.4.10 (http://modulestudio.de)
 */

/**
 * returns an array of all allowed object types in KnowledgeBase
 */
function KnowledgeBase_getObjectTypes()
{
    $allowedObjectTypes = array();
    $allowedObjectTypes[] = 'ticket';
    return $allowedObjectTypes;
}

/**
 * utility function for managing render templates
 */
function KnowledgeBase_processRenderTemplate(&$render, $type, $objectType, $func, $args=array())
{
    $template = DataUtil::formatForOS('KnowledgeBase_' . $type);
    if (!empty($objectType)) $template .= '_' . DataUtil::formatForOS($objectType);
    $template .= '_' . DataUtil::formatForOS($func);
    $tpl = FormUtil::getPassedValue('tpl', isset($args['tpl']) ? $args['tpl'] : '');
    if (!empty($tpl) && $render->template_exists($template . '_' . DataUtil::formatForOS($tpl) . '.htm')) {
        $template .= '_' . DataUtil::formatForOS($tpl);
    }
    $template .= '.htm';

    $raw = FormUtil::getPassedValue('raw', (isset($args['raw']) && is_bool($args['raw'])) ? $args['raw'] : false);
    if ($raw == true) {
        // standalone output
        $render->display($template);
        return true;
    }

    // normal output
    return $render->fetch($template);
}

/**
 * create nice permalinks
 */
function KnowledgeBase_createPermalink($name) {
    $name = str_replace(array('ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', 'ß', '.', '?', '"', '/'), array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '', '', '', '-'), $name);
    $name = DataUtil::formatPermalink($name);
    return strtolower($name);
}
