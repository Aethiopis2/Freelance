<?php

/**
 * admin-functions.php 
 *  some more admin related function defintions and handlers; includes global values too
 *
 * Date created:
 *  18th of April 2022, Monday.
 *
 * Last update:
 *  2nd of May 2022, Monday (Day of the Muslim Ra'amadan).
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

require_once('admin-generals.php');


/* ============================================================================================|
 * globals
 * ============================================================================================*/
$errors = array();                              /* stores all error's and displays during reloads */
$messages = array();                            /* stores extra messages */
$isEditingUser = false;                         /* indicates if we are update a user-profile */
$isEditingPost = false;                         /* are we updating the post? */
$picture_uploaded = false;                      /* indicates if the post contains thumbnails */
$isnon_text_post = false;                       /* inidcates if the post type is multimedia */
$isEditingCategory = false;                     /* are we updating the category info */
$isEditingTopic = false;                        /* are we updating the topic */
$isEditingGenre = false;                        /* updating the genre are we? */
$isEditingFAQ = false;                          /* are we updating the faq info? */
$isEditingAbout = false;                        /* updating the about? */
$isEditingAdvert = false;                       /* updating the advert, are we? */
$isEditingAdvert2 = false;

$user_roles = array('Admin', 'Author');         /* enum konstant identifing the user role/type */
$avatar_uploaded =false;                        /* determines if avatar has been uploaded or not */
$admin_id = 0;                                  /* store's the currently selected admin id */
$post_id = 0;                                   /* store's the id for the post */
$category_id = 0;                               /* store's category id during updating */
$topic_id = 0;                                  /* store's id for the topic */
$genre_id = 0;                                  /* store's id for the genre */
$faq_id = 0;                                    /* store's id for faq table */
$advert_id = 0;                                 /* the adverts id goes here */


$fullname = "";                 /* user info attributes */
$username = "";
$email = "";
$tel = "";
$bio = "";
$avatar = "";
$role = "";

$post_title = "";               /* related to posts */
$post_type = "";
$post_content = "";
$picture = "";


$category_name = "";            /* the category name */
$topic_name = "";
$genre_name = "";


$faq_quiz = "";                 /* FAQ related */
$faq_ans = "";


$about_content = "";            /* About */


$ad_slogan = "";                /* Adverts */
$date_from = "";
$date_to = "";
$ad_picture = "";
$ad_slide_path = "";
$ad_slide_id = "";
$ad_link = "";

/* ============================================================================================|
 * Edit user
 * ============================================================================================*/
if (isset($_GET['edit-user']))
{
    $isEditingUser = true;
    $admin_id = $_GET['edit-user'];
    Edit_User();
} // end if user editing


function Edit_User() {
    global $username, $role, $admin_id, $email, $tel, $fullname, $bio, $avatar;

    $sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$admin = Get_Result_Ajax($sql);

	// set form values ($username and $email) on the form to be updated
    $fullname = $admin['fullname'];
	$username = $admin['username'];
	$email = $admin['email'];
    $tel = $admin['tel'];
    $bio = $admin['bio'];
    $avatar = $admin['avatar'];
} // end Edit_User


/* ============================================================================================|
 * Update user
 * ============================================================================================*/
if (isset($_POST['update-user'])) {
    if (!empty($_FILES['avatar']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["avatar"]["name"]);
        $targetfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], ROOT_PATH . '/' . $targetfilepath)) {
                $avatar_uploaded = true;
            } // end if file uploaded
            else {
                $avatar_uploaded = false;
            } // no avatar
        } // end if 
    } // end if

	Update_User($_POST, $targetfilepath);
} // end if updating


