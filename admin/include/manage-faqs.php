<?php

/**
 * manage-faqs.php 
 *  some more controls over the faq page of xpressmedia
 *
 * Date created:
 *  2nd of May 2022, Monday (Day of the Muslim Ra'amadan).
 *
 * Last update:
 *  2nd of May 2022, Monday (Day of the Muslim Ra'amadan).
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

require_once('admin-generals.php');


/* ============================================================================================|
 * Get_FAQs:
 *  Returns all faq's stored in the database
 * ============================================================================================*/
function Get_FAQs() {
    $sql = "SELECT * FROM faqs";

    $faqs = Get_Result($sql);
    return $faqs;
} // end Get_FAQs



/* ============================================================================================|
 * Get_About:
 *  Let's also get the about info here
 * ============================================================================================*/
function Get_About() {
    $sql = "SELECT * FROM abouts LIMIT 1";

    $about = Get_Result($sql);
    return $about;
} // end Get_About



/* ============================================================================================|
 * Get_Adverts:
 *  Let's also get the advert info here too
 * ============================================================================================*/
function Get_Adverts() {
    $sql = "SELECT t.id, t.slogan, t.type, t.date_from, t.date_to,
    (CASE t.TotalSlides WHEN 0 THEN 1
    ELSE t.TotalSlides
    END) AS TotalSlides
    FROM ( 
    SELECT a.id, a.slogan, a.type, a.date_from, a.date_to, (
        SELECT COUNT(*) 
        FROM advert_slides 
        WHERE advert_id = a.id) AS TotalSlides
    FROM adverts AS a ) AS t";
    
    $adverts = Get_Result($sql);
    return $adverts;
} // end Get_Adverts




/* ============================================================================================|
 * Get_Advert_Slides_By_Advert_Id:
 *  returns all the advert slide info under a given id
 * ============================================================================================*/
function Get_Ad_Slides_By_Ad_Id($ad_id) {
    $sql = "SELECT * FROM advert_slides WHERE advert_id=$ad_id";

    $slides = Get_Result($sql);
    return $slides;
} // end Get_Ad_Slides_By_Ad_Id

?>