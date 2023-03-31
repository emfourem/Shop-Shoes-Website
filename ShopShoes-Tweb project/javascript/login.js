/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to login.php page
 */
$(document).ready(function() {
    /* Associate the manager responsible for hiding/showing the password to the eye icon */
    onEye();
    /* Attach the handler to the submit event to manage submission */
    $("#loginForm").submit(function(e) {
        /* Retrieve the form fields  */
        let form = $(this);
        e.preventDefault();
        /* Check the inputs */
        let pwd = $(this).find("#password").val();
        let username = $(this).find("#username").val();
        let pattern = /^[A-Z][a-z]{7}[0-9][.]$/;
        let pattern1 = /^[a-z]{4,16}$/;
        let result = pwd.match(pattern);
        let result1 = username.match(pattern1);
        if(result != null && result1 != null){
            $.ajax({
                url: "../php/functions.php",
                type:"post",
                /* Serialize the data to send them */
                data: form.serialize() + "&action=loginInitial",
                success: function (response) {
                    /* If the request was unsuccessful provides feedback to the user */
                    if(response.substring(1,0)==="n") {
                        $("#username").val('');
                        $("#password").val('');
                        $(".form-box #title").append("<div id='flash'> Username or password incorrect! </div>")
                    }else{
                        /* If the request was successful redirects the user to the home page */
                        window.location.href = "../php/home.php";
                    }
                },
                error: ajaxFailed
            });
        }else{
            window.location.href="../php/logout.php?error=true";
        }
    });
});