@extends('frontend.layouts.app')
@section('content')
<section class="sliders">
<div class="container">	
<div class="row">	
<div class="col-md-9">	
<div id="slider1" class="owl-carousel owl-theme">
@foreach($sliders as $slider)	
<div class="item">
<a href="{{ $slider->link }}"> 
    <img src="{!! asset($slider->image) !!}" class="img-fluid mx-auto d-block" alt="{{ $slider->title }}">
</a>
</div>
@endforeach
</div>
</div>
<div class="col-md-3">	
<a href="{{ route('tradeshows') }}"><img src="{!! asset('assets/frontend/images/tradeshow.png') !!}" class="img-fluid mgn25" alt=""></a>
<a href="{{ route('e-catalogs') }}"><img src="{!! asset('assets/frontend/images/e-cats.png') !!}" class="img-fluid" alt=""></a>
</div>
</div>
</div>
</section>
<div id="add-cart"></div>
<div id="add-cart_full"></div>
<section class="new_products">
<div class="container">		
<h2>New Products</h2>
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
</div>
</section>

<section class="categories">
<div class="container">		
<h2>Product Categories</h2>
<div class="clearfix"></div>
<div class="row">	
@foreach($categories as $category)	
<div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
<div class="ps-block--category">	
<a href="{{ route('categoryDetail', $category->url) }}"><img src="{!! asset($category->image) !!}" class="img-fluid mx-auto d-block" alt="{{ $category->name }}"></a>
<h3><a href="{{ route('categoryDetail', $category->url) }}">{{ $category->name }}</a></h3>
</div>
</div>
@endforeach
</div>
</div>
</section>

<section class="new_products">
<div class="container">		
<h2>Top Trending Products</h2>
<a href="{{ route('top-trending-products') }}" class="view_all">View All</a>
<div class="clearfix"></div>
<div id="trending_products" class="owl-carousel owl-theme">
@foreach($trending_products as $new_product)	
<div class="row item">
<div class="col-md-12">
@if($new_product->regular_price > $new_product->offer_price)<h6>{{ round(100-($new_product->offer_price/$new_product->regular_price)*100) }}%</h6>@endif
<a href="{{ route('productDetail', $new_product->url) }}"><img src="{!! asset($new_product->thumbnail) !!}" class="img-fluid mx-auto d-block" alt="{{ $new_product->name }}"></a>
<p>@if($new_product->regular_price > $new_product->offer_price) <del>${{ $new_product->regular_price }}</del> @endif ${{ $new_product->offer_price }}</p>
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
</div>
</section>

<section class="download-app">
    <div class="container">
        <div class="ps-download-app">
            <div class="ps-container">
                <div class="ps-block--download-app">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <div class="ps-block__thumbnail" style="margin-top: 30px;"><img src="{!! asset('assets/frontend/images/Untitled-1.png') !!}" alt=""></div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 ">
                                <div class="ps-block__content" style="margin-top:100px;">
                                    <p>Shopping fastly and easily more with our app. Get a link to download the app on your phone</p>
                                    <form class="ps-form--download-app" id="mysubscribe">
                                        <div class="form-group--nest">
                                            <div id="already_subs" style="color: #f00;width: 100%; position: absolute; bottom: -25px;"></div>
                                            <div id="email_subs" style="color: #008000;width: 100%; position: absolute; bottom: -25px;"></div>
                                            <input class="form-control" name="subscribe" type="Email" placeholder="Email Address">
                                            <div id="valid_email" style="color: #f00; width: 100%; position: absolute; bottom: -25px;"></div>
                                            <button class="ps-btn ajax_subscribe">Subscribe</button>
                                        </div>
                                    </form>
                                    <p class="download-link"><a href="#"><img src="{!! asset('assets/frontend/images/google-play.png') !!}" alt=""></a><a href="#"><img src="{!! asset('assets/frontend/images/app-store.png') !!}" alt=""></a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="quality">
	<div class="container">
    <div class="ps-site-features">
        <div class="ps-container">
            <div class="ps-block--site-features">
                <div class="ps-block__item">
                    <div class="ps-block__left"><i class="fa-solid fa-rocket"></i></div>
                    <div class="ps-block__right">
                        <h4>Free Delivery</h4>
                        <p>For all oders over $99</p>
                    </div>
                </div>
                <div class="ps-block__item">
                    <div class="ps-block__left"><i class="fa-solid fa-arrows-rotate"></i></div>
                    <div class="ps-block__right">
                        <h4>90 Days Return</h4>
                        <p>If goods have problems</p>
                    </div>
                </div>
                <div class="ps-block__item">
                    <div class="ps-block__left"><i class="fa-solid fa-credit-card"></i></div>
                    <div class="ps-block__right">
                        <h4>Secure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                </div>
                <div class="ps-block__item">
                    <div class="ps-block__left"><i class="fa-solid fa-comment-dots"></i></div>
                    <div class="ps-block__right">
                        <h4>24/7 Support</h4>
                        <p>Dedicated support</p>
                    </div>
                </div>
                <div class="ps-block__item">
                    <div class="ps-block__left"><i class="fa-solid fa-gift"></i></div>
                    <div class="ps-block__right">
                        <h4>Gift Service</h4>
                        <p>Support gift service</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>


 <div class="modal modal-video fade suc_pop" id="modalcnfrm_ac" tabindex="-1" role="dialog">
  <div class="modal-dialog otp-screen" role="document">
      <div class="modal-content" style="margin-top: 90px;">
        <div class="modal-header">
          <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
         <div class="row">
          <div class="col-md-12">
            <p class="suc_mg" style="text-align: center; font-weight:600; font-size: 20px; color: #0D7C55;">Congratulations...!!!</p>
          </div>
          </div>
          <div class="row">
            <div class="col-md-12">
               <p style="text-align:center; font-size: 16px; color: #888;"> Your account is active now</p>          
            </div>
            <div class="col-md-12">
              <br>
              <p class="suc_mg" style="text-align: center; font-weight:600; font-size: 16px; color: #0D7C55;padding-top: 0px !important;">Follow Us</p>
              <ul class="pop_social">
                  <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
              </ul>
            </div>
          
          </div>
        
        </div>
    </div>
  </div>
</div>


@endsection