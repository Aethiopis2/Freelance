<?php 
    require_once('include/home-header.php'); 

    /**
     * some php based variables; on the server side baby!!!
     */
    $home_slides = Get_Advert_Slides("'Home'");
    $post_categories = Get_All_Categories();
    $mm_posts = Get_All_MM_Posts();
    $all_posts = Get_Top_Rated_Posts();
    $title_name = "Top Posts";
    
     /**
     * test for the new register
     */
    if (isset($_POST['register-btn'])) {
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

	    Register_User($_POST, $targetfilepath);
    } // end if


    /**
     * test if our user is writing posts
     */
    if (isset($_POST['create-post'])) {
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
    
        Add_Post($_POST, $target_picfilepath, $target_postfilepath);
    } // end if


?>
    
    <title>XpressMedia | Home</title>
</head>
<body>

    <!-- ============================= sticking buttons ============================= -->
    <div class="icon-bar">
        <a class="add-post" onclick="Write_Post_Modal(1)">
            <i class="fa-solid fa-signs-post"></i></a>
        <a class="search-post" onclick="Search_Modal(1)"><i class="fa-solid fa-search"></i></a> 
    </div>

    <!-- ============================= sticking buttons ============================= -->

    <!-- ============================= home-page slider ============================= -->
    <div class="slideshow-container">
        <div class="slide-shows" data-aos="fade-up" data-aos-delay="100">
            <?php $total_slides = Get_Advert_Slides_Count(1); ?>
            <?php foreach($home_slides as $key => $slide): ?>
                <div class="myslides0 fade">
                    <div class="numberText"><?php echo ($key + 1) . '/' . $total_slides; ?></div>
                    <img src="<?php echo BASE_URL . $slide['filepath']; ?>" alt="" class="slideshow-img">
                    <div class="home-slogan" data-aos="fade-up" data-aos-delay="300"><?php echo $slide['slogan']; ?></div>
                </div>
            <?php endforeach ?>

            <a class="prev" onclick="Push_Slides(-1, 0)"><i class="fa-solid fa-angle-left" style="color:white"></i></a>
            <a class="next" onclick="Push_Slides(1, 0)"><i class="fa-solid fa-angle-right" style="color:white"></i></a>
        </div>

        <div class="slide-text">
            <?php foreach($home_slides as $key => $slide): ?>
                <span class="dot0" onclick="Current_Slide(<?php echo $key+1; ?>, 0)"></span> 
            <?php endforeach ?>
        </div>
    </div>
    <!--X============================= home-page slider =============================X-->

    <!-- ============================= navigation menu ============================= -->
    
    <?php require_once('include/home-navbar.php'); ?>

    <!--X============================= navigation menu =============================X-->

    <!-- ============================= Page-Content ============================= -->
    <main>
        
        <!-- ============================= Blog-carousel ============================= -->

        <section>
            <div class="blog-carousel">
                <div class="container">
                    <div class="owl-carousel owl-theme blog-post">

                        <?php foreach($mm_posts as $post): ?>
                            <div class="carousel-content" data-aos="fade-right" data-aos-delay="200">
                                <?php if(isset($post['picture'])): ?>
                                    <img src="<?php echo BASE_URL . $post['picture']; ?>" alt="">
                                <?php endif ?>
                                <div class="carousel-title">
                                    <h3><?php echo $post['title']; ?></h3>
                                    <a href="<?php echo BASE_URL; ?>single-post.php?post_id=<?php echo $post['id']; ?>">
                                        Play
                                    </a>
                                    <div class="carousel-info">
                                        <span><?php echo $post['post_type']; ?></span>
                                        <span><i class="fas fa-calendar-alt text-gray"></i>&nbsp;&nbsp;
                                            <?php echo date("M d, Y", strtotime($post['last_updated'])); ?></span>
                                            <?php $comment = Get_Post_Comment_Count($post['id']); ?>
                                        <?php if($comment > 0): ?>
                                        <span><i class="fas fa-comment text-gray" style="color:beige"></i>&nbsp;&nbsp;
                                            <?php echo $comment; ?>
                                        </span>
                                        <?php else: ?>
                                            <span><i class="fas fa-comment text-gray"></i>&nbsp;&nbsp;
                                            <?php echo $comment; ?>
                                        </span>
                                        <?php endif ?>

                                        <span><i class="fas fa-heart text-gray"></i>&nbsp;&nbsp;
                                            <?php echo Get_Post_Like_Count($post['id']); ?>
                                        </span>
                                        <span><i class="fa-solid fa-heart-crack text-gray"></i>&nbsp;&nbsp;
                                            <?php echo Get_Post_Dislike_Count($post['id']); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>
                </div>
            </div>
        </section>

        <!--X============================= Blog-carousel =============================X-->

        <!-- ============================= Main contents ============================= -->

        <?php require_once('include/home-main-content.php'); ?>

        <!--X============================= Main contents =============================X-->

    </main>
    <!--X============================= Page-Content =============================X-->

    <!-- ============================= footer ============================= -->
    <?php require_once('include/home-footer.php'); ?>