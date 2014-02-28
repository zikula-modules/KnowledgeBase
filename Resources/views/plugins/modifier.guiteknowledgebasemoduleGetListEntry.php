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
 * The guiteknowledgebasemoduleGetListEntry modifier displays the name
 * or names for a given list item.
 *
 * @param string $value      The dropdown value to process.
 * @param string $objectType The treated object type.
 * @param string $fieldName  The list field's name.
 * @param string $delimiter  String used as separator for multiple selections.
 *
 * @return string List item name.
 */
function smarty_modifier_guiteknowledgebasemoduleGetListEntry($value, $objectType = '', $fieldName = '', $delimiter = ', ')
{
    if (empty($value) || empty($objectType) || empty($fieldName)) {
        return $value;
    }

    $serviceManager = ServiceUtil::getManager();
    $helper = new Guite\KnowledgeBaseModule\Util\ListEntriesUtil($serviceManager, ModUtil::getModule('GuiteKnowledgeBaseModule'));

    return $helper->resolve($value, $objectType, $fieldName, $delimiter);
}