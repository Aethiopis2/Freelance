/**
 * populate-adverts.sql
 *  this is a sample script used to populate xpressmedia mysql db with fake advert/home screen info
 *  for testing of the website; code named xpress-media
 *
 * Date created:
 *  11th of April 2022, Monday.
 *
 * Last update:
 *  11th of April 2022, Monday.
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

INSERT INTO adverts (slogan, type)
VALUES ('Welcome to Xpress Media', 'Home');


/**
 * ===================================================================================================|
 */
 
INSERT INTO advert_slides (advert_id, filepath)
VALUES (1, 'assets/uploads/images/aksum.jpeg'),
       (1, 'assets/uploads/images/Ethiopian-lands.jpg'),
       (1, 'assets/uploads/images/ethiopic-maniuscript.jpg'),
       (1, 'assets/uploads/images/famous-authors.jpg'),
       (1, 'assets/uploads/images/Gondar.jpg'),
       (1, 'assets/uploads/images/lalibela-beta-georgis.jpeg'),
       (1, 'assets/uploads/images/last-supper.jpeg'),
       (1, 'assets/uploads/images/might-of-gondar.jpg'),
       (1, 'assets/uploads/images/the-culture.jpg'),
       (1, 'assets/uploads/images/type-writer.webp');


/**
 * ===================================================================================================|
 */

INSERT INTO adverts (slogan, type, filepath)
VALUES ('Advert 1', 'Banner', 'assets/uploads/images/fake-advert1.gif'),
       ('Advert 2', 'Banner', 'assets/uploads/images/fake-advert2.gif'),
       ('Advert 3', 'Banner', 'assets/uploads/images/fake-advert3.gif'),
       ('Advert 4', 'Banner', 'assets/uploads/images/fake-advert4.gif');