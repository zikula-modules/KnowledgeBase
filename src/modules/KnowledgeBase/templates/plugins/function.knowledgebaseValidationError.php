<?php
/**
 * KnowledgeBase.
 *
 * @copyright Axel Guckelsberger
 * @link http://zikula.org
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @package KnowledgeBase
 * @author Axel Guckelsberger.
 * @url https://guite.de
 * @version Generated by ModuleStudio 0.5.2 (http://modulestudio.de) at Thu Feb 17 14:43:00 CET 2011.
 */

/**
 * The knowledgebaseValidationError plugin returns appropriate (and multilingual) error messages for different validation error types.
 *
 * Available parameters:
 *   - assign:   If set, the results are assigned to the corresponding variable instead of printed out.
 *
 * @param  array            $params All attributes passed to this function from the template.
 * @param  Zikula_Form_View $view   Reference to the view object.
 *
 * @return string The output of the plugin.
 */
function smarty_function_knowledgebaseValidationError($params, $view)
{
    $id = $params['id'];
    $class = $params['class'];

    $message = '';
    switch ($class) {
        case 'required':
            $message = $view->__('This is a required field.');
            break;
        case 'validate-number':
            $message = $view->__('Please enter a valid number in this field.');
            break;
        case 'validate-digits':
            $message = $view->__('Please use numbers only in this field. please avoid spaces or other characters such as dots or commas.');
            break;
        case 'validate-alpha':
            $message = $view->__('Please use letters only (a-z) in this field.');
            break;
        case 'validate-alphanum':
            $message = $view->__('Please use only letters (a-z) or numbers (0-9) only in this field. No spaces or other characters are allowed.');
            break;
        case 'validate-date':
            $message = $view->__('Please enter a valid date.');
            break;
        case 'validate-email':
            $message = $view->__('Please enter a valid email address. For example yourname@example.com .');
            break;
        case 'validate-url':
            $message = $view->__('Please enter a valid URL.');
            break;
        case 'validate-date-au':
            $message = $view->__('Please use this date format: dd/mm/yyyy. For example 17/03/2010 for the 17th of March, 2010.');
            break;
        case 'validate-currency-dollar':
            $message = $view->__('Please enter a valid $ amount. For example $100.00 .');
            break;
        case 'validate-selection':
            $message = $view->__('Please make a selection.');
            break;
        case 'validate-one-required':
            $message = $view->__('Please select one of the above options.');
            break;
    }

    $message = '<div id="advice-' . $class . '-' . $id . '" class="validation-advice z-formnote" style="display: none">' . $message . '</div>';

    if (array_key_exists('assign', $params)) {
        $view->assign($params['assign'], $message);
        return;
    }
    return $message;
}
