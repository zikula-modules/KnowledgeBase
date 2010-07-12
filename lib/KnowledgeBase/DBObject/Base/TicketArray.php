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



Loader::loadClass('PNKnowledgeBaseArray', 'modules/KnowledgeBase/classes');

/**
 * This class provides basic functionality of PNTicketArrayBase
 */
abstract class PNTicketArrayBase extends PNKnowledgeBaseArray
{
    /**
     * Constructor, init everything to sane defaults and handle parameters.
     * It only needs to set the fields which are used to configure
     * the object's specific properties and actions.
     *
     * @param init        Initialization value (can be an object or a string directive) (optional) (default=null)
     *                    If it is an array it is set, otherwise it is interpreted as a string
     *                    specifying the source from where the data should be retrieved from.
     *                    Possible values:
     *                        D (DB), G ($_GET), P ($_POST), R ($_REQUEST), S ($_SESSION), V (failed validation)
     *
     * @param where       The where clause to use when retrieving the object array (optional) (default='')
     * @param orderBy     The order-by clause to use when retrieving the object array (optional) (default='')
     * @param assocKey    Key field to use for building an associative array (optional) (default=null)
     */
    function PNTicketArrayBase($init = null, $where = '', $orderBy = '', $assocKey = null)
    {
        // call base class constructor
        $this->PNObjectArray();

        // set the tablename this object maps to
        $this->_objType       = 'kbase_ticket';


        // set the ID field for this object
        $this->_objField      = 'ticketid';



        // set the access path under which the object's
        // input data can be retrieved upon input
        $this->_objPath       = 'ticket_array';


        // apply object permission filters
        $this->_objPermissionFilter[] = array('component_left'   => 'KnowledgeBase',
                                              'component_middle' => 'Ticket',
                                              'component_right'  => '',
                                              'instance_left'    => 'ticketid',
                                              'instance_middle'  => '',
                                              'instance_right'   => '',
                                              'level'            => ACCESS_READ);


        // call initialization routine
        $this->_init($init, $where, $orderBy, $assocKey);
    }

    /**
     * Retrieves an array with all fields which can be used for sorting instances
     */
    function getAllowedSortingFields()
    {
        return array(
                     'ticketid',
                     'subject',
                     'subjecturl',
                     'content',
                     'views',
                     'ratesup',
                     'ratesdown',
                     'obj_status',
                     'cr_date',
                     'cr_uid',
                     'lu_date',
                     'lu_uid'

);
    }

    /**
     * Retrieves the default sorting field/expression
     */
    function getDefaultSortingField()
    {
        return 'subject';
    }
    
    function selectPostProcess($all = null)
    {
        foreach ($this->_objData as $k => $data) {
        $data['ticketid'] = ((isset($data['ticketid']) && !empty($data['ticketid'])) ? DataUtil::formatForDisplay($data['ticketid']) : '');
        $data['subject'] = ((isset($data['subject']) && !empty($data['subject'])) ? DataUtil::formatForDisplay($data['subject']) : '');
        $data['subjecturl'] = ((isset($data['subjecturl']) && !empty($data['subjecturl'])) ? DataUtil::formatForDisplay($data['subjecturl']) : '');
        $data['content'] = ((isset($data['content']) && !empty($data['content'])) ? DataUtil::formatForDisplayHTML($data['content']) : '');
        $data['views'] = ((isset($data['views']) && !empty($data['views'])) ? DataUtil::formatForDisplay($data['views']) : '');
        $data['ratesup'] = ((isset($data['ratesup']) && !empty($data['ratesup'])) ? DataUtil::formatForDisplay($data['ratesup']) : '');
        $data['ratesdown'] = ((isset($data['ratesdown']) && !empty($data['ratesdown'])) ? DataUtil::formatForDisplay($data['ratesdown']) : '');

            $this->_objData[$k] = $data;
        }
    }

    /**
     * Interceptor being called if an object is used within a string context.
     * 
     * @return string
     */
    public function __toString() {
        $string  = 'Instance of the class "PNTicketArrayBase' . "\n";
        $string .= 'Managed table: ticket' . "\n";
        $string .= 'Table fields:' . "\n";
        $string .= '        ticketid' . "\n";
        $string .= '        subject' . "\n";
        $string .= '        subjecturl' . "\n";
        $string .= '        content' . "\n";
        $string .= '        views' . "\n";
        $string .= '        ratesUp' . "\n";
        $string .= '        ratesDown' . "\n";
        $string .= "\n";

        return $string;
    }
}
