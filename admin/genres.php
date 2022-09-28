<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage Genres";
    $current_selection = 6; 

    $categories = Get_Post_Categories();
    $topics = Get_Post_Topics();
    $genres = Get_Post_Genres();
?>

    <title>Xpress Media | Manage Genres</title>
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
            <div class="container content">
                    <div class="action">
                        <?php if($isEditingGenre === true): ?>
                            <h4 class="page-title">Update Genres</h4>
                        <?php else: ?>
                            <h4 class="page-title">Create Genres</h4>
                        <?php endif ?>

                        <form action="<?php echo BASE_URL . 'admin/genres.php'; ?>" method="POST" enctype="multipart/form-data">
                            <!-- editing a user requires id --> 
                            <?php if($isEditingGenre === true): ?>
                                <input type="hidden" name="genre_id" value="<?php echo $genre_id; ?>">
                            <?php endif ?>
                            
                            <?php if($isEditingGenre === false): ?>
                                <select name="post-category" onchange="Fetch_Topics(this.value);" required>
                                    <option value="" selected disabled>Select Category</option>
                                    <?php foreach ($categories as $key => $cat): ?>
                                        <option value="<?php echo $cat['category']; ?>"><?php echo $cat['category']; ?></option>
                                    <?php endforeach ?>
                                </select>

                                <select name="topic-select" id="topic_select" required>
                                </select>
                            <?php else: ?>
                                <select name="post-category" onchange="Fetch_Topics(this.value);">
                                    <option value="" selected disabled>Select Category</option>
                                    <?php foreach ($categories as $key => $cat): ?>
                                        <option value="<?php echo $cat['category']; ?>"><?php echo $cat['category']; ?></option>
                                    <?php endforeach ?>
                                </select>

                                <select name="topic-select" id="topic_select">
                                </select>
                            <?php endif ?>

                            <input type="text" name="post-genre" value="<?php echo $genre_name; ?>" 
                                placeholder="New Genre ..." required>

                            <!-- if editing user, display the update button instead of create button -->
                            <div class="admin-button-wrapper">
                                <?php if ($isEditingGenre === true): ?> 
                                    <button type="submit" class="admin-btn" name="update-genre">Update</button>
                                <?php else: ?>
                                    <button type="submit" class="admin-btn" name="create-genre">Save</button>
                                <?php endif ?>
                            </div>

                        </form>
                    </div>

                    <!-- display records from db -->
                    <div class="table-div">
                        
                        <!-- display notification message -->
                        <?php include(ROOT_PATH . 'admin/include/messages.php'); ?>


                        <?php if(empty($user_info)): ?>
                            <h1>No topics in the database</h1>
                        <?php else: ?>
                            <h4>Genres</h4>
                            <table class="table">
                                <thead>
                                    <th>N</th>
                                    <th>Topic Name</th>
                                    <th>Genre Name</th>
                                    <th colspan="2">Action</th>
                                </thead>

                                <tbody>
                                    <?php foreach($genres as $key => $genre): ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $genre['topic']; ?></td>
                                            <td><?php echo $genre['genre']; ?></td>
                                            <td class="table-icon">
                                                <a href="genres.php?edit-genre=<?php echo $genre['id']; ?>"
                                                    style="color:green;" onMouseOut="style.color='green'" 
                                                    onMouseOver="style.color='aqua'">
                                                    <span class="fa fa-pencil btn edit"></span>
                                                </a>
                                            </td>
                                            <td class="table-icon">
                                                <a href="genres.php?delete-genre=<?php echo $genre['id']; ?>"
                                                    style="color:red;" onMouseOut="style.color='red'" 
                                                    onMouseOver="style.color='aqua'">
                                                <span class="fa fa-trash btn delete"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php endif ?>
                        
                    </div>

            </div>
        </main>
        <!--X============================= Main =============================X-->

    </div>

    <!--X============================= Main-content =============================X-->


    <!-- ============================= Javascript ============================= -->
    <script src="<?php echo BASE_URL; ?>js/jquery3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL; ?>js/all.js"></script>
    <script src="<?php echo BASE_URL; ?>js/admin-script.js"></script>

    <!--X============================= Javascript =============================X-->
</body>
</html>