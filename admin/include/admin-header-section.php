<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
        //ini_set('display_errors', 1);

        include_once('include/manage-posts.php');
        include_once('include/manage-users.php');
        include_once('include/admin-functions.php');
        include_once('include/manage-faqs.php');

        
        if (isset($_SESSION['user']))
        {
            $user_info = $_SESSION['user'];
            
            $un_post = Get_Unpublished_Posts();
            $all_users = Get_Users();
        } // end if
        else
        {
            // prevent access to the dashboard without authentication
            $_SESSION['message'] = "You are not allowed to login";
                
            // redirect to public area
            header('location: ' . BASE_URL . 'index.php');				
            exit(0);
        } // end else wrong arrival

    ?>

    <!-- ================================= Links ===================================== -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/all.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/admin-style.css">