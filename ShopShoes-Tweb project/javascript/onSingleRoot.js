/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to the single product page for the root user
 */
var id=-1; /* Is used to save the product id once loaded if it exists */
var show=0; /* Is used to decide whether to show forwarding options or not */
var name_prod; /* Is used to save the product name */
$(document).ready(function(){
    /* Removes price and ability to add a comment */
    $("#product-price").remove();
    $("#user").children().remove();
    /* Enable the script that provides root guidance to delete one or more comments */
    $("#forRoot").css("visibility","visible");
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
                id =insertInfo(response);
            }
        },
        complete: function(){
            /* The id is -1 only when the product does not exist */
            if(id!==-1){
                /* If it exists, retrieve reviews about that product */
                findComments();
            }else{
                /* If it does not exist, feedback is provided to the root user */
                $(".single_product").children().remove();
                $(".main").children().remove();
                $(".single_product").append(
                    "<div id='removed'> This product has been removed!</div>"
                );
            }
        },
        error: ajaxFailed
    });
});

/* Function that retrieves comments for the product specified by the ID */
function findComments(){
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "findComments",
            "id": id,
        },
        success:function (response){
            let data = response;
            /* If there are no comments, it simply shows nothing */
            for(let i in data){
                /* Insert comments in the respective comment-boxes */
                $("#allComment").prepend(
                    "<div class='comment-box'>"+
                        "<div class='box-top'>"+
                            "<div class='profile'>"+
                                "<div class='profile_image'>"+
                                    "<i class='fa fa-minus' id='removeComment'></i>"+
                                "</div>"+
                                "<div class='Name'>"+
                                    "<strong id='username'>"+(data[i].username).toUpperCase()+"</strong>"+
                                    "<span id='email'>"+data[i].email+"</span>"+
                                    "<span id='date'>"+data[i].insert_date+"</span>"+
                                "</div>"+
                            "</div>"+
                        "</div>"+
                        "<div class='comment'>"+
                            "<p id='text'>"+data[i].text+"</p>"+
                        "</div>"+
                    "</div>"
                )
            };
        },
        complete: function(){
            /* Adds the event managers on minus icon */
            addOn();
        },
        error: ajaxFailed
    });
}

function addOn(){
    /* Add handlers on all minus icons */
    $("#allComment #removeComment").each(function(){
        $(this).click(function(e) {
            /* Go back to the DOM to retrieve the comment date and the username of the user who wrote it */
            let data=$(this).parent().parent().find("#date").html();
            let name=$(this).parent().parent().find("#username").html();
            /* Call the function that removes the referenced comment from date, username and product id */
            removeComment(data, name);
            /* Remove comment from view without refresh */
            $(this).parent().parent().parent().parent().remove();
        });
    });
}

/* Function that removes the comment from the reviews table */
function removeComment(date, name){
    $.ajax({
        url: "functions.php",
        type:"post",
        data: {
            "action": "removeComment",
            "data": date,
            "name": name,
            "id": id ,
        },
        success: function (response){
            if(response.substring(1,0)==="r"){
                /* Do nothing because the view is automatically updated */
            }else{ /* not removed */
                $("#allComment").prepend("<h2 id='impossible'> Updated view, but unable to remove comment </h2>");
                setTimeout(function (){
                    $("#impossible").remove();
                },3000);
            }
        },
        error: ajaxFailed
    });
}