/**
 * home-script: 
 *  a little java script file to controls most of client side animations and all.
 *
 * Date created:
 *  18th of April 2022, Monday.
 *
 * Last update:
 *  18th of April 2022, Monday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

/* ============================================================================================|
 * jQuery on document load
 * ============================================================================================*/
$(document).ready(function() {
    
    /* ============================================================================================|
     * Sidebar_Active menu
     *  Changes the style of active and inactive menu-items based on the clicking of the users
     * ============================================================================================*/
    let current_choice = $('.hidden-feild').val();
    
    let sidebar_items = document.getElementsByClassName('sidebar-item');

     // remove all active class names from the selections
     for (i = 0; i < sidebar_items.length; i++) {
        sidebar_items[i].className = sidebar_items[i].className.replace(" active", "");
    } // end for

    // add the active frame for the chosen menu
    sidebar_items[current_choice-1].className += " active";


});


/* ============================================================================================|
 * User_Exists
 *  Checks if the supplied username exists in the database
 * ============================================================================================*/
function User_Exists(value) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/include/admin-ajax.php';

    // invoke ajax
    $.ajax({
        type: 'post',
        url: path,
        data: {
            check_username:value
        },
        success:function(response) {
            let popup = document.getElementById("myPopup");

            if (response == 1) {
                popup.classList.add("show");
            } // end if
            else {
                popup.classList.remove("show");
            } // end else no error
        } // end success
    }); // end ajax
}



/* ============================================================================================|
 * Rich text editor plugins; i.e. the tool bars
 * ============================================================================================*/
ClassicEditor.create( document.querySelector( '#post-editor' ), {
    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
        ]
    }
} )
.catch( error => {
    console.log( error );
} );



/* ============================================================================================|
 * This function changes the type of input used for post content depending on the type of post;
 *  i.e. text posts are different from mm posts.
 * ============================================================================================*/
function Change_Post_Content(val) {
    if (val == "Text") {
        document.getElementById("post-content-write").style.display='block';
        document.getElementById("post-upload").style.display='none';
    } // end if
    else {
        document.getElementById("post-content-write").style.display='none';
        document.getElementById("post-upload").style.display='block';
    } // end else
} // end Change_Post_Content



/* ============================================================================================|
 * This function fetches the contents of the topic selection input based on the entries supplied
 *  from categories select input.
 * ============================================================================================*/
function Fetch_Topics(val) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/include/admin-ajax.php';

    // invoke ajax
    $.ajax({
        type: 'post',
        url: path,
        data: {
            get_topics:val
        },
        success: function(response) {
            document.getElementById("topic_select").innerHTML=response;
        }
    });
} // end Fetch_Topics



/* ============================================================================================|
 * This function fetches all the genres under a given topic and if the topic has no genres then
 *  the input (select) will turn invisible.
 * ============================================================================================*/
function Fetch_Genres(val) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/include/admin-ajax.php';
    
    // invoke ajax
    $.ajax({
        type: 'post',
        url: path,
        data: {
            get_genres:val
        },
        success: function(response) {
            if (response !== "") {
                document.getElementById("genre_select").style.display='block';      // force display
                document.getElementById("genre_select").innerHTML=response;
            } // end if append response
            else {
                document.getElementById("genre_select").style.display='none';       // hide
            } // end else no response
        } // end success
    }); // end ajax
} // end Fetch_Topics