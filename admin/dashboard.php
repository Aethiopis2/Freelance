<?php require_once('include/admin-header-section.php'); 
    $page_name = "Dashboard"; 
    $current_selection = 1;
?>

    <title>Xpress Media | Dashboard</title>
</head>
<body>
    
    <!-- ============================= Sidebar ============================= -->
    
    <?php require_once('include/admin-sidebar.php'); ?>
    
    <!--X============================= Sidebar =============================X-->

    <!-- ============================= Main-content ============================= -->
    
    <div class="main-content">

        <!-- ============================= Header bar ============================= -->

        <?php require_once('include/admin-headbar.php'); ?>

        <!--X============================= Header bar =============================X-->

        <!-- ============================= Main ============================= -->
        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1><?php echo Get_Post_Count(); ?></h1>
                        <span>Posts</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-signs-post fa-3x"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo Get_Users_Count(); ?></h1>
                        <span>Users</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-users fa-3x"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo Get_Topic_Count(); ?></h1>
                        <span>Topics</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-bars-staggered fa-3x"></span>
                    </div>
                </div>

                <div class="card-single">
                    <div>
                        <h1><?php echo Get_Genre_Count(); ?></h1>
                        <span>Genres</span>
                    </div>
                    <div>
                        <span class="fa-solid fa-ethernet fa-3x"></span>
                    </div>
                </div>
                
            </div>

            <div class="recent-grid">
                <div class="projects">
                    <div class="card">
                        <div class="card-header">
                            <h3>Unpublished Posts</h3>

                            <button>See all <span class="las la-arrow-right"></span></button>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                            <td>Title</td>
                                            <td>Category</td>
                                            <td>Topic</td>
                                            <td>Genre</td>
                                            <td>Type</td>
                                            <td>Author</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($un_post as $unp): ?>
                                        <tr>
                                            <td><?php echo $unp['title']; ?></td>
                                            <td><?php echo Get_Post_Category_By_Id($unp['category_id'])['category']; ?></td>
                                            <td><?php echo Get_Post_Topic_By_Post_Id($unp['id'])['topic']; ?></td>
                                            <td><?php echo Get_Post_Genre_By_Post_Id($unp['id'])['genre']; ?></td>
                                            <td><?php echo $unp['post_type']; ?></td>
                                            <td><?php echo Get_Post_Author($unp['id'])['fullname']; ?></td>
                                            <!--<td> <span class="status"></span>2</td> -->
                                        </tr>
                                        <?php endforeach ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="customers">
                    <div class="card">
                        <div class="card-header">
                            <h3>Users</h3>

                            <button>See all <span class="las la-arrow-right"></span></button>
                        </div>

                        <div class="card-body">

                            <?php foreach($all_users as $all): ?>
                            <div class="customer">
                                <div class="info">
                                    <img src="<?php echo BASE_URL . $all['avatar']; ?>" width="40px" height="40px" alt="">
                                    <div class>
                                        <h4><?php echo $all['fullname']; ?></h4>
                                        <small><?php echo $all['bio']; ?></small>
                                    </div>
                                    <div class="contact">
                                        <span class="las la-user-circle"></span>
                                        <span class="las la-comment"></span>
                                        <span class="las la-phone"></span>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach ?>

                        </div>
                    </div>
                </div>
            </div>

        </main>
        <!--X============================= Main =============================X-->

    </div>

    <!--X============================= Main-content =============================X-->


    <!-- ============================= Javascript ============================= -->
    <script src="<?php echo BASE_URL; ?>/js/jquery3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/js/all.js"></script>

    <!--X============================= Javascript =============================X-->
</body>
</html>