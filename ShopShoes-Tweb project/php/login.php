<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This page allows logging in to the site to the user
 */
if (!isset($_SESSION)) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/common.css">
        <link rel="stylesheet" type="text/css" href="../css/login.css">
        <link rel="icon" type="image/png" sizes="16x16"  href="../image/favicon-16x16.png">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="../jquery-ui-1.13.2.custom/external/jquery/jquery.js"></script>
        <script src="../javascript/commonFunctions.js" type="text/javascript"></script>
        <script src="../javascript/login.js" type="text/javascript"></script>
        <title>Shop Shoes</title>
    </head>
    <body>
    <!-- Start of the form that allows log in through appropriate functions -->
        <form id="loginForm" accept-charset="utf-8">
            <div class="form-box">
                <h1 id="title">Login</h1>
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
                    session_regenerate_id(TRUE);
                    session_unset();
                    session_destroy();
                    session_start(); /*for new login or registration*/
                }
                ?>
                <div class="input-box">
                    <i class="fa fa-user-secret"></i>
                    <input type="text" id="username" name="username" pattern="[a-z]{4,16}"
                           title="The username must be composed of at least 4 and maximum 16 letters all in lowercase"
                           minlength="4" maxlength="16" placeholder="Insert your username (example pippo)" required="required" >
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
                <button type="submit" class="button">Login</button>
                <p>Not registered yet? Go to <a href="registration.php">registration </a>or go <a href="index.php">back!</a></p>
            </div>
        </form>
    </body>
</html>



