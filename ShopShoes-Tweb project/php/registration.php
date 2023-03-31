<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This page allows registration to the site
 */
if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/common.css">
        <link rel="stylesheet" type="text/css" href="../css/registration.css">
        <link rel="icon" type="image/png" sizes="16x16"  href="../image/favicon-16x16.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="../jquery-ui-1.13.2.custom/external/jquery/jquery.js"></script>
        <script src="../javascript/commonFunctions.js" type="text/javascript"></script>
        <script src="../javascript/registration.js" type="text/javascript"></script>
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <title>Shop Shoes</title>
    </head>
    <body>
        <!-- Start of the form that allows registration through appropriate functions -->
        <form id="formRegistration" accept-charset="utf-8">
            <div class="form-box">
                <h1 id="title">Registration</h1>
                <?php
                /*
                 * This section allows to show an error message if it is initialized,
                 * destroy the current session and restart a new session immediately after
                 */
                if (isset($_SESSION["error"])) {
                    ?>
                    <div id="flash"> <?= $_SESSION["error"] ?> </div>
                    <?php
                    unset($_SESSION["error"]);
                    session_unset();
                    session_destroy();
                    session_start(); /*for new login or registration*/
                }
                ?>
                <div class="input-box">
                    <i class="fa fa-user"></i>
                    <input type="text" id="name" name="name" pattern="[A-Z]{1}[a-z]{1,16}|[A-Z]{1}[a-z]{1,16}\s[A-Z][a-z]{1,14}"
                           title="The maximum length of name is 32 letters and only initials in upper case. Two names maximum."
                           maxlength="32" placeholder="Insert your name (example Mario)" required="required" >
                </div>
                <div class="input-box">
                    <i class="fa fa-user-plus"></i>
                    <input type="text" id="surname" name="surname" pattern="[a-z]{0,1}[']{0,1}[A-Z]{1}[a-z]{1,32}"
                           title="The maximum length of surname is 32 letters and only initials in upper case"
                           maxlength="32" placeholder="Insert your surname (example Rossi)" required="required" >
                </div>
                <div class="input-box">
                    <i class="fa fa-user-secret"></i>
                    <input type="text" id="username" name="username" pattern="[a-z]{4,16}"
                           title="The username must be composed of at least 4 and maximum 16 letters all in lowercase"
                           minlength="4" maxlength="16" placeholder="Insert your username (example pippo)" required="required" >
                </div>
                <div class="input-box">
                    <i class="fa fa-envelope"></i>
                    <input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}"
                           title="The email must be composed of a prefix of lowercase only followed by @domain.it/com. The maximum length is 32 "
                           placeholder="Insert your email (example name@domain.it/com)" required="required" >
                </div>
                <div class="input-box">
                    <i class="fa fa-lock"></i>
                    <input type="password" id="password" name="password"
                           title="The password must contain exactly 8 letters of which only the first uppercase ending with a number and a dot"
                           pattern="[A-Z]{1}[a-z]{7}[0-9]{1}[.]{1}"
                           maxlength="10" minlength="10" placeholder="Insert your password (example Abcdefgh1.)" required="required" >
                    <span class="eye" id="eye">
                        <i id="hide1" class="fa fa-eye"></i>
                        <i id="hide2" class="fa fa-eye-slash"></i>
                    </span>
                </div>
                <button type="submit" class="button">Register</button>
                <p>You're already sign? Go to <a href="login.php">login</a> or go <a href="index.php">back!</a></p>
            </div>
        </form>
    </body>
</html>




