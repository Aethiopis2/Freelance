<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage About";
    $current_selection = 8; 

    $abouts = Get_About();
?>

    <title>Xpress Media | Manage FAQs</title>
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
                    <?php if($isEditingAbout === true): ?>
                        <h4 class="page-title">Update About</h4>
                    <?php else: ?>
                        <h4 class="page-title">New About</h4>
                    <?php endif ?>

                    <form action="<?php echo BASE_URL . 'admin/abouts.php'; ?>" method="POST" 
                        enctype="multipart/form-data" class="modal-content animate">

                        <!-- editing a faq requires id --> 
                        <?php if($isEditingAbout === true): ?>
                            <input type="hidden" name="about-id" value="<?php echo $about_id; ?>">
                        <?php endif ?>

                        <?php if($isEditingAbout === false): ?>
                            <input type="file" name="picture" value="<?php echo $about_pic; ?>" placeholder="Picture ..."
                                required>
                        <?php else: ?>
                            <input type="file" name="picture" value="<?php echo $about_pic; ?>" placeholder="Picture ...">
                        <?php endif ?>

                        <?php if($isEditingAbout === false): ?>
                            <textarea name="about-content" id="post-editor" placeholder="About ..."
                                    rows="10"></textarea>
                        <?php else: ?>
                            <textarea name="about-content" id="post-editor" placeholder="About ..."
                                rows="10"><?php echo $about_content; ?></textarea>
                        <?php endif ?>

                        <div class="admin-button-wrapper">
                            <?php if ($isEditingAbout === true): ?> 
                                <button type="submit" class="admin-btn" name="update-about">Update</button>
                            <?php else: ?>
                                <button type="submit" class="admin-btn" name="create-about">Save</button>
                            <?php endif ?>
                        </div>

                    </form>
                </div>

                <!-- display records from db -->
                <div class="table-div">
                    <!-- display notification message -->
                    <?php include(ROOT_PATH . 'admin/include/messages.php'); ?>

                    <?php if(empty($abouts)): ?>
                        <h1>About content is empty</h1>
                    <?php else: ?>
                        <h1 style="margin:1rem">All FAQs</h1>
                        <table class="table">
                            <thead>
                                <th>N</th>
                                <th>Picture</th>
                                <th>Content</th>
                                <th colspan="2">Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($abouts as $key => $about): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $about['picture']; ?></td>
                                        <td><?php echo $about['content']; ?></td>
                                        <td class="table-icon">
                                            <a href="abouts.php?edit-about=<?php echo $about['id'] ?>"
                                                style="color:green;" onMouseOut="style.color='green'" 
                                                onMouseOver="style.color='aqua'">
                                                <span class="fa fa-pencil btn edit"></span>
                                            </a>
                                        </td>
                                        <td class="table-icon">
                                            <a href="abouts.php?delete-about=<?php echo $about['id'] ?>"
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
    <script src="<?php echo BASE_URL; ?>js/ckeditor.js"></script>
    <script src="<?php echo BASE_URL; ?>js/admin-script.js"></script>

    <!--X============================= Javascript =============================X-->
</body>
</html>