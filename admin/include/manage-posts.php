<?php 


/**
 * manage-posts.php 
 *  definitions of functions responsible for fetching & editing of information pretaining to posts.
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
 * Get_Unpublished_Post:
 *  returns all the unpublished posts in the db
 * ============================================================================================*/
function Get_Unpublished_Posts() {
    $sql = "SELECT * FROM posts WHERE state='No'";

    $result = Get_Result($sql);
    return $result;
} // end Get_Unpublished_Posts



/* ============================================================================================|
 * Get_Post_Count:
 *  returns all count of posts since begining of time
 * ============================================================================================*/
function Get_Post_Count() {
    $sql = "SELECT COUNT(*) FROM posts";

    $result = Get_Result_Num($sql);
    return $result[0];
} // end Get_Post_Count



/* ============================================================================================|
 * Get_Topic_Count:
 *  returns all count of topics since begining of time
 * ============================================================================================*/
function Get_Topic_Count() {
    $sql = "SELECT COUNT(*) FROM post_topics";

    $result = Get_Result_Num($sql);
    return $result[0];
} // end Get_Topic_Count



/* ============================================================================================|
 * Get_Genre_Count:
 *  returns all count of genres since begining of time
 * ============================================================================================*/
function Get_Genre_Count() {
    $sql = "SELECT COUNT(*) FROM post_genres";

    $result = Get_Result_Num($sql);
    return $result[0];
} // end Get_Genre_Count



/* ============================================================================================|
 * Get_Post_Category_By_Id:
 *  returns the category info belonging to the post given it's id
 * ============================================================================================*/
function Get_Post_Category_By_Id($category_id) {
    $sql = "SELECT * FROM post_categories WHERE id = $category_id";
    
    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Category_By_Id



/* ============================================================================================|
 * Get_Post_Topics_By_Category_Name:
 *  returns the topic info belonging to a category by its category name
 * ============================================================================================*/
function Get_Post_Topics_By_Category_Name($cat_name) {
    $sql = "SELECT * FROM post_topics
    WHERE category_id IN (SELECT id FROM post_categories WHERE category = \"$cat_name\")";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_Post_Topics_By_Category_Name




/* ============================================================================================|
 * Get_All_Genres_By_Topic_Name:
 *  returns the genre info belonging to a topic by its topic name
 * ============================================================================================*/
function Get_All_Genres_By_Topic_Name($topic_name) {
    $sql = "SELECT * FROM post_genres
    WHERE topic_id IN (SELECT id FROM post_topics WHERE topic = '$topic_name')";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_All_Genres_By_Topic_Name



/* ============================================================================================|
 * Get_Post_Topic_By_Post_Id:
 *  returns the topic info belonging a given post id
 * ============================================================================================*/
function Get_Post_Topic_By_Post_Id($post_id) {
    $sql = "SELECT * FROM post_topics WHERE id IN (SELECT topic_id 
    FROM post_topic_genre_mapping 
    WHERE post_id = $post_id) LIMIT 1";
    
    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Topic_By_Post_Id



/* ============================================================================================|
 * Get_Post_Genre_By_Post_Id:
 *  returns the genre info belonging a given post id
 * ============================================================================================*/
function Get_Post_Genre_By_Post_Id($post_id) {
    $sql = "SELECT * FROM post_genres WHERE id IN (SELECT genre_id 
    FROM post_topic_genre_mapping 
    WHERE post_id = $post_id) LIMIT 1";
    
    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Genre_By_Post_Id



/* ============================================================================================|
 * Get_All_Posts:
 *  returns all the posts regardless ...
 * ============================================================================================*/
function Get_All_Posts() {
    $sql = "SELECT * FROM posts";

    $result = Get_Result($sql);
    return $result;
} // end Get_All_Posts



/* ============================================================================================|
 * Get_All_Posts:
 *  returns all the posts regardless ...
 * ============================================================================================*/
function Get_Post_By_Id($post_id) {
    $sql = "SELECT * FROM posts WHERE id = $post_id";

    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_By_Id



/* ============================================================================================|
 * Get_Post_Topic_By_Name:
 *  returns the named topic info
 * ============================================================================================*/
function Get_Post_Topic_By_Name($topic_name) {
    $sql = "SELECT * FROM post_topics WHERE topic = '$topic_name' LIMIT 1";

    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Topic_By_Name



/* ============================================================================================|
 * Get_Post_Genre_By_Name:
 *  returns the named genre info
 * ============================================================================================*/
function Get_Post_Genre_By_Name($genre_name) {
    $sql = "SELECT * FROM post_genres WHERE genre = \"$genre_name\" LIMIT 1";

    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Genre_By_Name



/* ============================================================================================|
 * Get_Post_Category_By_Name:
 *  returns the named category info
 * ============================================================================================*/
function Get_Post_Category_By_Name($cat_name) {
    $sql = "SELECT * FROM post_categories WHERE category = \"$cat_name\" LIMIT 1";

    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Category_By_Name



/* ============================================================================================|
 * Get_Post_Categories:
 *  returns the all category info
 * ============================================================================================*/
function Get_Post_Categories() {
    $sql = "SELECT * FROM post_categories";

    $result = Get_Result($sql);
    return $result;
} // end Get_Post_Categories



/* ============================================================================================|
 * Get_Post_Topics:
 *  returns the all topic info
 * ============================================================================================*/
function Get_Post_Topics() {
    $sql = "SELECT b.id, (SELECT category FROM post_categories AS a WHERE a.id = b.category_id) AS category,
    b.topic 
    FROM post_topics AS b";

    $result = Get_Result($sql);
    return $result;
} // end Get_Post_Topics




/* ============================================================================================|
 * Get_Post_Genres:
 *  returns the all genres info
 * ============================================================================================*/
function Get_Post_Genres() {
    $sql = "SELECT b.id, (SELECT topic FROM post_topics AS a WHERE a.id = b.topic_id) AS topic,
    b.genre
    FROM post_genres AS b";

    $result = Get_Result($sql);
    return $result;
} // end Get_Post_Topics



/* ============================================================================================|
 * Get_Post_Comments_By_Post_Id:
 *  returns the all the comments under a given id info
 * ============================================================================================*/
function Get_Post_Comments_By_Post_Id($post_id) {
    $sql = "SELECT (SELECT fullname FROM users WHERE id = a.user_id) fullname, a.content, a.post_id, a.id
    FROM post_comments AS a
    WHERE post_id=$post_id";

    $result = Get_Result($sql);
    return $result;
} // end Get_Post_Comments_By_Post_Id



?>