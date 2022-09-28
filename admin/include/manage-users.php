<?php

/**
 * this file contains some basic functions pre-taining to user information; including add, edit, delete, and update.
 *
 * Date created:
 *  18th of April 2022, Monday.
 *
 * Last update:
 *  18th of April 2022, Monday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

require_once('admin-generals.php');



/* ============================================================================================|
 * Get_All_Users
 *  returns all user info
 * ============================================================================================*/
function Get_Users() {
    $sql = "SELECT * FROM users";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_Users



/* ============================================================================================|
 * Get_Users_Count:
 *  returns all count of topics since begining of time
 * ============================================================================================*/
function Get_Users_Count() {
    $sql = "SELECT COUNT(*) FROM users";

    $result = Get_Result_Num($sql);
    return $result[0];
} // end Get_Topic_Count



/* ============================================================================================|
 * Get_Post_Author:
 *  returns the author of a post given its post id
 * ============================================================================================*/
function Get_Post_Author($post_id) {
    $sql = "SELECT * FROM users WHERE id = (SELECT user_id FROM posts WHERE id = $post_id)";

    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Topic_Count


?>