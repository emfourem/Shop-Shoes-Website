/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to the wishlist.php page
 */
$(document).ready(function(){
    /*
    Request ajax to dynamically recover all products in the user's wishlist to show to the user
     */
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "loadWishlist",
        },
        success:function (response){
            let data = response;
            /* If there are no products in the wishlist a feedback is provided to the user */
            if(data.length===0){
                $(".section-title").append(
                    "<h4 id='infoWishlist'> Your wishlist is empty! Go to <a href='home.php'>shopping</a> and add an item!</h4>"
                );
            }else {
                /* Each product in the wishlist is inserted into a card and shown to the user */
                for (let i in data) {
                    $('#row').append(
                        "<div class='column'>" +
                            "<div class='card'>" +
                                "<div class='product-image'>" +
                                    "<img src='" + data[i].image + "' alt='Foto'>" +
                                "</div>" +
                                "<div class='product-info'>" +
                                    '<h4 id="name">' + data[i].product_name + '</h4>' +
                                    "<h4 id='price'>" + data[i].price + "</h4>" +
                                "</div>" +
                                "<div class='btn'>" +
                                    "<i class='fa fa-star' id='star-btn'>" +
                                        "<span id='tooltip1'>Remove from wishlist</span>"+
                                    "</i>" +
                                    "<i class='fa fa-cart-plus' id='basket'>" +
                                        "<span id='tooltip1'>Add/remove to/from cart</span>"+
                                    "</i>" +
                                    "<i class='fa fa-info' id='info'>" +
                                        "<span id='tooltip1'>More info</span>"+
                                    "</i>" +
                                "</div>" +
                            "</div>" +
                        "</div>"
                    );
                }
            }
        },
        complete: function(){

            addOn();
        },
        error: ajaxFailed
    });
});

/*
Function that adds click event managers to elements and defines the behavior to follow
 */
function addOn(){
    /*
    Hides the cart icon from the cards.
    The idea is that to insert a product in the cart, the user must go to the page related to the individual product
    */
    $("#row #basket").each(function(){
        $(this).css("visibility", "hidden");
    });
    /*
    Adds the same handler to all information icons
     */
    $("#row #info").each(function(){
        $(this).click(function() {
            /*Retrieve the product name and save it in x*/
            let x = $(this).parent().parent().parent().find("#name").html();
            /* Redirects the user to the singleProduct page by passing the item name as if it were a GET parameter*/
            window.location.href = "../php/singleProduct.php?product_name="+x;
        });
    });
    /*
    Adds the same handler to all star icons
     */
    $("#row #star-btn").each(function(){
        $(this).click(function() {
            /* Retrieve the product name of the product and save it in x */
            let x = $(this).parent().parent().parent().find("#name").html();
            /* Remove the item from the wishlist as it is already present */
            addWishlistIfNotPresent(x);
            /* Remove the card from the display */
            $(this).parent().parent().parent().remove();
            /* Provides visible user feedback for 3 seconds */
            $(".section-title").append(
                "<h4 id='information'> An item has been removed from your wishlist!</h4>"
            )
            setTimeout(function (){
                $(".section-title #information").remove();
            },3000);
        });
    });
}