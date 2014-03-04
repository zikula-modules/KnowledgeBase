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
 * Breadcrumb navigation for KnowledgeBase module
 *
 * @param  array            $params All attributes passed to this function from the template.
 * @param  Zikula_Form_View $view   Reference to the view object.
 *
 * @return string Output of the plugin.
 */
function smarty_function_kbbreadcrumb($params, &$view)
{
    $currentFunc = FormUtil::getPassedValue('func', 'main', 'GET');

    $separator = ' &raquo; ';

    $result = '<ol class="breadcrumb">' . "\n";
    if ($currentFunc != 'main') {
        $result = '<li><a href="' . DataUtil::formatForDisplay(ModUtil::url('GuiteKnowledgeBaseModule', 'user', 'main')) . '" title="' . $view->__('Knowledge Base') . '">' . $view->__('Knowledge Base') . '</a></li>';
    } else {
        $result = $view->__('Knowledge Base');
    }

    $ticketID = (int) FormUtil::getPassedValue('id', 0, 'GET');
    $objectData = null;

    if ($currentFunc != 'view' && ($currentFunc != 'display' || $ticketID == 0)) {
        return $result;
    }

    $currentCat = 0;
    if ($currentFunc == 'view') {
        $currentCat = FormUtil::getPassedValue('cat', 0, 'GET');
    }
    elseif ($currentFunc == 'display') {
        $entity = ModUtil::apiFunc('GuiteKnowledgeBaseModule', 'selection', 'getEntity', array('ot' => 'ticket', 'id' => $ticketID));
        if (is_object($entity) && isset($entity['Categories'])) {
            $currentCat = $entity['Categories']['TicketCategoryMain']['id'];
        }
    }

    if ($currentCat > 0) {
        $cats = ModUtil::apiFunc('GuiteKnowledgeBaseModule', 'user', 'getCategories', array('full' => true));
        $lang = ZLanguage::getLanguageCode();
        foreach ($cats as $cat) {
            if ($cat['id'] != $currentCat) {
                continue;
            }

            // save current cat information because we have to check the parents first
            $resultTmp = $separator;
            $catName = $cat['name'];
            if (isset($cat['display_name'][$lang])) {
                $catName = $cat['display_name'][$lang];
            }
            $resultTmp .= '<li><a href="' . $cat['viewurlFormatted'] . '">' . $catName . '</a></li>';

            // process parents
            $categoryLevel = $cat['level'];
            $parentID = $cat['parent_id'];
            while ($categoryLevel > 1) {
                // get parent
                foreach ($cats as $catSub) {
                    if ($catSub['id'] != $parentID) {
                        continue;
                    }
                    $catName = $catSub['name'];
                    if (isset($catSub['display_name'][$lang])) $catName = $catSub['display_name'][$lang];
                    $resultTmp = $separator . '<li><a href="' . $catSub['viewurlFormatted'] . '">' . $catName . '</a></li>' . $resultTmp;
                    $categoryLevel--;
                    $parentID = $catSub['parent_id'];
                    break;
                }
            }

            $result .= $resultTmp;
            break;
        }
    }

    if ($currentFunc == 'display') {
        if (is_object($entity)) {
            $result .= $separator;
            $result .= '<li><a href="' . $entity['detailurlFormatted'] . '">' . $entity['subject'] . '</a></li>';
        }
    }

    $result .= '</ul>' . "\n";

    return $result;
}
