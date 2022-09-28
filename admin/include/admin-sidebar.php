<input type="checkbox" id="nav-toggle">
<div class="sidebar">
    <div class="sidebar-brand">
        <h2><span class="fa-brands fa-xing"></span> <span>Xpress Media</span></h2>
    </div>
    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="<?php echo BASE_URL . 'admin/dashboard.php'; ?>" class="sidebar-item active">
                <span class="fa-solid fa-ankh"></span>&nbsp;&nbsp;
                <span>Dashboard</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/posts.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-signs-post"></span>&nbsp;&nbsp;
                <span>Manage Posts</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/users.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-users"></span>&nbsp;&nbsp;
                <span>Manage Users</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/categories.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-ethernet"></span>&nbsp;&nbsp;
                <span>Manage Categories</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/topics.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-bars-staggered"></span>&nbsp;&nbsp;
                <span>Manage Topics</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/genres.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-tree"></span>&nbsp;&nbsp;
                <span>Manage Genres</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/faqs.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-circle-question"></span>&nbsp;&nbsp;
                <span>Manage FAQ's</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/abouts.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-message"></span>&nbsp;&nbsp;
                <span>Manage About</span></a>
            </li>
            <li>
                <a href="<?php echo BASE_URL . 'admin/adverts.php'; ?>" class="sidebar-item">
                <span class="fa-solid fa-rectangle-ad"></span>&nbsp;&nbsp;
                <span>Manage Adverts</span></a>
            </li>
        </ul>
    </div>
</div>
<input type="hidden" value="<?php echo $current_selection; ?>" class="hidden-feild">