function Update_User($request, $filepath) {
    global $username, $role, $isEditingUser, $admin_id, $email, $tel, $fullname, $bio, $avatar,
        $errors, $messages, $avatar_uploaded;

    $do_update = false;         /* tells us if we need to update */

	// get id of the admin to be updated
	$admin_id = $request['admin_id'];

	// set edit state to false
	$isEditingUser = false;
    $fullname = Esc($request['fullname']);
    $tel = Esc($request['tel']);
	$username = Esc($request['username']);
	$email = Esc($request['email']);
    $ol_password = Esc($request['old_password']);
	$password = Esc($request['password']);
	$passwordConfirmation = Esc($request['passwordConfirmation']);
    $bio = Esc($request['bio']);
    $role = $request['role'];

    // test if password is set; if not then based on the image file uploaded;
    //  kook some sql statments
    if (empty($password)) {
        // empty password; test if we need to upload an image
        if ($avatar_uploaded === true) {
            $sql = "UPDATE users 
            SET username='$username', 
            email='$email', 
            user_role='$role', 
            fullname = '$fullname',
            bio = '$bio',
            avatar='$filepath'
            WHERE id=$admin_id";
        } // end if avatar not uploaded
        else {
            $sql = "UPDATE users 
            SET username='$username', 
            email='$email', 
            user_role='$role', 
            fullname = '$fullname',
            bio = '$bio' 
            WHERE id=$admin_id";
        } // end else avatar uploaded

        $do_update = true;
    } // end if password empty
    else {
        // test if the old pawd is not empty
        if (!empty($ol_password)) {
            // make sure that the old pwd is correct
            // encrypt the ol password
            $old = md5($ol_password);
            $query = "SELECT * FROM users WHERE username='$username' AND password='$old'";
            $user = Get_Result_Ajax($query);

            // test if there is something
            if (!empty($user)) {
                // make sure the new pwd and confirmation pwd match
                if ($password == $passwordConfirmation) {
                    $pwd = md5($password);
                    // based on uploded image change
                    if ($avatar_uploaded === true) {
                        $sql = "UPDATE users 
                        SET username='$username', 
                        password = '$pwd',
                        email='$email', 
                        user_role='$role', 
                        fullname = '$fullname',
                        bio = '$bio',
                        avatar='$filepath'
                        WHERE id=$admin_id";
                    } // end if avatar not uploaded
                    else {
                        $sql = "UPDATE users 
                        SET username='$username', 
                        password='$pwd',
                        email='$email', 
                        user_role='$role', 
                        fullname = '$fullname',
                        bio = '$bio' 
                        WHERE id=$admin_id";
                    } // end else avatar uploaded

                    $do_update = true;
                } // end if a match
                else {
                    array_push($errors, "The new passwords don't match, please try again.");
                    $do_update = false;
                }
            } // end if pwd correct
            else {
                array_push($errors, "The old password is not correct");
                $do_update = false;
            } // end else no old password
        } // end if ol_password
        else {
            array_push($errors, "Please let us know your old password?");
            $do_update = false;
        } // end else no ol_password
    } // end else if pwd not empty

    if ($do_update === true) {
        Update_Info($sql);
        array_push($messages, "Successfuly updated");
    } // end if updating
} // end Update_User


/* ============================================================================================|
 * Create user
 * ============================================================================================*/
if (isset($_POST['create-user'])) {
    $isEditingUser = false;

    // test if we've uploads
    if (!empty($_FILES['avatar']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["avatar"]["name"]);
        $targetfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], ROOT_PATH . '/' . $targetfilepath)) {
                $avatar_uploaded = true;
            } // end if file uploaded
            else {
                $avatar_uploaded = false;
            } // no avatar
        } // end if 
    } // end if

	Create_User($_POST, $targetfilepath);
} // end if create-user


function Create_User($request, $filepath) {
    global $errors, $messages;

    // get the form values
    $fullname = Esc($request['fullname']);
    $tel = Esc($request['tel']);
	$username = Esc($request['username']);
	$email = Esc($request['email']);
	$password = Esc($request['password']);
	$passwordConfirmation = Esc($request['passwordConfirmation']);
    $bio = Esc($request['bio']);
    $role = $request['role'];

    // test if the passwords match
    if ($password == $passwordConfirmation) {
        // test if we've a picture to upload
        if ($avatar_uploaded === false) { $filepath = NULL; }
        $pwd = md5($password);

        // kook a query
        $sql = "INSERT INTO users (fullname, username, password, user_role, email, tel, bio, avatar) 
        VALUES ('$fullname', '$username', '$pwd', '$role', '$email', '$tel', '$bio', '$filepath')";

        Update_Info($sql);
        array_push($messages, "Successfuly created a new user");
    } // end if insert
    else {
        array_push($error, "The passwords don't match");
    } // end else
} // end Create_User



/* ============================================================================================|
 * Delete user
 * ============================================================================================*/
if (isset($_GET['delete-user'])) {
    $isEditingUser = false;
    $user_id = $_GET['delete-user'];
    Delete_User($user_id);
} // end if 


function Delete_User($user_id) {
    $sql = "DELETE FROM users WHERE id = $user_id";
    Update_Info($sql);
    array_push($messages, "User deleted");
} // end Delete_User




/* ============================================================================================|
 * Edit Post
 * ============================================================================================*/
if (isset($_GET['edit-post'])) {
    $post_id = $_GET['edit-post'];
    $isEditingPost = true;

    Edit_Post($post_id);
} // end edit-post


function Edit_Post($post_id) {
    global $post_type, $post_content, $post_title, $picture;

    $sql = "SELECT * FROM posts WHERE id=$post_id";
    $posts = Get_Result_Ajax($sql);

    // assign variables
    $post_type = $posts['post_type'];
    $post_content = $posts['content'];
    $post_title = $posts['title'];
    $picture = $posts['picture'];
} // end Edit_Post



/* ============================================================================================|
 * Update Post
 * ============================================================================================*/
