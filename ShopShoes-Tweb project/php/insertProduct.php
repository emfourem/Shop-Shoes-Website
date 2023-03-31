<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This page can only be used by the root user and allows the root to insert a new item in the store
 */
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['username'],$_SESSION['name'],$_SESSION['surname'],$_SESSION['email'], $_SESSION["typeof"]) && strcmp($_SESSION['typeof'],"root")==0 ) {
    /*Begin of the navbar*/
    include "../html/top.html";?>
    <link rel="stylesheet" href="../css/insertProduct.css">
    <script src="../javascript/insert.js" type="text/javascript"></script>
    <?php
    include "../html/navbar.html"; ?>
    <li class="menu-item"><a href="home.php" class="new"><i class="fa fa-user" id="user-name"><span id="tooltip">Hi <?= $_SESSION["name"]." ".$_SESSION["surname"] ?></span></i></a></li>
    <li class="menu-item"><a href="insertProduct.php" class="new"><i class="fa fa-plus" id="plusRoot"><span id="tooltip">Click here to insert a product</span></i></a></li>
    <li class="menu-item"><a href="removeProduct.php" class="new"><i class="fa fa-minus" id="minusRoot"><span id="tooltip">Click here to remove a product</span></i></a></li>
    <?php
    include "../html/bottomNavbar.html";
    /*End of navbar*/
    /*Start of the section that allows the actual insertion of the desired product*/
    include "../html/singleProductInsert.html";
    /*End of section and start of footer*/
    include ("../html/footer.html");
}else {
    /*
     * An error message is set and then shown on the page where the user is redirected
     * To use the message on the next page, set it as a variable in the _SESSION array
     */
    $_SESSION["error"]="You're not logged in. Log in and try again!";
    header("Location: ../php/login.php");
}
?>

