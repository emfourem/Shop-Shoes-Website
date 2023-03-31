<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This is the first page that you see when you want to access the site and contains a small presentation
 * and links to pages to log in or register
 */
if(!isset($_SESSION)){
    session_start();
}?>
<!DOCTYPE html>
<html lang="">
    <head>
        <link rel="stylesheet" type="text/css" href="../css/common.css">
        <link rel="stylesheet" type="text/css" href="../css/index.css">
        <link rel="icon" type="image/png" sizes="16x16"  href="../image/favicon-16x16.png">
        <script src="../jquery-ui-1.13.2.custom/external/jquery/jquery.js"></script>
        <script src="../javascript/index.js" type="text/javascript"></script>
        <title>Shop Shoes</title>
    </head>
    <body>
        <div class="form-box">
            <h1> Welcome to Shop Shoes</h1>
            <h2> The best online store of football shoes</h2>
            <h3> Log in with your ShopShoes account or register to continue</h3>
            <div class="both">
                <button class="button" id="login">Login</button>
                <button class="button" id="registration">Register</button>
            </div>
        </div>
    </body>
</html>


