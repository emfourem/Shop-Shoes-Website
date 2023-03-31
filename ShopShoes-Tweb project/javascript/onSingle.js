/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to the single product page for the user
 */
var id=-1; /* Is used to save the product id once loaded if it exists */
var show=0; /* Is used to decide whether to show forwarding options or not */
var name_prod; /* Is used to save the product name */
$(document).ready(function(){
    /* Retrieve parameter from URL as if it were a parameter of GET method */
    let params = new URLSearchParams(window.location.search);
    let name=params.get('product_name');
    /* Save the product name into name_prod */
    name_prod=name
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "findProduct",
            "product_name": name ,
        },
        success:function (response){
            let data = response;
            /* If the product exists */
            if(data.length>0) {
                /* The card is filled with all the detailed information */
                id =insertInfo(response);
                /* Check that the product is in user's shopping cart */
                checkInCart();
            }
        },
        complete: function(){
            /* The id is -1 only when the product does not exist */
            if(id===-1){
                /* If it does not exist, feedback is provided to the user */
                $(".single_product").children().remove();
                $(".main").children().remove();
                $(".single_product").append(
                  "<div id='removed'> This product has been removed! Go to <a href='../php/home.php'>home</a></div>"
                );
            }else {
                /* If it exists, two different functions are performed */
                /* Adds the event managers */
                addOn();
                /* Retrieve reviews about that product */
                findComment();
            }
        },
        error: ajaxFailed
    });
});

function addOn(){
    /* Add the manager to the form that allows the insertion of a new comment */
    addOnForm();
    /* Change the visibility of the forwarding options at click through the value of the show variable */
    $("#sendSingle").click(function () {
        if (show === 1) {
            $("#tosend").css("visibility", "hidden");
            show = 0;
        } else {
            $("#tosend").css("visibility", "visible");
            show = 1;
        }
    });
}

/* Check that the item is in the cart and if it is not present allows to insert it. */
function checkInCart(){
    $.ajax({
        url: "functions.php",
        type:"post",
        data: {
            "action": "checkCart",
            "id": id,
        },
        success: function (response) {
            /* If the item is already in the cart */
            if(response.substring(1,0)==="a"){
                $("#cart").append(
                    "<p id='p'>Already in cart</p>"
                );
            }else{
                /* if the item isn't in the cart */
                $("#cart").append(
                    "<i class='fa fa-cart-plus'></i>"
                );
                /* Add icon and click manager */
                $("#cart").click(function (){
                    /* Add product to shopping cart */
                    addToCartIfNotPresent(name_prod,0);
                    $("#cart").children().remove();
                    /* Change the view */
                    $("#cart").append(
                        "<p id='p'>Already in cart</p>"
                    );
                    /* Disable the listener on the click */
                    $("#cart").off("click");
                });
            }
        },
        error: ajaxFailed
    });
}

/* Function that retrieves comments for the product specified by the ID */
function findComment(){
    $.ajax({
        url: "functions.php",
        type:"post",
        data: {
            "action": "findComments",
            "id": id,
        },
        success: function (response) {
            /* Insert comments in the respective comment-boxes */
            insertComments(response);
        },
        error: ajaxFailed
    });
}

/* Function that inserts comments in the respective comment-boxes */
function insertComments(response){
    /* If there are no comments, it simply shows nothing */
    let data = response;
    for (let i in data) {
        $("#allComment").prepend(
            "<div class='comment-box'>" +
                "<div class='box-top'>" +
                    "<div class='profile'>" +
                        "<div class='profile_image'>" +
                            "<i class='fa fa-user'></i>" +
                        "</div>" +
                        "<div class='Name'>" +
                            "<strong id='username'>" + (data[i].username).toUpperCase() + "</strong>" +
                            "<span id='email'>" + data[i].email + "</span>" +
                            "<span id='date'>" + data[i].insert_date + "</span>" +
                        "</div>" +
                    "</div>" +
                "</div>" +
                "<div class='comment'>" +
                    "<p id='text'>" + data[i].text + "</p>" +
                "</div>" +
            "</div>"
        )
    }
}
/* Funzione che aggiunge il listener per la sottomissione di un commento */
function addOnForm(){
    $("#idForm").submit(function(e) {
        /* Create the current date according to the format defined in the database */
        const d = new Date();
        let text = d.toLocaleString("en-CA", {
            hour12:false,
            hour: "2-digit",
            second: "2-digit",
            minute: "2-digit",
            day: "2-digit",
            year: "numeric",
            month: "2-digit",
        });
        let date=text.replace(",","");
        /* Retrieve data from the form */
        let form = $(this);
        e.preventDefault();
        $.ajax({
            url: "functions.php",
            type:"post",
            /* Serialize the data to send them */
            data: form.serialize() + "&action=addComment", /* + '&' + $.param(object)*/
            success: function (response) {
                /* Update view by dynamically entering comment before others */
                addLastComment(response);
            },
            error: ajaxFailed
        });
    });
}

/* Retrieve the comment just written and update the view */
function addLastComment(date){
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "findLastComment",
            "id": id ,
            "date": date,
        },
        success:function (response){
            console.log(date);
            /* Call insertComments to add comment */
            insertComments(response);
        },
        complete: function(){
            /* Empty the form */
            $("#idForm #text").val('');
        },
        error: ajaxFailed
    });
}