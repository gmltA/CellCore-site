<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:    outputfilter
 * Name:    gzip
 * Version:    0.1
 * Date:    2003-02-13
 * Author:    Joscha Feth, joscha@feth.com
 * Purpose:    gzip the output, before it is sent to the client
 * -------------------------------------------------------------
 */
function smarty_outputfilter_gzip($tpl_source, $smarty)
{
    /*~ the compression level to use
        default: 9
        -------------------------------------
        0        ->    9
        less compressed ->    better compressed
        less CPU usage    ->    more CPU usage
        -------------------------------------
    */    
    $compression_level    =    4;
    
    /*~ force compression, even if gzip is not sent in HTTP_ACCEPT_ENCODING,
        for example Norton Internet Security filters this, but 95% percent of
        the browsers do support output compression, including Phoenix and Opera.
        default: yes
    */
    $force_compession    =    true;
    
    //~ message to append to the template source, if it is compressed
    $append_message = "\n<!-- gzip compression level ".$compression_level." -->";
    
    
    if(    !headers_sent() && //~ headers are not yet sent
        extension_loaded("zlib") && //~ zlib is loaded
                !$smarty->debugging && //~ possible bug IE ?!?
        (strstr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip") || $force_compession)) { //~ correct encoding is sent, or compression is forced            
        $tpl_source = gzencode($tpl_source.$append_message,$compression_level);                
    }
    unset($compression_level, $force_compession, $append_message);
    return $tpl_source;
}
?>