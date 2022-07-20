@extends('frontend.layouts.app')
@section('content')
<div id="add-cart"></div>
<div id="add-cart_full"></div>
<section class="bredcrum">
  <div class="container">
    <ul>
      <li><a href="{{ route('home') }}">Home</a></li>
      <li>&nbsp;/ &nbsp;<a href="{{ route('categoryDetail', $product->cat_url) }}">{{ $product->category }}</a></li>
      @if($product->cat2)
      <li>&nbsp;/ &nbsp;<a href="{{ route('categoryDetail', $product->url2) }}">{{ $product->cat2 }}</a></li>
      @endif
      @if($product->cat3)
      <li>&nbsp;/ &nbsp;<a href="{{ route('categoryDetail', $product->url3) }}">{{ $product->cat3 }}</a></li>
      @endif
      @if($product->cat4)
      <li>&nbsp;/ &nbsp;<a href="{{ route('categoryDetail', $product->url4) }}">{{ $product->cat4 }}</a></li>
      @endif
      @if($product->cat5)
      <li>&nbsp;/ &nbsp;<a href="{{ route('categoryDetail', $product->url5) }}">{{ $product->cat5 }}</a></li>
      @endif
      <li>&nbsp;/ &nbsp;{{ $product->name }}</li>
    </ul>
  </div>
</section>

  <div class="clearfix"></div>
  <!-- DETAILS-MAIN STRATS -->
    <section class="details-main">
      <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-2 d-md-block d-none">
                <aside>
            <div class="accordion" id="accordionExample">        
              <div class="card" style="margin-top: 50px;">
                <div class="card-header" id="headingOne1">
                  <h5>Categories</h5>
                </div>
                  <div class="card-body">
                    <ul id="selective" style="padding: 0px; list-style: none;">
                       @if($Categorys)
        @php $ci = 0;   @endphp
        @foreach($Categorys as $category)
         @php $ci++;   @endphp
           <li><a href="{{ route('categoryDetail', $category->url) }}">{{ $category->name}}</a></li>
          @endforeach
        @endif
                </ul>
                  </div>
              </div>
              </div>
            </aside>
                
       
            </div>
            <div class="col-lg-10 col-md-10" id="category-list">
        <div class="row">
          <div class="col-lg-4">
            <div class="row">
              <!--<div class="col-lg-2" style="padding-right: 0px;">  
                <img class="img-fluid mx-auto d-block" src="{!! asset($product->featured_image) !!}" alt="">
              </div>-->
              
              @if(count($gallery_imgs) > 0)
              <div class="row">
                  <div class="col-md-3">
                <div id="featured-slide1">
                <ul id="gal1" class="pl-0 mb-0">
                <a class="big-img" href="{!! asset($product->featured_image) !!}">
                  <li class="bbbb my-2">
                    <a href="#" data-image="{!! asset($product->featured_image) !!}" data-zoom-image="{!! asset($product->featured_image) !!}">
                    <img id="img_01" src="{!! asset($product->featured_image) !!}" alt="" onerror="this.src='https://dentclues.com/img/not-found.png';">
                    </a>
                  </li>
                </a>
                  @if(isset($gallery_imgs))
                  @foreach($gallery_imgs as $gallery_img)
                  <li class="bbbb my-2">
                  <a href="#" data-image="{!! asset($gallery_img->product_image) !!}" data-zoom-image="{!! asset($gallery_img->product_image) !!}">
                  <img id="img_01" src="{!! asset($gallery_img->product_image) !!}" onerror="this.src='https://dentclues.com/img/not-found.png';">
                  </a>
                  </li>
                  @endforeach
                  @endif
                </ul>
              </div>
              </div>
              <div class="col-md-9">
              <div class="main-prod prod-img">
                    <span id="img_ft_zoom">
                    <img class="mn-img img-fluid mx-auto d-block" src="{!! asset($product->featured_image) !!}" alt="" onerror="this.src='https://dentclues.com/img/not-found.png';">
                    </span>
                </div>
                </div>
                </div>
            @else  
         
                <div class="main-prod prod-img">
                    <span id="img_ft_zoom">
                    <img class="mn-img img-fluid mx-auto d-block" src="{!! asset($product->featured_image) !!}" alt="" onerror="this.src='https://dentclues.com/img/not-found.png';">
                    </span>
                </div>
            @endif 
            </div>
          </div>
          <div class="col-lg-5">
                <div class="details-heading">
                  <h2 class="product-name">{{ $product->name }} </h2>
                  <div class="price_box">
                   @if($case_deal_price == 0) 
                   <p id="selected_product_price">@if($product->regular_price > $product->offer_price)<del><i class="fa fa-dollar"></i>{{ $product->regular_price }}</del>@endif <i class="fa fa-dollar"></i>{{ $product->offer_price }}</p>
                   @else
                   <p id="selected_product_price"><i class="fa fa-dollar"></i>{{ $product->offer_price - $case_deal_price }}</p>
                   @endif
                  </div>
                  <div class="short_description"> 
                    <!--<h6><b style="font-weight: 600; font-size: 14px;">SOLD BY: PUKA CREATIONS</b></h6> -->
                    {!! $product->description !!}
                  </div>
                  @if($case_deal->count() != 0)
                  <div class="bulk-product-offers">
                    <h4>Case Deals</h4>
                    <table>
                    <tr>
                      <td>Min Buy</td>
                      <td>Max Buy</td>
                      <td>Offer</td>
                    </tr>
                    @foreach($case_deal as $deal)
                    <tr>
                      <td>{{ $deal->quantity }} nos.</td>
                      <td>{{ $deal->max_quantity }} nos.</td>
                      <td>{{ $deal->discount }}% Discount</td>
                    </tr>
                    @endforeach
                   </table>
                  </div>
                  @endif
                  <div class="add-to-cart">
                    @if($product->quantity != 0)
                    <button onclick="addToCart(this.value)" value="{{ $product->id }}" class="btn">Add to Cart</button>
                    <a class="btn phn-margin-top" href="{{ route('buy-now', $product->id) }}">Buy Now</a>
                      @if(Auth::id()) 
                      @php get_wishlist($product->id) @endphp
                        @if(empty(get_wishlist($product->id)))
                          <a href="{{ route('addWishlist', $product->id) }}" title="Add To Wishlist" class="wish-btn"><i class="fa fa-heart-o" aria-hidden="true"></i></a>
                        @else
                          <a href="{{ route('deleteWishlist', $product->id)}}" title="Remove From Wishlist" class="wish-btn"><i class="fa fa-heart" aria-hidden="true"></i></a>
                      @endif
                      @endif
                    @else
                    <button value="{{ $product->id }}" onclick="notifyme(this.value)" class="btn">Out Of Stock</button>
                    @endif
                  </div>
                  <div class="clearfix"></div>
                  <div class="sku-details">
                  <p>SKU: {{ $product->sku }}</p>
                  @if($product->srp)
                  <p>SRP: <i class="fa fa-dollar"></i>{{ $product->srp }}</p>
                  @endif 
                  <p>Categories: <a href="{{ route('categoryDetail', $product->cat_url) }}">{{ $product->category }}</a>
                  @if($product->cat2)
                  , <a href="{{ route('categoryDetail', $product->url2) }}">{{ $product->cat2 }}</a>
                  @endif
                  @if($product->cat3)
                  , <a href="{{ route('categoryDetail', $product->url3) }}">{{ $product->cat3 }}</a>
                  @endif
                  @if($product->cat4)
                  , <a href="{{ route('categoryDetail', $product->url4) }}">{{ $product->cat4 }}</a>
                  @endif
                  @if($product->cat5)
                  , <a href="{{ route('categoryDetail', $product->url5) }}">{{ $product->cat5 }}</a>
                  @endif
                  </p>
                  <ul class="socl-share">
                    <li><a class="fb" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('productDetail', $product->url) }}"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="tw" target="_blank" href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ route('productDetail', $product->url) }}"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="gp" target="_blank" href="https://wa.me/?text={{ route('productDetail', $product->url) }}" class="social-button " id=""><span class="fa fa-whatsapp" style="background-color: #42E45F !important;"></span></a></li>
                  </ul>
                  </div>
              </div>
           </div>
           <div class="col-lg-3">
              <div class="ps-page__right">
                    <aside class="widget widget_product widget_features">
                      <p><i class="fa-solid fa-credit-card"></i> Credit Card (We will not activate live charge)</p>
                      <p><i class="fa-solid fa-globe"></i> Shipping worldwide</p>
                      <p><i class="fa-solid fa-arrows-spin"></i> Terms as Approved</p>
                      <p><i class="fa-brands fa-paypal"></i> PayPal (coming soon)</p>
                      <p><i class="fa-solid fa-bitcoin-sign"></i> BitCoin (coming soon)</p>
                       
                      <!--   
                        <p><i class="fa-solid fa-file-invoice-dollar"></i> Supplier give bills for this product.</p>
                         -->
                    </aside>
                </div>
           </div>
        </div>
         <section class="description_detail">

        <h4>Description</h4>
        {!! $product->product_description !!}

  </section>
  @if($InstructionVideo)
  <section class="InstructionVideo">

        <h4>{{ $InstructionVideo->name }}</h4>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $InstructionVideo->iframe_code }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
   
  </section>
  @endif
  
  <section class="new_products">
