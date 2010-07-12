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

/**
 * The knowledgebaseFormFrame plugin adds styling <div> elements and a validation summary.
 *
 * Available parameters:
 *   - assign:   If set, the results are assigned to the corresponding variable instead of printed out
 *
 * @param        array       $params       All attributes passed to this function from the template
 * @param        string      $content      The content of the block
 * @param        object      &$render     Reference to the Smarty object
 * @return       string      The output of the plugin
 */
function smarty_block_knowledgebaseFormFrame($params, $content, &$render)
{
    // As with all pnForms plugins, we must remember to register our plugin.
    // In this case we also register a validation summary so we don't have to
    // do that explicitively in the templates.

    // We need to concatenate the output of boths plugins.
    $result = $render->registerPlugin('Form_Plugin_ValidationSummary', $params);
    $result .= $render->registerBlock('KnowledgeBase_Form_Plugin_Frame', $params, $content);

    return $result;
}
