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
 * @version Generated by ModuleStudio 0.5.2 (http://modulestudio.de) at Thu Feb 17 14:43:00 CET 2011.
 */

/**
 * Generic item list block base class
 */
class KnowledgeBase_Block_Base_ItemList extends Zikula_Controller_Block
{
    /**
     * Initialise the block
     */
    public function init()
    {
        SecurityUtil::registerPermissionSchema('KnowledgeBase:ItemListBlock:', 'Block title::');
    }

    /**
     * Get information on the block
     *
     * @return       array       The block information
     */
    public function info()
    {
        $requirementMessage = '';
        // check if the module is available at all
        if (!ModUtil::available('KnowledgeBase')) {
            $requirementMessage .= $this->__('Notice: This block will not be displayed until you activate the KnowledgeBase module.');
        }

        return array('module'          => 'KnowledgeBase',
            'text_type'       => $this->__('Item list'),
            'text_type_long'  => $this->__('Show a list of KnowledgeBase items based on different criteria.'),
            'allow_multiple'  => true,
            'form_content'    => false,
            'form_refresh'    => false,
            'show_preview'    => true,
            'admin_tableless' => true,
            'requirement'     => $requirementMessage);
    }

    /**
     * Display the block
     *
     * @param        array       $blockinfo a blockinfo structure
     * @return       output      the rendered bock
     */
    public function display($blockinfo)
    {
        // only show block content if the user has the required permissions
        if (!SecurityUtil::checkPermission('KnowledgeBase:FactListBlock:', "$blockinfo[title]::", ACCESS_OVERVIEW)) {
            return false;
        }

        // check if the module is available at all
        if (!ModUtil::available('KnowledgeBase')) {
            return false;
        }

        // get current block content
        $vars = BlockUtil::varsFromContent($blockinfo['content']);
        $vars['bid'] = $blockinfo['bid'];

        // set default values for all params which are not properly set
        if (!isset($vars['objectType']) || empty($vars['objectType'])) {
            $vars['objectType'] = 'ticket';
        }
        if (!isset($vars['sorting']) || empty($vars['sorting'])) {
            $vars['sorting'] = 'default';
        }
        if (!isset($vars['amount']) || !is_numeric($vars['amount'])) {
            $vars['amount'] = 5;
        }
        if (!isset($vars['template'])) {
            $vars['template'] = 'itemlist_' . ucwords($vars['objectType']) . '_display.tpl';
        }
        if (!isset($vars['filter'])) {
            $vars['filter'] = '';
        }

        if (!isset($vars['objectType']) || !in_array($vars['objectType'], KnowledgeBase_Util_Controller::getObjectTypes('block'))) {
            $vars['objectType'] = KnowledgeBase_Util_Controller::getDefaultObjectType('block');
        }

        $objectType = $vars['objectType'];

        // instantiate a new collection corresponding to $objectType
        $objectCollection = KnowledgeBase_Factory::getBusinessCollection($objectType, 'block', array('controller' => 'ItemList', 'action' => 'display'));

        $sortParam = '';
        if ($vars['sorting'] == 'random')
            $sortParam = 'RAND()';
        elseif ($vars['sorting'] == 'newest')
            $sortParam = $objectCollection->get_intIdField() . ' DESC';
        elseif ($vars['sorting'] == 'default')
            $sortParam = $objectCollection->get_intDefaultSortingField() . ' ASC';

        // get objects from database
        // while the result will be saved in the object, we assign in to a local variable for convenience.
        $objectData = $objectCollection->selectWherePaginated($vars['filter'], $sortParam, -1, $vars['amount']);

        $this->view->setCaching(true);

        // assign block vars and fetched data
        $this->view->assign('vars', $vars)
            ->assign('objectType', $objectType)
            ->assign('items', $objectData);

        // set a block title
        if (empty($blockinfo['title'])) {
            $blockinfo['title'] = $this->__('KnowledgeBase items');
        }

        $output = '';
        $templateForObjectType = str_replace('itemlist_', 'itemlist_' . ucwords($objectType) . '_', $vars['template']);
        if ($this->view->template_exists('contenttype/' . $templateForObjectType)) {
            $output = $this->view->fetch('contenttype/' . $templateForObjectType);
        } elseif ($this->view->template_exists('contenttype/' . $vars['template'])) {
            $output = $this->view->fetch('contenttype/' . $vars['template']);
        } elseif ($this->view->template_exists('block/' . $templateForObjectType)) {
            $output = $this->view->fetch('block/' . $templateForObjectType);
        } elseif ($this->view->template_exists('block/' . $vars['template'])) {
            $output = $this->view->fetch('block/' . $vars['template']);
        } else {
            $output = $this->view->fetch('block/itemlist.tpl');
        }

        $blockinfo['content'] = $output;

        // return the block to the theme
        return BlockUtil::themeBlock($blockinfo);
    }

    /**
     * Modify block settings
     *
     * @param        array       $blockinfo a blockinfo structure
     * @return       output      the block form
     */
    public function modify($blockinfo)
    {
        // Get current content
        $vars = BlockUtil::varsFromContent($blockinfo['content']);

        // set default values for all params which are not properly set
        if (!isset($vars['objectType']) || empty($vars['objectType'])) {
            $vars['objectType'] = 'ticket';
        }
        if (!isset($vars['sorting']) || empty($vars['sorting'])) {
            $vars['sorting'] = 'default';
        }
        if (!isset($vars['amount']) || !is_numeric($vars['amount'])) {
            $vars['amount'] = 5;
        }
        if (!isset($vars['template'])) {
            $vars['template'] = 'itemlist_' . $vars['objectType'] . '_display.tpl';
        }
        if (!isset($vars['filter'])) {
            $vars['filter'] = '';
        }

        $this->view->setCaching(false);

        // assign the approriate values
        $this->view->assign($vars);

        // clear the block cache
        $this->view->clear_cache('block/itemlist_display.tpl');
        $this->view->clear_cache('block/itemlist_' . ucwords($vars['objectType']) . '_display.tpl');
        $this->view->clear_cache('block/itemlist_display_description.tpl');
        $this->view->clear_cache('block/itemlist_' . ucwords($vars['objectType']) . '_display_description.tpl');

        // Return the output that has been generated by this function
        return $this->view->fetch('block/itemlist_modify.tpl');
    }

    /**
     * Update block settings
     *
     * @param        array       $blockinfo a blockinfo structure
     * @return       $blockinfo  the modified blockinfo structure
     */
    public function update($blockinfo)
    {
        // Get current content
        $vars = BlockUtil::varsFromContent($blockinfo['content']);

        $vars['objectType'] = FormUtil::getPassedValue('objecttype', 'ticket', 'POST', FILTER_SANITIZE_STRING);
        $vars['sorting'] = FormUtil::getPassedValue('sorting', 'default', 'POST', FILTER_SANITIZE_STRING);
        $vars['amount'] = (int)FormUtil::getPassedValue('amount', 5, 'POST', FILTER_VALIDATE_INT);
        $vars['template'] = FormUtil::getPassedValue('template', '', 'POST');
        $vars['filter'] = FormUtil::getPassedValue('filter', '', 'POST');

        if (!in_array($vars['objectType'], KnowledgeBase_Util_Controller::getObjectTypes('block'))) {
            $vars['objectType'] = KnowledgeBase_Util_Controller::getDefaultObjectType('block');
        }

        // write back the new contents
        $blockinfo['content'] = BlockUtil::varsToContent($vars);

        // clear the block cache
        $this->view->clear_cache('block/itemlist_display.tpl');
        $this->view->clear_cache('block/itemlist_' . ucwords($vars['objectType']) . '_display.tpl');
        $this->view->clear_cache('block/itemlist_display_description.tpl');
        $this->view->clear_cache('block/itemlist_' . ucwords($vars['objectType']) . '_display_description.tpl');

        return $blockinfo;
    }

}
