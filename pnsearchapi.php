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
 * Even though we're handling objects for multiple tables, we only have one function for any use case.
 * The specific functionality for each object is encapsulated in the actual class implementation within the
 * module's classes directory while the handling code can remain identical for any number of entities.
 * This component-based approach allows you to have generic handler code which relies on the functionality
 * implemented in the object's class in order to achieve it's goals.
 */

// preload common used classes
Loader::requireOnce('modules/KnowledgeBase/common.php');


/**
 * This is a custom function. Documentation for this will be improved in later versions.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @return       Render output
 */
function KnowledgeBase_searchapi_info($args)
{
    return array('title'     => 'KnowledgeBase',
                 'functions' => array('KnowledgeBase' => 'search'));
}

/**
 * This is a custom function. Documentation for this will be improved in later versions.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @return       Render output
 */
function KnowledgeBase_searchapi_options($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ)) {
        return '';
    }
// DEBUG: permission check aspect ends

    $render = pnRender::getInstance('KnowledgeBase');
    $render->assign('active', (isset($args['active']) && isset($args['active']['KnowledgeBase'])) || !isset($args['active']));
    return $render->fetch('KnowledgeBase_search.htm');
}

/**
 * This is a custom function. Documentation for this will be improved in later versions.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @return       Render output
 */
function KnowledgeBase_searchapi_search($args)
{
// DEBUG: permission check aspect starts
    if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ)) {
        return true;
    }
// DEBUG: permission check aspect ends

    $dom = ZLanguage::getModuleDomain('KnowledgeBase');

    pnModDBInfoLoad('Search');
    $tables       = pnDBGetTables();
    $kbasetable   = $tables['kbase_ticket'];
    $kbasecolumn  = $tables['kbase_ticket_column'];
    $searchTable  = $tables['search_result'];
    $searchColumn = $tables['search_result_column'];

    $where = search_construct_where($args,
                                    array($kbasecolumn['subject'],
                                          $kbasecolumn['content']));

    // further exlusions
    //$where .= ' AND ...';

    $sql = 'SELECT ' . $kbasecolumn['ticketid'] . ' AS ticketid, '
                     . $kbasecolumn['cr_date'] . ' AS cr_date, '
                     . $kbasecolumn['subject'] . ' AS subject, '
                     . $kbasecolumn['content'] . ' AS content'
         . ' FROM ' . $kbasetable . ' WHERE ' . $where;

    $result = DBUtil::executeSQL($sql);
    if (!$result) {
        return LogUtil::registerError (__('Error! Could not load items.', $dom));
    }

    $sessionId = session_id();

    $insertSql = 'INSERT INTO ' . $searchTable . '('
                . $searchColumn['title'] . ','
                . $searchColumn['text'] . ','
                . $searchColumn['extra'] . ','
                . $searchColumn['module'] . ','
                . $searchColumn['created'] . ','
                . $searchColumn['session']
                . ') VALUES ';

    // Process the result set and insert into search result table
    for (; !$result->EOF; $result->MoveNext()) {
        $kbaseItem = $result->GetRowAssoc(2);

        $sql = $insertSql . '('
                . '\'' . DataUtil::formatForStore($kbaseItem['subject']) . '\', '
                . '\'' . DataUtil::formatForStore($kbaseItem['content']) . '\', '
                . '\'' . DataUtil::formatForStore(pnModURL('KnowledgeBase', 'user', 'display', array('id' => $kbaseItem['ticketid']))) . '\', '
                . '\'' . 'KnowledgeBase' . '\', '
                . '\'' . DataUtil::formatForStore($kbaseItem['cr_date']) . '\', '
                . '\'' . DataUtil::formatForStore($sessionId) . '\')';

        $insertResult = DBUtil::executeSQL($sql);
        if (!$insertResult) {
            return LogUtil::registerError (__('Error! Could not load items.', $dom));
        }
    }

    return true;
}

/**
 * This is a custom function. Documentation for this will be improved in later versions.
 *
 * @author       Axel Guckelsberger
 * @params       TODO
 * @return       Render output
 */
function KnowledgeBase_searchapi_search_check($args)
{
    $datarow = &$args['datarow'];

    $datarow['url'] = $datarow['extra'];

    return true;
}
