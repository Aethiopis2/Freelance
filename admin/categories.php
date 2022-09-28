<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage Categories";
    $current_selection = 4; 

    $categories = Get_Post_Categories();
?>

    <title>Xpress Media | Manage Users</title>
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
                            <h4 class="page-title">Update Category</h4>
                        <?php else: ?>
                            <h4 class="page-title">Create Category</h4>
                        <?php endif ?>

                        <form action="<?php echo BASE_URL . 'admin/categories.php'; ?>" method="POST">
                            <!-- editing a user requires id --> 
                            <?php if($isEditingCategory === true): ?>
                                <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                            <?php endif ?>

                            <input type="text" name="category_name" value="<?php echo $category_name; ?>" 
                                placeholder="New Category ..." required>

                            <!-- if editing user, display the update button instead of create button -->
                            <div class="admin-button-wrapper">
                                <?php if ($isEditingCategory === true): ?> 
                                    <button type="submit" class="admin-btn" name="update-category">Update</button>
                                <?php else: ?>
                                    <button type="submit" class="admin-btn" name="create-category">Save</button>
                                <?php endif ?>
                            </div>

                        </form>
                    </div>

                    <!-- display records from db -->
                    <div class="table-div">
                        
                        <!-- display notification message -->
                        <?php include(ROOT_PATH . 'admin/includes/messages.php'); ?>


                        <?php if(empty($user_info)): ?>
                            <h1>No Categories in the database</h1>
                        <?php else: ?>
                            <h4>Users</h4>
                            <table class="table">
                                <thead>
                                    <th>N</th>
                                    <th>Category Name</th>
                                    <th colspan="2">Action</th>
                                </thead>

                                <tbody>
                                    <?php foreach($categories as $key => $category): ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $category['category']; ?></td>
                                            <td class="table-icon">
                                                <a href="categories.php?edit-category=<?php echo $category['id']; ?>"
                                                    style="color:green;" onMouseOut="style.color='green'" 
                                                    onMouseOver="style.color='aqua'">
                                                    <span class="fa fa-pencil btn edit"></span>
                                                </a>
                                            </td>
                                            <td class="table-icon">
                                                <a href="categories.php?delete-category=<?php echo $category['id']; ?>"
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