if (isset($_POST['update-post'])) {
    $isEditingPost = false;
    
    // test for an uploaded image
    $target_postfilepath = "";
    $target_picfilepath = "";

	if (!empty($_FILES['picture']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["picture"]["name"]);
        $target_picfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($target_picfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], ROOT_PATH . '/' . $target_picfilepath))
                $picture_uploaded = true;
            else
                $picture_uploaded = false;
        } // end if 
    } // end if

    // do test for uploaded multimedia
    if (!empty($_FILES['non-text-post']['name']))
    {
        $type = $_POST["post-type"];
        $tdir = "assets/uploads/" . $type . "/";
        $typefname = basename($_FILES["non-text-post"]["name"]);
        $target_postfilepath = $tdir . $typefname;
        $audiotypes = array("mp3", "wav", "wma", "mp4");
        $videotypes = array("mp4", "avi", "mpeg", "dat");
        $upload_type = pathinfo($target_postfilepath, PATHINFO_EXTENSION);

        if ( (in_array($upload_type, $audiotypes) && $type == "Audio") || 
            (in_array($upload_type, $videotypes) && $type == "video") ||
            ($type == "Other") )
        {
            if (move_uploaded_file($_FILES["non-text-post"]["tmp_name"], ROOT_PATH . "/" . $target_postfilepath))
                $isnon_text_post = true;
            else
                $isnon_text_post = false;
        } // end if
    } // end if

	Update_Post($_POST, $target_picfilepath, $target_postfilepath);
} // end if


function Update_Post($request, $pic_filepath, $post_filepath) {
    global $errors, $messages, $picture_uploaded;

    // get form values
    $post_title = Esc($conn, $request['post_title']);
    $post_category = $request['post-category'];
    $topic_select = $request['topic-select'];
    $genre_select = $request['genre-select'];
    $post_pub = $request['publish-post'];
    $post_type = $request['post-type'];
    $post_id = $request['post_id'];


    // get the old post
    $post = Get_Post_By_Id($post_id);
    $category = Get_Post_Category_By_Id($post['category_id']);
    $topic = Get_Post_Topic_By_Post_Id($post_id);
    $genre = Get_Post_Genre_By_Post_Id($post_id);

    $named_genre = Get_Post_Genre_By_Name($genre_select);
    $named_topic = Get_Post_Topic_By_Name($topic_select);

    if (empty($post_type)) {
        $post_type = $post['post_type'];
    } // end if empty post type

    // get the content
    if ($post_type == "Text") {
        $post_content = nl2br(Esc($conn, $request['post-editor']));
    } // end if
    else {
        if (empty($post_filepath)) {
            $post_content = str_replace(['<p>', '</p>'], '', Esc($request['post-editor']));
        } // end if no upload
        else {
            $post_content = $post_filepath;
        } // end else
    } // end else

    // some more variables
    $c; $t; $g;     /* category, topic, and genre respectively */

    // now test if there are any changes
    if ($post_category != $category['category']) $c = $category['id'];
    else $c = $post['category_id'];

    // test topics
    if ($named_topic['id'] != $topic['id']) $t = $named_topic['id'];
    else $t = $topic['id'];     // remains the same

    // and genres
    if ($named_genre['id'] != $genre['id']) $g = $named_genre['id'];
    else $g = $genre['id'];
    
    if ($picture_uploaded === true) {
        $picture = $request['picture'];

        $sql = "UPDATE posts SET 
        category_id = $c, 
        post_type = '$post_type', 
        published = '$post_pub', 
        title = '$post_title', 
        content = '$post_content', 
        pic = '$picture' 
        WHERE id = $post_id";
        Update_Info($sql);

        // insert to post_categories
        $sql = "UPDATE post_topic_genre_mapping 
        SET topic_id = $t,
        genre_id = $g 
        WHERE post_id = $post_id";
        
        Update_Info($sql);
    } // end if picture uploaded
    else {
    
        $sql = "UPDATE posts SET 
        category_id = $c,  
        post_type = '$post_type',
        published = '$post_pub',  
        title = '$post_title',  
        content = '$post_content'  
        WHERE id = $post_id";
        Update_Info($sql);
        
        // insert to post_categories
        $sql = "UPDATE post_topic_genre_mapping 
        SET topic_id = $t,
        genre_id = $g 
        WHERE post_id = $post_id";
        
        Update_Info($sql);
    } // end else no pic

    array_push($messages, "Successfuly updated post");
} // end Update_Post



/* ============================================================================================|
 * Create Post
 * ============================================================================================*/
