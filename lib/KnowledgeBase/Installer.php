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

class KnowledgeBase_Installer extends Zikula_Installer
{
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
    public function install()
    {
        // create the ticket table
        if (!DBUtil::createTable('kbase_ticket')) {
            return false;
        }

        // set up all our module vars with initial values

        // create the default data for KnowledgeBase
        $this->defaultdata();

        // create the default categories for KnowledgeBase
        if (!$this->defaultcategories()) {
            return LogUtil::registerError($this->__('creation of default categories failed'));
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
    public function upgrade($oldversion)
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
    public function uninstall()
    {
        if (!DBUtil::dropTable('kbase_ticket')) {
            return false;
        }

        // remove all module vars
        $this->delVars();

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
    public function defaultdata()
    {
        // ensure that tables are cleared
        if (!DBUtil::deleteWhere('kbase_ticket', '1=1')) {
            return false;
        }

        // insertion successful
        return true;
    }



    /**
     * create the default categories for KnowledgeBase
     *
     * @author       Axel Guckelsberger
     * @return       bool       true if successful or false if something went wrong
     */
    protected function defaultcategories()
    {
        // get the language file
        $lang = ZLanguage::getLanguageCode();

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
        $rootCat = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $parentList = array($rootCat);                  // reset to level one
        $catNames = array('en' => 'Ticket Categories',
                'de' => 'Ticket-Kategorien');
        $catDescriptions = array('en' => 'Available topics for tickets',
                'de' => 'Verfügbare Themen für Tickets');
        $parentLvlOne = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

        $parentList = array($rootCat, $parentLvlOne);   // reset to level two
        {
            $catNames = array('en' => 'Installation',
                    'de' => 'Installation');
            $catDescriptions = array('en' => 'Installation of Zikula',
                    'de' => 'Installation von Zikula');
            $parentLvlTwo = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

            $catNames = array('en' => 'Configuration',
                    'de' => 'Konfiguration');
            $catDescriptions = array('en' => 'Configure Zikula and basic settings',
                    'de' => 'Zikula konfigurieren und Grundeinstellungen');
            $parentLvlTwo = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

            $catNames = array('en' => 'Modules',
                    'de' => 'Module');
            $catDescriptions = array('en' => 'Setup, manage and use modules',
                    'de' => 'Module einrichten, verwalten und verwenden');
            $parentLvlTwo = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

            $catNames = array('en' => 'Themes',
                    'de' => 'Themes');
            $catDescriptions = array('en' => 'Design your layout in Zikula',
                    'de' => 'Realisiere Dein Design mit Zikula');
            $parentLvlTwo = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

            $catNames = array('en' => 'Customisation',
                    'de' => 'Anpassung');
            $catDescriptions = array('en' => 'Your individual Zikula',
                    'de' => 'Individualisierung von Zikula');
            $parentLvlTwo = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

            $catNames = array('en' => 'Development',
                    'de' => 'Entwicklung');
            $catDescriptions = array('en' => 'Development of and for Zikula',
                    'de' => 'Entwicklung von und für Zikula');
            $parentLvlTwo = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);

            $catNames = array('en' => 'Tools and Services',
                    'de' => 'Nützliche Werkzeuge');
            $catDescriptions = array('en' => 'CoZi, extension database and further tools',
                    'de' => 'CoZi, Extension-Datenbank und andere Tools');
            $parentLvlTwo = $this->createSingleCategoryArray($nextCatID++, $parentList, $catNames, $catDescriptions, &$objArray);
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


    protected function createSingleCategoryArray($catID, $parentArray, $catNames, $catDescriptions, &$destArray) {
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


}