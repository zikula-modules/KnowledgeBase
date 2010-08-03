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

class KnowledgeBase_Api_User extends Zikula_Api
{
    /**
     * Retrieve flat or full list of categories for the KnowledgeBase modules
     */
    public function getCategories($args)
    {
        $full = (isset($args['full']) && $args['full']);
        $flat = !$full;

        $baseCatPath = ModUtil::getVar('KnowledgeBase', 'baseCatTicketCategoryMain');
        $baseCat = CategoryRegistryUtil::getRegisteredModuleCategory('KnowledgeBase', 'kbase_ticket', 'TicketCategoryMain');
        $categories = CategoryUtil::getSubCategories($baseCat, $full);
        foreach ($categories as $k => $cat) {
            $categories[$k]['name'] = $cat['name'];
            $categories[$k]['nameStripped'] = str_replace('"', '\'', DataUtil::formatForDisplay($cat['name']));
            if (!isset($args['skipurlbuilding'])) {
                $categories[$k]['viewurl'] = ModUtil::url('KnowledgeBase', 'user', 'view', array('cat' => $cat['id']));
                $categories[$k]['viewurlFormatted'] = DataUtil::formatForDisplay($categories[$k]['viewurl']);
            }

            $relPath = str_replace($baseCatPath . '/', '', $cat['path']);
            $relPathParts = explode('/', $relPath);
            $categories[$k]['level'] = count($relPathParts);

            if (!isset($args['skipticketassignment'])) {
                list($objectData, $objcount) = ModUtil::apiFunc('KnowledgeBase', 'user', 'getTickets', array('category' => $cat['id'], 'term' => ''));
                $categories[$k]['tickets'] = $objectData;
                $categories[$k]['ticketcount'] = $objcount;
            }
        }

        return $categories;
    }

    /**
     * Retrieve ticket objects from database based on different criteria
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function getTickets($args)
    {
// DEBUG: permission check aspect starts
        if (!SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_READ)) {
            return LogUtil::registerPermissionError();
        }
// DEBUG: permission check aspect ends

        // instantiate the object-array
        $objectArray = new KnowledgeBase_DBObject_TicketArray();

        // parameter for used sorting field
        $sort = ((isset($args['sort']) ? $args['sort'] : FormUtil::getPassedValue('sort', '', 'GET')));
        if (empty($sort) || !in_array($sort, $objectArray->getAllowedSortingFields())) {
            $sort = $objectArray->getDefaultSortingField();
        }

        // parameter for used sort order
        $sdir = ((isset($args['sdir']) ? $args['sdir'] : FormUtil::getPassedValue('sdir', '', 'GET')));
        if ($sdir != 'asc' && $sdir != 'desc') $sdir = 'asc';


        // startnum is the current offset which is used to calculate the pagination
        $startnum = (int) ((isset($args['pos']) ? $args['pos'] : FormUtil::getPassedValue('pos', 1, 'GET')));

        // pagesize is the number of items displayed on a page for pagination
        $pagesize = (int) ((isset($args['amount']) ? $args['amount'] : 100));//ModUtil::getVar('KnowledgeBase', 'pagesize', 10);

        // convenience vars to make code clearer
        $where = '';
        $sortParam = $sort . ' ' . $sdir;

        // use FilterUtil to support generic filtering based on an object-oriented approach
        $fu = new FilterUtil(array('table' => $objectArray->_objType, array('join' => &$objectArray->_objJoin)));

        $filter = '';
        if (isset($args['filter'])) {
            $filter = $args['filter'];
        }
        $searchterm = ((isset($args['term']) ? $args['term'] : FormUtil::getPassedValue('term', '', 'GET')));
        if (!empty($searchterm)) {
            //if (!empty($filter)) $filter .= ',';
            //$filter .= 'subject:like:%' . $searchterm . '%,content:like:%' . $searchterm . '%';
            if (!empty($filter)) $filter .= ' AND ';
            $filter .= '(zk_subject LIKE \'%' . DataUtil::formatForStore($searchterm) . '%\' OR zk_content LIKE \'%' . DataUtil::formatForStore($searchterm) . '%\')';
        }
        if (!empty($filter)) {
            //$fu->setFilter($filter);
        }
        // you could set explicit filters at this point, something like
        // $fu->setFilter('type:eq:' . $args['type'] . ',id:eq:' . $args['id']);
        // supported operators: eq, ne, like, lt, le, gt, ge, null, notnull

        // process request input filters and get result for DBUtil
        $ret = $fu->GetSQL();
        $where = $filter;//$ret['where'];

        // category filters
        $category = ((isset($args['category']) ? $args['category'] : FormUtil::getPassedValue('cat', 0, 'GET')));
        if ($category > 0) {
            $catProp = 'TicketCategoryMain';
            $catValue = $category;
            // add category filter including sub categories
            if (!is_array($objectArray->_objCategoryFilter)) {
                $objectArray->_objCategoryFilter = array();
            }

            $categoryWithSubIDs = array($catValue);
            $subCats = CategoryUtil::getSubCategories($catValue);

            foreach($subCats as $subCat) {
                $categoryWithSubIDs[] = $subCat['id'];
            }

            $objectArray->_objCategoryFilter[$catProp] = $categoryWithSubIDs;
        }

        // get() returns the cached object fetched from the DB during object instantiation
        // get() with parameters always performs a new select
        // while the result will be saved in the object, we assign in to a local variable for convenience.
        $objectData = $objectArray->get($where, $sortParam, $startnum-1, $pagesize);

        // get total number of records for building the pagination by method call
        $objcount = $objectArray->getCount($where);

        return array($objectData, $objcount);
    }

    /**
     * Retrieve a single ticket object from database
     *
     * @author       Axel Guckelsberger
     * @params       TODO
     * @return       Render output
     */
    public function getTicket($args)
    {
        if (!isset($args['id']) || !is_numeric($args['id']) || !$args['id']) {
            return false;
        }

        // intantiate object model
        $object = new KnowledgeBase_DBObject_Ticket();
        $idField = $object->getIDField();

        // retrieve the ID of the object we wish to view
        $id = $args['id'];

        // assign object data
        // this performs a new database select operation
        // while the result will be saved within the object, we assign it to a local variable for convenience
        $objectData = $object->get($id, $idField);
        if (!is_array($objectData) || !isset($objectData[$idField]) || !is_numeric($objectData[$idField])) {
            return LogUtil::registerError($this->__('No such item.'));
        }

        return $objectData;
    }


