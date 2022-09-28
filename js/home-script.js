/**
 * home-script: 
 *  a little java script file to controls most of client side animations and all.
 *
 * Date created:
 *  11th of April 2022, Monday.
 *
 * Last update:
 *  6th of May 2022, Friday.
 *
 * Script Author:
 *  Dr. Rediet Worku aka Aethiopis II ben Zahab
 */

/**
 * controls responsiveness of owl-carousel
 */
const responsive = {
    0: {
        items:1
    },
    320:{
        items:1
    },
    560: {
        items:2
    },
    960: {
        items:3
    }
}

/* ============================================================================================|
 * jquery style
 * ============================================================================================*/
$(document).ready(function() {


/* ============================================================================================|
 * owl-carosusel
 * ============================================================================================*/
$('.owl-carousel').owlCarousel({
    loop:true,
    autoplay:true,
    autoplayTimeout:3000,
    dots:true,
    responsive:responsive
});



/* ============================================================================================|
 * footer scroll up
 * ============================================================================================*/
$('.move-up span').click(function(){
    $('html, body').animate({
        scrollTop: 0
    }, 1000);
});


/* ============================================================================================|
 * Animation on scroll
 * ============================================================================================*/
AOS.init();



/* ============================================================================================|
 * Ajax form validation for login session
 * ============================================================================================*/
$('#login-form').submit(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "index.php",
        data: $(this).serialize(),
        dataType: 'html',
        async: true,
        success: function(data) {
            $("#error-block").append(data);
            
            // redirect to the right place based on the value of the hidden feild
            if ($('#hidden-radio:last-child').val() == 1) {
                // to the admin dashboard
                location.href = "admin/dashboard.php";
            } // end if authenticated
            else if ($('#hidden-radio:last-child').val() == 2) {
                // back to home page; average joe ....
                location.href = "index.php";
            } // end else if author
        } // end success story
    }); // end ajax
}); // end login-form.submit


/* ============================================================================================|
 * Sticky nav-menu
 * ============================================================================================*/
window.onscroll = function() { Sticky_Function(); };

let header = document.getElementById("main-nav-header");
let sticky = header.offsetTop;

function Sticky_Function() {
    console.log('inside sticky ' + sticky);
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky-header");
    } // end if
    else {
        header.classList.remove("sticky-header");
    } // end else
} // end function


/* ============================================================================================|
 * FAQ
 * ============================================================================================*/
const faqs=document.querySelectorAll(".faq");
faqs.forEach(faq=>{
    faq.addEventListener("click", ()=>{
        faq.classList.toggle("active");
    });
});


Change_Post_Content("Text");

}); // end $(doucment).ready



/* ============================================================================================|
 * Signin modal popup
 * ============================================================================================*/
function Signin_Modal(show_dialog) {
    if (show_dialog == 0)
        document.getElementById('signin-form-dialog').style.display='none';
    else
        document.getElementById('signin-form-dialog').style.display='block';
} // end Signin_Modal



/* ============================================================================================|
 * Signup modal popup
 * ============================================================================================*/
function Signup_Modal(show_dialog) {
    if (show_dialog == 0)
        document.getElementById('signup-form-dialog').style.display='none';
    else
        document.getElementById('signup-form-dialog').style.display='block';
} // end Signup_Modal



/* ============================================================================================|
 * Search modal popup
 * ============================================================================================*/
function Search_Modal(show_dialog) {
    if (show_dialog == 0)
        document.getElementById('search-dialog').style.display='none';
    else
        document.getElementById('search-dialog').style.display='block';
} // end Signin_Modal

// Get the modal
var modal3 = document.getElementById('search-dialog');
var modal = document.getElementById('signin-form-dialog');
var modal2 = document.getElementById('create-post-dialog');
var modal4 = document.getElementById('signin-form-dialog');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == modal2) {
        modal2.style.display = "none";
    }
    if (event.target == modal3) {
        modal3.style.display = "none";
    }
    if (event.target == modal4) {
        modal3.style.display = "none";
    }
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
 * Write post modal popup
 * ============================================================================================*/