<h2>Related Products</h2>
<div class="clearfix"></div>
<div id="new_products" class="owl-carousel owl-theme">
@foreach($new_products as $new_product)	
<div class="row item">
<div class="col-md-12">
@if($new_product->regular_price > $new_product->offer_price)<h6>{{ round(100-($new_product->offer_price/$new_product->regular_price)*100) }}%</h6>@endif
<a href="{{ route('productDetail', $new_product->url) }}"><img src="{!! asset($new_product->thumbnail) !!}" class="img-fluid mx-auto d-block" alt="{{ $new_product->name }}"></a>
<p>@if($new_product->regular_price > $new_product->offer_price)<del>${{ $new_product->regular_price }}</del> @endif ${{ $new_product->offer_price }} </p>
<h3><a href="{{ route('productDetail', $new_product->url) }}">{{ $new_product->name }}</a></h3>
<div class="add_box">   
<select class="qty{{$new_product->id}}">
    <option value="1">Qty</option>
    <option value="1">1</option>
    <option value="2">2</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
</select>
<button onclick="addToCart(this.value)" value="{{ $new_product->id }}" class="btn">Add to Cart</button>
</div>
</div>
</div>
@endforeach
</div>
</section>
  
      </div>
      </div>
      </div>
  </section>
 

  <!-- INDEX-MAIN ENDS -->

  <div class="clearfix"></div>
 
@endsection
