<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * PEAR::Net_Finger
 *
 * This class acts as interface to finger servers
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Net
 * @package   Net_Finger
 * @author    Sebastian Nohn <sebastian@nohn.net>
 * @copyright 2003-2007 Sebastian Nohn <sebastian@nohn.net>
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $id$
 * @link      http://pear.php.net/package/Net_Finger
 * @since     File available since Release 1.0.0
 */

require_once 'PEAR.php';
require_once 'Net/Socket.php';

/**
 * PEAR's Net_Finger:: interface.
 *
 * Provides functions useful for Finger-Queries.
 *
 * @category Net
 * @package  Net_Finger
 * @author   Sebastian Nohn <sebastian@nohn.net>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version  Release: @package_version@
 * @link     http://pear.php.net/package/Net_Finger
 */
class Net_Finger
{

    /**
     * Implements Net_Finger::query() function using PEAR's socket functions
     *
     * @param string $server The finger-server to query
     * @param string $query  The finger database object to lookup
     *
     * @return mixed  		  The data returned from the finger-server as string
     *                        or a PEAR_Error ( see Net_Socket for error codes)
     */   
    function query($server, $query)
    {
        $socket = new Net_Socket;
        if (PEAR::isError($sockerror = $socket->connect($server, 79))) {
            $data = new PEAR_Error("Error connecting to $server (Net_Socket says: ".
                        $sockerror->getMessage().")", $sockerror->getCode());
        } else {
            $query .= "\n"; 
            $socket->write($query); 
            $data = $socket->read(16384); 
            $socket->disconnect();
        }         
        return $data; 
    } 
} 
?>