if (isset($_POST['create-post'])) {
    $isEditingPost = false;
    $target_postfilepath = "";
    $target_picfilepath = "";

	if (!empty($_FILES['picture']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["picture"]["name"]);
        $target_picfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($target_picfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], ROOT_PATH . '/' . $target_picfilepath))
                $picture_uploaded = true;
            else
                $picture_uploaded = false;
        } // end if 
    } // end if

    // do test for uploaded multimedia
    if (!empty($_FILES['non-text-post']['name']))
    {
        $type = $_POST["post-type"];
        $tdir = "assets/uploads/" . $type . "/";
        $typefname = basename($_FILES["non-text-post"]["name"]);
        $target_postfilepath = $tdir . $typefname;
        $audiotypes = array("mp3", "wav", "wma", "mp4");
        $videotypes = array("mp4", "avi", "mpeg", "dat");
        $upload_type = pathinfo($target_postfilepath, PATHINFO_EXTENSION);

        if ( (in_array($upload_type, $audiotypes) && $type == "Audio") || 
            (in_array($upload_type, $videotypes) && $type == "video") ||
            ($type == "Other") )
        {
            if (move_uploaded_file($_FILES["non-text-post"]["tmp_name"], ROOT_PATH . "/" . $target_postfilepath))
                $isnon_text_post = true;
            else
                $isnon_text_post = false;
        } // end if
    } // end if

	Create_Post($_POST, $target_picfilepath, $target_postfilepath);
} // end if creating


function Create_Post($request, $pic_path, $post_path) {
    global $errors, $messages, $picture_uploaded;

    // get form values
    $post_title = Esc($request['post_title']);
    $post_category = $request['post-category'];
    $topic_select = $request['topic-select'];
    $genre_select = $request['genre-select'];
    $post_pub = $request['publish-post'];
    $post_type = $request['post-type'];
    $user = $_SESSION['user'];
    $uid = $user['id'];

    if (empty($post_pub))
        $post_pub = "No";
    
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

    array_push($messages, "Inserted new post successfuly");
} // end Create_Post



/* ============================================================================================|
 * Delete Post
 * ============================================================================================*/
if (isset($_GET['delete-post'])) {
    $isEditingPost = false;
    $post_id = $_GET['delete-post'];
    Delete_Post($post_id);
} // end if set


function Delete_Post($post_id) {
    global $messages;

    // delete all relationships
    $sql = "DELETE FROM comment_replies WHERE comment_id IN (SELECT id FROM post_comments WHERE post_id=$post_id)";
    Update_Info($sql);

    $sql = "DELETE FROM post_comments WHERE post_id=$post_id";
    Update_Info($sql);

    $sql = "DELETE FROM post_likes WHERE post_id=$post_id";
    Update_Info($sql);
    
    // delete the post genre too
    $sql = "DELETE FROM post_topic_genre_mapping WHERE post_id=$post_id";
    Update_Info($sql);

    // delete the post at last
    $sql = "DELETE FROM posts WHERE id=$post_id;";
    Get_Result($sql);

    array_push($messages, "Successfuly deleted the post");
} // end Delete_Post;




/* ============================================================================================|
 * Edit category
 * ============================================================================================*/
if (isset($_GET['edit-category'])) {
    $isEditingCategory = true;
    $category_id = $_GET['edit-category'];
    Edit_Category($category_id);
} // end if category edit



function Edit_Category($category_id) {
    global $messages, $errors, $category_name;

    $sql = "SELECT * FROM post_categories WHERE id = $category_id";
    $cat = Get_Result_Ajax($sql);

    $category_name = $cat['category'];
} // end Edit_Category



/* ============================================================================================|
 * update category
 * ============================================================================================*/
if (isset($_POST['update-category'])) {
    $isEditingCategory = false;
    Update_Category($_POST);
} // end if category edit



function Update_Category($cat) {
    global $messages, $errors;

    $name = Esc($cat['category_name']);
    $id = $cat['category_id'];

    $sql = "UPDATE post_categories SET category='$name' WHERE id = $id";
    Update_Info($sql);
} // end Update_Category



/* ============================================================================================|
 * create category
 * ============================================================================================*/
if (isset($_POST['create-category'])) {
    $isEditingCategory = false;
    Create_Category($_POST);
} // end if category edit



function Create_Category($cat) {
    global $messages, $errors;

    $name = Esc($cat['category_name']);
    $id = $cat['category_id'];

    $sql = "INSERT INTO post_categories (category)
    VALUE ('$name')";
    Update_Info($sql);
} // end Create_Category



/* ============================================================================================|
 * delete category
 * ============================================================================================*/
if (isset($_GET['delete-category'])) {
    $isEditingCategory = false;
    $id = $_GET['delete-category'];
    Delete_Category($id);
} // end if category edit



function Delete_Category($id) {
    global $messages, $errors;

    $sql = "DELETE FROM post_categories WHERE id=$id";
    Get_Result($sql);
} // end Delete_Category




/* ============================================================================================|
 * Edit topics
 * ============================================================================================*/
if (isset($_GET['edit-topic'])) {
    $isEditingTopic = true;
    $topic_id = $_GET['edit-topic'];
    Edit_Topic($topic_id);
} // end if edit



function Edit_Topic($topic_id) {
    global $topic_name;

    $sql = "SELECT * FROM post_topics WHERE id=$topic_id";
    $topic = Get_Result_Ajax($sql);

    $topic_name = $topic['topic'];
} // end Edit_Topic


/* ============================================================================================|
 * update topics
 * ============================================================================================*/
