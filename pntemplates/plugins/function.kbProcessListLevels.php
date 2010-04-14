<?php
/**
 * Zikula Application Framework
 *
 * @copyright (c) 2008, Zikula Development Team
 * @link http://www.zikula.org
 * @license GNU/GPL - http://www.gnu.org/copyleft/gpl.html
 * @package Zikula_Generated_Modules
 * @subpackage KnowledgeBase
 * @author Axel Guckelsberger
 * @url http://guite.de
 */

/* generated at Sun Jul 06 11:45:39 GMT 2008 by ModuleStudio 0.4.10 (http://modulestudio.de) */

/**
 * Smarty function to process hierarchical list structures by given level information
 *
 * Available parameters:
 *   - assign:  If set, the result is assigned to the corresponding variable instead of printed out
 *
 * @param        array       $params      All attributes passed to this function from the template
 * @param        object      &$smarty     Reference to the Smarty object
 * @param        string      $assign      (optional) The name of the variable to assign the result to
 * @return       string      The recent users language
 */
function smarty_function_kbProcessListLevels($params, &$render)
{
    $dom = ZLanguage::getModuleDomain('KnowledgeBase');
    if (!isset($params['level']) || !isset($params['lastlevel'])) {
        $render->trigger_error(__f('%1$s: missing parameter \'%2$s\'', array('smarty_function_kbProcessListLevels', 'lastlevel'), $dom));
    }

    $result = '';

    $level = (is_numeric($params['level'])) ? $params['level'] : count(explode('.', $params['level']));
    $lastLevel = (is_numeric($params['lastlevel'])) ? $params['lastlevel'] : count(explode('.', $params['lastlevel']));

    $opened = false;
    if ($lastLevel > 0) {
        if ($level > $lastLevel) {
            while ($level > $lastLevel) {
                $result .= '<ul>';
                $level--;
            }
            $opened = true;

        } elseif ($level < $lastLevel) {
            while ($level < $lastLevel) {
                $result .= '</li></ul>';
                $level++;
            }
        }
        if (!$opened) {
            $result .= '</li>';
        }
    }

    if (isset($assign)) {
        $smarty->assign($assign, $result);
        return;
    }

    return $result;
}
