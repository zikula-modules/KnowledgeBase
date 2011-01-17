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

class KnowledgeBase_Version extends Zikula_Version
{
    public function getMetaData()
    {
        $meta = array();
        $meta['displayname']    = $this->__('KnowledgeBase');
        $meta['description']    = $this->__('KnowledgeBase Module');
        $meta['url']            = $this->__('knowledgebase');
        $meta['version']        = '1.0.0';
        return $meta;
    }
}