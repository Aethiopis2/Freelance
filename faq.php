<?php 
    require_once('include/home-header.php'); 

    $post_categories = Get_All_Categories();
    $faqs = Get_FAQs();

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
        <h1 class="page-title">FAQ's</h1>
        <?php foreach($faqs as $faq): ?>
        <div class="faq">
            <div class="question">
                <h3><?php echo $faq['question']; ?></h3>
                <svg width="15" height="10" viewbox="0 0 42 25">
                    <path d="M3 3L21 21L39 3" stroke="white" stroke-width="7" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="answer">
                <p>
                    <?php echo $faq['answer']; ?>
                </p>
            </div>
        </div>
        <?php endforeach ?>
        <!--X============================= Main contents =============================X-->

    </main>
    <!--X============================= Page-Content =============================X-->

    <!-- ============================= footer ============================= -->
    <?php require_once('include/home-footer.php'); ?>