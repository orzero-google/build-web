<?php 
/**
 * Sanity check, is it really an URL?
 */
function is_url($url){
    $url = substr($url,-1) == "/" ? substr($url,0,-1) : $url;
    if ( !$url || $url=="" ) return false;
    if ( !( $parts = @parse_url( $url ) ) ) return false;
    else {
        if ( $parts[scheme] != "http" && $parts[scheme] != "https" && $parts[scheme] != "ftp" && $parts[scheme] != "gopher" ) return false;
        else if ( !eregi( "^[0-9a-z]([-.]?[0-9a-z])*.[a-z]{2,4}$", $parts[host], $regs ) ) return false;
        else if ( !eregi( "^([0-9a-z-]|[_])*$", $parts[user], $regs ) ) return false;
        else if ( !eregi( "^([0-9a-z-]|[_])*$", $parts[pass], $regs ) ) return false;
        else if ( !eregi( "^[0-9a-z/_.@~-]*$", $parts[path], $regs ) ) return false;
        else if ( !eregi( "^[0-9a-z?&=#,]*$", $parts[query], $regs ) ) return false;
    }
    return true;
}

/**
 * Prints: true
 */
if (is_url('http://crunchbang.org')) echo 'true'; else echo 'false';
echo "\r\n";
/**
 * Prints: true
 */
if (is_url('https://crunchbang.org')) echo 'true'; else echo 'false';
echo "\r\n";
/**
 * Prints: false
 */
if (is_url('www.crunchbang.org')) echo 'true'; else echo 'false';
echo "\r\n";
/**
 * Prints: false
 */
if (is_url('crunchbang.org')) echo 'true'; else echo 'false';
echo "\r\n";
/**
 * Prints: false
 */
if (!is_url('http://www.crunchbang.org')) echo 'true'; else echo 'false';
echo "\r\n";

?>