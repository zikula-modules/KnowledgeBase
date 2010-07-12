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
 * initialise the KnowledgeBase module
 *
 * This function is only ever called once during the lifetime of a particular
 * module instance
 * This function MUST exist in the pninit file for a module
 *
 * @author       Axel Guckelsberger
 * @return       bool       true on success, false otherwise
 */
function KnowledgeBase_init()
{
    $dom = ZLanguage::getModuleDomain('KnowledgeBase');

    // create the ticket table
    if (!DBUtil::createTable('kbase_ticket')) {
        return false;
    }



    // set up all our module vars with initial values

    // create the default data for KnowledgeBase
    KnowledgeBase_defaultdata();

    // create the default categories for KnowledgeBase
    if (!KnowledgeBase_defaultcategories()) {
        return LogUtil::registerError(__('creation of default categories failed', $dom));
    }

    // Initialisation successful
    return true;
}

/**
 * upgrade the KnowledgeBase module from an old version
 *
 * This function can be called multiple times
 * This function MUST exist in the pninit file for a module
 *
 * @author       Axel Guckelsberger
 * @param       int        $oldversion version to upgrade from
 * @return      bool       true on success, false otherwise
 */
function KnowledgeBase_upgrade($oldversion)
{
/*
    // Upgrade dependent on old version number
    switch ($oldversion){
    case '1.00':
            KnowledgeBase_createTables_101();
        break;
    }
*/

    // Update successful
    return true;
}

/**
 * delete the KnowledgeBase module
 * This function is only ever called once during the lifetime of a particular
 * module instance
 * This function MUST exist in the pninit file for a module
 *
 * @author       Axel Guckelsberger
 * @return       bool       true on success, false otherwise
 */
function KnowledgeBase_delete()
{
    if (!DBUtil::dropTable('kbase_ticket')) {
        return false;
    }



    // remove all module vars
    ModUtil::delVar('KnowledgeBase');

    // Deletion successful
    return true;
}

/**
 * create the default data for KnowledgeBase
 *
 * This function is only ever called once during the lifetime of a particular
 * module instance
 *
 * @author       Axel Guckelsberger
 * @return       bool       true on success, false otherwise
 */
function KnowledgeBase_defaultdata()
{
    // ensure that tables are cleared
    if (
        !DBUtil::deleteWhere('kbase_ticket', '1=1')) {
        return false;
    }

    $dom = ZLanguage::getModuleDomain('KnowledgeBase');


    // insertion successful
    return true;
}



/**
 * create the default categories for KnowledgeBase
 *
 * @author       Axel Guckelsberger
 * @return       bool       true if successful or false if something went wrong
 */
