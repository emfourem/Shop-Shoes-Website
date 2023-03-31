/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to removeProduct.php page
 */
$(document).ready(function() {
    /* Retrieve the parameter passed through the URL */
    let params = new URLSearchParams(window.location.search);
    let name=params.get('product_name');
    /* Required to retrieve all items from the products table */
    $.ajax({
        url: "functions.php",
        type:"post",
        datatype:"json",
        data: {
            "action": "toRemove",
        },
        success: function (response) {
            let data = response;
            /* If there are no products a feedback is provided to the user */
            if (data.length === 0) {
                $('#row').append("<p> No product to remove <p>");
            } else {
                /*
                Recovered items are entered as options in the select
                If the initially recovered parameter is different from null, it is set as selected
                 */
                for (let i in data[0]) {
                    if(name===null){
                        $('#select').append(
                            "<option>" + data[0][i].product_name + ", " + data[0][i].id + "<option>"
                        );
                    }else {
                        if (data[0][i].product_name === name) {
                            $('#select').append(
                                "<option selected>" + data[0][i].product_name + ", " + data[0][i].id + "<option>"
                            );
                        } else {
                            $('#select').append(
                                "<option>" + data[0][i].product_name + ", " + data[0][i].id + "<option>"
                            );
                        }
                    }
                }
            }
        },
        complete: function (){
            /* Associate to the form that contains the select, correctly compiled by success function, the relative handler*/
            $("#myform").submit(function(e) {
                e.preventDefault();
                /* If the choice is not valid */
                if($("#myform").children().val()==="-1" || $("#myform").children().val()===null){
                    /*Do nothing*/
                    $(".section-title").append(
                        "<h4 id='information'> Choose a valid item!</h4>"
                    )
                    setTimeout(function () {
                        $(".section-title #information").remove();
                    }, 5000);
                } else {
                    /* If the choice is valid recovers the form data */
                    let form = $(this);
                    $.ajax({
                        url: "functions.php",
                        type: "post",
                        /* Serialize the data to send them */
                        data: form.serialize() + "&action=removeProduct",
                        success: function (response) {
                            /* Removes the selected for the removed item and provides feedback to the user in both cases*/
                            $("#select").prop('selectedIndex', 0);
                            if (response.substring(1, 0) === "r") { /*removed*/
                                /* Item removed correctly*/
                                $(".section-title").append(
                                    "<h4 id='information'> An item has been removed!</h4>"
                                )
                                setTimeout(function () {
                                    $(".section-title #information").remove();
                                }, 5000);
                            } else {
                                /* Item not removed */
                                $(".section-title").append(
                                    "<h4 id='information'> Impossible to remove the element!</h4>"
                                )
                                setTimeout(function () {
                                    $(".section-title #information").remove();
                                }, 5000);
                            }
                        }
                    });
                }
            });
        },
        error: ajaxFailed
    });
});