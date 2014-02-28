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

namespace Guite\KnowledgeBaseModule\Util\Base;

use Guite\KnowledgeBaseModule\Util\ControllerUtil as ConcreteControllerUtil;

use DataUtil;
use FormUtil;
use ModUtil;
use PageUtil;
use SecurityUtil;
use System;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zikula_AbstractBase;
use Zikula_View;
use Zikula\Core\Response\PlainResponse;

/**
 * Utility base class for view helper methods.
 */
class ViewUtil extends Zikula_AbstractBase
{
    /**
     * Determines the view template for a certain method with given parameters.
     *
     * @param Zikula_View $view       Reference to view object.
     * @param string      $type       Current type (admin, user, ...).
     * @param string      $objectType Name of treated entity type.
     * @param string      $func       Current function (index, view, ...).
     * @param Request     $request    Current request.
     *
     * @return string name of template file.
     */
    public function getViewTemplate(Zikula_View $view, $type, $objectType, $func, Request $request)
    {
        // create the base template name
        $template = DataUtil::formatForOS(ucwords($type) . '/' . ucwords($objectType) . '/' . $func);
    
        // check for template extension
        $templateExtension = $this->determineExtension($view, $type, $objectType, $func, $request);
    
        // check whether a special template is used
        $tpl = '';
        if ($request->isMethod('POST')) {
            $tpl = $request->request->filter('tpl', '', false, FILTER_SANITIZE_STRING);
        } elseif ($request->isMethod('GET')) {
            $tpl = $request->query->filter('tpl', '', false, FILTER_SANITIZE_STRING);
        }
    
        $templateExtension = '.' . $templateExtension;
        if ($templateExtension != '.tpl') {
            $templateExtension .= '.tpl';
        }
    
        if (!empty($tpl) && $view->template_exists($template . '_' . DataUtil::formatForOS($tpl) . $templateExtension)) {
            $template .= '_' . DataUtil::formatForOS($tpl);
        }
        $template .= $templateExtension;
    
        return $template;
    }

    /**
     * Utility method for managing view templates.
     *
     * @param Zikula_View $view       Reference to view object.
     * @param string      $type       Current type (admin, user, ...).
     * @param string      $objectType Name of treated entity type.
     * @param string      $func       Current function (index, view, ...).
     * @param string      $template   Optional assignment of precalculated template file.
     * @param Request     $request    Current request.
     *
     * @return mixed Output.
     */
    public function processTemplate(Zikula_View $view, $type, $objectType, $func, Request $request, $template = '')
    {
        $templateExtension = $this->determineExtension($view, $type, $objectType, $func, $request);
        if (empty($template)) {
            $template = $this->getViewTemplate($view, $type, $objectType, $func, $request);
        }
    
        // look whether we need output with or without the theme
        $raw = false;
        if ($request->isMethod('POST')) {
            $raw = (bool) $request->request->filter('raw', false, false, FILTER_VALIDATE_BOOLEAN);
        } elseif ($request->isMethod('GET')) {
            $raw = (bool) $request->query->filter('raw', false, false, FILTER_VALIDATE_BOOLEAN);
        }
        if (!$raw && in_array($templateExtension, array('csv', 'rss', 'atom', 'xml', 'pdf', 'vcard', 'ical', 'json', 'kml'))) {
            $raw = true;
        }
    
        if ($raw == true) {
            // standalone output
            if ($templateExtension == 'pdf') {
                $template = str_replace('.pdf', '', $template);
                return $this->processPdf($view, $template);
            } else {
                return new PlainResponse($view->display($template));
            }
        }
    
        // normal output
        return new Response($view->fetch($template));
    }

    /**
     * Get extension of the currently treated template.
     *
     * @param Zikula_View $view       Reference to view object.
     * @param string      $type       Current type (admin, user, ...).
     * @param string      $objectType Name of treated entity type.
     * @param string      $func       Current function (index, view, ...).
     * @param Request     $request    Current request.
     *
     * @return array List of allowed template extensions.
     */
    protected function determineExtension(Zikula_View $view, $type, $objectType, $func, Request $request)
    {
        $templateExtension = 'tpl';
        if (!in_array($func, array('view', 'display'))) {
            return $templateExtension;
        }
    
        $extParams = $this->availableExtensions($type, $objectType, $func);
        foreach ($extParams as $extension) {
            $extensionVar = 'use' . $extension . 'ext';
            $extensionCheck = $request->query->filter($extensionVar, 0, false, FILTER_VALIDATE_INT);
            if ($extensionCheck == 1) {
                $templateExtension = $extension;
                break;
            }
        }
    
        return $templateExtension;
    }

    /**
     * Get list of available template extensions.
     *
     * @param string $type       Current type (admin, user, ...).
     * @param string $objectType Name of treated entity type.
     * @param string $func       Current function (index, view, ...).
     *
     * @return array List of allowed template extensions.
     */
    public function availableExtensions($type, $objectType, $func)
    {
        $extParams = array();
        $hasAdminAccess = SecurityUtil::checkPermission('GuiteKnowledgeBaseModule:' . ucwords($objectType) . ':', '::', ACCESS_ADMIN);
        if ($func == 'view') {
            if ($hasAdminAccess) {
                $extParams = array('csv', 'rss', 'atom', 'xml', 'json', 'kml'/*, 'pdf'*/);
            } else {
                $extParams = array('rss', 'atom'/*, 'pdf'*/);
            }
        } elseif ($func == 'display') {
            if ($hasAdminAccess) {
                $extParams = array('xml', 'json', 'kml'/*, 'pdf'*/);
            }
        }
    
        return $extParams;
    }

    /**
     * Processes a template file using dompdf (LGPL).
     *
     * @param Zikula_View $view     Reference to view object.
     * @param string      $template Name of template to use.
     *
     * @return mixed Output.
     */
    protected function processPdf(Zikula_View $view, $template)
    {
        // first the content, to set page vars
        $output = $view->fetch($template);
    
        // make local images absolute
        $output = str_replace('img src="/', 'img src="' . System::serverGetVar('DOCUMENT_ROOT') . '/', $output);
    
        // see http://codeigniter.com/forums/viewthread/69388/P15/#561214
        //$output = utf8_decode($output);
    
        // then the surrounding
        $output = $view->fetch('include_pdfheader.tpl') . $output . '</body></html>';
    
        $controllerHelper = new ConcreteControllerUtil($this->serviceManager, ModUtil::getModule($this->name));
        // create name of the pdf output file
        $fileTitle = $controllerHelper->formatPermalink(System::getVar('sitename'))
                   . '-'
                   . $controllerHelper->formatPermalink(PageUtil::getVar('title'))
                   . '-' . date('Ymd') . '.pdf';
    
        // if ($_GET['dbg'] == 1) die($output);
    
        // instantiate pdf object
        $pdf = new \DOMPDF();
        // define page properties
        $pdf->set_paper('A4');
        // load html input data
        $pdf->load_html($output);
        // create the actual pdf file
        $pdf->render();
        // stream output to browser
        $pdf->stream($fileTitle);
    
        // prevent additional output by shutting down the system
        System::shutDown();
    
        return true;
    }
}