function KnowledgeBase_defaultcategories()
{
    // load necessary classes
    Loader::loadClass('CategoryUtil');
    Loader::loadClassFromModule('Categories', 'Category');
    Loader::loadClassFromModule('Categories', 'CategoryRegistry');

    // get the language file
    $lang = UserUtil::getLang();


    ModUtil::dbInfoLoad('Categories');

    $pntables = DBUtil::getTables();

    $catcolumn = $pntables['categories_category_column'];
    $where = '';
    $orderBy = " $catcolumn[id] DESC";
    $lastCat = DBUtil::selectObjectArray('categories_category', $where, $orderBy, 0, 1); //LIMIT 0, 1
    if ($lastCat === false || !$lastCat) {
        return false;
    }

    //we have only one item
    $lastCat = $lastCat[0];

    $nextCatID = $lastCat['id'] + 1;

    $objArray = array();

    $parentList = array();
    $rootCat = array();
    $parentLvlOne = array();
    $parentLvlTwo = array();


    $catNames = array('en' => 'Knowledge Base',
                      'de' => 'Knowledge Base');
    $catDescriptions = array('en' => 'Main category for the Knowledge Base',
                             'de' => 'Hauptkategorie für die Knowledge Base');
    $rootCat = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

    $parentList = array($rootCat);                  // reset to level one
    $catNames = array('en' => 'Ticket Categories',
                      'de' => 'Ticket-Kategorien');
    $catDescriptions = array('en' => 'Available topics for tickets',
                             'de' => 'Verfügbare Themen für Tickets');
    $parentLvlOne = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

    $parentList = array($rootCat, $parentLvlOne);   // reset to level two
    {
        $catNames = array('en' => 'Installation',
                          'de' => 'Installation');
        $catDescriptions = array('eng' => 'Installation of Zikula',
                                 'deu' => 'Installation von Zikula');
        $parentLvlTwo = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $catNames = array('en' => 'Configuration',
                          'de' => 'Konfiguration');
        $catDescriptions = array('eng' => 'Configure Zikula and basic settings',
                                 'deu' => 'Zikula konfigurieren und Grundeinstellungen');
        $parentLvlTwo = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $catNames = array('en' => 'Modules',
                          'de' => 'Module');
        $catDescriptions = array('eng' => 'Setup, manage and use modules',
                                 'deu' => 'Module einrichten, verwalten und verwenden');
        $parentLvlTwo = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $catNames = array('en' => 'Themes',
                          'de' => 'Themes');
        $catDescriptions = array('eng' => 'Design your layout in Zikula',
                                 'deu' => 'Realisiere Dein Design mit Zikula');
        $parentLvlTwo = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $catNames = array('en' => 'Customisation',
                          'de' => 'Anpassung');
        $catDescriptions = array('eng' => 'Your individual Zikula',
                                 'deu' => 'Individualisierung von Zikula');
        $parentLvlTwo = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $catNames = array('en' => 'Development',
                          'de' => 'Entwicklung');
        $catDescriptions = array('eng' => 'Development of and for Zikula',
                                 'deu' => 'Entwicklung von und für Zikula');
        $parentLvlTwo = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $catNames = array('en' => 'Tools and Services',
                          'de' => 'Nützliche Werkzeuge');
        $catDescriptions = array('eng' => 'CoZi, extension database and further tools',
                                 'deu' => 'CoZi, Extension-Datenbank und andere Tools');
        $parentLvlTwo = createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);
    }

    // insert the categories records
    DBUtil::insertObjectArray($objArray, 'categories_category', 'id', true);


    // rebuild all path entries so that we can use them below
    CategoryUtil::rebuildPaths('path', 'name');
    CategoryUtil::rebuildPaths('ipath', 'id');

    // define category registration mappings to ticket table
    $mappingRootCats = array(
        array('prop' => 'TicketCategoryMain', 'rootPath' => '/__SYSTEM__/Knowledge Base/Ticket Categories'));

    foreach ($mappingRootCats as $mappingRoot) {
        $rootCat = CategoryUtil::getCategoryByPath($mappingRoot['rootPath']);

        $registry = new Categories_DBObject_Registry();
        $registry->setDataField('modname', 'KnowledgeBase');
        $tableName = 'kbase_ticket';
        $registry->setDataField('table', $tableName);
        $registry->setDataField('property', $mappingRoot['prop']);
        $registry->setDataField('category_id', $rootCat['id']);
        $registry->insert();

        ModUtil::setVar('KnowledgeBase', 'baseCat' . $mappingRoot['prop'], $mappingRoot['rootPath']);
    }

    return true;
}


function createSingleCategoryArray($catID, $parentArray, $catNames, $catDescriptions, &$destArray) {
    $path = '/__SYSTEM__/Knowledge Base';
    $ipath = '';
    $numParents = count($parentArray);
    if ($numParents > 0) {
        foreach($parentArray as $parentCat) {
            $path .= '/' . $parentCat['name'];
            $ipath = '/' . $parentCat['id'];
        }
    }

    $ipath .= '/' . $catID;

    $newCatArray = array(
        'id'               => $catID,
        'parent_id'        => ($numParents > 0) ? $parentArray[$numParents-1]['id'] : 1,
        'is_locked'        => 0,
        'is_leaf'          => 0,
        'name'             => $catNames['en'],
        'display_name'     => serialize($catNames),
        'display_desc'     => serialize($catDescriptions),
        'path'             => $path,
        'ipath'            => $ipath,
        'status'           => 'A');

    $destArray[] = $newCatArray;
    return $newCatArray;
}


