<?php
/**
 * config.php
 *  this should be included at the top of the web-page file; it contains important configuration info
 *  and starter kits.
 * 
 * Date created:
 *  10th of April 2022, Sunday.
 *
 * Last update:
 *  10th of April 2022, Sunday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

session_start();        /* start php session keep track of activites */

require_once('db-login.php');


/**
 * start connection with the database server; and keep a global connection object
 */
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error)
{
    die(mysqli_connect_error());
} // end if bad connection


/**
 * these two lines gets us the root directory or URL respectively; so that we can navigate thru
 * our site with relative ease
 */
define ("ROOT_PATH", realpath(dirname(__FILE__)) . "/");
define ("BASE_URL", "http://localhost/xpress-media/");


?>