function Write_Post_Modal(show_dialog) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/admin/include/admin-ajax.php';

    // go ajax
    // invoke ajax
    $.ajax({
        type: 'post',
        url: path,
        data: {
            user_signed:'dummy'
        },
        success: function(response) {
            if (response == 1) {
                if (show_dialog == 0) document.getElementById('create-post-dialog').style.display='none';
                else document.getElementById('create-post-dialog').style.display='block';
            } // end if user signed in
            else {
                // show alerts; kill it easy
                alert('signin first!');
            } // end else not so
        } // end success
    }); // end ajax
} // end Signin_Modal



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
    let path = loc + '/admin/include/admin-ajax.php';
    console.log(">>>>> " + val);
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
    let path = loc + '/admin/include/admin-ajax.php';
    
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


/* ============================================================================================|
 * This function toggles the reply form
 * ============================================================================================*/
function Toggle_Reply(value) {
    let id_name = "reply-form" + value;
    let id_name2 = "reply-svg" + value;

    console.log(id_name);
    let reply = document.getElementById(id_name);
    let svg = document.getElementById(id_name2);
    
    reply.classList.toggle("reply-wrapper-active");
    svg.classList.toggle("reply-wrapper-svg");
} // end Toggle_Reply



/* ============================================================================================|
 * This function toggles the like button and updates db
 * ============================================================================================*/
function Toggle_Like(item, user_id, post_id) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/admin/include/admin-ajax.php';

    console.log(user_id);
    let status = item.classList.toggle("like-btn-red");
   
   // test if true and false and update db accordingly
   if (status === true) {
    
        // invoke ajax
        $.ajax({
            type: 'post',
            url: path,
            data: {
                insert_like:user_id,
                post_id:post_id
            },
            success: function(response) {
                let last_count = $('#like-text-inner').text();
                ++last_count;
                $('#like-text-inner').text(last_count);
                console.log(response);
            } // end success
        }); // end ajax
   } // end if inserting new count
   else {
        // invoke ajax
        $.ajax({
            type: 'post',
            url: path,
            data: {
                delete_like:user_id,
                post_id:post_id
            },
            success: function(response) {
                let last_count = $('#like-text-inner').text();
                --last_count;
                $('#like-text-inner').text(last_count);
                console.log(response);
            } // end success
        }); // end ajax
   } // end else
} // end Toggle_Like


/* ============================================================================================|
 * This function toggles the dislike button and updates db
 * ============================================================================================*/
function Toggle_Dislike(item, user_id, post_id) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/admin/include/admin-ajax.php';

    let status = item.classList.toggle("dislike-btn-blue");

    // test if true and false and update db accordingly
   if (status === true) {
    
    // invoke ajax
    $.ajax({
        type: 'post',
        url: path,
        data: {
            insert_dislike:user_id,
            post_id:post_id
        },
        success: function(response) {
            let last_count = $('#dislike-text-inner').text();
            ++last_count;
            $('#dislike-text-inner').text(last_count);
            console.log(response);
        } // end success
    }); // end ajax
} // end if inserting new count
else {
    // invoke ajax
    $.ajax({
        type: 'post',
        url: path,
        data: {
            delete_dislike:user_id,
            post_id:post_id
        },
        success: function(response) {
            let last_count = $('#dislike-text-inner').text();
            --last_count;
            $('#dislike-text-inner').text(last_count);
            console.log(response);
        } // end success
    }); // end ajax
} // end else
} // end toggle_dislike



/* ============================================================================================|
 * User_Exists
 *  Checks if the supplied username exists in the database
 * ============================================================================================*/
