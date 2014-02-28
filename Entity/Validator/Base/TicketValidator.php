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

namespace Guite\KnowledgeBaseModule\Entity\Validator\Base;

use Guite\KnowledgeBaseModule\AbstractValidator as BaseAbstractValidator;

use ServiceUtil;
use Zikula_EntityAccess;
use ZLanguage;

/**
 * Validator class for encapsulating entity validation methods.
 *
 * This is the base validation class for ticket entities.
 */
class TicketValidator extends BaseAbstractValidator
{
    /**
     * Performs all validation rules.
     *
     * @return mixed either array with error information or true on success
     */
    public function validateAll()
    {
        $errorInfo = array('message' => '', 'code' => 0, 'debugArray' => array());
        $dom = ZLanguage::getModuleDomain('GuiteKnowledgeBaseModule');
        if (!$this->isValidInteger('id')) {
            $errorInfo['message'] = __f('Error! Field value may only contain digits (%s).', array('id'), $dom);
            return $errorInfo;
        }
        if (!$this->isNumberNotLongerThan('id', 9)) {
            $errorInfo['message'] = __f('Error! Length of field value must not be higher than %2$s (%1$s).', array('id', 9), $dom);
            return $errorInfo;
        }
        if (!$this->isStringNotEmpty('workflowState')) {
            $errorInfo['message'] = __f('Error! Field value must not be empty (%s).', array('workflow state'), $dom);
            return $errorInfo;
        }
        if (!$this->isStringNotLongerThan('subject', 255)) {
            $errorInfo['message'] = __f('Error! Length of field value must not be higher than %2$s (%1$s).', array('subject', 255), $dom);
            return $errorInfo;
        }
        if (!$this->isStringNotEmpty('subject')) {
            $errorInfo['message'] = __f('Error! Field value must not be empty (%s).', array('subject'), $dom);
            return $errorInfo;
        }
        if (!$this->isStringNotLongerThan('content', 2000)) {
            $errorInfo['message'] = __f('Error! Length of field value must not be higher than %2$s (%1$s).', array('content', 2000), $dom);
            return $errorInfo;
        }
        if (!$this->isStringNotEmpty('content')) {
            $errorInfo['message'] = __f('Error! Field value must not be empty (%s).', array('content'), $dom);
            return $errorInfo;
        }
        if (!$this->isValidInteger('views')) {
            $errorInfo['message'] = __f('Error! Field value may only contain digits (%s).', array('views'), $dom);
            return $errorInfo;
        }
        if (!$this->isNumberNotLongerThan('views', 11)) {
            $errorInfo['message'] = __f('Error! Length of field value must not be higher than %2$s (%1$s).', array('views', 11), $dom);
            return $errorInfo;
        }
        if (!$this->isValidInteger('ratesUp')) {
            $errorInfo['message'] = __f('Error! Field value may only contain digits (%s).', array('rates up'), $dom);
            return $errorInfo;
        }
        if (!$this->isNumberNotLongerThan('ratesUp', 4)) {
            $errorInfo['message'] = __f('Error! Length of field value must not be higher than %2$s (%1$s).', array('rates up', 4), $dom);
            return $errorInfo;
        }
        if (!$this->isValidInteger('ratesDown')) {
            $errorInfo['message'] = __f('Error! Field value may only contain digits (%s).', array('rates down'), $dom);
            return $errorInfo;
        }
        if (!$this->isNumberNotLongerThan('ratesDown', 4)) {
            $errorInfo['message'] = __f('Error! Length of field value must not be higher than %2$s (%1$s).', array('rates down', 4), $dom);
            return $errorInfo;
        }
    
        return true;
    }
    
    /**
     * Check for unique values.
     *
     * This method determines if there already exist tickets with the same ticket.
     *
     * @param string $fieldName The name of the property to be checked
     * @return boolean result of this check, true if the given ticket does not already exist
     */
    public function isUniqueValue($fieldName)
    {
        if ($this->entity[$fieldName] === '') {
            return false;
        }
    
        $entityClass = 'GuiteKnowledgeBaseModule:TicketEntity';
        $serviceManager = ServiceUtil::getManager();
        $entityManager = $serviceManager->getService('doctrine.entitymanager');
        $repository = $entityManager->getRepository($entityClass);
    
        $excludeid = $this->entity['id'];
    
        return $repository->detectUniqueState($fieldName, $this->entity[$fieldName], $excludeid);
    }
    
    /**
     * Get entity.
     *
     * @return Zikula_EntityAccess
     */
    public function getEntity()
    {
        return $this->entity;
    }
    
    /**
     * Set entity.
     *
     * @param Zikula_EntityAccess $entity.
     *
     * @return void
     */
    public function setEntity(Zikula_EntityAccess $entity = null)
    {
        $this->entity = $entity;
    }
    
}