if (isset($_POST['update-topic'])) {
    $isEditingTopic = false;
    Update_Topic($_POST);
} // end if edit


function Update_Topic($request) {
    global $messages, $errors;

    $name = Esc($request['post-topic']);
    $cat = $request['post-category'];
    $id = $request['topic_id'];

    $sql = "SELECT * FROM post_categories WHERE id = (SELECT category_id FROM post_topics WHERE id = $id)";
    $category = Get_Result_Ajax($sql);

    // check the selected category
    if (!empty($cat)) {
        if ($cat !== $category['category']) {
            // get the new cat value
            $category = Get_Post_Category_By_Name($cat);
        } // end if
    } // end if updating the cat too

    $c = $category['id'];

    // kook an update query
    $sql = "UPDATE post_topics 
    SET category_id = $c,
    topic = '$name'
    WHERE id = $id";

    Update_Info($sql);

    array_push($messages, "Successfuly updated topic");
} // end Update_Topic



/* ============================================================================================|
 * create topics
 * ============================================================================================*/
if (isset($_POST['create-topic'])) {
    $isEditingTopic = false;
    Create_Topic($_POST);
} // end if edit


function Create_Topic($request) {
    global $messages, $errors;

    $name = Esc($request['post-topic']);
    $cat = $request['post-category'];
    $category = Get_Post_Category_By_Name($cat);
    $c = $category['id'];

    $sql = "INSERT INTO post_topics (category_id, topic)
    VALUES ($c, '$name')";

    Update_Info($sql);
    array_push($messages, "Successfuly created topic");
} // end Create_Topic




/* ============================================================================================|
 * create topics
 * ============================================================================================*/
if (isset($_GET['delete-topic'])) {
    $isEditingTopic = false;
    $topic_id = $_GET['delete-topic'];
    Delete_Topic($topic_id);
} // end if edit


function Delete_Topic($topic_id) {
    global $messages, $errors;

    $sql = "DELETE FROM post_topics WHERE id = $topic_id";

    Update_Info($sql);
    array_push($messages, "Successfuly deleted topic");
} // end Delete_Topic



/* ============================================================================================|
 * Edit genre
 * ============================================================================================*/
if (isset($_GET['edit-genre'])) {
    $isEditingGenre = true;
    $id = $_GET['edit-genre'];
    Edit_Genre($id);
} // end if genre edit



function Edit_Genre($id) {
    global $messages, $errors, $genre_id, $genre_name;

    $genre_id = $id;
    $sql = "SELECT * FROM post_genres WHERE id = $id";
    $genre = Get_Result_Ajax($sql);
    $genre_name = $genre['genre'];
} // end Edit_Genre




/* ============================================================================================|
 * Edit genre
 * ============================================================================================*/
if (isset($_POST['update-genre'])) {
    $isEditingGenre = false;
    Update_Genre($_POST);
} // end if genre edit



function Update_Genre($request) {
    global $messages, $errors, $genre_id, $genre_name;

    $genre_id = $request['genre_id'];
    $genre_name = Esc($request['post-genre']);
    $topic_name = $request['post-topic'];

    // make sure the topic is non empty if so make adjstments
    if (!empty($topic_name)) {
        $topic = Get_Post_Topic_By_Name($topic_name);
    } // end if 
    else {
        $sql = "SELECT * FROM post_topics WHERE id = (
            SELECT topic_id FROM post_genres WHERE id = $genre_id)";
        $topic = Get_Result_Ajax($sql);
    } // end else
    $t = $topic['id'];

    // run the update query
    $sql = "UPDATE post_genres SET 
    topic_id = $t,
    genre = '$genre_name'
    WHERE id=$genre_id";
    Update_Info($sql);

    array_push($messages, "Successfuly updated genre");
} // end Update_Genre



/* ============================================================================================|
 * Create genre
 * ============================================================================================*/
if (isset($_POST['create-genre'])) {
    $isEditingGenre = false;
    Create_Genre($_POST);
} // end if genre edit



function Create_Genre($request) {
    global $messages, $errors, $genre_id, $genre_name;

    $genre_name = Esc($request['post-genre']);
    $topic_name = $request['topic-select'];
    $topic = Get_Post_Topic_By_Name($topic_name);
    $t = $topic['id'];

    // run the update query
    $sql = "INSERT INTO post_genres (topic_id, genre) VALUES ($t, '$genre_name')";
    Update_Info($sql);

    array_push($messages, "Successfuly added new genre");
} // end Create_Genre



/* ============================================================================================|
 * Create genre
 * ============================================================================================*/
if (isset($_GET['delete-genre'])) {
    $isEditingGenre = false;
    Delete_Genre($_GET['delete-genre']);
} // end if genre edit



function Delete_Genre($id) {
    global $messages, $errors;

    // run the update query
    $sql = "DELETE FROM post_genres WHERE id = $id";
    Update_Info($sql);

    array_push($messages, "Successfuly deleted genre");
} // end Delete_Genre


