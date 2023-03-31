/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to order.php for the user
 */
$(document).ready(function(){
    /* Ajax function that retrieves all user orders */
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "loadOrder",
        },
        success:function (response){
            /* The function recovers date and total price of all orders */
            let data = response;
            let date; /* It is used to save the order date and then pass it to the addItems function */
            let j=0; /* j is used to set the id of the div related to the different orders that will contain the products */
            /* If the order list is empty, a user feedback is generated */
            if(data.length===0){
                $(".section-title").append(
                    "<h4> Your order list is empty! Go to <a href='../php/home.php'>shopping</a> and make a purchase!</h4>"
                );
            }else {
                /* Each order is placed in a different comment-box */
                for (let i in data) {
                    date = data[i].date_of;
                    $('#full').append(
                        "<div class='comment-box'>" +
                            "<div class='box-top'>" +
                                "<div class='profile'>" +
                                    "<div class='profile_image'>" +
                                        "<i class='fa fa-money'></i>" +
                                    "</div>" +
                                    "<div class='Name'>" +
                                        "<strong id='username'>Il tuo ordine del " + data[i].date_of + "</strong>" +
                                        "<span>Costo totale: " + data[i].total_price + "</span>" +
                                    "</div>" +
                                "</div>" +
                            "</div>" +
                            "<div id='allItems" + j + "'>" +
                            "</div>" +
                        "</div>"
                    );
                    /* Retrieve and place products within the order j in that date*/
                    addItems(date, j);
                    /* Increment j at each order */
                    j = j + 1;
                }
            }
        },
        error: ajaxFailed
    });

});

/*
Function that retrieves items of order j
 */
function addItems(date,j){
    $.ajax(
        {
            url: "functions.php",
            type:"post",
            datatype:"json",
            data: {
                "action": "retrieveItems",
                "date": date,
            },
            success: function (response) {
                /* There cannot be empty orders and even if a product is removed, the order remains intact */
                let data = response;
                /* Name and price shown for each item */
                for(let i in data) {
                    $("#allItems"+j).append(
                        "<div class='comment'>"+
                            "<p id='text'>"+data[i].product_name+" - "+ data[i].price +"</p>"+
                            "<abbr title='More info'><i class='fa fa-info' id='info'></i></abbr>" +
                        "</div>"
                    );
                }

            },
            complete: function(){
                /* Adds an event manager for event click on information icon */
                addOnSingle()
            },
            error: ajaxFailed
        }
    );
}