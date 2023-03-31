<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 * This page can be used by both the root user and the normal user
 * and allows to view respectively all orders and orders of the same user
 */
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['username'],$_SESSION['name'],$_SESSION['surname'])) {
    /*Begin of navbar*/
    include "../html/top.html";?>
    <link rel="stylesheet" href="../css/order.css">
    <?php
    /*
     * Use a different javascript file depending on whether the page is viewed by the root user or a normal user
     */
    if($_SESSION['typeof']==="root"){ ?>
            <script src="../javascript/orderRoot.js" type="text/javascript"></script>
    <?php }else{ ?>
        <script src="../javascript/order.js" type="text/javascript"></script>
    <?php
    }
    include "../html/navbar.html"; ?>
    <li class="menu-item"><a href="home.php" class="new"><i class="fa fa-user" id="user-name"><span id="tooltip">Hi <?= $_SESSION["name"]." ".$_SESSION["surname"] ?></span></i></a></li>
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
    /* Begin of order section */?>
    <div class="section-title">
        <h1 class="heading"><a id="products-title">ORDERS</a></h1>
    </div>
    <section class="main">
        <div class="full-boxer" id="full">
        </div>
    </section>
    <?php
    /* End of order section and start of footer*/
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
