<div id="" class="modal fade quickviews in quickviews-modal-product-details-{{$product->id}}" tabindex="-1" role="dialog" style="display: hidden;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  data-product-id="{{$product->id}}" data-dismiss="modal" aria-label="Close"><i class="material-icons close">close</i></button>
            </div>
            <div class="modal-body">
                <div class="row no-gutters">
                    <div class="col-md-5 col-sm-5 divide-right">
                        <div class="images-container bottom_thumb">
                            <div class="product-cover">
                                <img class="js-qv-product-cover img-fluid" src="{{asset('assets/images/products/' . $product->images[0]->photo) ?? ''}}" style="width:100%;" itemprop="image">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-7">
                        <h1 class="product-name">{{$product ->  name}}</h1>

                        <div class="product-prices">
                            <div class="product-price " itemprop="offers" itemscope="" itemtype="https://schema.org/Offer">
                                <div class="current-price">
                                     <span itemprop="price"
                                           class="price">{{$product -> special_price ?? $product -> price }}</span>
                                    @if($product -> special_price)
                                    <span
                                        class="regular-price">{{$product -> price}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="tax-shipping-delivery-label">
                                Tax included
                            </div>
                        </div>

                        <div id="product-description-short" itemprop="description"><span> {{ $product -> description }}</span></div>
                        <div class="product-actions">
                            <form action="" method="post" id="add-to-cart-or-refresh">
                                @csrf
                                <input type="hidden" name="id_product" value="{{$product -> id }}" id="product_page_product_id">
                                <div class="product-add-to-cart in_border">
                                    <div class="add">
                                        <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit">
                                            <div class="icon-cart">
                                                <i class="shopping-cart"></i>
                                            </div>
                                            <span>Add to cart</span>
                                        </button>
                                    </div>

                                    <a class="addToWishlist wishlistProd_6" href="#" data-rel="6"
                                       data-product-id="{{$product -> id}}">
                                        <i class="fa fa-heart"></i>
                                        <span>Add to Wishlist</span>
                                    </a>


                                    <div class="clearfix"></div>

                                    <div id="product-availability" class="info-stock mt-20">
                                        <label class="control-label">Availability:</label>
                                        {{$product -> in_stock ? 'in stock' : 'out of stock'}}
                                    </div>
                                    <p class="product-minimal-quantity mt-20">
                                    </p>
                                </div>

                            </form>
                        </div>

                        <div class="tabs">

                            <div class="seller_info">

                                <div class="average_rating">
                                    <a href="http://demo.bestprestashoptheme.com/savemart/en/jmarketplace/2_taylor-jonson/comments" title="View comments about Taylor Jonson">
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        <div class="star"></div>
                                        (0)
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
