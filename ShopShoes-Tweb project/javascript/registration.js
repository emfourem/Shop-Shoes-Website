/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to registration.php page
 */
$(document).ready(function() {
    /* Associate the manager responsible for hiding/showing the password to the eye icon */
    onEye();
    /* Attach the handler to the submit event to manage submission */
    $("#formRegistration").submit(function(e) {
        /* Retrieve the form fields  */
        let form = $(this);
        e.preventDefault();
        /* Check the inputs */
        let pwd = $(this).find("#password").val();
        let username = $(this).find("#username").val();
        let name = $(this).find("#name").val();
        let surname = $(this).find("#surname").val();
        let email = $(this).find("#email").val();
        let pattern = /^[A-Z][a-z]{7}[0-9][.]$/;
        let pattern1 = /^[a-z]{4,16}$/;
        let pattern2 = /^[A-Z][a-z]{1,16}|[A-Z][a-z]{1,16}\s[A-Z][a-z]{1,14}$/;
        let pattern3 = /^[a-z]?[']?[A-Z][a-z]{1,32}$/;
        let pattern4 = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
        let result = pwd.match(pattern);
        let result1 = username.match(pattern1);
        let result2 = name.match(pattern2);
        let result3 = surname.match(pattern3);
        let result4 = email.match(pattern4);
        if(result != null && result1 != null && result2 != null && result3 != null && result4 != null) {
            $.ajax({
                url: "../php/functions.php",
                type: "post",
                /* Serialize the data to send them */
                data: form.serialize() + "&action=registrationInitial",
                success: function (response) {
                    /* If the request was unsuccessful provides feedback to the user  */
                    if (response.substring(1, 0) === "e") {
                        $("#username").val('');
                        $("#password").val('');
                        $(".form-box #title").append("<div id='flash'> Please re-enter your personal data </div>")
                        setTimeout(function () {
                            $("#flash").remove()
                        }, 3000)
                    } else if (response.substring(1, 0) === "u") {
                        /* If a user with that username already exists, it provides feedback to the customer */
                        $(".form-box #title").append("<div id='flash'> Username already in use!  </div>")
                        setTimeout(function () {
                            $("#flash").remove()
                        }, 3000)
                    } else {
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