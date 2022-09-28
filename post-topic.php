<?php 
    require_once('include/home-header.php'); 

    $post_categories = Get_All_Categories();

    if (isset($_GET['topic_id'])) {
        $topic_id = $_GET['topic_id'];

         /**
          * some php based variables; on the server side baby!!!
          */
        $post_categories = Get_All_Categories();
        $all_posts = Get_Post_By_Topic_Id($topic_id);
        $title_name = Get_Post_Topic_By_Id($topic_id)['topic'];
    } // end if
    
    if (isset($_GET['genre_id'])) {
        $genre_id = $_GET['genre_id'];

        /**
         * some php based variables; on the server side baby!!!
         */
        $all_posts = Get_Post_By_Genre_Id($genre_id);
        $title_name = Get_Post_Genre_By_Id($genre_id)['genre'];

    } // end if genre

    if (isset($_POST['search-post'])) {
        $title_name = "Search Results";

        $all_posts = Get_Search_Posts($_POST);
    } // end if searching


    // test for my posts
    if ( isset($_GET['user_id']) ) {
        $title_name = "My Posts";

        $all_posts = Get_User_Posts($_GET['user_id']);
    } // end if user_id


?>
    
    <title>XpressMedia | Topics</title>
</head>
<body>

    <!-- ============================= sticking buttons ============================= -->
    <div class="icon-bar">
        <a class="add-post" onclick="Write_Post_Modal(1)">
            <i class="fa-solid fa-signs-post"></i></a>
        <a class="search-post" onclick="Search_Modal(1)"><i class="fa-solid fa-search"></i></a> 
    </div>

    <!-- ============================= sticking buttons ============================= -->


    <!-- ============================= navigation menu ============================= -->
    
    <?php require_once('include/home-navbar.php'); ?>

    <!--X============================= navigation menu =============================X-->

    <!-- ============================= Page-Content ============================= -->
    <main>
        

        <div class="slide-shows">
            
        </div>
        <!-- ============================= Main contents ============================= -->
        
        <?php require_once('include/home-main-content.php'); ?>

        <!--X============================= Main contents =============================X-->

    </main>
    <!--X============================= Page-Content =============================X-->

    <!-- ============================= footer ============================= -->
    <?php require_once('include/home-footer.php'); ?>