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



Loader::loadClass('PNKnowledgeBase', 'modules/KnowledgeBase/classes');

/**
 * This class provides basic functionality of PNTicketBase
 */
abstract class PNTicketBase extends PNKnowledgeBase
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
     * @param key         The DB key to use to retrieve the object (optional) (default=null)
     * @param field       The field containing the key value (optional) (default=null)
     */
    function PNTicketBase($init = null, $key = 0, $field = null)
    {
        // call base class constructor
        $this->PNObject();

        // set the tablename this object maps to

        $this->_objType       = 'kbase_ticket';

        // set the ID field for this object

        $this->_objField      = 'ticketid';

        // set the access path under which the object's
        // input data can be retrieved upon input

        $this->_objPath       = 'ticket';


        // apply object permission filters
        $this->_objPermissionFilter[] = array('component_left'   => 'KnowledgeBase',
                                              'component_middle' => 'Ticket',
                                              'component_right'  => '',
                                              'instance_left'    => 'ticketid',
                                              'instance_middle'  => '',
                                              'instance_right'   => '',
                                              'level'            => ACCESS_READ);




        // call initialisation routine
        $this->_init($init, $key, $this->_objField);
    }
    
    function selectPostProcess($data = null)
    {
        if (!$data) {
            $data =& $this->_objData;
        }
        
        $data['ticketid'] = ((isset($data['ticketid']) && !empty($data['ticketid'])) ? DataUtil::formatForDisplay($data['ticketid']) : '');
        $data['subject'] = ((isset($data['subject']) && !empty($data['subject'])) ? DataUtil::formatForDisplay($data['subject']) : '');
        $data['subjecturl'] = ((isset($data['subjecturl']) && !empty($data['subjecturl'])) ? DataUtil::formatForDisplay($data['subjecturl']) : '');
        $data['content'] = ((isset($data['content']) && !empty($data['content'])) ? DataUtil::formatForDisplayHTML($data['content']) : '');
        $data['views'] = ((isset($data['views']) && !empty($data['views'])) ? DataUtil::formatForDisplay($data['views']) : '');
        $data['ratesup'] = ((isset($data['ratesup']) && !empty($data['ratesup'])) ? DataUtil::formatForDisplay($data['ratesup']) : '');
        $data['ratesdown'] = ((isset($data['ratesdown']) && !empty($data['ratesdown'])) ? DataUtil::formatForDisplay($data['ratesdown']) : '');
    }


    /**
     * Interceptor being called if an object is used within a string context.
     * 
     * @return string
     */
    public function __toString() {
        $string  = 'Instance of the class "PNTicketBase' . "\n";
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
