<?php 
    require_once('include/home-header.php'); 

    $post_categories = Get_All_Categories();
    $abouts = Get_About();
?>
    
    <title>XpressMedia | FAQ's</title>
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
        

        <!-- ============================= Main contents ============================= -->
        <h1 class="page-title">About Me</h1>
        
        <div class="about-container">
            <?php foreach($abouts as $about): ?>
            <div class="picture-container">
                <img src="<?php echo BASE_URL . $about['picture']; ?>" alt="">
            </div>

            <div class="text-container">
                <p>
                    <?php echo $about['content']; ?>
                </p>
            </div>
            <?php endforeach ?>
        </div>

        <!--X============================= Main contents =============================X-->

    </main>
    <!--X============================= Page-Content =============================X-->

    <!-- ============================= footer ============================= -->
    <?php require_once('include/home-footer.php'); ?>