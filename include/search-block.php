<div class="modal" id="search-dialog">

    <form action="<?php echo BASE_URL . 'post-topic.php'; ?>" method="POST" enctype="multipart/form-data" 
        class="modal-content animate">
 
        <div class="signin-container">
            <input type="text" name="search-text" placeholder="Search post ..." required>

            <!-- if editing user, display the update button instead of create button -->
            <div class="admin-button-wrapper">
                <button type="submit" class="admin-btn" name="search-post">Search</button>
            </div>
        </div>

    </form>
</div>