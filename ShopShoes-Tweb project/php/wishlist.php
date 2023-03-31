<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * In this file there is the structure of the page relative to the wishlist of every single user.
 */
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['username'],$_SESSION['name'],$_SESSION['surname'])) {
    /* Begin of navbar */
    include "../html/top.html";?>
    <script src="../javascript/wishlist.js" type="text/javascript"></script>
    <link rel="stylesheet" href="../css/wishlist.css">
    <?php
    include "../html/navbar.html"; ?>
    <li class="menu-item"><a href="home.php" class="new"><i class="fa fa-user" id="user-name"><span id="tooltip">Hi <?= $_SESSION["name"]." ".$_SESSION["surname"] ?></span></i></a></li>
    <li class="menu-item"><a href="wishlist.php" class="new"><i class="fa fa-star" id="seeWishlist" ><span id="tooltip">Click to see your wishlist</span></i></a></li>
    <li class="menu-item"><a href="cart.php" class="new"><i class="fa fa-shopping-cart" id="seeCart"><span id="tooltip">Click to see your cart</span></i></a></li>
    <?php
    include "../html/bottomNavbar.html";
    /* End of navbar*/
    /* Start of product section */
    include "../html/productsWishlist.html";
    /* End of product section and start of footer*/
    include "../html/footer.html";
}else {
    /*
     * An error message is set and then shown on the page where the user is redirected
     * To use the message on the next page, set it as a variable in the _SESSION array
     */
    $_SESSION["error"]="You're not logged in. Log in and try again!";
    header("Location: ../php/login.php");
}
?>
