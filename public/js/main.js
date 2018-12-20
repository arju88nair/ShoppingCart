/**
 * Copyright (C) Covalense Technologies - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Nair, 20/12/18 11:41 PM
 */
/**
 * Method for adding/updating cart items
 * @param id
 */

function addToCart(id) {
    $('.loading').show();
    fetch('addToCart?id=' + id)
        .then(
            function (response) {
                $('.loading').hide();
                if (response.status !== 200) {
                    console.log(response);
                    console.log('Looks like there was a problem. Status Code: ' +
                        response.status);
                    toastr["error"]("Something went wrong");
                    return false;
                }
                // Examine the content in the response
                response.json().then(function (data) {
                    toastr["success"](data.message);
                    $("#addedButton").show();
                    $("#cartButton").hide();

                });
            }
        )
        .catch(function (err) {
            console.log('Fetch Error :-S', err);
        });

}
