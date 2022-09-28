<?php require_once('include/admin-header-section.php'); 
    $page_name = "Manage Posts";
    $current_selection = 2; 

    $pub_post = Get_All_Posts();
    $categories = ["Art & Culture", "Who's Who", "Journals"];
    $post_types = ["Text", "Audio", "Video", "Other"];
    $post_published = ["Yes", "No"];
?>

    <title>Xpress Media | Manage Posts</title>
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
                    <?php if($isEditingPost === true): ?>
                        <h4 class="page-title">Update Post</h4>
                    <?php else: ?>
                        <h4 class="page-title">New Post</h4>
                    <?php endif ?>

                    <form action="<?php echo BASE_URL . 'admin/posts.php'; ?>" method="POST" 
                        enctype="multipart/form-data" class="modal-content animate">
                        <!-- editing a user requires id --> 
                        <?php if($isEditingPost === true): ?>
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <?php endif ?>

                        <!-- post image/thumbnail section --> 
                        <div class="imgcontainer">
                            <?php if(true): ?>
                                <?php if(isset(Get_Post_By_Id($post_id)['pic'])): ?>
                                    <img src="<?php echo BASE_URL . Get_Post_By_Id($post_id)['picture']; ?>" alt="Post image" 
                                        class="post-image" width="64px" height="64px">
                                <?php endif ?>
                            <?php endif ?>
                        </div>

                        <div class="signin-container">
                            <input type="text" name="post_title" value="<?php echo $post_title ?>" placeholder="Post Title" 
                                required>

                            <?php if($isEditingPost === false): ?>
                                <div class="post-type-list">
                                    <select name="post-type" onchange="Change_Post_Content(this.value);" required>
                                        <option value="" selected disabled>Select Post Type</option>
                                        <?php foreach ($post_types as $key => $post_type): ?>
                                            <option value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <div class="post-type-list">
                                    <select name="post-type" onchange="Change_Post_Content(this.value);">
                                        <option value="" selected disabled>Select Post Type</option>
                                        <?php foreach ($post_types as $key => $post_type): ?>
                                            <option value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            <?php endif ?>

                            <div class="post-content-write" id="post-content-write">
                                <?php if($isEditingPost === false): ?>
                                    <textarea name="post-editor" id="post-editor" placeholder="Type in your post ..."
                                        rows="10"></textarea>
                                <?php else: ?>
                                    <textarea name="post-editor" id="post-editor" placeholder="Type in your post ..." rows="10">
                                        <?php echo $post_content; ?></textarea>
                                <?php endif ?>
                            </div>

                            <div class="post-upload" id="post-upload">
                                <label for="">Non-text post</label>
                                <input type="file" name="non-text-post" value="<?php echo $non_text_post; ?>" 
                                    placeholder="Picture ...">
                            </div>
                            
                            <?php if($isEditingPost === false): ?>
                                <select name="post-category" onchange="Fetch_Topics(this.value);" required>
                                    <option value="" selected disabled>Select Category</option>
                                    <?php foreach ($categories as $key => $cat): ?>
                                        <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                                    <?php endforeach ?>
                                </select>

                                <select name="topic-select" id="topic_select" onchange="Fetch_Genres(this.value);" required>
                                </select>
                                <select name="genre-select" id="genre_select" required>
                                </select>
                            <?php else: ?>
                                <select name="post-category" onchange="Fetch_Topics(this.value);">
                                    <option value="" selected disabled>Select Category</option>
                                    <?php foreach ($categories as $key => $cat): ?>
                                        <option value="<?php echo $cat; ?>"><?php echo $cat; ?></option>
                                    <?php endforeach ?>
                                </select>

                                <select name="topic-select" id="topic_select" onchange="Fetch_Genres(this.value);">
                                </select>
                                <select name="genre-select" id="genre_select">
                                </select>
                            <?php endif ?>

                            <?php if (isset($_SESSION['user'])): ?>
                                <?php if($_SESSION['user']['user_role'] == "Admin"): ?>
                                    <select name="publish-post" required>
                                        <option value="" selected disabled>Post published?</option>
                                        <?php foreach ($post_published as $key => $pub): ?>
                                            <option value="<?php echo $pub; ?>"><?php echo $pub; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                <?php endif ?>
                            <?php endif ?>

                            <label for="">Upload picture</label>
                            <input type="file" name="picture" value="<?php echo $picture; ?>" placeholder="Picture ...">

                            <!-- if editing user, display the update button instead of create button -->
                            <div class="admin-button-wrapper">
                                <?php if ($isEditingPost === true): ?> 
                                    <button type="submit" class="admin-btn" name="update-post">Update Post</button>
                                <?php else: ?>
                                    <button type="submit" class="admin-btn" name="create-post">Save Post</button>
                                <?php endif ?>
                            </div>
                        </div>

                    </form>

                    <?php if($isEditingPost === true): ?>
                        <?php $comments = Get_Post_Comments_By_Post_Id($post_id); ?>
                        <h4>Comments</h4>
                        <table class="table">
                            <thead>
                                <th>N</th>
                                <th>Full Name</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($comments as $key => $comment): ?>
                                    <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $comment['fullname']; ?></td>
                                        <td><?php echo $comment['content']; ?></td>
                                        <td class="table-icon">
                                            <a href="posts.php?delete-comment=<?php echo $comment['id']; ?>"
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

                <!-- display records from db -->
                <div class="table-div">
                    <!-- display notification message -->
                    <?php include(ROOT_PATH . 'admin/include/messages.php'); ?>

                    <?php if(empty($pub_post)): ?>
                        <h1>No posts in the database</h1>
                    <?php else: ?>
                        <h1 style="margin:1rem">All Posts</h1>
                        <table class="table">
                            <thead>
                                <th>N</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Topic</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th colspan="2">Action</th>
                            </thead>

                            <tbody>
                                <?php foreach($pub_post as $key => $pub): ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo Get_Post_Author($pub['id'])['username']; ?></td>
                                        <td><?php echo Get_Post_Category_By_Id($pub['category_id'])['category']; ?></td>
                                        <td><?php echo Get_Post_Topic_By_Post_Id($pub['id'])['topic']; ?></td>
                                        <td><?php echo $pub['title']; ?></td>
                                        <td><?php echo $pub['post_type']; ?></td>
                                        <td class="table-icon">
                                            <a href="posts.php?edit-post=<?php echo $pub['id'] ?>"
                                                style="color:green;" onMouseOut="style.color='green'" 
                                                onMouseOver="style.color='aqua'">
                                                <span class="fa fa-pencil btn edit"></span>
                                            </a>
                                        </td>
                                        <td class="table-icon">
                                            <a href="posts.php?delete-post=<?php echo $pub['id'] ?>"
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