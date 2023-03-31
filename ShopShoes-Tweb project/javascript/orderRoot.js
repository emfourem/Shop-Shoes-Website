/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to order.php for the root user
 */
$(document).ready(function(){
    /* Function that returns date and total price of all orders executed on the site */
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "allOrder",
        },
        success:function (response){
            let data = response;
            let date; /* It is used to save the order date and then pass it to the addItems function */
            let user;
            let j=0; /* j is used to set the id of the div related to the different orders that will contain the products */
            /* If the order list is empty, a root user feedback is generated */
            if(data.length === 0){
                $(".section-title").append(
                    "<h4> There are no orders yet. </h4>"
                );
            }else{
                /* Each order is placed in a different comment-box */
                for(let i in data) {
                    date=data[i].date_of;
                    user=data[i].username;
                    $('#full').append(
                        "<div class='comment-box'>"+
                            "<div class='box-top'>"+
                                "<div class='profile'>"+
                                    "<div class='profile_image'>"+
                                        "<i class='fa fa-money'></i>"+
                                    "</div>"+
                                    "<div class='Name'>"+
                                        "<strong id='username'>Ordine di "+user.toUpperCase()+" del "+date +"</strong>"+
                                        "<span>Costo totale: "+data[i].total_price +"</span>"+
                                    "</div>"+
                                "</div>"+
                            "</div>"+
                            "<div id='allItems"+j+"'>"+
                            "</div>"+
                        "</div>"
                    );
                    /* Retrieve and place products within the order j made by the user on that date*/
                    addItems(date,j,user);
                    /* Increment j at each order */
                    j=j+1;
                }
            }
        },
        error: ajaxFailed
    });

});

/*
Function that retrieves items of order j made by the user on that date
 */
function addItems(date,j,user){
    $.ajax(
        {
            url: "functions.php",
            type:"post",
            data: {
                "action": "retrieveAllItems",
                "date": date,
                "user": user,
            },
            success: function (response) {
                /* There cannot be empty orders and even if a product is removed, the order remains intact */
                let data = response;
                /* Name and price shown for each item */
                for(let i in data) {
                    $("#allItems"+j).append(
                        "<div class='comment'>"+
                            "<p id='text'>"+data[i].product_name+" - "+ data[i].price +"</p>"+
                            "<abbr title='More info'><i class='fa fa-info' id='info'></i></abbr>"+
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