    /**
     * form custom url string
     *
     * @author       Axel Guckelsberger
     * @return       string custom url string
     */
    public function encodeurl($args)
    {
        // check if we have the required input
        if (!isset($args['modname']) || !isset($args['func']) || !isset($args['args'])) {
            return LogUtil::registerError ($this->__('Error! Could not do what you wanted. Please check your input.'));
        }

        if (!isset($args['type'])) {
            $args['type'] = 'user';
        }

        $customFuncs = array('view', 'display');
        if (!in_array($args['func'], $customFuncs)) {
            return '';
        }

        // create an empty string ready for population
        $vars = '';

        // display function
        if ($args['func'] == 'view' || $args['func'] == 'display') {
            // for the display function use either the title (if present) or the object's id
            $objectType = 'ticket';

            $tables = DBUtil::getTables();

            if ($args['func'] == 'view') {
                $groupFolder = '';
                if (isset($args['args']['cat']) && !empty($args['args']['cat'])) {
                    $currentCat = $args['args']['cat'];
                    unset($args['args']['cat']);

                    $cats = ModUtil::apiFunc('KnowledgeBase', 'user', 'getCategories', array('full' => true, 'skipurlbuilding' => true, 'skipticketassignment' => true));
                    foreach ($cats as $cat) {
                        if ($cat['id'] != $currentCat) {
                            continue;
                        }

                        // save current cat information because we have to check the parents first
                        $resultTMP = DataUtil::formatForURL($cat['name']);

                        // process parents
                        $categoryLevel = $cat['level'];
                        $parentID = $cat['parent_id'];
                        while ($categoryLevel > 1) {
                            // get parent
                            foreach ($cats as $catSub) {
                                if ($catSub['id'] != $parentID) {
                                    continue;
                                }
                                $resultTMP = DataUtil::formatForURL($catSub['name']) . '_-_' . $resultTMP;
                                $categoryLevel--;
                                $parentID = $catSub['parent_id'];
                                break;
                            }
                        }

                        $groupFolder .= $resultTMP;
                        break;
                    }
                }
                else {
                    $groupFolder = 'view';
                }
                $vars = $groupFolder . '/';
            }
            elseif ($args['func'] == 'display') {
                $id = 0;
                if (isset($args['args']['id'])) {
                    $id = $args['args']['id'];
                    unset($args['args']['id']);
                }
                if (isset($args['args']['objectid'])) {
                    $id = $args['args']['objectid'];
                    unset($args['args']['objectid']);
                }

                $tableName = 'kbase_' . strtolower($objectType);

                $permalinkField = 'subjecturl';

                if ($id > 0) {
                    $item = DBUtil::selectObjectByID($tableName, $id, strtolower($objectType) . 'id');
                }
                else {
                    $item = DBUtil::selectObjectByID($tableName, $args['args']['title'], $permalinkField);
                    unset($args['args']['title']);
                }

                $groupFolder = 'tickets';
                $vars = $groupFolder . '/' . $item[$permalinkField];

                $vars .= '.' . $item[strtolower($objectType).'id'];
                $fileEnding = '.html';
                if (isset($args['args']['pdf']) && $args['args']['pdf'] == 1) {
                    $fileEnding = '.pdf';
                    unset($args['args']['pdf']);
                }
                $vars .= $fileEnding;
            }
        }

        //all other arguments
        $extraargs = '';
        if (count($args['args']) > 0) {
            $extraargs = array();
            foreach ($args['args'] as $k => $v) {
                $extraargs[] = "$k=$v";
            }
            $extraargs = implode('&', $extraargs);
            if (substr($vars, -1, 1) != '/') {
                $extraargs = '/'. $extraargs;
            }
        }

        return $args['modname'] . '/' . $vars . $extraargs;
    }

