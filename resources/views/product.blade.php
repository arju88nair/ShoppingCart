@include('partials.header')
<link href="{{ asset('css/details.css') }}" rel="stylesheet">
<script src="{{ asset('js/detail.js') }}" defer></script>

<main class="py-4">
    <div class="container">
        <div class="loading"></div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="container-fluid">
                        <div class="wrapper row">
                            <div class="preview col-md-6">
                                <div class="preview-pic tab-content">
                                    <div class="tab-pane active res" id="pic-1"><img class="img-responsive"
                                                                                     src={{$product['image']}} />
                                    </div>
                                </div>
                                <ul class="preview-thumbnail nav nav-tabs">
                                    <li class="active"><a data-target="#pic-1" data-toggle="tab"><img
                                                src={{$product['image']}}></a></li>
                                </ul>
                            </div>
                            <div class="details col-md-6">
                                <h3 class="product-title">{{$product['name']}}</h3>
                                <div class="rating">
                                    <div class="stars">
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star checked"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                    </div>
                                    <span class="review-no">41 reviews</span>
                                </div>
                                <p class="product-description">{{$product['details']}}</p>
                                <h4 class="price">current price: <span>${{$product['price']}}</span></h4>
                                <p class="vote"><strong>91%</strong> of buyers enjoyed this product! <strong>(87
                                        votes)</strong></p>
                                <br><br>
                                <div class="action">
                                    @if ($is_added === 0)
                                        <button class="add-to-cart btn btn-default" type="button" id="cartButton"
                                                onclick="addToCart({{$product['id']}})">Add to cart
                                        </button>
                                    @else
                                        <p id="addedButton">Already added in the cart</p>
                                        <button class="remove-from-cart btn btn-default" type="button" id="removeButton"
                                                onclick="removeItem({{$product['id']}})">Remove from cart
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

@include('partials.footer')