/* ============================================================================================|
 * Delete comments
 * ============================================================================================*/
if (isset($_GET['delete-comment'])) {
    $comment_id = $_GET['delete-comment'];
    
    $sql = "DELETE FROM post_comments WHERE id=$comment_id";
    Get_Result_Ajax($sql);

    array_push($messages, "Successfuly deleted comment");
} // end if delete-comment




/* ============================================================================================|
 * Creating new FAQ content
 * ============================================================================================*/
if (isset($_POST['create-faq'])) {
    $isEditingFAQ = false;

    Create_FAQ($_POST);
} // end if



function Create_FAQ($request) {
    global $messages;

    $quiz = Esc($request['faq-quiz']);
    $ans = Esc($request['faq-ans']);

    $sql = "INSERT INTO faqs (question, answer) VALUES ('$quiz', '$ans')";
    Update_Info($sql);

    array_push($messages, "Successfuly added FAQ content");
} // end Create_FAQ



/* ============================================================================================|
 * Editing FAQ content
 * ============================================================================================*/
if (isset($_GET['edit-faq'])) {
    $isEditingFAQ = true;

    // get the id
    $faq_id = $_GET['edit-faq'];
    Edit_FAQ($faq_id);
} // end if



function Edit_FAQ($id) {
    global $faq_quiz, $faq_ans;

    // fill em up with a query
    $sql = "SELECT * FROM faqs WHERE id=$id";
    $faq = Get_Result_Ajax($sql);

    $faq_quiz = $faq['question'];
    $faq_ans = $faq['answer'];
} // end Edit_FAQ




/* ============================================================================================|
 * Updating FAQ content
 * ============================================================================================*/
if (isset($_POST['update-faq'])) {
    $isEditingFAQ = false;

    Update_FAQ($_POST);
} // end if Update



function Update_FAQ($request) {
    global $messages;

    $id = $request['faq-id'];
    $quiz = Esc($request['faq-quiz']);
    $ans = Esc($request['faq-ans']);

    $sql = "UPDATE faqs SET question='$quiz', answer='$ans' WHERE id=$id";
    Update_Info($sql);

    array_push($messages, "Successfuly updated");
} // end function




/* ============================================================================================|
 * Editing FAQ content
 * ============================================================================================*/
if (isset($_GET['delete-faq'])) {
    $isEditingFAQ = false;

    Delete_FAQ($_GET['delete-faq']);
} // end if deleting faq



function Delete_FAQ($id) {
    global $messages;

    $sql = "DELETE FROM faqs WHERE id=$id";
    Update_Info($sql);

    array_push($messages, "Successfuly deleted");
} // end Delete_FAQ



/* ============================================================================================|
 * Creating About content
 * ============================================================================================*/
if (isset($_POST['create-about'])) {
    $isEditingAbout = false;

    // test if we've uploads
    if (!empty($_FILES['picture']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["picture"]["name"]);
        $targetfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], ROOT_PATH . '/' . $targetfilepath)) {
                $avatar_uploaded = true;
            } // end if file uploaded
            else {
                $avatar_uploaded = false;
            } // no avatar
        } // end if 
    } // end if

	Create_About($_POST, $targetfilepath);
} // end if



function Create_About($request, $filepath) {
    global $messages;

    $content = Esc($request['about-content']);

    $sql = "INSERT INTO abouts (content, picture) VALUES ('$content', '$filepath')";
    Update_Info($sql);

    array_push($messages, "New About entry successful");
} // end Create_About




/* ============================================================================================|
 * Deleting about content
 * ============================================================================================*/
if (isset($_GET['delete-about'])) {
    $isEditingAbout = false;

    Delete_About($_GET['delete-about']);
} // end if deleting about



function Delete_About($id) {
    global $messages;

    $sql = "DELETE FROM abouts WHERE id=$id";
    Update_Info($sql);

    array_push($messages, "Successfuly deleted");
} // end Delete_About



/* ============================================================================================|
 * Editing about content
 * ============================================================================================*/
if (isset($_GET['edit-about'])) {
    $isEditingAbout = true;
    $about_id = $_GET['edit-about'];
    
    Edit_About($about_id);
} // end if 



function Edit_About($id) {
    global $messages, $about_content;

    $sql = "SELECT * FROM abouts WHERE id=$id";
    $about = Get_Result_Ajax($sql);

    $about_content = $about['content'];
} // end Edit_About



/* ============================================================================================|
 * Updating about content
 * ============================================================================================*/
if (isset($_POST['update-about'])) {
    $isEditingAbout = false;

    // test if we've uploads
    if (!empty($_FILES['picture']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["picture"]["name"]);
        $targetfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], ROOT_PATH . '/' . $targetfilepath)) {
                $avatar_uploaded = true;
            } // end if file uploaded
            else {
                $avatar_uploaded = false;
            } // no avatar
        } // end if 
    } // end if
    
    Update_About($_POST, $targetfilepath);
} // end if 



