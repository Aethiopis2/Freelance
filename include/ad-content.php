<aside class="home-side-content">
    <div class="post-topic">
        <h2>Topics</h2>
        <ul class="topic-list" data-aos="fade-left" data-aos-delay="100">
            <?php foreach(Get_All_Post_Topics() as $topic): ?>
                <li class="topic-list-items">
                    <a href="<?php echo BASE_URL . 'post-topic.php?topic_id=' . $topic['id']; ?>">
                        <?php echo $topic['topic']; ?>
                    </a>
                    <span><?php echo "(" . $topic['category_id'] . ")"; ?></span>
                </li>
            <?php endforeach ?>
        </ul>
    </div>

    <div class="advert-banners">
        <h2>Adverts</h2>

        <?php $ads = Get_Non_Home_Adverts(); ?>
        <?php $counter = 0; ?>
        <?php foreach($ads as $ad): ?>
            <?php if($ad['type'] === 'Banner'): ?>
                <?php if(isset($ad['date_from'])): ?>

                    <?php if($ad['date_from'] <= now() && $ad['date_to'] >= now()): ?>
                        <article class="post-content" data-aos="flip-up" data-aos-delay="200">
                            <div class="post-image">
                                <div>
                                    <a href="<?php echo $ad['adlink']; ?>">
                                        <h1 class="glow"><?php echo $ad['slogan']; ?></h1>
                                        <img src="<?php echo BASE_URL . $ad['filepath']; ?>" alt="" class="img">
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endif ?>
                <?php else: ?>

                    <article class="post-content" data-aos="flip-up" data-aos-delay="200">
                        <div class="post-image">
                            <div>
                                <a href="<?php echo $ad['adlink']; ?>">
                                    <h1 class="glow"><?php echo $ad['slogan']; ?></h1>
                                    <img src="<?php echo BASE_URL . $ad['filepath']; ?>" alt="" class="img">
                                </a>
                            </div>
                        </div>
                    </article>

                <?php endif ?>
            <?php else: ?>
                
                <?php if(isset($ad['date_from'])): ?>
                    <?php if($ad['date_from'] <= now() && $ad['date_to'] >= now()): ?>
                        <?php $counter += 1; ?>
                        <div class="slideshow-container">
                            <div class="slide-shows" data-aos="fade-up" data-aos-delay="100">
                                <?php $total_slides = Get_Advert_Slides_Count($ad['id']); ?>
                                <?php $slides = Get_Ad_Slides($ad['id']); ?>
                                <?php foreach($slides as $key => $slide): ?>
                                    <a href="<?php echo $ad['adlink']; ?>">
                                        <div class="myslides<?php echo $counter; ?> fade">
                                            <input type="hidden" class="slide-index" value="<?php echo $key; ?>">
                                            <div class="numberText"><?php echo ($key + 1) . '/' . $total_slides; ?></div>
                                            <img src="<?php echo BASE_URL . $slide['filepath']; ?>" alt="" class="slideshow-img">
                                            <div class="home-slogan" data-aos="fade-up" data-aos-delay="300">
                                                <h1 class="glow"><?php echo $ad['slogan']; ?></h1></div>
                                        </div>
                                    </a>
                                <?php endforeach ?>

                                <a class="prev" onclick="Push_Slides(-1, <?php echo $counter; ?>)">
                                    <i class="fa-solid fa-angle-left" style="color:white"></i></a>
                                <a class="next" onclick="Push_Slides(1, <?php echo $counter; ?>)">
                                    <i class="fa-solid fa-angle-right" style="color:white"></i></a>
                            </div>

                            <div class="slide-text">
                                <?php foreach($slides as $key => $slide): ?>
                                    <span class="dot<?php echo $counter; ?>" 
                                        onclick="Current_Slide(<?php echo $key+1; ?>, <?php echo $counter; ?>)"></span> 
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif ?>
                <?php else: ?>

                    <?php $counter += 1; ?>
                    <div class="slideshow-container">
                        <div class="slide-shows" data-aos="fade-up" data-aos-delay="100">
                            <?php $total_slides = Get_Advert_Slides_Count($ad['id']); ?>
                            <?php $slides = Get_Ad_Slides($ad['id']); ?>
                            <?php foreach($slides as $key => $slide): ?>
                                <a href="<?php echo $ad['adlink']; ?>">
                                    <div class="myslides<?php echo $counter; ?> fade">
                                        <div class="numberText"><?php echo ($key + 1) . '/' . $total_slides; ?></div>
                                        <img src="<?php echo BASE_URL . $slide['filepath']; ?>" alt="" class="slideshow-img">
                                        <div class="home-slogan" data-aos="fade-up" data-aos-delay="300">
                                            <h1 class="glow"><?php echo $ad['slogan']; ?></h1></div>
                                    </div>
                                </a>
                            <?php endforeach ?>

                            <a class="prev" onclick="Push_Slides(-1, <?php echo $counter; ?>)">
                                <i class="fa-solid fa-angle-left" style="color:white"></i></a>
                            <a class="next" onclick="Push_Slides(1, <?php echo $counter; ?>)">
                                <i class="fa-solid fa-angle-right" style="color:white"></i></a>
                        </div>

                        <div class="slide-text">
                            <?php foreach($slides as $key => $slide): ?>
                                <span class="dot<?php echo $counter; ?>" 
                                    onclick="Current_Slide(<?php echo $key+1; ?>, <?php echo $counter; ?>)"></span> 
                            <?php endforeach ?>
                        </div>
                    </div>

                <?php endif ?>

            <?php endif ?>
        <?php endforeach ?>

    </div>
</aside>