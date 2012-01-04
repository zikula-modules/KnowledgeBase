<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package KnowledgeBase
 * @author Axel Guckelsberger <info@guite.de>.
 * @link https://guite.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.5.4 (http://modulestudio.de) at Wed Jan 04 20:13:48 CET 2012.
 */

/**
 * Manual api class with custom additional methods.
 */
class KnowledgeBase_Api_Manual extends Zikula_AbstractApi
{
    /**
     * Select a single entity.
     *
     * @param integer $args['id']       The id to use to retrieve the ticket object (default=null).
     *
     * @return void
     */
    public function incrementViews($args)
    {
        if (!isset($args['id']) || !is_numeric($args['id'])) {
            return LogUtil::registerArgsError();
        }
        $repository = $this->entityManager->getRepository('KnowledgeBase_Entity_Ticket');
        $repository->incrementViews($args['id']);
    }
}