function Update_About($request, $filename) {
    global $messages, $about_id;

    $about_id = $request['about-id'];
    $content = Esc($request['about-content']);
    $sql;

    if (empty($filename)) {
        $sql = "UPDATE abouts SET content = '$content' WHERE id=$about_id";
    } // end if empty
    else {
        $sql = "UPDATE abouts SET content = '$content', picture='$filename' WHERE id=$about_id";
    } // end else

    Update_Info($sql);
    array_push($messages, "Successfuly updated");
} // end Update_About




/* ============================================================================================|
 * Edit ad
 * ============================================================================================*/
if (isset($_GET['edit-ad'])) {
    $isEditingAdvert = true;
    $advert_id = $_GET['edit-ad'];

    Edit_Ad($advert_id);
} // end if


function Edit_Ad($id) {
    global $ad_picture, $ad_slogan, $date_from, $date_to, $ad_link;

    $sql = "SELECT * FROM adverts WHERE id = $id";
    $ad = Get_Result_Ajax($sql);

    $ad_slogan = $ad['slogan'];
    $ad_picture = $ad['filepath'];
    $date_from = $ad['date_from'];
    $date_to = $ad['date_to'];
    $ad_link = $ad['adlink'];
} // end Edit_Ad



/* ============================================================================================|
 * Update ad
 * ============================================================================================*/
if (isset($_POST['update-ad'])) {
    $isEditingAdvert = false;
    $isEditingAdvert2 = false;

    if (!empty($_FILES['ad-picture']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["ad-picture"]["name"]);
        $targetfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["ad-picture"]["tmp_name"], ROOT_PATH . '/' . $targetfilepath)) {
                $avatar_uploaded = true;
            } // end if file uploaded
            else {
                $avatar_uploaded = false;
            } // no avatar
        } // end if 
    } // end if

    Update_Ad($_POST, $targetfilepath);
} // end update-ad



function Update_Ad($request, $filepath) {
    global $messges, $errors;

    $id = $request['advert-id'];

    $ad_type = $request['ad-type'];
    $slogan = Esc($request['ad-slogan']);
    $ad_link = Esc($request['ad-link']);
    $date_from = strtotime($request['ad-date-from']);
    $date_to = strtotime($request['ad-date-to']);
    

    if (!empty($filepath)) {
        if (empty($date_from)) {
            $sql = "UPDATE adverts 
            SET slogan='$slogan',
            type = '$ad_type', 
            adlink = '$ad_link'
            date_from=NULL, 
            date_to=NULL,
            filepath='$filepath'
            WHERE id = $id";
        } // end if
        else {
            $sql = "UPDATE adverts 
            SET slogan='$slogan',
            type = '$ad_type', 
            adlink = '$ad_link',
            date_from=$date_from, 
            date_to=$date_to,
            filepath='$filepath'
            WHERE id = $id";
        } // end else
    } // end if not empty
    else {
        if (empty($date_from)) {
            $sql = "UPDATE adverts 
            SET slogan='$slogan',
            type = '$ad_type',
            adlink = '$ad_link',
            date_from=NULL, 
            date_to=NULL
            WHERE id = $id";
        } // end if
        else {
            $sql = "UPDATE adverts 
            SET slogan='$slogan',
            type = '$ad_type',
            adlink = '$ad_link',
            date_from=$date_from, 
            date_to=$date_to
            WHERE id = $id";
        } // end else
    } // end else empty

    Update_Info($sql);
    array_push($messages, "Successfuly updated");
} // end Update_Ad



/* ============================================================================================|
 * Create ad
 * ============================================================================================*/
if (isset($_POST['create-ad'])) {
    $isEditingAdvert = false;
    $isEditingAdvert2 = false;

    $count = count($_FILES['ad-picture']['name']);
    $targetfilepath = array();


    for ($i = 0; $i < $count; $i++) {
        // test if we've uploads
        if (!empty($_FILES['ad-picture']['name'][$i]))
        {
            $targetDir = "assets/uploads/images/";
            $filename = basename($_FILES["ad-picture"]["name"][$i]);
            $targetfilepath[$i] = $targetDir . $filename;
            $allowtypes = array('jpg','png','jpeg','gif','pdf');

            // get a file type
            $filetype = pathinfo($targetfilepath[$i], PATHINFO_EXTENSION);
            if (in_array($filetype, $allowtypes))
            {
                if (move_uploaded_file($_FILES["ad-picture"]["tmp_name"][$i], ROOT_PATH . '/' . $targetfilepath[$i])) {
                    $avatar_uploaded = true;
                } // end if file uploaded
                else {
                    $avatar_uploaded = false;
                } // no avatar
            } // end if 
        } // end if

    } // end for

    Create_Ad($_POST, $targetfilepath);
} // end if



