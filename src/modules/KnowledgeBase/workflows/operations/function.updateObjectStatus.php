<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package KnowledgeBase
 * @author Axel Guckelsberger <info@guite.de>.
 * @link https://guite.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Wed Jan 04 20:13:48 CET 2012.
 */

/**
 * Operation method for amendments of the status field.
 *
 * @param array $obj
 * @param array, $params
 *
 * @return bool
 */
function KnowledgeBase_operation_updateObjectStatus(&$obj, $params)
{
    // get attributes read from the workflow
    $objectType = isset($params['ot']) ? $params['ot'] : 'item'; /** TODO required? */
    $status = isset($params['status']) ? $params['status'] : 1;

    // assign value to the data object
    $obj['status'] = $status;

    /** TODO */
    //return {UPDATE}
    return true;
}
