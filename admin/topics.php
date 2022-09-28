<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage Topics";
    $current_selection = 5; 

    $categories = Get_Post_Categories();
    $topics = Get_Post_Topics();
?>

    <title>Xpress Media | Manage Topics</title>
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
                    <?php if($isEditingCategory === true): ?>
                        <h4 class="page-title">Update Topic</h4>
                    <?php else: ?>
                        <h4 class="page-title">Create Topic</h4>
                    <?php endif ?>

                    <form action="<?php echo BASE_URL . 'admin/topics.php'; ?>" method="POST">
                        <!-- editing a user requires id --> 
                        <?php if($isEditingTopic === true): ?>
                            <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
                        <?php endif ?>
                        
                        <?php if($isEditingTopic === true): ?>
                            <select name="post-category">
                                <option value="" selected disabled>Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['category']; ?>"><?php echo $cat['category']; ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php else: ?>
                            <select name="post-category" required>
                                <option value="" selected disabled>Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['category']; ?>"><?php echo $cat['category']; ?></option>
                                <?php endforeach ?>
                            </select>
                        <?php endif ?>

                        <input type="text" name="post-topic" value="<?php echo $topic_name; ?>" 
                            placeholder="New topic ..." required>

                        <!-- if editing user, display the update button instead of create button -->
                        <div class="admin-button-wrapper">
                            <?php if ($isEditingTopic === true): ?> 
                                <button type="submit" class="admin-btn" name="update-topic">Update</button>
                            <?php else: ?>
                                <button type="submit" class="admin-btn" name="create-topic">Save</button>
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
                        <h4>All Topics</h4>
                        <table class="table">
                            <thead>
                                <th>N</th>
                                <th>Category Name</th>
                                <th>Topic Name</th>
                                <th colspan="2">Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($topics as $key => $topic): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $topic['category']; ?></td>
                                        <td><?php echo $topic['topic']; ?></td>
                                        <td class="table-icon">
                                            <a href="topics.php?edit-topic=<?php echo $topic['id']; ?>"
                                                style="color:green;" onMouseOut="style.color='green'" 
                                                onMouseOver="style.color='aqua'">
                                                <span class="fa fa-pencil btn edit"></span>
                                            </a>
                                        </td>
                                        <td class="table-icon">
                                            <a href="topics.php?delete-topic=<?php echo $topic['id']; ?>"
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