function Create_Ad($request, $filepaths) {
    global $messages, $errors;

    $count = count($filepaths);
    
    $ad_type = $request['ad-type'];
    $slogan = Esc($request['ad-slogan']);
    $ad_link = Esc($request['ad-link']);
    $date_from = $request['ad-date-from'];
    $date_to = $request['ad-date-to'];

    $sql;
    if ($ad_type === 'Banner') {
        // only 1 pic allowed
        if (!empty($date_from)) {
            $sql = "INSERT INTO adverts (slogan, type, adlink, filepath, date_from, date_to)
            VALUES ('$slogan', '$ad_type', '$ad_link', '$filepaths[0]', $date_from, $date_to)";
        } // end if
        else {
            $sql = "INSERT INTO adverts (slogan, type, adlink, filepath)
            VALUES ('$slogan', '$ad_type', '$ad_link', '$filepaths[0]')";
        } // end else
        Update_Info($sql);
    } // end if
    else {

        if (!empty($date_from)) {
            $sql = "INSERT INTO adverts (slogan, type, adlink, date_from, date_to)
            VALUES ('$slogan', '$ad_type', '$ad_link', $date_from, $date_to)";
        } // end if
        else {
            $sql = "INSERT INTO adverts (slogan, type, adlink)
            VALUES ('$slogan', '$ad_type', '$ad_link')";
        } // end else

        $ad_id = Update_Info($sql);

        // add the slides
        for ($i = 0; $i < $count; ++$i) {
            $sql = "INSERT INTO advert_slides (advert_id, filepath) VALUES ($ad_id, '$filepaths[$i]')";
            Update_Info($sql);
        } // end for
    } // end else not banner

    array_push($messages, "Successfuly created");
} // end Create_Ad




/* ============================================================================================|
 * Delete ad
 * ============================================================================================*/
if (isset($_GET['delete-ad'])) {
    $isEditingAdvert = false;
    $isEditingAdvert2 = false;

    $id = $_GET['delete-ad'];
    Delete_Ad($id);
} // end if delete ad



function Delete_Ad($id) {
    global $messages;
    $sql = "DELETE FROM advert_slides WHERE advert_id=$id";
    Update_Info($sql);

    array_push($messages, "Deleted slides");

    $sql = "DELETE FROM adverts WHERE id=$id";
    Update_Info($sql);
    array_push($messages, "Delete successful");
} // end Delete Add



/* ============================================================================================|
 * Edit ad slides
 * ============================================================================================*/
if(isset($_GET['edit-ad-slide'])) {
    $isEditingAdvert = true;
    $ids = explode(",", $_GET['edit-ad-slide']);
    $advert_id = $ids[1];

    Edit_Ad_Slides($ids);
} // end if



function Edit_Ad_Slides($ids) {
    global $ad_picture, $ad_slogan, $date_from, $date_to, $ad_slide_id, $ad_link;

    $sql = "SELECT * FROM adverts WHERE id = $ids[1]";
    $ad = Get_Result_Ajax($sql);

    $ad_slogan = $ad['slogan'];
    $ad_picture = $ad['filepath'];
    $date_from = $ad['date_from'];
    $date_to = $ad['date_to'];
    $ad_link = $ad['adlink'];

    $ad_slide_id = $ids[0];
} // end Edit_Ad_Slides



/* ============================================================================================|
 * Edit ad slides
 * ============================================================================================*/
if(isset($_POST['update-ad-slide'])) {
    $isEditingAdvert = false;

    // test if we've uploads
    if (!empty($_FILES['ad-slide-path']['name']))
    {
        $targetDir = "assets/uploads/images/";
        $filename = basename($_FILES["ad-slide-path"]["name"]);
        $targetfilepath = $targetDir . $filename;
        $allowtypes = array('jpg','png','jpeg','gif','pdf');

        // get a file type
        $filetype = pathinfo($targetfilepath, PATHINFO_EXTENSION);
        if (in_array($filetype, $allowtypes))
        {
            if (move_uploaded_file($_FILES["ad-slide-path"]["tmp_name"], ROOT_PATH . '/' . $targetfilepath)) {
                $avatar_uploaded = true;
            } // end if file uploaded
            else {
                $avatar_uploaded = false;
            } // no avatar
        } // end if 
    } // end if

    Update_Ad_Slide($_POST, $targetfilepath);
} // end if



function Update_Ad_Slide($request, $filepath) {
    global $messages;

    $id = $request['slide-id'];
    
    $sql = "UPDATE advert_slides SET filepath='$filepath' WHERE id=$id";
    Update_Info($sql);
    array_push($messages, "Successfuly updated slide");
} // end Update_Ad_Slide




/* ============================================================================================|
 * delete ad slides
 * ============================================================================================*/
if(isset($_GET['delete-ad-slide'])) {
    $isEditingAdvert = false;

    Delete_Ad_Slide($_GET['delete-ad-slide']);
} // end if



function Delete_Ad_Slide($id) {
    global $messages;
    
    $sql = "DELETE FROM advert_slides WHERE id=$id";
    Update_Info($sql);

    array_push($messages, "Successfuly deleted slide");
} // end if

?>