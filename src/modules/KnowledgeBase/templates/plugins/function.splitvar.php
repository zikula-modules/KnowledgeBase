<?php
/**
* Smarty plugin
* @package Smarty
* @subpackage plugins
*/

/**
* Smarty {splitvar} function plugin
*
* Type:     function<br>
* Name:     splitvar<br>
* Date:     Oct 13, 2005<br>
* Purpose:  split a variable up by string<br>
* Input:
*         - var = variable to split up
*         - delim = delimiter (optional, default "|")
*         - assign = template varname to assign to
*
* Example:
* {splitvar var=$foo delim="|" assign="bar"}
*
* @author Monte Ohrt <monte@ispi.net>
* @version  1.0
* @param array
* @param Smarty
* @return null
*/
function smarty_function_splitvar($params, $smarty)
{
    if (!isset($params['var'])) {
        $smarty->trigger_error("splitvar: missing var parameter");
        return;
    }
    if (empty($params['assign'])) {
        $smarty->trigger_error("splitvar: missing assign parameter");
        return;
    }

    $_delim = (empty($params['delim'])) ? '|' : $params['delim'];
    $smarty->assign($params['assign'], explode($_delim, $params['var']));

    return;
}
