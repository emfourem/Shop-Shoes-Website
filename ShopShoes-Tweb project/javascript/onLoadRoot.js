/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to loading products on the home page for the root
 */
$(document).ready(function(){
    /* Ajax function that retrieves all products from the products table */
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "load",
        },
        success:function (response){
            let data = response;
            /* If there are no products for sale a feedback is provided to the root user */
            if(data.length === 0){
                $("#row").append("<div id='empty'> There are no products for sale at the moment. </div>");
            }else {
                /* Each product is inserted into a card and shown to the root user */
                for (let i in data) {
                    $('#row').append(
                        "<div class='column'>" +
                            "<div class='card'>" +
                                "<div class='product-image'>" +
                                    "<img src='" + data[i].image + "' alt='Foto'>" +
                                "</div>" +
                                "<div class='product-info'>" +
                                    "<h4 id='name'>" + data[i].product_name + "</h4>" +
                                    "<h4 id='price'>" + data[i].price + "</h4>" +
                                "</div>" +
                                "<div class='btn'>" +
                                    "<i class='fa fa-minus' id='minus'>" +
                                        "<span id='tooltip1'>Remove this product</span>" +
                                    "</i>" +
                                    "<i class='fa fa-cog' id='cog'>" +
                                        "<span id='tooltip1'>See info</span>" +
                                    "</i>" +
                                "</div>" +
                            "</div>" +
                        "</div>"
                    );
                }
            }
        },
        complete:function (){
            /* After the success function different functions are invoked for different tasks*/
            addOnClick();
            addOnSend();
        },
        error: ajaxFailed
    });
});

/* Adds the event managers  */
function addOnClick(){
    /* Adds the same handler to each minus icon */
    $("#row #minus").each(function(){
        $(this).click(function() {
            /* Retrieve the name of the product */
            let name=$(this).parent().parent().find("#name").html();
            /*Redirect the root user to the remove product page passing the name of the product to be removed as a GET parameter */
            window.location.href = "../php/removeProduct.php?product_name="+name;
        });
    });
    /* Adds the same handler to each cog icon(similar to the information icon) */
    $("#row #cog").each(function(){
        $(this).click(function() {
            /* Retrieve the name of the product */
            let name=$(this).parent().parent().find("#name").html();
            /*Redirect the root user to the individual product page by passing the name as a GET parameter */
            window.location.href = "../php/singleProduct.php?product_name="+name;
        });
    });
}