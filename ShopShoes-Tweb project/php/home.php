<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This file defines the structure of the home page of the Shop Shoes site.
 * It contains a presentation section, a section that shows the products sold,
 * a section that invites the user to provide feedback for the page
 * and finally a section to learn more about the creator of the same.
 */
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['username'],$_SESSION['name'],$_SESSION['surname'],$_SESSION["typeof"])){
    /*Begin of the navbar*/
    include "../html/top.html";
    /*
     * Use a different javascript file depending on whether the page is viewed by the root user or a normal user
     */
    if($_SESSION['typeof']==="root"){ ?>
        <script src="../javascript/onLoadRoot.js" type="text/javascript"></script>
    <?php }else{ ?>
        <script src="../javascript/onLoad.js" type="text/javascript"></script>
    <?php }
    include "../html/navbar.html";
    ?>
    <li class="menu-item"><a href="home.php" class="new"><i class="fa fa-user" id="user-name"><span id="tooltip">Welcome <?= $_SESSION["name"]." ".$_SESSION["surname"] ?></span></i></a></li>
    <?php
    /*
     * A different bar is loaded depending on whether the user of the page is the root user or the normal user
     */
    if($_SESSION["typeof"]==="root"){?>
        <li class="menu-item"><a href="insertProduct.php" class="new"><i class="fa fa-plus" id="plusRoot"><span id="tooltip">Click here to insert a product</span></i></a></li>
        <li class="menu-item"><a href="removeProduct.php" class="new"><i class="fa fa-minus" id="minusRoot"><span id="tooltip">Click here to remove a product</span></i></a></li>
        <?php
    }else{?>
        <li class="menu-item"><a href="wishlist.php" class="new"><i class="fa fa-star" id="seeWishlist" ><span id="tooltip">Click to see your wishlist</span></i></a></li>
        <li class="menu-item"><a href="cart.php" class="new"><i class="fa fa-shopping-cart" id="seeCart"><span id="tooltip">Click to see your cart</span></i></a></li>
        <?php
    }
    include "../html/bottomNavbar.html";
    /*End of navbar*/
    ?>
    <?php
    /*Start of the home(presentation) section*/
    include "../html/home.html";
    /*End of home section*/
    /*Start of the products section*/
    include "../html/products.html";
    /*End of products section*/
    /*Start of the contact section*/
    include "../html/contact.html";
    /*End of contact section*/
    /*Start of information(discover me) section*/
    include "../html/about.html";
    /*End of information section and footer start*/
    include "../html/footer.html";
}else{
    /*
     * An error message is set and then shown on the page where the user is redirected
     * To use the message on the next page, set it as a variable in the _SESSION array
     */
    $_SESSION["error"]="You're not logged in. Log in and try again!";
    header("Location: ../php/login.php");
}
?>