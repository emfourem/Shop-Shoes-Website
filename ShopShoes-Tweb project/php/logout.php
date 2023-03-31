<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This page is used to disconnect the user and to delete the user’s session data as well as make the logout effective
 */
session_start();
session_unset();
session_destroy();

session_start();
if(isset($_GET["error"])){
    $_SESSION["error"] = "There were problems with your requests.\n Please try again later.";
} else {
    $_SESSION["error"] = "Logout successfully";
}
header("Location: ../php/login.php");