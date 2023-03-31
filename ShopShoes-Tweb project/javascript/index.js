/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript function related to the index page or the page that opens the site
 */
$(document).ready(function() {
    /*
    Link the appropriate redirection to the two buttons on the page
     */
    $("#login").click(function (){
        window.location.href="../php/login.php";
    });
    $("#registration").click(function (){
        window.location.href="../php/registration.php";
    });
});