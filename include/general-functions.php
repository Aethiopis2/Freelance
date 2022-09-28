<?php

/**
 * general-functons.php 
 *  defintions for the most generic functions; since all that we do is run quries back and forth
 *  then we could generalize this method a bit more.
 *
 * Date created:
 *  11th of April 2022, Monday.
 *
 * Last update:
 *  11th of April 2022, Monday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

$dir_name = realpath(dirname('config.php'));
require_once($dir_name . '/config.php');

/* ============================================================================================|
 * Returns results as an associative array by running quires using an already
 *  connected db interface.
 * ============================================================================================*/
function Get_Result($sql) {
    global $conn;      // an open connection

    $result_set = mysqli_query($conn, $sql);
    $result_array = mysqli_fetch_all($result_set, MYSQLI_ASSOC);
    return $result_array;
} // end get_result


/* ============================================================================================|
 * this is the numerical version of the above associative array; this function
 *  returns results as numerical arrays; the ol'skool way
 * ============================================================================================*/
function Get_Result_Num($sql)
{
    global $conn;      // an open connection

    $result_set = mysqli_query($conn, $sql);
    $result_array = $result_set->fetch_array();
    return $result_array;
} // end Get_Result_Num


/* ============================================================================================|
 * Returns results as an associative array by running quires using an already
 *  connected db interface; however this is for ajax based functions which start a new connection
 * ============================================================================================*/
function Get_Result_Ajax($sql) {
    global $hn,$un, $pw, $db;

    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error)
    {
        die(mysqli_connect_error());
    } // end if bad connection

    $result_set = mysqli_query($conn, $sql);
    $result_array = mysqli_fetch_assoc($result_set);
    return $result_array;
} // end Get_Result_Ajax



/* ============================================================================================|
 * Update's, inserts or delete's a table info; depending on the query provided
 * ============================================================================================*/
function Update_Info($sql) {
    global $conn;

    mysqli_query($conn, $sql);      // no need of return types
    return $conn->insert_id;
} // end Update_Info



/* ============================================================================================|
 * thisfunction makes user entries safe for processing on our server; no funny business for
 *  a nifty user ...
 * ============================================================================================*/
function Esc($value)
{
    global $conn;

    $safe_value = $conn->real_escape_string($value);
    return $safe_value;
} // end Esc


?>