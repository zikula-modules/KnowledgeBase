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
 * The knowledgebaseSelectorObjectTypes plugin provides items for a dropdown selector.
 *
 * Available parameters:
 *   - assign:   If set, the results are assigned to the corresponding variable instead of printed out.
 *
 * @param  array     $params  All attributes passed to this function from the template.
 * @param  Zikula_Form_View $view    Reference to the view object.
 *
 * @return string The output of the plugin.
 */
function smarty_function_knowledgebaseSelectorObjectTypes($params, $view)
{
    $result = array();

    $result[] = array('text' => $view->__('Tickets'), 'value' => 'ticket');

    if (array_key_exists('assign', $params)) {
        $view->assign($params['assign'], $result);
        return;
    }
    return $result;
}
