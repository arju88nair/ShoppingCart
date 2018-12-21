/**
 * Where the products will be loaded
 */

$(document).ready(function () {
    $('.loading').show();
    fetch('getProducts')
        .then(
            function (response) {
                $('.loading').hide();

                if (response.status !== 200) {
                    console.log('Looks like there was a problem. Status Code: ' +
                        response.status);
                    return;
                }
                // Examine the text in the response
                response.json().then(function (data) {
                    let products = data.products;
                    if (products.length > 0) {
                        $.each(products, function (key, item) {
                            $("#productDiv").append("            <div class=\"col-md-4\">\n" +
                                "                <div class=\"product-item\">\n" +
                                "                    <div class=\"pi-img-wrapper\">\n" +
                                "                        <img src=" + item.image + " class=\"img-responsive\" alt=\"Berry Lace Dress\">\n" +
                                "                        <div>\n" +
                                "                            <a href=\"productDetail?id=" + item.id + "\" class=\"btn\">View</a>\n" +
                                "                        </div>\n" +
                                "                    </div>\n" +
                                "                    <h3><a href=\"shop-item.html\">" + item.name + "</a></h3>\n" +
                                "                    <div class=\"pi-price\">$" + item.price + ".00</div>\n" +
                                "                    <a href=\"javascript:addToCart(" + item.id + ");\" class=\"btn add2cart\">Add to cart</a>\n" +
                                "                    <div class=\"sticker sticker-new\"></div>\n" +
                                "                </div>\n" +
                                "            </div>\n")
                        });
                    }
                    console.log(data.products);

                });
            }
        )
        .catch(function (err) {
            console.log('Fetch Error :-S', err);
        });

});



