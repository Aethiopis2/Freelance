<?php

/**
 * admin-ajax.php 
 *  various support functions for ajax based calls
 *
 * Date created:
 *  19th of April 2022, Tuesday.
 *
 * Last update:
 *  23rd of April 2022, Saturday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

require_once('admin-generals.php');
require_once('manage-posts.php');

/* ============================================================================================|
 * Checks if username exists or not
 * ============================================================================================*/
if (isset($_POST['check_username'])) {
    $username = $_POST['check_username'];

    if (Check_Username($username) === true)
        echo 1;
    else echo 2;
} // end if checking username


function Check_Username($username) {
    $sql = "SELECT * FROM users WHERE username='$username'";
    $user = Get_Result_Ajax($sql);

    if (!empty($user)) return true;
    else return false;
} // end Check_Username



/* ============================================================================================|
 * Get's and populates the topics menu for select input during post creation or update.
 * ============================================================================================*/
if (isset($_POST['get_topics'])) {
    $category = $_POST['get_topics'];
    
    $cat_all = Get_Post_Topics_By_Category_Name($category);
    foreach ($cat_all as $cat) {
        echo "<option value=\"" . $cat['topic']. "\">".$cat['topic']."</option>";
    } // end foreach
    exit;
} // end if get_topics




/* ============================================================================================|
 * Get's and populates the topics menu for select input during post creation or update.
 * ============================================================================================*/
if (isset($_POST['get_genres'])) {
    $topic = $_POST['get_genres'];
    
    $genres = Get_All_Genres_By_Topic_Name($topic);
    foreach ($genres as $genre) {
        echo "<option value=\"" . $genre['genre']. "\">".$genre['genre']."</option>";
    } // end foreach
    exit;
} // end if get_topics


/* ============================================================================================|
 * Test's if our user has a session and returns a success or fail result
 * ============================================================================================*/
if (isset($_POST['user_signed'])) {
    // check for the session
    if (isset($_SESSION['user'])) {
        echo 1;     // success
    } // end if success
    else {
        echo -1;   // fail
    } // end else no success
} // end post user-signed



/* ============================================================================================|
 * Add's a new count to the database
 * ============================================================================================*/
if (isset($_POST['insert_like'])) {
    $user_id = $_POST['insert_like'];
    $post_id = $_POST['post_id'];

    $sql = "INSERT INTO post_likes (post_id, user_id, status, status_date)
    VALUES ($post_id, $user_id, 'Like', now())";
    Update_Info($sql);

    echo 1;
} // end insert_like post



/* ============================================================================================|
 * delete's a user's like count to the database
 * ============================================================================================*/
if (isset($_POST['delete_like'])) {
    $user_id = $_POST['delete_like'];
    $post_id = $_POST['post_id'];

    $sql = "DELETE FROM post_likes WHERE post_id=$post_id AND user_id=$user_id";
    Update_Info($sql);

    echo 1;
} // end delete_like post



/* ============================================================================================|
 * Add's a new count of dislikes to the database
 * ============================================================================================*/
if (isset($_POST['insert_dislike'])) {
    $user_id = $_POST['insert_dislike'];
    $post_id = $_POST['post_id'];

    $sql = "INSERT INTO post_likes (post_id, user_id, status, status_date)
    VALUES ($post_id, $user_id, 'Dislike', now())";
    Update_Info($sql);

    echo 1;
} // end insert_like post



/* ============================================================================================|
 * delete's a user's dislike count to the database
 * ============================================================================================*/
if (isset($_POST['delete_dislike'])) {
    $user_id = $_POST['delete_dislike'];
    $post_id = $_POST['post_id'];

    $sql = "DELETE FROM post_likes WHERE post_id=$post_id AND user_id=$user_id";
    Update_Info($sql);

    echo 1;
} // end delete_like post



/* ============================================================================================|
 * verifies an email address
 * ============================================================================================*/
if (isset($_POST['verify_email'])) {
    $api_key = "0aa229a4e37242f5a124e8d276458a98";
    $email = $_POST['verify_email'];
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://emailvalidation.abstractapi.com/v1/?api_key=$api_key&email=$email",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true
    ]);

    $response = curl_exec($ch);

    curl_close($ch);
    $data = json_decode($response, true);
    
    // test if data is delivarable
    if ($data['deliverability'] === 'UNDELIVERABLE') echo 1;
    else echo -1;
} // end if

?>