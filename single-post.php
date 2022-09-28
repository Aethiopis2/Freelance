<?php 
    require_once('include/home-header.php'); 
    $post_categories = Get_All_Categories();
    $post_id = 0;

    // test if comments is being set
    if (isset($_POST['comment-btn'])) {
        $text = $_POST['comment-text'];
        $id = $_GET['post_id'];

        Add_Post_Comment($text, $id);
    } // end if posting


    // test for replies
    if (isset($_POST['reply-btn'])) {
        Add_Comment_Reply($_POST, $_GET['post_id']);
    } // end if reply


    if (isset($_GET['post_id'])) {
        $post_id = $_GET['post_id'];

         /**
          * some php based variables; on the server side baby!!!
          */
        $all_posts = Get_Post_By_Id($post_id);
        $title_name = "";
        $comments = Get_Post_Comments_By_Post_Id($post_id);

        /**
         * update the count of views
         */
        // update the count
        Update_View_Count($post_id);
    } // end if

?>
    
    <title>XpressMedia | Topics</title>
</head>
<body>

    <!-- ============================= sticking buttons ============================= -->
    <div class="icon-bar">
        <a class="add-post" onclick="Write_Post_Modal(1)">
            <i class="fa-solid fa-signs-post"></i></a>
        <a class="search-post" onclick="Search_Modal(1)"><i class="fa-solid fa-search"></i></a> 
    </div>

    <!-- ============================= sticking buttons ============================= -->


    <!-- ============================= navigation menu ============================= -->
    
    <?php require_once('include/home-navbar.php'); ?>

    <!--X============================= navigation menu =============================X-->

    <!-- ============================= Page-Content ============================= -->
    <main>
        
        <div class="slide-shows">
            
        </div>

        <!-- ============================= Main contents ============================= -->
        
        <section class="container">
            <div class="site-content">
                <div class="posts">
                    <h1 style="font-size:4.4rem; color:darkblue;"><?php echo $title_name; ?></h1>

                    <?php foreach($all_posts as $post): ?>
                        <?php $post_user = Get_User_By_Id($post['user_id']); ?>

                        <div class="single-post-title"><?php echo $post['title']; ?></div>
                        <div class="single-post-author">
                            <?php if(isset($post_user['avatar'])): ?>
                                <img src="<?php echo BASE_URL . $post_user['avatar']; ?>" alt="" 
                                    class="single-post-author-img">
                            <?php else: ?>
                                <i class="fas fa-user-circle fa2x"></i>
                            <?php endif ?>
                            <span class="author-name">By: <?php echo $post_user['fullname']; ?></span>
                            <span class="single-post-date"><?php echo date("M d, Y", strtotime($post['last_updated'])); ?>
                            </span>
                            <i><span class="view-count"><?php echo $post['views']; ?> Views</span></i>
                        </div>

                        <article class="post-content" data-aos="zoom-in" data-aos-delay="200">
                            <div class="post-image">
                                <div>
                                    <?php if(isset($post['picture'])): ?>
                                        <img src="<?php echo BASE_URL . $post['picture']; ?>" alt="" class="img">
                                    <?php endif ?>
                                </div>
                                
                            </div>
                            <div class="post-title">
                                <p>
                                    <?php if($post['post_type'] !== 'Text'): ?>
                                        <?php if($post['post_type'] === 'Audio'): ?>
                                            <audio controls>
                                                <source src="<?php echo BASE_URL . $post['content']; ?>">
                                            </audio>
                                        <?php elseif($post['post_type'] === 'Video'): ?>
                                            <video width="640px" height="480px">
                                                <source src="<?php echo BASE_URL . $post['content']; ?>">
                                            </video>
                                        <?php endif ?>
                                    <?php else: ?>
                                        <?php echo $post['content']; ?>
                                    <?php endif ?>
                                </p>

                                <div class="post-info2 flex-row">
                                    <?php $comment = Get_Post_Comment_Count($post['id']); ?>
                                    <?php if($comment > 0): ?>
                                    <span><i class="fas fa-comment text-gray" style="color:darkgoldenrod"></i>&nbsp;
                                        <?php echo $comment; ?>
                                    </span>&nbsp;&nbsp;
                                    <?php else: ?>
                                        <span><i class="fas fa-comment text-gray"></i>&nbsp;
                                        <?php echo $comment; ?>
                                    </span>&nbsp;&nbsp;
                                    <?php endif ?>

                                    <?php $uid = $_SESSION['user']; ?>
                                    <span class="like-text" id="like-text"><i class="fas fa-heart text-gray" 
                                        onclick="Toggle_Like(this, <?php echo $uid['id']; ?>, 
                                            <?php echo $post['id']; ?>)"></i>&nbsp;
                                        <span id="like-text-inner">
                                            <?php echo Get_Post_Like_Count($post['id']); ?>
                                        </span>
                                    </span>&nbsp;&nbsp;
                                    <span><i class="fa-solid fa-heart-crack text-gray" 
                                        onclick="Toggle_Dislike(this, <?php echo $uid['id']; ?>, 
                                            <?php echo $post['id']; ?>)"></i>&nbsp;
                                        <span id="dislike-text-inner">
                                            <?php echo Get_Post_Dislike_Count($post['id']); ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </article>

                        <div class="comments-wrapper" data-aos="fade-in" data-aos-delay="200">
                            <form class="comment-form" method="Post" action="single-post.php?post_id=<?php echo $post_id; ?>">
                                <div class="comment-form-wrapper">
                                    <?php $userm = Get_User_By_Id($comment['user_id']); ?>
                                    <?php if(isset($userm['avatar'])): ?>
                                        <img class="image-icon" src="<?php echo BASE_URL . $userm['avatar']; ?>" alt="">
                                    <?php else: ?>
                                        <i class="fas fa-user-circle fa2x image-icon"></i>
                                    <?php endif ?>

                                    <textarea name="comment-text" id="comment-text" rows="1" 
                                        placeholder="Add a comment ..." class="comment-text">
                                    </textarea>
                                    <button name="comment-btn" class="comment-btn">Add comment</button>
                                </div>
                            </form>

                            <?php foreach($comments as $comment): ?>
                                <?php $user = Get_User_By_Id($comment['user_id']); ?>
                                <div class="comments-section">
                                    <div class="comment-title">
                                        <?php if(isset($user['avatar'])): ?>
                                            <img src="<?php echo BASE_URL . $user['avatar']; ?>" alt="">
                                        <?php else: ?>
                                            <i class="fas fa-user fa2x"></i>
                                        <?php endif ?>

                                        <span class="comment-user"><?php echo $user['fullname']; ?></span>
                                        <span class="comment-date">
                                            <?php echo date("F j, Y", strtotime($comment['comment_date'])); ?>
                                        </span>
                                    </div>
                                    <div class="comment-content">
                                        <?php echo $comment['content']; ?>
                                    </div>
                                </div>

                                <?php $replies = Get_Comment_Replies_By_Comment_Id($comment['id']); ?>

                                <?php if(!empty($replies)): ?>

                                    <?php foreach($replies as $reply): ?>
                                        <?php $rep_user = Get_User_By_Id($reply['user_id']); ?>

                                        <div class="reply-section">
                                            <div class="comment-title">
                                                <?php if(isset($user['avatar'])): ?>
                                                    <img src="<?php echo BASE_URL . $rep_user['avatar']; ?>" alt="">
                                                <?php else: ?>
                                                    <i class="fas fa-user fa2x"></i>
                                                <?php endif ?>

                                                <span class="comment-user"><?php echo $rep_user['fullname']; ?></span>
                                                <span class="comment-date">
                                                    <?php echo date("M d, Y", strtotime($reply['reply_date'])); ?>
                                                </span>
                                            </div>
                                            <div class="comment-content">
                                                <?php echo $reply['content']; ?>
                                            </div>
                                        </div>

                                        <div class="reply-wrapper">
                                            <span class="reply-section-btn"
                                                onclick="Toggle_Reply(<?php echo $reply['id']; ?>)">
                                                Reply</span>
                                            <svg width="15" height="10" viewbox="0 0 42 25" id="reply-svg<?php echo $reply['id']; ?>">
                                                <path d="M3 3L21 21L39 3" stroke="white" stroke-width="7" 
                                                    stroke-linecap="round"/>
                                            </svg>

                                            <div class="reply-form" id="reply-form<?php echo $reply['id']; ?>">
                                                <form class="comment-form" method="Post" 
                                                    action="single-post.php?post_id=<?php echo $post_id; ?>">
                                                    <div class="comment-form-wrapper">
                                                        <?php if(!isset($user['avatar'])): ?>
                                                            <i class="fas fa-user-circle fa-2x image-icon"></i>
                                                        <?php else: ?>
                                                            <img class="image-icon" src="<?php echo BASE_URL . $user['avatar']; ?>" 
                                                                width="32px" height="32px" style="border-radius:50%;" alt="">
                                                        <?php endif ?>

                                                        <input type="hidden" name="comment-id" value="<?php echo $comment['id']; ?>">
                                                        <textarea name="reply-text" id="comment-text" rows="1" 
                                                            placeholder="Add a reply ..." class="comment-text">
                                                        </textarea>
                                                        <button name="reply-btn" class="comment-btn">Reply</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    <?php endforeach ?>
                                <?php else: ?>

                                    <div class="reply-wrapper">
                                        <span class="reply-section-btn" onclick="Toggle_Reply('_LoneWolf')">
                                            Reply</span>
                                        <svg width="15" height="10" viewbox="0 0 42 25" id="reply-svg_LoneWolf">
                                            <path d="M3 3L21 21L39 3" stroke="white" stroke-width="7" stroke-linecap="round"/>
                                        </svg>

                                        <div class="reply-form" id="reply-form_LoneWolf">
                                            <form class="comment-form" method="Post" 
                                                action="single-post.php?post_id=<?php echo $post_id; ?>">
                                                <div class="comment-form-wrapper">
                                                    <?php if(!isset($user['avatar'])): ?>
                                                        <i class="fas fa-user-circle fa-2x image-icon"></i>
                                                    <?php else: ?>
                                                        <img class="image-icon" src="<?php echo BASE_URL . $user['avatar']; ?>" 
                                                            width="32px" height="32px" style="border-radius:50%;" alt="">
                                                    <?php endif ?>

                                                    <input type="hidden" name="comment-id" value="<?php echo $comment['id']; ?>">
                                                    <textarea name="reply-text" id="comment-text" rows="1" 
                                                        placeholder="Add a reply ..." class="comment-text">
                                                    </textarea>
                                                    <button name="reply-btn" class="comment-btn">Reply</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>

                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    <?php endforeach ?>

                </div>

                <?php include_once('include/ad-content.php'); ?>

            </div>
        </section>

        <!--X============================= Main contents =============================X-->

    </main>
    <!--X============================= Page-Content =============================X-->

    <!-- ============================= footer ============================= -->
    <?php require_once('include/home-footer.php'); ?>