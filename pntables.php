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
 * generated at Thu Apr 08 22:42:13 CEST 2010 by ModuleStudio 0.4.10 (http://modulestudio.de)
 */

/**
 * Populate tables array for KnowledgeBase module
 *
 * This function is called internally by the core whenever the module is
 * loaded. It delivers the table information to the core.
 * It can be loaded explicitly using the pnModDBInfoLoad() API function.
 *
 * @author       Axel Guckelsberger
 * @return       array       The table information.
 */
function KnowledgeBase_pntables()
{
    // Initialise table array
    $tables = array();

    $dbdriver = DBConnectionStack::getConnectionDBDriver();


    /*
     * definitions for ticket table
     */

    // set the table name combined with prefix
    $tables['kbase_ticket'] = DBUtil::getLimitedTablename('kbase_ticket');

    // set the column names
    $columns = array(
        'ticketid' => 'zk_ticketid',
        'subject' => 'zk_subject',
        'subjecturl' => 'zk_subjecturl',
        'content' => 'zk_content',
        'views' => 'zk_views',
        'ratesup' => 'zk_ratesup',
        'ratesdown' => 'zk_ratesdown');

    // set the data dictionary for the table columns

    $contentType = 'X';

    $dbType = DBConnectionStack::getConnectionDBType();
    if ($dbType == 'mssql') { // mssql can't sort on fields of type text
        $contentType = 'C(8000)';
    }

    $columnDef = array(
        'ticketid' => "I NOTNULL AUTO PRIMARY",
        'subject' => "C(255) NOTNULL DEFAULT ''",
        'subjecturl' => "C(255) NOTNULL DEFAULT ''",
        'content' => "$contentType NOTNULL",
        'views' => "I4 DEFAULT '0'",
        'ratesup' => "I4 DEFAULT '0'",
        'ratesdown' => "I4 DEFAULT '0'");

    // DEBUG: object extension aspect starts

    // add standard fields to the table definition and data dictionary
    ObjectUtil::addStandardFieldsToTableDefinition($columns, 'zk_');
    ObjectUtil::addStandardFieldsToTableDataDefinition($columnDef);

    $tables['kbase_ticket_primary_key_column'] = 'ticketid';
    // enable categorization services
    $tables['kbase_ticket_db_extra_enable_categorization'] = true;

    // enable attribution services
    $tables['kbase_ticket_db_extra_enable_attribution'] = true;

    // enable meta data
    $tables['kbase_ticket_db_extra_enable_meta'] = true;

    // disable logging services
    $tables['kbase_ticket_db_extra_enable_logging'] = false;

    // DEBUG: object extension aspect ends




    $tables['kbase_ticket_column'] = $columns;
    $tables['kbase_ticket_column_def'] = $columnDef;


    // return table data
    return $tables;
}
