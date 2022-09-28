<div class="modal" id="create-post-dialog">

    <form action="<?php echo BASE_URL; ?>index.php" method="POST" enctype="multipart/form-data" 
        class="modal-content animate">
 
        <h2 class="page-title">New Post</h2>
            
        <!-- post image/thumbnail section --> 
        <div class="imgcontainer">
            <span onclick="Write_Post_Modal(0)" class="close" title="Close Modal" style="margin:-15px">&times;</span>
        </div>

        <div class="signin-container">
            <input type="text" name="post_title" placeholder="Post Title" required>

            <div class="post-type-list">
                <select name="post-type" onchange="Change_Post_Content(this.value);" required>
                    <option value="" selected disabled>Select Post Type</option>
                    <?php foreach ($post_types as $key => $post_type): ?>
                        <option value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="post-content-write" id="post-content-write">
                <textarea name="post-editor" id="post-editor" placeholder="Type in your post ..."></textarea>
            </div>

            <div class="post-upload" id="post-upload">
                <label for="">Non-text post</label>
                <input type="file" name="non-text-post" placeholder="Picture ...">
            </div>
            
            <select name="post-category" onchange="Fetch_Topics(this.value);" required>
                <option value="" selected disabled>Select Category</option>
                <?php foreach ($post_categories as $cat): ?>
                    <option value="<?php echo $cat['category']; ?>"><?php echo $cat['category']; ?></option>
                <?php endforeach ?>
            </select>

            <select name="topic-select" id="topic_select" onchange="Fetch_Genres(this.value);" required>
            </select>
            <select name="genre-select" id="genre_select" required>
            </select>

            <label for="">Upload picture</label>
            <input type="file" name="picture" placeholder="Picture ...">

            <!-- if editing user, display the update button instead of create button -->
            <div class="admin-button-wrapper">
                <button type="submit" class="admin-btn" name="create-post">Save</button>
            </div>
        </div>

    </form>
</div>