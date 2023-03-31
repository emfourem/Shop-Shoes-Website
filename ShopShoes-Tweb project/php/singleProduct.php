<?php
/*
 * Shop Shoes -> Tweb Project
 * Merico Michele, matricola 945287
 *  This page allows you to analyze the properties of an article and read its reviews.
 *  It then allows the user to review, share or purchase the product
 *  while allowing the root user to delete reviews and display information about a single product
 */
if(!isset($_SESSION)){
    session_start();
}
if(isset($_SESSION['username'],$_SESSION['name'],$_SESSION['surname'],$_SESSION["typeof"])){
    /*Begin of navbar*/
    include "../html/top.html";?>
    <link rel="stylesheet" href="../css/singleProduct.css">
    <?php
    /*
     * Use a different javascript file depending on whether the page is viewed by the root user or a normal user
     */
    if($_SESSION['typeof']==="root"){ ?>
        <script src="../javascript/onSingleRoot.js" type="text/javascript"></script>
    <?php }else{ ?>
        <script src="../javascript/onSingle.js" type="text/javascript"></script>
    <?php }
    include "../html/navbar.html";
    ?>
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
    /*End of navbar and start of main section that allows to analyze the items properties*/?>
    <section class="single_product">
        <div class="section-title">
            <h1 class="heading"><a id="products-title">INFORMATION AND REVIEWS</a></h1>
        </div>
        <main class="container" id="container">
            <div class='left-column' id="left-img">
            </div>
            <div class='right-column'>
                <div class='product-description'>
                    <span>Football Shoes</span>
                    <h1 id="name"></h1>
                </div>
                <div class='product-configuration'>
                    <div class='allInfo'>
                        <span>Field</span>
                        <div class='singleInfo'>
                            <div class="information" id="field"></div>
                        </div>
                    </div>
                    <div class='allInfo'>
                        <span>Height Cleats</span>
                        <div class='singleInfo'>
                            <div class="information" id="height"></div>
                        </div>
                    </div>
                    <div class='allInfo'>
                        <span>Material</span>
                        <div class='singleInfo'>
                            <div class="information" id="material"></div>
                        </div>
                    </div>
                    <div class='allInfo'>
                        <span>Number</span>
                        <div class='singleInfo'>
                            <select class='list'>
                                <option></option>
                                <?php
                                for($i=38; $i<=48 ;$i++){?>
                                    <option ><?=$i?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <a href='#'>How to choose your number?</a>
                    </div>
                </div>
                <div class='product-price' id="product-price">
                    <span id="singlePrice"> </span>
                    <a class="cart-btn" id="cart"></a>
                    <a class="cart-btn" id="sendSingle">
                        <abbr title="Share with a friend">
                            <i class="fa fa-share" id="share">
                            </i>
                        </abbr>
                    </a>
                </div>
                <span id="tosend">
                    <ul class="socialsSend" >
                        <li><a href="#"><i class="fa fa-facebook" ></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" ></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" ></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube" ></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin-square" ></i></a></li>
                    </ul>
                </span>
            </div>
        </main>
    </section>
    <!--End of main section and start of section that shows the comments and allows you to add more-->
    <section class="main">
        <h1>REVIEWS</h1>
        <h4 id="forRoot">CLICK MINUS TO DELETE A COMMENT</h4>
        <div class="full-boxer" id="allComment">
        </div>
        <div class="full-boxer" id="user">
            <div class="comment-box">
                <div class="box-top">
                    <div class="profile">
                        <div class="profile_image">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="Name">
                            <strong id="username"><?=strtoupper($_SESSION["username"])?></strong>
                            <span><?=$_SESSION['email']?></span>
                            <span><?=date('Y-m-d');?></span>
                        </div>
                    </div>
                </div>
                <div id="otherComment">
                    <div class="comment" id="to_insert">
                        <form id="idForm">
                            <input type="text" id="text" class="input-text" name="text" placeholder="Enter your comment here">
                            <input type="hidden" name="product_name" value="<?=$_GET["product_name"]?>" >
                            <button type="submit" id="comm"><i class="fa fa-paper-plane" id="send_comment"></i></button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <?php
    /*End of reviews section and start of footer*/
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
