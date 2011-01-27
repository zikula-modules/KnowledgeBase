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
 * @version Generated by ModuleStudio 0.5.2 (http://modulestudio.de) at Thu Jan 27 15:07:46 CET 2011.
 */

/**
 * Utility helper base class
 */
class KnowledgeBase_Base_Util
{
    /**
     * Returns an array of all allowed object types in KnowledgeBase.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, actionHandler, block, contentType, mailz).
     * @param array  $args    Additional arguments.
     *
     * @return array List of allowed object types
     */
    public static function getObjectTypes($context = '', $args = array())
    {
        if (!in_array($context, array('controllerAction', 'api', 'actionHandler', 'block', 'contentType', 'mailz'))) {
            $context = 'controllerAction';
        }

        $allowedObjectTypes = array();
        $allowedObjectTypes[] = 'ticket';
        return $allowedObjectTypes;
    }

    /**
     * Returns the default object type in KnowledgeBase.
     *
     * @param string $context Usage context (allowed values: controllerAction, api, actionHandler, block, contentType, mailz).
     * @param array  $args    Additional arguments.
     *
     * @return string The name of the default object type
     */
    public static function getDefaultObjectType($context = '', $args = array())
    {
        if (!in_array($context, array('controllerAction', 'api', 'actionHandler', 'block', 'contentType', 'mailz'))) {
            $context = 'controllerAction';
        }

        $defaultObjectType = 'ticket';
        return $defaultObjectType;
    }

    /**
     * Utility method for managing view templates.
     *
     * @param Zikula_View $view       Reference to view object.
     * @param string      $type       Current type (admin, user, ...).
     * @param string      $objectType Name of treated entity type.
     * @param string      $func       Current function (main, view, ...).
     * @param array       $args       Additional arguments.
     *
     * @return mixed Output.
     */
    public static function processViewTemplate($view, $type, $objectType, $func, $args = array())
    {
        // create the base template name
        $template = DataUtil::formatForOS($type . '/' . $objectType . '/' . $func);

        // check for template extension
        $templateExtension = self::determineTemplateExtension($view, $type, $objectType, $func, $args);

        // check whether a special template is used
        $tpl = FormUtil::getPassedValue('tpl', isset($args['tpl']) ? $args['tpl'] : '', 'GETPOST');
        if (!empty($tpl) && $view->template_exists($template . '_' . DataUtil::formatForOS($tpl) . '.' . $templateExtension)) {
            $template .= '_' . DataUtil::formatForOS($tpl);
        }
        $template .= '.' . $templateExtension;

        // look whether we need output with or without the theme
        $raw = (bool) FormUtil::getPassedValue('raw', (isset($args['raw']) && is_bool($args['raw'])) ? $args['raw'] : false, 'GETPOST', FILTER_VALIDATE_BOOLEAN);
        if (!$raw && in_array($templateExtension, array('csv', 'rss', 'atom', 'xml', 'pdf', 'vcard', 'ical'))) {
            $raw = true;
        }

        if ($raw == true) {
            // standalone output
            if ($templateExtension == 'pdf') {
                return self::processPdf();
            }
            else {
                $view->display($template);
            }
            return true;
        }

        // normal output
        return $view->fetch($template);
    }

    /**
     * Get extension of currently treated template
     *
     * @param Zikula_View $view       Reference to view object.
     * @param string      $type       Current type (admin, user, ...).
     * @param string      $objectType Name of treated entity type.
     * @param string      $func       Current function (main, view, ...).
     * @param array       $args       Additional arguments.
     *
     * @return array List of allowed template extensions.
     */
    protected static function determineTemplateExtension($view, $type, $objectType, $func, $args = array())
    {
        $templateExtension = 'tpl';
        if (!in_array($func, array('view', 'display'))) {
            return $templateExtension;
        }

        $extParams = self::availableTemplateExtensions($type, $objectType, $func, $args);
        foreach ($extParams as $extension) {
            $extensionCheck = (int) FormUtil::getPassedValue('use' . $extension . 'ext', 0, 'GET', FILTER_VALIDATE_INT);
            if ($extensionCheck == 1) {
                $templateExtension = $extension;
                break;
            }
        }
        return $templateExtension;
    }

    /**
     * Get list of available template extensions
     *
     * @param Zikula_View $view       Reference to view object.
     * @param string      $type       Current type (admin, user, ...).
     * @param string      $objectType Name of treated entity type.
     * @param string      $func       Current function (main, view, ...).
     * @param array       $args       Additional arguments.
     *
     * @return array List of allowed template extensions.
     */
    public static function availableTemplateExtensions($type, $objectType, $func, $args = array())
    {
        $extParams = array();
        if ($func == 'view') {
            if (SecurityUtil::checkPermission('KnowledgeBase::', '::', ACCESS_ADMIN)) {
                $extParams = array('csv', 'rss', 'atom', 'xml'/*, 'pdf'*/);
            }
            else {
                $extParams = array('rss', 'atom'/*, 'pdf'*/);
            }
        }
        elseif ($func == 'display') {
            $extParams = array('xml'/*, 'pdf'*/);
        }
        return $extParams;
    }

    /**
     * Processes a template file using dompdf (LGPL).
     * To use this functionality:
     *    - download dompdf from the project page at http://www.digitaljunkies.ca/dompdf/
     *    - copy it to modules/KnowledgeBase/lib/vendor/dompdf/ (see inclusion below)
     *    - override the corresponding template
     *
     * @param string $template Name of template to use.
     *
     * @return mixed Output.
     */
    protected static function processPdf($template)
    {
        // include dom pdf classes
        $pdfConfigFile = 'modules/KnowledgeBase/lib/vendor/dompdf/dompdf_config.inc.php';
        if (!file_exists($pdfConfigFile)) {
            return false;
        }
        require_once($pdfConfigFile);

        // first the content, to set page vars
        $output = $render->fetch($template);

        // see http://codeigniter.com/forums/viewthread/69388/P15/#561214
        $output = utf8_decode($output);

        // then the surrounding
        $output = $render->fetch('include_pdfheader.tpl') . $output . '</body></html>';

        // create name of the pdf output file
        $fileTitle = self::formatPermalink(System::getVar('sitename')) . '-' . self::formatPermalink(PageUtil::getVar('title'));
        $fileTitle .= '-' . date('Ymd') . '.pdf';

//if ($_GET['dbg'] == 1) die($output);

        // instantiate pdf object
        $pdf = new DOMPDF();
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

    /**
     * Create nice permalinks
     */
    public static function formatPermalink($name)
    {
        $name = str_replace(array('ä', 'ö', 'ü', 'Ä', 'Ö', 'Ü', 'ß', '.', '?', '"', '/', ':', 'é', 'è', 'â'),
                            array('ae', 'oe', 'ue', 'Ae', 'Oe', 'Ue', 'ss', '', '', '', '-', '-', 'e', 'e', 'a'),
                            $name);
        $name = DataUtil::formatPermalink($name);
        return strtolower($name);
    }
}
