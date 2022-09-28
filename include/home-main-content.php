<section class="container">
    <div class="site-content">
        <div class="posts">
            <h1 style="font-size:4.4rem; color:darkblue;"><?php echo $title_name; ?></h1>

            <?php foreach($all_posts as $post): ?>
                <article class="post-content" data-aos="zoom-in" data-aos-delay="200">
                    <div class="post-image">
                        <div>
                            <?php if(isset($post['picture'])): ?>
                                <img src="<?php echo BASE_URL . $post['picture']; ?>" alt="" class="img">
                            <?php endif ?>
                        </div>
                        <div class="post-info flex-row">
                            <span><i class="fas fa-user text-gray"></i>
                                <?php echo Get_Post_User_By_Id($post['id'])['username']; ?>
                            </span>
                            <span><i class="fas fa-calendar-alt text-gray"></i>&nbsp;&nbsp;
                                <?php echo date("M d, Y", strtotime($post['last_updated'])); ?></span>

                            <?php $comment = Get_Post_Comment_Count($post['id']); ?>
                            <?php if($comment > 0): ?>
                            <span><i class="fas fa-comment text-gray" style="color:beige"></i>&nbsp;&nbsp;
                                <?php echo $comment; ?>
                            </span>
                            <?php else: ?>
                                <span><i class="fas fa-comment text-gray"></i>&nbsp;&nbsp;
                                <?php echo $comment; ?>
                            </span>
                            <?php endif ?>

                            <span><i class="fas fa-heart text-gray"></i>&nbsp;&nbsp;
                                <?php echo Get_Post_Like_Count($post['id']); ?>
                            </span>
                            <span><i class="fa-solid fa-heart-crack text-gray"></i>&nbsp;&nbsp;
                                <?php echo Get_Post_Dislike_Count($post['id']); ?>
                            </span>
                        </div>
                    </div>
                    <div class="post-title">
                        <span><?php echo $post['title']; ?></span>
                        <p>
                            <?php if($post['post_type'] != 'Text'): ?>
                                <a href="single-post.php?post_id=<?php echo $post['id']; ?>">Play</a>
                            <?php else: ?>
                                <?php echo substr($post['content'], 0, strpos($post['content'], ".", 0)); ?>
                                <a href="<?php echo BASE_URL . 'single-post.php?post_id=' . $post['id']; ?>">
                                    Continue Reading ...
                                </a>
                            <?php endif ?>
                        </p>
                    </div>
                </article>
                <hr>
            <?php endforeach ?>

        </div>

        <?php include_once('ad-content.php'); ?>

    </div>
</section>