<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:    outputfilter
 * Name:    trimnls
 * Version:    0.1
 * Date:    2009-11-21
 * Author:    Raziel
 * -------------------------------------------------------------
 */
function smarty_outputfilter_singlestring($tpl_source, $smarty)
{

    $tpl_source = str_replace(chr(9), '', $tpl_source);
    $tpl_source = str_replace(chr(10), '', $tpl_source);        
    $tpl_source = str_replace(chr(13), '', $tpl_source);
    $tpl_source = str_replace('//<![CDATA[', '//<![CDATA['.chr(10), $tpl_source);
    
    return $tpl_source;
}
?>