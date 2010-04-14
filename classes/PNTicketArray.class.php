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



Loader::loadClass('PNTicketArrayBase', 'modules/KnowledgeBase/classes/Base');

/**
 * This class implements the functionality of PNTicketArrayBase
 */
class PNTicketArray extends PNTicketArrayBase
{
    /**
     * retrieve subdata arrays
     */
    function selectPostProcess($objArray = null)
    {
        if (!$objArray) {
            $objArray =& $this->_objData;
        }

        if (!$objArray) {
            return $objArray;
        }

        foreach ($objArray as $k => $data) {
            $objArray[$k]['subjectStripped'] = str_replace('"', '\'', $data['subject']);

            $objArray[$k]['detailurl'] = pnModURL('KnowledgeBase', 'user', 'display', array('id' => $data['ticketid']));
            $objArray[$k]['detailurlFormatted'] = DataUtil::formatForDisplay($objArray[$k]['detailurl']);

            $objArray[$k]['editurl'] = pnModURL('KnowledgeBase', 'user', 'edit', array('id' => $data['ticketid']));
            $objArray[$k]['editurlFormatted'] = DataUtil::formatForDisplay($objArray[$k]['editurl']);
        }

        return $objArray;
    }
}
