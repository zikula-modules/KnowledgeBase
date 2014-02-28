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

namespace Guite\KnowledgeBaseModule\Form\Plugin\Base;

use FormUtil;
use ModUtil;
use PageUtil;
use SecurityUtil;
use ServiceUtil;
use ThemeUtil;
use Zikula_Form_Plugin_TextInput;
use Zikula_Form_View;
use Zikula_View;

/**
 * Item selector plugin base class.
 */
class ItemSelector extends Zikula_Form_Plugin_TextInput
{
    /**
     * The treated object type.
     *
     * @var string
     */
    public $objectType = '';

    /**
     * Identifier of selected object.
     *
     * @var integer
     */
    public $selectedItemId = 0;

    /**
     * Get filename of this file.
     * The information is used to re-establish the plugins on postback.
     *
     * @return string
     */
    public function getFilename()
    {
        return __FILE__;
    }

    /**
     * Create event handler.
     *
     * @param Zikula_Form_View $view    Reference to Zikula_Form_View object.
     * @param array            &$params Parameters passed from the Smarty plugin function.
     *
     * @see    Zikula_Form_AbstractPlugin
     * @return void
     */
    public function create(Zikula_Form_View $view, &$params)
    {
        $params['maxLength'] = 11;
        /*$params['width'] = '8em';*/

        // let parent plugin do the work in detail
        parent::create($view, $params);
    }

    /**
     * Helper method to determine css class.
     *
     * @see    Zikula_Form_Plugin_TextInput
     *
     * @return string the list of css classes to apply
     */
    protected function getStyleClass()
    {
        $class = parent::getStyleClass();
        return str_replace('z-form-text', 'z-form-itemlist ' . strtolower($this->objectType), $class);
    }

    /**
     * Render event handler.
     *
     * @param Zikula_Form_View $view Reference to Zikula_Form_View object.
     *
     * @return string The rendered output
     */
    public function render(Zikula_Form_View $view)
    {
        static $firstTime = true;
        if ($firstTime) {
            PageUtil::addVar('javascript', 'prototype');
            PageUtil::addVar('javascript', 'Zikula.UI'); // imageviewer
            PageUtil::addVar('javascript', 'Resources/public/js/GuiteKnowledgeBaseModule_finder.js');
            PageUtil::addVar('stylesheet', ThemeUtil::getModuleStylesheet('GuiteKnowledgeBaseModule'));
        }
        $firstTime = false;

        if (!SecurityUtil::checkPermission('GuiteKnowledgeBaseModule:' . ucwords($this->objectType) . ':', '::', ACCESS_COMMENT)) {
            return false;
        }

        $categorisableObjectTypes = array('ticket');
        $catIds = array();
        if (in_array($this->objectType, $categorisableObjectTypes)) {
            // fetch selected categories to reselect them in the output
            // the actual filtering is done inside the repository class
            $catIds = ModUtil::apiFunc('GuiteKnowledgeBaseModule', 'category', 'retrieveCategoriesFromRequest', array('ot' => $this->objectType));
        }

        $this->selectedItemId = $this->text;

        $entityClass = 'GuiteKnowledgeBaseModule:' . ucwords($this->objectType) . 'Entity';
        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->getService('doctrine.entitymanager');
        $repository = $entityManager->getRepository($entityClass);

        $sort = $repository->getDefaultSortingField();
        $sdir = 'asc';

        // convenience vars to make code clearer
        $where = '';
        $sortParam = $sort . ' ' . $sdir;

        $entities = $repository->selectWhere($where, $sortParam);

        $view = Zikula_View::getInstance('GuiteKnowledgeBaseModule', false);
        $view->assign('objectType', $this->objectType)
             ->assign('items', $entities)
             ->assign('selectedId', $this->selectedItemId);

        // assign category properties
        $properties = null;
        if (in_array($this->objectType, $categorisableObjectTypes)) {
            $properties = ModUtil::apiFunc('GuiteKnowledgeBaseModule', 'category', 'getAllProperties', array('ot' => $this->objectType));
        }
        $view->assign('properties', $properties)
             ->assign('catIds', $catIds);

        return $view->fetch('External/' . ucwords($this->objectType) . '/select.tpl');
    }

    /**
     * Decode event handler.
     *
     * @param Zikula_Form_View $view Zikula_Form_View object.
     *
     * @return void
     */
    public function decode(Zikula_Form_View $view)
    {
        parent::decode($view);
        $this->objectType = FormUtil::getPassedValue('GuiteKnowledgeBaseModule_objecttype', 'ticket', 'POST');
        $this->selectedItemId = $this->text;
    }
}