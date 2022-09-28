<?php 


/**
 * post-categories.php 
 *  definitions of functions responsible for fetching of information pretaining to posts.
 *
 * Date created:
 *  13th of April 2022, Wednesday.
 *
 * Last update:
 *  5th of April 2022, Friday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

require_once('general-functions.php');


/* ============================================================================================|
 * Get_Top_Rated_Posts:
 *  returns all top rated posts ordered by like the first 10
 * ============================================================================================*/
function Get_Top_Rated_Posts() {
    $sql = "SELECT t.* 
    FROM (
    SELECT a.id, a.user_id, a.category_id, a.title, a.content, a.picture,
    a.post_type, a.state, a.created_date, a.last_updated, a.published_date, (SELECT COUNT(*) 
    FROM post_likes WHERE post_id=a.id AND status='Like') AS total
    FROM posts AS a
    WHERE post_type = 'Text' AND state='Yes') AS t
    ORDER BY t.total LIMIT 10";

    $result = Get_Result($sql);
    return $result;
} // end Get_Top_Rated_Posts

/* ============================================================================================|
 * Get_All_MM_Posts:
 *  returns all audio-video/multimedia based posts.
 * ============================================================================================*/
function Get_All_MM_Posts() {
    $sql = "SELECT * FROM posts WHERE post_type != 'Text' AND state='Yes'";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_All_MM_Posts



/* ============================================================================================|
 * Get_All_Text_Posts:
 *  returns all text based posts.
 * ============================================================================================*/
function Get_All_Text_Posts() {
    $sql = "SELECT * FROM posts WHERE post_type = 'Text' AND state='Yes'";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_All_Text_Posts



/* ============================================================================================|
 * Get_Post_By_Id:
 *  returns a post given it's id
 * ============================================================================================*/
function Get_Post_By_Id($post_id) {
    $sql = "SELECT * FROM posts WHERE id=$post_id";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_Post_By_Id




/* ============================================================================================|
 * Get_Post_Comment_By_Post_Id
 *  returns all comments under a post
 * ============================================================================================*/
function Get_Post_Comments_By_Post_Id($post_id) {
    $sql = "SELECT * FROM post_comments WHERE post_id=$post_id";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_Post_Comments_By_Id




/* ============================================================================================|
 * Get_Comment_Replies_By_Comment_Id
 *  returns all replies under a comment
 * ============================================================================================*/
function Get_Comment_Replies_By_Comment_Id($comment_id) {
    $sql = "SELECT * FROM comment_replies WHERE comment_id=$comment_id";
    
    $result = Get_Result($sql);
    return $result;
} // end Get_Comment_Replies_By_Comment_Id




/* ============================================================================================|
 * Get_Post_By_Topic_Id
 *  returns all posts belonging to a particular topic
 * ============================================================================================*/
function Get_Post_By_Topic_Id($topic_id) {
    $sql = "SELECT * 
    FROM posts 
    WHERE id IN (SELECT post_id 
    FROM post_topic_genre_mapping 
    WHERE topic_id=$topic_id)";

    $result = Get_Result($sql);
    return $result;
} // end Get_Post_By_Topic_Id



/* ============================================================================================|
 * Get_Post_By_Genre_Id
 *  returns all posts belonging to a particular genre
 * ============================================================================================*/
function Get_Post_By_Genre_Id($genre_id) {
    $sql = "SELECT * 
    FROM posts 
    WHERE id IN (SELECT post_id 
    FROM post_topic_genre_mapping 
    WHERE genre_id=$genre_id)";

    $result = Get_Result($sql);
    return $result;
} // end Get_Post_By_Genre_Id



/* ============================================================================================|
 * Get_Post_Topic_By_Id:
 *  returns the post topic for a given post
 * ============================================================================================*/
function Get_Post_Topic_By_Id($topic_id) {
    $sql = "SELECT *
    FROM post_topics 
    WHERE id = $topic_id";

    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Topic_By_Id



/* ============================================================================================|
 * Get_Post_Genre_By_Id:
 *  returns the post genre for a given topic
 * ============================================================================================*/
function Get_Post_Genre_By_Id($genre_id) {
    $sql = "SELECT *
    FROM post_genres
    WHERE id = $genre_id";

    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_Genre_By_Id



/* ============================================================================================|
 * Get_Post_Comment_Count:
 *  returns the count of comments for a given post
 * ============================================================================================*/
function Get_Post_Comment_Count($post_id) {
    $sql = "SELECT COUNT(*) FROM post_comments WHERE post_id=$post_id";

    $result = Get_Result_Num($sql);
    return $result[0];
} // end Get_Post_Comment_Count



/* ============================================================================================|
 * Get_Post_Like_Count:
 *  returns the count of likes for a given post
 * ============================================================================================*/
function Get_Post_Like_Count($post_id) {
    $sql = "SELECT COUNT(*) FROM post_likes WHERE post_id=$post_id AND status='Like'";

    $result = Get_Result_Num($sql);
    return $result[0];
} // end Get_Post_Like_Count



/* ============================================================================================|
 * Get_Post_Dislike_Count:
 *  returns the count of likes for a given post
 * ============================================================================================*/
function Get_Post_Dislike_Count($post_id) {
    $sql = "SELECT COUNT(*) FROM post_likes WHERE post_id=$post_id AND status='Dislike'";

    $result = Get_Result_Num($sql);
    return $result[0];
} // end Get_Post_Dislike_Count



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
 * Add_Post:
 *  write's the post as unpublished format
 * ============================================================================================*/
function Add_Post($request, $pic_path, $post_path) {
    // get form values
    $post_title = Esc($request['post_title']);
    $post_category = $request['post-category'];
    $topic_select = $request['topic-select'];
    $genre_select = $request['genre-select'];
    $post_pub = 'No';
    $post_type = $request['post-type'];
    $user = $_SESSION['user'];
    $uid = $user['id'];
    
    // get the id's for the topics and genres
    $category = Get_Post_Category_By_Name($post_category);
    $c = $category['id'];

    $topic = Get_Post_Topic_By_Name($topic_select);
    $t = $topic['id'];

    $genre = Get_Post_Genre_By_Name($genre_select);
    $g = $genre['id'];

    if ($post_type == "Text") {
        $post_content = nl2br(Esc($conn, $request['post-editor']));
    } // end if
    else {
        $post_content = $post_path;
    } // end else

    // test if we've a picture uploaded
    if (empty($pic_path)) $picture = NULL;
    else $picture = $pic_path;

    // prepare an sql statment
    $sql = "INSERT INTO posts (user_id, category_id, title, content, picture, post_type, state) 
    VALUES ($uid, $c, '$post_title', '$post_content', '$picture', '$post_type', '$post_pub')";
    $post_id = Update_Info($sql);

    // insert into post_topic_genre_mapping
    $sql = "INSERT INTO post_topic_genre_mapping (post_id, topic_id, genre_id) 
    VALUES ($post_id, $t, $c)";
    Update_Info($sql);
} // end Add_Post



/* ============================================================================================|
 * Add_Post_Comment:
 *  write's the post comment
 * ============================================================================================*/
function Add_Post_Comment($request, $post_id) {
    $comment = Esc($request);

    if (isset($_SESSION['user'])) {
        if (!empty($comment)) {
            // get the user for the post
            $sql = "SELECT * FROM users WHERE id = (SELECT user_id FROM posts WHERE id=$post_id)";
            $user = $_SESSION['user'];
            $user_id = $user['id'];

            $sql = "INSERT INTO post_comments (post_id, user_id, content) 
                VALUES ($post_id, $user_id, '$comment')";
            Update_Info($sql);
        } // end if post not empty
    } // end if set
    else {
        echo "<script>alert('You must be signed-in to write comments')</script>";
    } // end else
} // end Add_Post_Comment



/* ============================================================================================|
 * Add_Comment_Reply:
 *  write's the post comment replies
 * ============================================================================================*/
function Add_Comment_Reply($request, $post_id) {
    $reply = Esc($request['reply-text']);
    $comment_id = $request['comment-id'];

    if (isset($_SESSION['user'])) {
        if (!empty($reply)) {
            // get the user for the post
            $sql = "SELECT * FROM users WHERE id = (SELECT user_id FROM posts WHERE id=$post_id)";
            $user = $_SESSION['user'];
            $user_id = $user['id'];

            $sql = "INSERT INTO comment_replies (comment_id, user_id, content) 
                VALUES ($comment_id, $user_id, '$reply')";
            Update_Info($sql);
        } // end if post not empty
    } // end if set
    else {
        echo "<script>alert('You must be signed-in to write replies')</script>";
    } // end else
} // end Add_Comment_Reply



/* ============================================================================================|
 * Add_Comment_Reply:
 *  write's the post comment replies
 * ============================================================================================*/
function Get_Search_Posts($request) {
    $search = Esc($request['search-text']);
    $txt = '%' . $search . '%';
    
    $sql = "SELECT * FROM posts WHERE (title LIKE '$txt' OR content LIKE '$txt') AND state='Yes'";
    $result = Get_Result($sql);
    return $result;
} // end Get_Search_Posts


/* ============================================================================================|
 * Get_User_Posts
 *  returns all the posts from a given user
 * ============================================================================================*/
function Get_User_Posts($user_id) {
    $sql = "SELECT * FROM posts WHERE user_id=$user_id";

    $result = Get_Result($sql);
    return $result;
} // end Get_User_Posts



/* ============================================================================================|
 * Get_FAQs:
 *  Returns all faq's stored in the database
 * ============================================================================================*/
function Get_FAQs() {
    $sql = "SELECT * FROM faqs";

    $faqs = Get_Result($sql);
    return $faqs;
} // end Get_FAQs




/* ============================================================================================|
 * Get_About:
 *  Let's also get the about info here
 * ============================================================================================*/
function Get_About() {
    $sql = "SELECT * FROM abouts LIMIT 1";

    $about = Get_Result($sql);
    return $about;
} // end Get_About



/* ============================================================================================|
 * Update view count:
 *  Updates the view count
 * ============================================================================================*/
function Update_View_Count($post_id) {
    $sql = "UPDATE posts SET views = views + 1 WHERE id=$post_id";
    Update_Info($sql);
} // end Update_View_Count


?>