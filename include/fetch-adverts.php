<?php 


/**
 * fetch-adverts.php 
 *  definitions of functions responsible for fetching of information pretaining to advert tables.
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

require_once('general-functions.php');

/* ============================================================================================|
 * Get_Advert_Slides:
 *  this function fetches all slide related images from the database. The function can also
 *  be used to limit the number of home screen items fetched all at once. By default however,
 *  the function returns only the first.
 * ============================================================================================*/
function Get_Advert_Slides($advert_type)
{
    $sql = "SELECT a.id, a.slogan, b.filepath 
            FROM adverts as a
            JOIN advert_slides as b
            ON a.id = b.advert_id
            WHERE a.type = " . $advert_type . " ";

    $result = Get_Result($sql);
    return $result;     // as an associative array
} // end Get_Advert_Slides



/* ============================================================================================|
 * Get_Advert_Slides_Count:
 *  function returns the count of slides under a given advert id (the main group) and returns
 *  to the caller; function is useful to know the total of slides to keep track of and set an
 *  upper bound to our dear client side js code.
 * ============================================================================================*/
function Get_Advert_Slides_Count($advert_id) 
{
    $sql = "SELECT COUNT(*) 
            FROM advert_slides 
            WHERE advert_id = $advert_id";

    $result = Get_Result_Num($sql);
    return $result[0];      /* there should be one row any-ways! */
} // end Get_Advert_Slides_Count



/* ============================================================================================|
 * Get_All_Advert_Banners:
 *  returns all banners existing in our system's database.
 * ============================================================================================*/
function Get_All_Advert_Banners() 
{
    $sql = "SELECT * FROM adverts WHERE type='Banner'";

    $result = Get_Result($sql);
    return $result; 
} // end Get_All_Advert_Banners




/* ============================================================================================|
 * Get_Non_Home_Adverts
 *  Returns all adverts that are not home
 * ============================================================================================*/
function Get_Non_Home_Adverts()
{
    $sql = "SELECT *
    FROM adverts
    WHERE type != 'Home'";

    $result = Get_Result($sql);
    return $result;     // as an associative array
} // end Get_Non_Home_Adverts



/* ============================================================================================|
 * Get_Ad_Slides
 *  Returns slides belonging to an id
 * ============================================================================================*/
function Get_Ad_Slides($ad_id)
{
    $sql = "SELECT *
    FROM advert_slides
    WHERE advert_id = $ad_id";

    $result = Get_Result($sql);
    return $result;     // as an associative array
} // end Get_Advert_Slides

?> 