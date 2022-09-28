<header>
    <h2>
        <label for="nav-toggle">
            <span class="fas fa-bars"></span>
        </label>
        <?php echo $page_name; ?>
    </h2>

    
    <div class="user-wrapper">
        <?php if(isset($user_info['avatar'])): ?>
            <img src="<?php echo BASE_URL . $user_info['avatar']; ?>" width="40px" height="40px" alt="">
        <?php else: ?>
            <img src="<?php echo BASE_URL; ?>assets/static-files/avatar-profile.png" width="40px" height="40px" alt="">
        <?php endif ?>
        <div>
            <h2><?php echo $user_info['username']; ?></h2>
            <a href="<?php echo BASE_URL; ?>index.php"><span class="fa-solid fa-house"></span></a>
            <small><?php echo $user_info['user_role']; ?></small>
            <a href="<?php echo BASE_URL; ?>/include/logout.php">Signout</a>
        </div>
    </div>
</header>