function User_Exists(value) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/admin/include/admin-ajax.php';
    
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
                let x = document.getElementById("username-verified");
                x.value = "-1";
            } // end if
            else {
                popup.classList.remove("show");
                let x = document.getElementById("username-verified");
                x.value = "1";
            } // end else no error
        } // end success
    }); // end ajax
} // end User_Exists


/* ============================================================================================|
 * Verify_Email
 *  verifies an email if it be valid or not
 * ============================================================================================*/
function Verify_Email(email) {
    // get the current working directory
    let fullloc = window.location.href;
    let loc = fullloc.substring(0, fullloc.lastIndexOf('/')); // get the location for current file
    let path = loc + '/admin/include/admin-ajax.php';
    
    // invoke ajax
    $.ajax({
        type: 'post',
        url: path,
        data: {
            verify_email:email
        },
        success:function(response) {
            let popup = document.getElementById("myPopup2");

            if (response == 1) {
                popup.classList.add("show");
                let x = document.getElementById("email-verified");
                x.value = "-1";
            } // end if
            else {
                popup.classList.remove("show");
                let x = document.getElementById("email-verified");
                x.value = "1";
            } // end else no error
        } // end success
    }); // end ajax
} // end Verify_Email




/* ============================================================================================|
 * Toggle navbar
 * ============================================================================================*/
function Toggle_Navbar() {
    let nav = document.getElementById("main-nav-header");
    console.log(nav.classList.toggle("nav-toggle"));

    let sign = document.getElementById("signin-block");
    console.log(sign.classList.toggle("signin-toggle"));
} // end Toggle_Navbar


/* ============================================================================================|
 * Home page slide show
 * ============================================================================================*/
let slide_shows = document.getElementsByClassName("slide-shows");
let slide_index = [];
for (let y = 0; y < slide_shows.length; y++) {
    slide_index[y] = 0;
    Show_Slides(y);
    Manual_Slides(slide_index[y], y);
} // end for

function Push_Slides(n, k) {
    console.log(k);
    Manual_Slides(slide_index[k] += n, k);
} // end Push_Slides

function Current_Slide(n, k) {
    Manual_Slides(slide_index[k] = n, k);
} // end Current_Slide


/* ============================================================================================|
 * function animates the home screen-slide show or any other element named by the given classes
 *  On future versions; I'd probably think of a more generic function ...
 * ============================================================================================*/
function Show_Slides(selected) {
    let i;
    sname = "myslides" + selected;
    dname = "dot" + selected;

    let slides = document.getElementsByClassName(sname);
    let dots = document.getElementsByClassName(dname);

    // hide all slides from visiblity
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    } // end for

    // wrap-around the index if it exceeds bounds
    if (++slide_index[selected] > slides.length) slide_index[selected] = 1;
    
    // remove all active class names from the dotted selections
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    } // end for
    
    // set the current slide as the active slide
    if (slides.length > 0 && dots.length > 0) {
        slides[slide_index[selected] - 1].style.display = "block";  
        dots[slide_index[selected] - 1].className += " active";
        setTimeout(function() {
            Show_Slides(selected)
        }, 3000); // Change image every 3 seconds
    } // end if
} // end Show_Slides



/* ============================================================================================|
 * Overloaded for manual handling of slide show
 * ============================================================================================*/
function Manual_Slides(n, k) {
    let i;
    sname = "myslides" + k;
    dname = "dot" + k;

    let slides = document.getElementsByClassName(sname);
    let dots = document.getElementsByClassName(dname);

    // hide all slides from visiblity
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    } // end for

    // wrap-around the index if it exceeds bounds
    if (n > slides.length) {slide_index[k] = 1;}    
    if (n < 1) {slide_index[k] = slides.length;}
    
    // remove all active class names from the dotted selections
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    } // end for
    
    // set the current slide as the active slide
    if (slides.length > 0 && dots.length > 0) {
        slides[slide_index[k]-1].style.display = "block";  
        dots[slide_index[k]-1].className += " active";
    } // end if
} // end Show_Slides