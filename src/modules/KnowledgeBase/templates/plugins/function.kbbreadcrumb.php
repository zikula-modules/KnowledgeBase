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
 * generated at Wed Apr 07 21:54:26 CEST 2010 by ModuleStudio 0.4.10 (http://modulestudio.de)
 */

/**
 * Breadcrumb navigation for KnowledgeBase module
 *
 * @param        array       $params       All attributes passed to this function from the template
 * @param        object      &$render     Reference to the Smarty object
 * @return       string      The output of the plugin
 */
function smarty_function_kbbreadcrumb($params, $render)
{
    $currentFunc = FormUtil::getPassedValue('func', 'main', 'GET');

    $dom = ZLanguage::getModuleDomain('KnowledgeBase');
    $separator = ' &raquo; ';

    $result = '';
    if ($currentFunc != 'main') {
        $result = '<a href="' . DataUtil::formatForDisplay(ModUtil::url('KnowledgeBase', 'user', 'main')) . '" title="' . __('Knowledge Base', $dom) . '">' . __('Knowledge Base', $dom) . '</a>';
    }
    else {
        $result = __('Knowledge Base', $dom);
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
        $objectData = ModUtil::apiFunc('KnowledgeBase', 'user', 'getTicket', array('id' => $ticketID));
        if (is_array($objectData)) {
            $currentCat = $objectData['__CATEGORIES__']['TicketCategoryMain']['id'];
        }
    }

    if ($currentCat > 0) {
        $cats = ModUtil::apiFunc('KnowledgeBase', 'user', 'getCategories', array('full' => true));
        $lang = ZLanguage::getLanguageCode();
        foreach ($cats as $cat) {
            if ($cat['id'] != $currentCat) {
                continue;
            }

            // save current cat information because we have to check the parents first
            $resultTMP = $separator;
            $catName = $cat['name'];
            if (isset($cat['display_name'][$lang])) $catName = $cat['display_name'][$lang];
            $resultTMP .= '<a href="' . $cat['viewurlFormatted'] . '">' . $catName . '</a>';

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
                    $resultTMP = $separator . '<a href="' . $catSub['viewurlFormatted'] . '">' . $catName . '</a>' . $resultTMP;
                    $categoryLevel--;
                    $parentID = $catSub['parent_id'];
                    break;
                }
            }

            $result .= $resultTMP;
            break;
        }
    }

    if ($currentFunc == 'display') {
        if (is_array($objectData)) {
            $result .= $separator;
            $result .= '<a href="' . $objectData['detailurlFormatted'] . '">' . $objectData['subject'] . '</a>';
        }
    }

    return $result;
}
