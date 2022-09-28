<?php 


/**
 * post-categories.php 
 *  definitions of functions responsible for fetching of information pretaining to post categories and topics and genres.
 *
 * Date created:
 *  13th of April 2022, Wednesday.
 *
 * Last update:
 *  13th of April 2022, Wednesday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

require_once('general-functions.php');

/* ============================================================================================|
 * Get_All_Categories:
 *  this function returns all the feilds and records of the post category db info.
 * ============================================================================================*/
function Get_All_Categories() {
    $sql = "SELECT * FROM post_categories";
    $result = Get_Result($sql);
    return $result;
} // end Get_All_Categories



/* ============================================================================================|
 * Get_Topic_By_CategoryID:
 *  returns the topic information associated with a given category info
 * ============================================================================================*/
function Get_Topic_By_CategoryID($cat_id) 
{
    $sql = "SELECT * FROM post_topics WHERE category_id = $cat_id";
    $result = Get_Result($sql);
    return $result;
} // end Get_Topic_By_CategoryID



/* ============================================================================================|
 * Get_Genre_By_TopicID:
 *  returns the genre info that is mapped to a given topic; like the above function
 * ============================================================================================*/
function Get_Genre_By_TopicID($topic_id) 
{
    $sql = "SELECT * FROM post_genres WHERE topic_id = $topic_id";
    $result = Get_Result($sql);
    return $result;
} // end Get_Genre_By_TopicID


/* ============================================================================================|
 * Get_All_Post_Topics()
 *  returns all the post topic info stored in the database
 * ============================================================================================*/
function Get_All_Post_Topics() 
{
    $sql = "SELECT * FROM post_topics";
    $result = Get_Result($sql);
    return $result;
} // end Get_Genre_By_TopicID


?>