<header id="main-nav-header">
    <div class="page-title">
        <h1>Xpress Media</h1>
    </div>

    <div class="toggle-navbar" onclick="Toggle_Navbar()" id="toggle-navbar-btn">
        <i class="fa-solid fa-bars"></i>
    </div>

    <nav class="main-navbar" id="main-navbar">
        <a href="<?php echo BASE_URL ?>index.php">Home</a>

        <?php foreach($post_categories as $cat): ?>
            <div class="dropdown">
                    <button class="dropdown-btn"><?php echo $cat['category'] . ' '; ?><i class="fa fa-caret-down"></i></button>
                    <div class="dropdown-content">
                        <div class="drop-header">
                            <h2><?php echo $cat['category'] . ' '; ?></h2>
                        </div>

                        <div class="drop-row">
                            <?php foreach (Get_Topic_By_CategoryID($cat['id']) as $topic): ?>
                                <div class="drop-column">
                                    <h3><a href="<?php echo BASE_URL . 'post-topic.php?topic_id=' . $topic['id']; ?>">
                                        <?php echo $topic['topic']; ?>
                                    </a></h3>
                                    <?php foreach(Get_Genre_By_TopicID($topic['id']) as $genre): ?>
                                        <a href="<?php echo BASE_URL . 'post-topic.php?genre_id=' . $genre['id']; ?>">
                                            <?php echo $genre['genre']; ?>
                                        </a>
                                    <?php endforeach ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                        
                    </div>
            </div>
        <?php endforeach ?>

        <a href="<?php echo BASE_URL; ?>faq.php">FAQs</a>
        <a href="<?php echo BASE_URL; ?>about.php">About</a>
    </nav>

    <div class="signin-block" id="signin-block">
        <?php if(!isset($_SESSION['user'])): ?>
            <span class="signin" onclick="Signin_Modal(1)"><i class="fas fa-user"></i>Signin | </span>
            <span class="signup" onclick="Signup_Modal(1)">SignUp</span>
        <?php else: ?>
            <?php $user = $_SESSION['user']; ?>
            <span class="signin"> 
                <?php if(isset($user['avatar'])): ?>
                    <img src="<?php echo BASE_URL . $user['avatar']; ?>" width="32px" height="32px" 
                        style="border-radius=50%;">
                            
                <?php else: ?>
                    <i class="fas fa-user"></i>
                <?php endif ?>

                <?php $cuser = $_SESSION['user']; ?>
                <div class="profile-dropdown">
                    <span class="profile-dropbtn"><?php echo $user['username']; ?></span>
                    <div class="profile-dropdown-content">
                        <a href="<?php echo BASE_URL; ?>post-topic.php?user_id=<?php echo $cuser['id']; ?>">
                            My Posts
                        </a>
                        <?php if($cuser['user_role'] == 'Admin'): ?>
                            <a href="<?php echo BASE_URL; ?>admin/dashboard.php">Dashboard</a>
                        <?php endif ?>
                    </div>
                </div>
                
            </span>
            <a href="<?php echo BASE_URL . 'include/logout.php' ?>">Signout</a>
        <?php endif ?>
    </div>
</header>