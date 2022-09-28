/**
 * xpress-media.sql
 *  a script file used to create database for Xpress Media website. The database stores and manages the posts, user info and
 *  all other requirements including uploaded adverts.
 *
 * Date created:
 *  10th of April 2022, Sunday.
 *
 * Last update:
 *  7th of May 2022, Saturday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

/**
 * create's new blank database named; xpressmdeia.
 */
CREATE DATABASE xpressmedia CHARACTER SET utf8 COLLATE utf8_general_ci;

/**
 * ===================================================================================================|
 */

/**
 * change db context to xpress media and populate with the following tables.
 */
USE xpressmedia;


/**
 * ===================================================================================================|
 */


/**
 * create our user table; store's information on all users available on the system; in xpressmedia there are
 *  two kinds of users, admin's and author's.
 */
CREATE TABLE users (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    fullname nvarchar(260) NOT NULL,
    username nvarchar(32) UNIQUE NOT NULL,
    password nvarchar(64) NOT NULL,     /* hashed using md5 algorithim */
    user_role enum('Admin', 'Author') NOT NULL DEFAULT 'Author',
    email nvarchar(260) UNIQUE NOT NULL,
    tel nvarchar(16) UNIQUE NOT NULL,
    bio nvarchar(1024) NULL,
    avatar nvarchar(260) DEFAULT 'assets/static-files/avatar-profile.png',          /* uploaded image for user */
    active tinyint DEFAULT 1,           /* 0 for inactive, 1 for active */
    created_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,

    INDEX(fullname(16)),
    INDEX(email(16)),
    INDEX(tel(8)),
    INDEX(username(16))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/**
 * ===================================================================================================|
 */


/**
 * a post can be broadly classified into categories, largely a post can be of type Art & Culture, Who's
 *  Who and Journal. Anyother form of category classification is left to the owner of the website to decide.
 * The categories are effectively the ones that appear as the root/top-level menus of the website.
 */
 CREATE TABLE post_categories (
     id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
     category nvarchar(128) UNIQUE NOT NULL,

     INDEX(category(16))
 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * Each post category may inturn is classfied into various topics, that may peek the intersets of our vistors
 *  topics like, poetry, editorials, etc. This has a fine-tune filter effect for our post topics.
 */
CREATE TABLE post_topics (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    category_id int NOT NULL,
    topic nvarchar(128) UNIQUE NOT NULL,

    INDEX(topic(16)),
    FOREIGN KEY(category_id) REFERENCES post_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * As each category has it's own topic, so can too can each topic has its own genre; this table maps
 *  genre's to each topic available if it needs one.
 */
CREATE TABLE post_genres (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    topic_id int NOT NULL,
    genre nvarchar(64) UNIQUE NOT NULL,

    INDEX(genre(16)),
    FOREIGN KEY(topic_id) REFERENCES post_topics(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * this is the heart of our website; this is where all the posts that have been published/unpublished go into.
 */
CREATE TABLE posts (
    id bigint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id int NOT NULL,
    category_id int NOT NULL,   /* all posts belong to a given category; one at a time only */

    title nvarchar(260) NOT NULL,   /* post title */
    content text,                   /* the post if text or path to a file if any other post type like audio */
    picture nvarchar(260),          /* path to picture for the post */
    post_type enum('Text', 'Audio', 'Video', 'Image', 'Other') NOT NULL,  /* we can't really combine Audio posts with text */
    state enum('Yes', 'No') NOT NULL,       /* state of the post; i.e. is it published or not or viewable to users or not? */
    created_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    last_updated datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    published_date datetime NULL,   /* date of publication or change of state to Yes. */
    views bigint NOT NULL DEFAULT 0,

    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(category_id) REFERENCES post_categories(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * at some crazy points a single post may belong to multiple genres or even topics; this table keeps
 *  track of the many topics and genres a post may belong to.
 */
CREATE TABLE post_topic_genre_mapping (
    id bigint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    post_id bigint NOT NULL,
    topic_id int NOT NULL,          /* a post should at least have a topic */
    genre_id int NULL,              /* we may not always get posts with a particular genre */

    FOREIGN KEY(post_id) REFERENCES posts(id),
    FOREIGN KEY(topic_id) REFERENCES post_topics(id),
    FOREIGN KEY(genre_id) REFERENCES post_genres(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * Naturally a single post can be followed with a pelthora of comments and replies; thus this table 
 *  store's all the information required to store a post comment.
 */
CREATE TABLE post_comments (
    id bigint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    post_id bigint NOT NULL,
    user_id int NOT NULL,

    content text NOT NULL,
    comment_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(post_id) REFERENCES posts(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * since a single comment itself can have multiple replies this table store's that info
 */
CREATE TABLE comment_replies (
    id bigint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id int NOT NULL,
    comment_id bigint NOT NULL,

    content nvarchar(1024) NOT NULL,
    reply_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(comment_id) REFERENCES post_comments(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * this table stores all the likes and dislikes given to a post and from whom.
 */
CREATE TABLE post_likes (
    id bigint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    post_id bigint NOT NULL,
    user_id int NOT NULL,
    status enum('Like', 'Dislike') NOT NULL,
    status_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(post_id) REFERENCES posts(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * a post can be shared across mutliple website's this table tracks which posts were shared and where.
 */
CREATE TABLE post_shares (
    id bigint AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id int NOT NULL,
    post_id bigint NOT NULL,
    url nvarchar(1024) NOT NULL,        /* address of shared website */
    shared_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY(post_id) REFERENCES posts(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/**
 * ===================================================================================================|
 */


/**
 * this is used for storing advert related banners and slide-shows or even welcome screens.
 */
CREATE TABLE adverts (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    slogan nvarchar(128),                        /* a short content describing the advert */
    type enum('Banner', 'Slide-Show', 'Home') NOT NULL,  /* a slide-show effectively contains many slides and additional slogans */
    filepath nvarchar(260),                       /* the uploaded file path for the banner or slide-show or whatever */
    adlink nvarchar(512),                         /* the website for the ad */
    date_from bigint,
    date_to bigint
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/**
 * ===================================================================================================|
 */


/**
 * when adverts are slide shows; then images can be multiple.
 */
CREATE TABLE advert_slides (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    advert_id int NOT NULL,
    filepath nvarchar(260) NOT NULL,

    FOREIGN KEY(advert_id) REFERENCES adverts(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/**
 * ===================================================================================================|
 */


/**
 * Here are some support functions; this table holds the faq info
 */
CREATE TABLE faqs (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    question text NOT NULL,
    answer text NOT NULL

) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/**
 * ===================================================================================================|
 */


/**
 * Here are some support functions; this table holds the about info; only a single record is required
 */
CREATE TABLE abouts (
    id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    content text NOT NULL,
    picture nvarchar(260) NOT NULL
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/**
 * ===================================================================================================|
 */


/**
 *          THE END
 */


/**
 * ===================================================================================================|
 */