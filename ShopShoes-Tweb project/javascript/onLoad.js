/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to loading products on the home page for the user
 */
$(document).ready(function(){
    /* Ajax function that retrieves all products from the products table */
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype: "json",
        data: {
            "action": "load",
        },
        success:function (response){
            let data=response;
            let x=$("#row");
            /* If there are no products for sale a feedback is provided to the user */
            if(data.length === 0){
                x.append("<div id='empty'> There are no products for sale at the moment. </div>");
            }else {
                /* Each product is inserted into a card and shown to the user */
                /* There are two hidden fields to dynamically recover product name and price */
                /* The id chosen for the product-image div is useful to facilitate the next search */
                for (var i in data) {
                    x.append(
                        "<div class='column'>" +
                            "<div class='card'>" +
                                "<div class='product-image' id='item" + i + "'>" +
                                    "<img src='" + data[i].image + "' alt='Foto'>" +
                                "</div>" +
                                "<div class='product-info'>" +
                                    '<h4 id="name">' + data[i].product_name + '</h4>' +
                                    "<h4 id='price'>" + data[i].price + "</h4>" +
                                    "<input type='hidden' id='item" + i + "_name' value='" + data[i].product_name + "'>" +
                                    "<input type='hidden' id='item" + i + "_price' value='" + data[i].price + "'>" +
                                "</div>" +
                                "<div class='btn'>" +
                                    "<i class='fa fa-star' id='star-btn'>" +
                                        "<span id='tooltip1'>Add/remove to/from wishlist</span>" +
                                    "</i>" +
                                    "<i class='fa fa-cart-plus' id='basket'>" +
                                        "<span id='tooltip1'>Add/remove to/from cart</span>" +
                                    "</i>" +
                                    "<i class='fa fa-info' id='info'>" +
                                        "<span id='tooltip1'>More info</span>" +
                                    "</i>" +
                                "</div>" +
                            "</div>" +
                        "</div>"
                    );
                }
                /* As last card a special card used for drag and drop is added */
                x.append(
                    "<div class='column' id='mycart'>" +
                        "<div class='card' >" +
                            "<div class='product-image' id='item" + i + "'>" +
                                "<img src='../image/cart-plus-solid.svg' alt='Foto'>" +
                            "</div>" +
                            "<div class='product-info'>" +
                                "<h4 id='name'>Drag here to add/remove a product from your cart</h4>" +
                                "<h4 id='price'><a href='cart.php'>See your cart</a></h4>" +
                            "</div>" +
                            "<div class='btn'>" +
                                "<p>It’s easier if you drag it</p>" +
                            "</div>" +
                        "</div>" +
                    "</div>"
                );
            }
        },
        complete: function(){
            /* After the success function different functions are invoked for different tasks*/
            checkInWishlist();
            checkInCart();
            addOnClick();
            addOnSend();
            dragAndDrop();
        },
        error: ajaxFailed
    });

});

/* Adds the event managers  */
 function addOnClick(){
     /* Adds the same handler to each cart icon */
     $("#row #basket").each(function(){
         $(this).click(function() {
             /* Retrieve the name of the product */
             let x = $(this).parent().parent().find("#name").html();
             /* Add it to wishlist if not present, remove it otherwise */
             addToCartIfNotPresent(x,0);
             /* Change the icon color depending on whether the item is in the cart
              and provides feedback to the user*/
             if(($(this).css('color') === 'rgb(255, 255, 0)') || ($(this).css('color') === 'rgb(255, 255, 255)')){
                 let a=$(this).parent().parent().find("#price");
                 a.append("<h3 id='added'>Inserted in cart correctly!</h3>");
                 setTimeout(function (){
                     a.find("#added").remove();
                 },3000);
                 $(this).css('color','gold');
             }else{
                 let a=$(this).parent().parent().find("#price");
                 a.append("<h3 id='presents'>Already in cart! Removed!</h3>");
                 setTimeout(function (){
                     a.find("#presents").remove();
                 },3000);
                 $(this).css('color','white');
             }
         });
     });
     /* Adds the same handler to each star icon */
     $("#row #star-btn").each(function(){
         $(this).click(function() {
             /* Retrieve the name of the product */
             let x = $(this).parent().parent().find("#name").html();
             /* Add it to wishlist if not present, remove it otherwise */
             addWishlistIfNotPresent(x);
             /* Change the icon color depending on whether the item is in the wishlist
              and provides feedback to the user*/
             if(($(this).css('color') === 'rgb(255, 255, 0)') || ($(this).css('color') === 'rgb(255, 255, 255)')){
                 let a=$(this).parent().parent().find("#price");
                 a.append("<h3 id='added'>Inserted in wishlist correctly!</h3>");
                 setTimeout(function (){
                     a.find("#added").remove();
                 },3000);
                 $(this).css('color','gold');
             }else{
                 let a=$(this).parent().parent().find("#price");
                 a.append("<h3 id='presents'>Removed from wishlist!</h3>");
                 setTimeout(function (){
                     a.find("#presents").remove();
                 },3000);
                 $(this).css('color','white');
             }
         });
     });
     /* Adds the same handler to each information icon */
     $("#row #info").each(function(){
         $(this).click(function() {
             /* Retrieve the name of the product */
             let x = $(this).parent().parent().find("#name").html();
             /*Redirect the user to the individual product page by passing the name as a GET parameter */
             window.location.href = "../php/singleProduct.php?product_name="+x;
         });
     });

 }

 /* Function that defines drag and drop */
 function dragAndDrop(){
     /* As draggable object is used card image */
     $( ".product-image" ).draggable({
         opacity: 0.6,
         /* Revert will only occur if the draggable has not been dropped on a droppable */
         revert: 'invalid',
         /* Creates a clone of the dragged element and leaves the original element behind */
         helper: 'clone',
         /* The starting zIndex that gets applied by default when an element is pressed/touched */
         zIndex: 100
     });
     /* As droppable object is used a special card */
     $("#mycart").droppable({
         /* Drop callback function */
         drop:function(e, ui) {
             /* e is the event that is triggered when the draggable item is dropped on the droppable.*/
             /* ui is of type object. ui.draggable is the jQuery object representing the draggable element. */
             var param = $(ui.draggable).attr('id');
             /* Retrieves the id set in the div that contains the image (which is the Draggable object) */
             cart(param);
         }
     });

     /* Function that adds or removes the referenced element by the draggable object in/from the cart */
     function cart(id) {
         /* Find the relative div using the received id as parameter */
         const c=$("#row #" + id);
         /* Go up the DOM and look for the hidden field that contains the product name */
         const name = c.parent().find("#" + id + "_name")[0].value;
         /* Retrieve the cart icon for that card */
         const x = c.parent().find("#basket");
         /*
         Adds or removes the item from the cart and based on the answer decides the color of the icon
         Provides feedback to the user in both cases
         */
         addToCartIfNotPresent(name,1);
         if((x.css('color') === 'rgb(255, 255, 0)') || x.css('color') === 'rgb(255, 255, 255)'){
             let a=x.parent().parent().find("#price");
             a.append("<h3 id='added'>Inserted in cart correctly!</h3>");
             setTimeout(function (){
                 a.find("#added").remove();
             },3000);
             x.css('color','gold');
         }else{
             let a=x.parent().parent().find("#price");
             a.append("<h3 id='presents'>Removed from cart!</h3>");
             setTimeout(function (){
                 a.find("#presents").remove();
             },3000);
             x.css('color','white');
         }
     }
 }