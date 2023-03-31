/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to the cart.php page
 */
$(document).ready(function() {
    /*
    Request ajax to dynamically recover all products in the user's cart to show to the user
     */
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "loadCart",
        },
        success: function (response) {
            /*
            If successful, if the cart is not empty, the information is entered in the cards and shown to the user
             */
            let data = response;
            if (data.length === 0) {
                $("#row").append("<h3 id='complete'> Your cart is empty! Go to <a href='../php/home.php'>shopping</a> or go to <a href='../php/order.php'>your order</a></h3>");
            } else {
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
                                    "<i class='fa fa-cart-arrow-down' id='basket'>" +
                                        "<span id='tooltip1'>Remove from cart</span>"+
                                    "</i>" +
                                    "<i class='fa fa-info' id='info'>" +
                                    "</i>" +
                                "</div>" +
                            "</div>" +
                        "</div>"
                    );
                }
            }
        },
        complete: function(){
            /*
            ajax complete allows you to execute code after success has been fully executed
             */
            count();
            addOn();
        },
        error: ajaxFailed
    });
});

/*
Function that adds click event managers to elements and defines the behavior to follow
 */
function addOn() {
    /*
    Adds the same handler to all cart icons
     */
    $("#row #basket").each(function () {
        $(this).click(function () {
            /* Retrieve the product name of the product and save it in x */
            let x = $(this).parent().parent().parent().find("#name").html();
            /* Remove the card from the display */
            $(this).parent().parent().parent().remove();
            /* Remove the item from the cart as it is already present */
            addToCartIfNotPresent(x,0);
            /* Call the count function to update the total order price information in the shopping cart */
            count();
            /* Provides visible user feedback for 3 seconds */
            $(".section-title").append(
                "<h4 id='information'> An item has been removed from your cart!</h4>"
            )
            setTimeout(function (){
                $(".section-title #information").remove();
            },3000);
            /* Warn that cart is empty if total is <=0 */
            if($("#total").html()<=0){
                $("#row").append("<h3 id='complete'> Your cart is empty! Go to <a href='../php/home.php'>shopping</a> or go to <a href='../php/order.php'>your order</a></h3>");
            }
        });
    });
    /*
    Adds the same handler to all information icons
     */
    $("#row #info").each(function(){
        $(this).click(function() {
            /* Retrieve the product name and save it in x */
            let x = $(this).parent().parent().parent().find("#name").html();
            /* Redirects the user to the singleProduct page by passing the item name as if it were a GET parameter*/
            window.location.href = "../php/singleProduct.php?product_name="+x;
        });
    });
    /*
    Add the handler to the SendNow button that completes the order
     */
    $("#sendNow").click(function () {
        /* Dynamically adds useful classes to the animation success  */
        if($("#total").html()>0){
            $(this).addClass("actived");
            setTimeout(function (){
                $("#sendNow").addClass("success");
                /* Remove all items from the cart and update the cart total and the view */
                removeAllCartElement();
                $("#toOrder").append("<h2> Thank you for your order. See you soon!</h2>");
            },3700);
            setTimeout(function (){
                $("#sendNow").removeClass("actived");
                $("#sendNow").removeClass("success");
            },5000);
            setTimeout(function (){
                $("#toOrder").children().last().remove();
                $("#row").append("<h3 id='complete'> Your order is done! Return to <a href='../php/home.php'>shopping</a> or go to <a href='../php/order.php'>your order</a></h3>");
            },8000);
            /*
            Call completeOrder to insert the tuple relative to the new order in the bought table
            passing as parameter the total price of the order
            */
            completeOrder($("#total").html());
        }else{
            /*
            If the total price is not greater than zero the order is not executed
            and animated feedback is provided to the user
             */
            $(this).addClass("actived");
            setTimeout(function (){
                $("#sendNow").addClass("failed");
                $("#toOrder").append("<h2> Your cart is empty, add any products.</h2>");
            },3000);
            setTimeout(function (){
                $("#sendNow").removeClass("actived");
                $("#sendNow").removeClass("failed");
            },5000);
            setTimeout(function (){
                $("#toOrder").children().last().remove();
            },8000);
        }
    });
}

/* Function inserting new order in bought table */
function completeOrder(total){
    $.ajax({
        url: "functions.php",
        type:"post",
        data: {
            "action": "completeOrder",
            "total_price": total,
        },
        success: function (response){
            /* If the order is not concluded a feedback is provided to the customer */
            if(response.substring(1,0) === "n"){
                $("#row").append("<h3 id='complete'> There was a problem with your order, try again later!</h3>");
            }
        },
        error: ajaxFailed
    });
}

/*
Function called whenever you need to update or calculate the total of items in the cart
 */
function count() {
    /* Find all prices of items */
    let x = $("#row").children().find("#price");
    let sum=0;
    /* Sum all prices */
    for (let i = 0; i < x.length; i++){
        sum= sum + Number(x[i].innerHTML);
    }
    /* Change the total value shown to the user */
    $("#total").html(sum);
}
/* Function called up when the order is complete to remove all items from the customer’s cart */
function removeAllCartElement(){
    $.ajax({
        url: "functions.php",
        type:"post",
        data: {
            "action": "removeAllCartElement",
        },
        success: function (response){
            /* If the cart is emptied correctly, it updates the view and the account */
            if(response.substring(1,0) === "e"){
                $("#row").children().remove();
                count();
            }
        },
        error: ajaxFailed
    });
}
