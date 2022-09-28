<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage FAQs";
    $current_selection = 7; 

    $faqs = Get_FAQs();
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
                    <?php if($isEditingFAQ === true): ?>
                        <h4 class="page-title">Update FAQ</h4>
                    <?php else: ?>
                        <h4 class="page-title">New FAQ</h4>
                    <?php endif ?>

                    <form action="<?php echo BASE_URL . 'admin/faqs.php'; ?>" method="POST" 
                        enctype="multipart/form-data" class="modal-content animate">
                            <!-- editing a faq requires id --> 
                            <?php if($isEditingFAQ === true): ?>
                                <input type="hidden" name="faq-id" value="<?php echo $faq_id; ?>">
                            <?php endif ?>

                            <input type="text" name="faq-quiz" value="<?php echo $faq_quiz; ?>" placeholder="Question ..."
                                required>
                            <?php if($isEditingFAQ === false): ?>
                                <textarea name="faq-ans" id="post-editor" placeholder="Answer ..."
                                        rows="10"></textarea>
                            <?php else: ?>
                                <textarea name="faq-ans" id="post-editor" placeholder="Answer ..."
                                    rows="10"><?php echo $faq_ans; ?></textarea>
                            <?php endif ?>

                            <div class="admin-button-wrapper">
                                <?php if ($isEditingFAQ === true): ?> 
                                    <button type="submit" class="admin-btn" name="update-faq">Update</button>
                                <?php else: ?>
                                    <button type="submit" class="admin-btn" name="create-faq">Save</button>
                                <?php endif ?>
                            </div>
                    </form>
                </div>

                <!-- display records from db -->
                <div class="table-div">
                    <!-- display notification message -->
                    <?php include(ROOT_PATH . 'admin/include/messages.php'); ?>

                    <?php if(empty($faqs)): ?>
                        <h1>No FAQs in the database</h1>
                    <?php else: ?>
                        <h1 style="margin:1rem">All FAQs</h1>
                        <table class="table">
                            <thead>
                                <th>N</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th colspan="2">Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($faqs as $key => $faq): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $faq['question']; ?></td>
                                        <td><?php echo $faq['answer']; ?></td>
                                        <td class="table-icon">
                                            <a href="faqs.php?edit-faq=<?php echo $faq['id'] ?>"
                                                style="color:green;" onMouseOut="style.color='green'" 
                                                onMouseOver="style.color='aqua'">
                                                <span class="fa fa-pencil btn edit"></span>
                                            </a>
                                        </td>
                                        <td class="table-icon">
                                            <a href="faqs.php?delete-faq=<?php echo $faq['id'] ?>"
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