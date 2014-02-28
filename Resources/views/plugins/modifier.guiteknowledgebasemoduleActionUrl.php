<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger (Guite)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Axel Guckelsberger <info@guite.de>.
 * @link https://guite.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.6.1 (http://modulestudio.de).
 */

/**
 * The guiteknowledgebasemoduleActionUrl modifier creates the URL for a given action.
 *
 * @param string $urlType      The url type (admin, user, etc.)
 * @param string $urlFunc      The url func (view, display, edit, etc.)
 * @param array  $urlArguments The argument array containing ids and other additional parameters
 *
 * @return string Desired url in encoded form.
 */
function smarty_modifier_guiteknowledgebasemoduleActionUrl($urlType, $urlFunc, $urlArguments)
{
    return DataUtil::formatForDisplay(ModUtil::url('GuiteKnowledgeBaseModule', $urlType, $urlFunc, $urlArguments));
}