    /**
     * decode the custom url string
     *
     * @author       Axel Guckelsberger
     * @return       bool true if successful, false otherwise
     */
    public function decodeurl($args)
    {
        // check we actually have some vars to work with
        if (!isset($args['vars'])) {
            return LogUtil::registerError ($this->__('Error! Could not do what you wanted. Please check your input.'));
        }

        // define the available user functions
        $funcs = array('main', 'view', 'display', 'edit');

        // set the correct function name based on our input
        if (empty($args['vars'][2])) {
            // no func and no vars = main
            System::queryStringSetVar('func', 'main');
            return true;
        } elseif (in_array($args['vars'][2], $funcs)) {
            return false;
        }

        foreach ($_GET as $k => $v) {
            if (in_array($k, array('module', 'type', 'func')) === false) {
                unset($_GET[$k]);
            }
        }

        //get the thing as string
        $url = implode('/', array_slice($args['vars'], 2));
        if (preg_match('~^(\w+)/[^/.]+\.(\d+).html(?:/(\w+=.*))?$~', $url, $matches)) {
            $groupFolder = $matches[1];
            $objectid = $matches[2];
            $extraargs = $matches[3];

            System::queryStringSetVar('func', 'display');
            System::queryStringSetVar('id', $objectid);
        }
        elseif (preg_match('~^(\w+)/[^/.]+\.(\d+).pdf(?:/(\w+=.*))?$~', $url, $matches)) {
            $groupFolder = $matches[1];
            $objectid = $matches[2];
            $extraargs = $matches[3];

            System::queryStringSetVar('func', 'display');
            System::queryStringSetVar('id', $objectid);
            System::queryStringSetVar('pdf', '1');

        } elseif (preg_match('~^([^/]+)(?:/(\w+)(?:/[^/.]+\.(\d+|\w\w))?)?(?:/?|/(\w+=.*))$~', $url, $matches)) {
            $groupFolder = $matches[1];
            $filterelement = $matches[2];
            $filterid = $matches[3];
            $extraargs = $matches[4];

            $groupFolder = explode('_-_', $groupFolder);
            $groupFolder = $groupFolder[count($groupFolder)-1];

            $cats = ModUtil::apiFunc('KnowledgeBase', 'user', 'getCategories', array('full' => true));
            foreach ($cats as $cat) {
                if ($groupFolder == DataUtil::formatForURL($cat['name']) || $groupFolder == $cat['name']) {
                    System::queryStringSetVar('cat', $cat['id']);
                    break;
                }
            }

            System::queryStringSetVar('func', 'view');
        } else {
            System::queryStringSetVar('func', 'view');
        }

        //parse extraargs
        if (isset($extraargs) && !empty($extraargs)) {
            $vars = explode('&', $extraargs);
            if (is_array($vars)) {
                foreach ($vars as $var) {
                    list($k, $v) = explode('=', $var, 2);
                    System::queryStringSetVar($k, $v);
                }
            }
        }

        //set filter
        if (!empty($filter)) {
            $urlfilter = FormUtil::getPassedValue('filter', false, 'GETPOST');
            if (!empty($urlfilter)) {
                $filter = $urlfilter .','.$filter;
            }
            System::queryStringSetVar('filter', $filter);
        }

        return true;
    }

}