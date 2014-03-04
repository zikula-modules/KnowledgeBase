<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger (Guite)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Axel Guckelsberger <info@guite.de>.
 * @link https://guite.de
 * @link http://zikula.org
 * @version Generated by ModuleStudio 0.6.1 (http://modulestudio.de).
 */

namespace Guite\KnowledgeBaseModule\Api;

use Zikula_AbstractApi;

/**
 * Manual api class with custom additional methods.
 */
class KnowledgeBase_Api_Manual extends Zikula_AbstractApi
{
    /**
     * Select a single entity.
     *
     * @param integer $args['id'] The id to use to retrieve the ticket object (default=null).
     *
     * @return void
     */
    public function incrementViews($args)
    {
        if (!isset($args['id']) || !is_numeric($args['id'])) {
            return LogUtil::registerArgsError();
        }

        $entityClass = 'GuiteKnowledgeBaseModule:' . ucwords($objectType) . 'Entity';
        $repository = $this->entityManager->getRepository($entityClass);

        $repository->incrementViews($args['id']);
    }
}
