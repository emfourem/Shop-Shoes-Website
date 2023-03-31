/*
    Shop Shoes -> Tweb Project
    Merico Michele, matricola 945287
    Javascript file related to the product insertion page
 */
$(document).ready(function() {
    /* Attach the handler to the submit event to manage submission*/
    $("#insertForm").submit(function(e) {
        /* Retrieve all fields in the form */
        let form = $(this);
        e.preventDefault();
        /* Check the inputs */
        /* Recover the name of the uploaded photo */
        let x=document.getElementById("path").files[0]["name"];
        /* Recover the type of the uploaded file */
        let y=document.getElementById("path").files[0]["type"];
        /* Types of images allowed */
        let validImageTypes = ['image/jpg', 'image/jpeg', 'image/png'];
        let height = $(this).find("#height").val();
        let price = $(this).find("#price").val();
        let material = $('input[name=material]:checked').val();
        let field = $('input[name=field]:checked').val();
        let pattern = /^\d{1,2}[.]\d{1,2}$/;
        let pattern1 = /^\d{1,6}[.]\d{1,2}$/;
        let pattern2 = /^[A-Z][a-z]{3,9}\s?\w{0,5}$/;
        let pattern3 = /^[A-Z][a-z]{6,8}\s?\w{0,7}$/;
        let result = height.match(pattern);
        let result1 = price.match(pattern1);
        let result2 = field.match(pattern2);
        let result3 = material.match(pattern3);
        if(result != null && result1 != null && result2 != null && result3 != null && validImageTypes.includes(y)) {
            /*For security reasons absolute file paths cannot be retrieved,
             so assume the file is in the my_image folder.
             Insert the new product in the database*/
            $.ajax({
                url: "functions.php",
                type: "post",
                /* Serialize the form data to send them*/
                data: form.serialize() + "&action=insertProduct&photo=" + x,
                success: function (response) {
                    console.log(response);
                    /* Empty the form*/
                    $("#path").val('');
                    $("#height").val('');
                    $("#price").val('');
                    $('input[name=field]').prop('checked', false);
                    $('input[name=material]').prop('checked', false);
                    /* Based on the response provides feedback for 5 seconds to the user*/
                    if (response.substring(1, 0) === "i") { /*inserted*/
                        $(".product-price").append("<h1 id='addCorrectly'>Element has been added!</h1>");
                        $(".single_product").prepend("<h1 id='addCorrectly'>Element has been added!</h1>");
                        setTimeout(function () {
                            $("#addCorrectly").remove();
                            $("#addCorrectly").remove();
                        }, 5000);
                    } else if (response.substring(1, 0) === "a") { /* already present*/
                        $(".product-price").append("<h1 id='addCorrectly'>This element already exists!</h1>");
                        $(".single_product").prepend("<h1 id='addCorrectly'>This element already exists!</h1>");
                        setTimeout(function () {
                            $("#addCorrectly").remove();
                            $("#addCorrectly").remove();
                        }, 5000);
                    } else { /* error */
                        $(".product-price").append("<h1 id='addCorrectly'>Impossible to add the element!</h1>");
                        $(".single_product").prepend("<h1 id='addCorrectly'>Impossible to add the element!</h1>");
                        setTimeout(function () {
                            $("#addCorrectly").remove();
                            $("#addCorrectly").remove();
                        }, 5000);
                    }
                },
                error: ajaxFailed
            });
        }else{
            $(".single_product").prepend("<h1 id='addCorrectly'>The file is not an image. Security breach!</h1>");
            $(".product-price").append("<h1 id='addCorrectly'>The file is not an image. Security breach!</h1>");
            setTimeout(function () {
                window.location.href="../php/logout.php?error=true";
            }, 5000);
        }
    });
});