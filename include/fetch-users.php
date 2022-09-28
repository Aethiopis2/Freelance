<?php

/**
 * this file contains some basic functions pre-taining to user information; only fetching is required
 *
 * Date created:
 *  15th of April 2022, Friday.
 *
 * Last update:
 *  15th of April 2022, Friday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

require_once('general-functions.php');


/* ============================================================================================|
 * Authenticate
 *  authenticates users and leads on them to the right path if successful
 * ============================================================================================*/
function Authenticate_User($raw_username, $raw_password)
{
    // trim and make user entry safe
    $username = Esc($raw_username);
    $password = md5(Esc($raw_password));

    // now kook query and test for any errors ...
    $sql = "SELECT * FROM users WHERE (username='$username' OR email='$username') AND password='$password'";
    $user = Get_Result_Ajax($sql);

    // test if there is something
    if (!empty($user)) {
        // successful auth; save the user session info
        $_SESSION['user'] = $user;
        $uname = $user['username'];

        $sql = "INSERT INTO user_stats (user_id, log, log_time)
        VALUE ($id, 'login', now())";
        Update_Info($sql);

        return true;
    } // end if user id'ed
    else {

        // return an error to ajax server
        return false;
    } // end else not authenticated
} // end Authenticate



/* ============================================================================================|
 * Get_Post_User_By_Id
 *  returns the person who posted a given article given the post id.
 * ============================================================================================*/
function Get_Post_User_By_Id($post_id) {
    $sql = "SELECT * FROM users WHERE id = (SELECT user_id FROM posts WHERE id = $post_id)";
    
    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Post_User_By_Id



/* ============================================================================================|
 * Get_All_Users
 *  returns all user info
 * ============================================================================================*/
function Get_Users() {
    $sql = "SELECT * FROM users";
    
    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_Users



/* ============================================================================================|
 * Get_User_By_Id
 *  returns all user info
 * ============================================================================================*/
function Get_User_By_Id($user_id) {
    $sql = "SELECT * FROM users WHERE id=$user_id";
    
    $result = Get_Result_Ajax($sql);
    return $result;
} // end Get_User_By_Id



/* ============================================================================================|
 * Register_User
 *  returns all user info
 * ============================================================================================*/
function Register_User($request, $filepath) {
    global $errors, $messages;

    // get the form values
    $fullname = Esc($request['fullname']);
    $tel = Esc($request['tel']);
	$username = Esc($request['username']);
	$email = Esc($request['email']);
	$password = Esc($request['password']);
	$passwordConfirmation = Esc($request['passwordConfirmation']);
    $bio = Esc($request['bio']);
    $role = 'Author';

    $emailv = $request['email-v'];
    $usernamev = $request['username-v'];

    if ($emailv == 1 && $usernamev == 1) {
        // test if the passwords match
        if ($password === $passwordConfirmation) {
            // test if we've a picture to upload
            
            $pwd = md5($password);
            $sql = "";
            if ($avatar_uploaded === false) { 
                // kook a query
                $sql = "INSERT INTO users (fullname, username, password, user_role, email, tel, bio) 
                VALUES ('$fullname', '$username', '$pwd', '$role', '$email', '$tel', '$bio')";
            } // end if
            else {
                // kook a query
                $sql = "INSERT INTO users (fullname, username, password, user_role, email, tel, bio, avatar) 
                VALUES ('$fullname', '$username', '$pwd', '$role', '$email', '$tel', '$bio', '$filepath')";
            } // end else


            $id = Update_Info($sql);
            array_push($messages, "Successfuly created a new user");

            $sql = "SELECT * FROM users WHERE id = $id";
            $nuser = Get_Result($sql);
            $_SESSION['user'] = $nuser;
        } // end if insert
        else {
            array_push($errors, "The passwords don't match");
        } // end else
    } // end if email verified
    else {
        if ($emailv === -1) array_push($errors, "Supplied email is not valid");
        if ($usernamev === -1) array_push($errors, "The username already exists");
    } // end else
} // end Create_User

?>