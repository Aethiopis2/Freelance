/**
 * populate-adverts.sql
 *  this script populates our database manually with some basic information; important for test driving the web
 *  site content and renderings.
 *
 * Date created:
 *  12th of April 2022, Tuesday.
 *
 * Last update:
 *  7th of May 2022, Saturday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

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
INSERT INTO users (id, fullname, username, password, user_role, email, tel, bio, active, created_at)
VALUES (1, 'Alem Hailu G/Kirstos', 'AlemHailu', '918f1b13559a6a9bf9a88899ee3d6126', 'Admin', 
    'Alem@gmail.com', '0911111111', 'Author, Journalist, Poet', 1, CURRENT_TIMESTAMP()),
	   (2, 'Henok Tibebu', 'HenyBlack', '918f1b13559a6a9bf9a88899ee3d6126', 'Author', 'HenyBlack@gmail.com', '0911121314', 
	   'Novel-Author, Journalist', 1, CURRENT_TIMESTAMP());


/**
 * ===================================================================================================|
 */
INSERT INTO post_categories (id, category)
VALUES (1, 'Art & Culture'),
	   (2, 'Who''s Who'),
	   (3, 'Journals');


/**
 * ===================================================================================================|
 */
INSERT INTO post_topics (id, category_id, topic)
VALUES (1, 1, 'Poetry'),
	   (2, 1, 'Short Stories'),
	   (3, 1, 'Informal Essay'),
	   (4, 1, 'Amharic Translations'),
	   (5, 1, 'From Amharic Translations'),
	   (6, 1, 'Painting'),
	   (7, 1, 'Sculputre'),
	   (8, 1, 'Photography'),
	   (9, 1, 'Music'),
	   (10, 1, 'Drama'),
	   (11, 1, 'Film'),
	   (12, 1, 'Book Review'),
	   (13, 1, 'Fashion'),
	   (14, 1, 'Design'),
	   (15, 1, 'Folklore'),
	   (16, 1, 'Folktale'),
	   (17, 1, 'Quotations'),
	   (18, 1, 'Tangable Heritages'),
	   (19, 1, 'Intangable Heritages'),
	   (20, 2, 'Patriots'),
	   (21, 2, 'Researchers'),
	   (22, 2, 'Creative Youth'),
	   (23, 2, 'People Living with Disablitites'),
	   (24, 2, 'Women'),
	   (25, 2, 'Ordinary People trying ends meet'),
	   (26, 2, 'Successful Individuals'),
	   (27, 2, 'Successful Organizations'),
	   (28, 2, 'The Ethiopian Diaspora'),
       (29, 3, 'News'),
	   (30, 3, 'Editorial'),
	   (31, 3, 'Opinion'),
	   (32, 3, 'Weeks in review'),
	   (33, 3, 'Others');


/**
 * ===================================================================================================|
 */
INSERT INTO post_genres (topic_id, genre)  
VALUES (1, 'Allegory'),
       (1, 'Aubade'),
       (1, 'Ballad'),
       (1, 'Blason'),
       (1, 'Cento'),
       (1, 'Dirge'),
       (1, 'Dramatic Monolog'),
       (1, 'Eclogue'),
       (1, 'Epic'),
	   (1, 'Satire'),
	   (1, 'Infromal'),
       (2, 'Fables and Animal Tales'),
       (2, 'Folktales and Farytales'),
       (2, 'Ghost Stories'),
       (2, 'Crime and Detective'),
       (2, 'Fantasy'),
       (2, 'Love and Romance'),
       (3, 'Descriptive'),
       (3, 'Narration'),
       (3, 'Exposition'),
       (3, 'Argumentation'),
       (6, 'Portarites and Sketches'),
       (6, 'Oil Painting'),
       (6, 'Abstract'),
       (11, 'Action'),
       (11, 'Thriller'),
       (11, 'Comedy'),
       (11, 'Slap-stick'),
       (11, 'Adventure');