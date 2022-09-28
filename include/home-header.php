<?php require_once("config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php 

        $post_types = ["Text", "Audio", "Video", "Other"];
        $user_roles = ["Admin", "Author"];
        

        include_once(ROOT_PATH . 'include/fetch-adverts.php');
        include_once(ROOT_PATH . 'include/post-categories.php');
        include_once(ROOT_PATH . 'include/fetch-posts.php');
        include_once(ROOT_PATH . 'include/signin-form.php');
        include_once(ROOT_PATH . 'include/signup-form.php');
        include_once(ROOT_PATH . 'include/fetch-users.php');
        
        $post_categories = Get_All_Categories();
        
        /**
         * test if we have a session set and all and if we are receving any form
         *  inptus and stuff
         */
        if (isset($_POST['uname']) && isset($_POST['password'])) {
            if (Authenticate_User($_POST['uname'], $_POST['password']) == false) {
                echo "<div class='error-item'>Invalid username and/or password</div>";
                echo "<input id='hidden-radio' type='hidden' value='-1'>";
            } // end if error
            else {
                // redirect page based on user value
                if ($_SESSION['user']['user_role'] == 'Admin') {
                    echo "<input id='hidden-radio' type='hidden' value='1'>";
                } // end if admin
                else {
                    echo "<input id='hidden-radio' type='hidden' value='2'>";
                } // end else everyone else
            } // end else
            exit;
        } // end if loggin in

        include_once(ROOT_PATH . 'include/write-post.php');
        include_once(ROOT_PATH . 'include/search-block.php');
        

    ?>
    
    <!-- ============================= style-sheets ============================= -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/all.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/aos.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/home-style.css">