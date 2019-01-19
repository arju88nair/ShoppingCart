/**
 * Written by Nair, 20/12/18 11:41 PM
 */


$(document).ready(function () {
    $(".loading").hide();
    $("button.btn.btn-secondary.redeem").click(function () {
        redemption();
    });
});


/**
 * Method for adding/updating cart items
 * @param id
 */

function addToCart(id) {
    dataCall("AddToCart", id);
}

/**
 * Removing item from cart
 * @param id
 */
function removeItem(id) {
    dataCall("RemoveItem", id);
}

/**
 * Common function for cart manipulation
 * @param url
 * @param id
 */

function dataCall(url, id) {
    var r = confirm("Are you sure you want to " + url.match(/[A-Z][a-z]+|[0-9]+/g).join(" "));
    if (r == true) {
        $('.loading').show();
        fetch(url + '?id=' + id)
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
                    else {
                        response.json().then(function (data) {
                            toastr["success"](data.message);
                            window.location.reload()
                        });
                    }
                }
            )
            .catch(function (err) {
                console.log('Fetch Error :-S', err);
            });
    }
}

/**
 * Redemption action
 */
function redemption() {
    let code = $("input.form-control.redemption-code").val();
    if (code) {
        $('.loading').show();
        fetch('checkCode?code=' + code)
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
                    else {
                        response.json().then(function (data) {
                            toastr["success"](data.message);
                            let total_amount=parseFloat($("#total-amount").text());
                            let discounted  = (total_amount - ( total_amount * data.percentage / 100 )).toFixed(2);
                            $("#total-amount").text(discounted)
                        });
                    }
                }
            )
            .catch(function (err) {
                console.log('Fetch Error :-S', err);
            });
    }
    else {
        console.log("Ddd")
        toastr["error"]("Please enter a coupon code");
    }

}


