/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file that contains functions common to multiple javascript files
 */

/* Function that adds animation to the button in the contact section*/
function addOnSend(){
    /* Find the button and add the listener for the event click */
    let x=$("#sendNow");
    x.click(function() {
        x.addClass("actived");
        setTimeout(function (){
            x.addClass("success");
        },3700);
        setTimeout(function (){
            x.removeClass("actived");
            x.removeClass("success");
            $(".button").append("<h2>Thank you for your feedback!</h2>")
            $("#message").val('');
            $("#text").val('');
            $("#email").val('');
        },5000);
        setTimeout(function (){
            $(".button h2").remove();
        },8000);
    });
}

/* Function that retrieves all products in the wishlist of the user */
function checkInWishlist(){
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "checkInWishlist",
        },
        success: function (response) {
            let data = response;
            /* For all the products in the wishlist, golden color the star icon of the card for the single product */
            for (let i in data) {
                $("#row").find("#name:contains(" + data[i] + ")").parent().next().children(":first").css("color", "gold");
            }
        },
        error: ajaxFailed
    });
}

/*Function that takes an item and adds it to the user’s wishlist if it is not present otherwise removes it*/
function addWishlistIfNotPresent(a){
    $.ajax({
        url: "functions.php",
        type:"post",
        data: {
            "action": "checkWishlist",
            "product_name": a,
        },
        success: function (response) {
            /* Do nothing because in both cases the view is automatically updated */
        },
        error: ajaxFailed
    });
}

/* Function that retrieves all products in the cart of the user */

function checkInCart(){
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "checkInCart",
        },
        success: function (response) {
            let data = response;
            /* For all the products in the cart, golden color the star icon of the card for the single product */
            for (let i in data) {
                $("#row").find("#name:contains(" + data[i] + ")").parent().next().children().eq(1).css("color", "gold");
            }
        },
        error: ajaxFailed
    });
}

/*
Function that takes an item and adds it to the user’s cart if it is not present otherwise removes it
The value parameter causes actions in response to the request.
If value is 1 (only in the case of drag and drop) a feedback is provided to the user of the addition/ removal of the product from the cart
*/
function addToCartIfNotPresent(a,value){
    $.ajax({
        url: "functions.php",
        type:"post",
        data: {
            "action": "addToCart",
            "product_name": a,
        },
        success: function (response) {
            if(value===1){
                /* Manages feedback to be provided to the user that may be positive or negative */
                let y=$("#mycart");
                if(response.substring(1,0)==="r"){ /*removed*/
                    y.find("#name").html("");
                    y.find("#name").append("<i class='fa fa-remove' id='remove'></i>");
                    setTimeout (function () {
                        y.find("#name").html("Already in cart! Removed.");
                    }, 2000);
                    setTimeout (function () {
                        y.find("#name").html("Drag here to add/remove a product from your cart");
                    }, 5000);
                }else{
                    y.find("#name").html("");
                    y.find("#name").append("<i class='fa fa-check' id='add'></i>");
                    setTimeout (function () {
                        y.find("#name").html("Inserted correctly.");
                    }, 2000);
                    setTimeout (function () {
                        y.find("#name").html("Drag here to add/remove a product from your cart");
                    }, 5000);
                }
            }
        },
        error: ajaxFailed
    });
}

/*Function called to dynamically enter information for a given product in the appropriate fields */
function insertInfo(response){
    let data = response;
    $("#name").html(data[0].product_name);
    $("#left-img").append("<img src='" + data[0].image + "' alt='product'>");
    $("#height").append(data[0].height_cleats);
    $("#name").append(name);
    $("#material").append(data[0].material);
    $("#singlePrice").html("$ "+data[0].price);
    $("#field").append(data[0].field);
    /*
    Returns the product id value for later use
    to add comments or add/remove it from cart
     */
    return data[0].id;
}

/*Function that retrieves the product name of the single product
and redirects to the page that shows the information of the single product */
function addOnSingle(){
    $("#full #info").each(function(){
        $(this).click(function() {
            /* Text is of the form "name -price" */
            let x = $(this).parent().parent().find("#text").html();
            let y=x.split(" -");
            /* Redirects after extracting name only */
            window.location.href = "../php/singleProduct.php?product_name="+y[0];
        });
    });
}

/* Function that shows or hides the password during login or registration */
function onEye(){
    $("#eye").click(function(){
        let x =$("#password");
        let y =$("#hide1");
        let z =$("#hide2");
        if(x.get(0).type === 'password'){
            x.get(0).type = 'text';
            y.css("display","block");
            z.css("display","none");
        }else{
            x.get(0).type = 'password';
            y.css("display","none");
            z.css("display","block");
        }
    });
}
/* Function that defines the behavior in case of ajax function error */
function ajaxFailed(e){
    console.log("Server status: "+e.status +",  "+e.statusText+"\n Server response text: "+ e.responseText);
    /* Redirects to the logout page that destroys the session and generates a response to the user */
    window.location.href="../php/logout.php?error=true";
}
