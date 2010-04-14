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



Loader::loadClass('PNTicketBase', 'modules/KnowledgeBase/classes/Base');

/**
 * This class implements the functionality of PNTicketBase
 */
class PNTicket extends PNTicketBase
{
    /**
     * retrieve subdata arrays
     */
    function selectPostProcess($data = null)
    {
        if (!$data) {
            $data = $this->_objData;
        }
        if (!$data) {
            return $data;
        }

        $currentType = FormUtil::getPassedValue('type', 'user', 'GETPOST');
        $currentFunc = FormUtil::getPassedValue('func', 'main', 'GETPOST');
        if ($currentType == 'user' && $currentFunc == 'display') {
            // increase amount of views
            $idField = $this->getIDField();
            DBUtil::incrementObjectFieldByID('kbase_ticket', 'views', $data[$idField], $idField, 1);
        }

        $data['subjectStripped'] = str_replace('"', '\'', $data['subject']);

        $data['detailurl'] = pnModURL('KnowledgeBase', 'user', 'display', array('id' => $data['ticketid']));
        $data['detailurlFormatted'] = DataUtil::formatForDisplay($data['detailurl']);

        $data['editurl'] = pnModURL('KnowledgeBase', 'user', 'edit', array('id' => $data['ticketid']));
        $data['editurlFormatted'] = DataUtil::formatForDisplay($data['editurl']);

        $this->_objData = $data;
        return $data;
    }
}
