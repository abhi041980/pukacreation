@extends('frontend.layouts.app')
@section('content')
@php
    $route  = \Route::currentRouteName();    
@endphp
@php
$offer_id = null;

@endphp

@php
  $sale_price = 0;
  $list_price = 0;
  $case_deal_price = 0;
  $tax = 0;
  $discount = 0;
  $stich_price = 0;
  $offer_based = \Session::get('offer_based');
  if($offer_based){
  $discount_type = \Session::get('discount_type');
  $off_percentage = \Session::get('off_percentage');
  $off_amount = \Session::get('off_amount');
  $min_amount = \Session::get('min_amount');
  $max_discount = \Session::get('max_discount');
  $sub_product = \Session::get('sub_product');
  $product_id = \Session::get('product_id');
  $offer_id = \Session::get('offer_id');

    if($offer_based == 'brand' || $offer_based == 'category'){
             $name = \Session::get('name'); @endphp
            <div class="alert alert-info" role="alert">
            @php 
            echo 'You get '; 
            if($discount_type == 'Price'){
                echo 'Rs. '.$off_amount.' off in minimum amount Rs.'.$min_amount.' ';
            }
            if($discount_type == 'Percentage'){
                echo ''.$off_percentage.'% off in minimum amount Rs.'.$min_amount.' and max discount is Rs. '.$max_discount.'';
            }
              echo ' on all '.$name.' products';
            @endphp
          </div>
            @php 
            }

             if($offer_based == 'product'){
             $name = \Session::get('name'); @endphp
          <div class="alert alert-info" role="alert">
            @php 
            echo 'You get '; 
            if($discount_type == 'Price'){
                echo 'Rs. '.$off_amount.' off in minimum amount Rs.'.$min_amount.' and max discount is Rs. '.$max_discount.'';
            }
            if($discount_type == 'Percentage'){
                echo ''.$off_percentage.'% off in minimum amount Rs.'.$min_amount.' and max discount is Rs. '.$max_discount.'';
            }
              echo ' in '.$name.'';

            @endphp
          </div>
            @php 
            }
             if($offer_based == 'get_one'){
             $name = \Session::get('name'); 
             $sub_name = \Session::get('sub_name');
             @endphp
          <div class="alert alert-info" role="alert">
            @php 
            echo 'Buy <b>'.$name.'</b> and get one free <b>'.$sub_name.'</b>'; 
            @endphp
          </div>
            @php 
            }

            if($offer_based == 'category'){
            $cat_id = \Session::get('cat_id');
             $discount += get_cat_discount($offer_id);
            if(get_cat_minimum($offer_id)<$min_amount) {
             $discount = 0;
            } else {
             if($discount>$max_discount){
             $discount = $max_discount;
           }
          }
            }  

          if($offer_based == 'brand'){
            $cat_id = \Session::get('brand_id');
             $discount += get_brand_discount($offer_id);
            if(get_brand_minimum($offer_id)<$min_amount) {
             $discount = 0;
            } else {
             if($discount>$max_discount){
             $discount = $max_discount;
           }
           }
          } 
          if($offer_based == 'Price'){
            $discount += $off_amount;
            if(get_price_minimum($offer_id)<$min_amount) {
             $discount = 0;
            } 
          }

          if($offer_based == 'Percentage'){
             $discount += get_percentage_discount($offer_id);
            if(get_price_minimum($offer_id)<$min_amount) {
             $discount = 0;
            } else {
             if($discount>$max_discount){
             $discount = $max_discount;
           }
           }
          } 

          if($offer_based == 'product'){
            $cat_id = \Session::get('brand_id');
             $discount += get_product_discount($offer_id);

            if(get_product_minimum($offer_id)<$min_amount) {
             $discount = 0;
            } else {
             if($discount>$max_discount){
             $discount = $max_discount;
           }
           }
          }
           }
            @endphp

            

<div class="clearfix"></div>
 <section class="bredcrum">
    <div class="container">
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li>&nbsp;/&nbsp;<a href="{{ route('cartDetail') }}">Cart</a></li>
        <li>&nbsp;/&nbsp;<a href="{{ route('manage-address') }}">Address</a></li>
        <li>&nbsp;/&nbsp;Checkout</li>
      </ul>
    </div>
  </section>

  <section class="checkout-page">
     <div class="container">
      <h3>Review Your Order</h3>
        <div class="row">
          <div class="col-md-6">
            <div class="row" id="dform">
              @if(isset($user_address->name))
              <div class="col-md-12">
                <div class="user_addresse_box">
                <input type="radio" name="address" checked=""  value="{{ $user_address->id }}" class="chk_address">
                <h6 style="text-transform: uppercase; font-size: 20px;"> {{ $user_address->name }} </h6>
                <p style="font-size: 16px; font-weight: 400;"> {{ $user_address->address }}, {{ $user_address->city }}, 
                  {{ $user_address->state }} - {{ $user_address->pincode }} <br><span style="font-size: 17px; float: left; margin-top: 7px;"> PHONE: {{ $user_address->mobile }} </span> </p>
                <p style="position: absolute; top: 10px; right: 15px; font-size: 16px;">Shipping address <a class="address_edit" style="position: static; color: #D03B3D;" href="{{ route('manage-address')}}">Change</a>
              </div>
              </div>
              @endif
            </div>

              @if(isset($cart_products)) 
              @foreach($cart_products as $cart_product)
              @if(isset($cart_product->offer_price))
              @php

              $s_price = $cart_product->offer_price;
              $sale_price += $s_price*$cart_product->quantity;
              $list_price += $cart_product->regular_price*$cart_product->quantity; 

              $cd_price = cart_case_deal_price_discount($cart_product->c_id, $cart_product->offer_price);
              $case_deal_price += $cd_price*$cart_product->quantity;

             @endphp   

              <div class="product">
                <div class="row">
                  <div class="col-md-2">
                    <div class="prod-img">
                      <img src="{!! asset($cart_product->thumbnail) !!}" class="img-fluid d-block" alt="">
                    </div>
                  </div>
                  <div class="col-md-10">
                    <h6>{{ $cart_product->name }}</h6>
                    <p style="margin-bottom: 0px;"><i class="fa fa-dollar"></i>{{ $s_price - $cd_price }}</p>
                    <p>Quantity: {{ $cart_product->quantity }}</p>
                  </div>
                </div>
              </div>
            @endif
            @endforeach
            @endif

        </div>


          <div class="col-md-5 offset-md-1">
          <div style="box-shadow: 1px 1px 10px rgba(0,0,0,0.3);padding: 30px; padding-bottom: 10px; background: #f1f1f1;">
          <h5 style="text-transform: uppercase; font-weight: 500; margin-bottom: 15px; color: #5B5B5B; font-size: 20px;">Order Summary</h5>          
          <div class="total-box">
@php
  $total_pay_amount =  +$sale_price-$discount;
  $discount = (int)$discount;
  $sale_price = (int)$sale_price;
  $total_pay_amout = (int)$total_pay_amount; @endphp
            @if($sale_price != 0)
              <div class="total_c" style="border: 0px; padding: 0px; margin-bottom: 0px;">
              <p>Item(s) Price <span id="total_list_price"> <i class="fa fa-dollar"></i>{{ $list_price }}</span></p>
              <!-- <p>Discount <span id="discount"> <i class="fa fa-dollar"></i>{{ $discount + $case_deal_price + $list_price - $sale_price }}</span></p> -->
              <p style="border-bottom: 1px solid #d6d6d6; padding-bottom: 15px;">Subtotal <span id="total_sale_price_cart"> <i class="fa fa-dollar"></i>{{ $sale_price - $case_deal_price - $discount }}</span></p>
              <p style="font-size: 20px; font-weight: 600; color: #000; padding-top: 3px;">Total <span id="total_sale_price_cart1" style="color: #be0027;"> <i class="fa fa-dollar"></i>{{ $sale_price - $case_deal_price - $discount }}</span></p>
              </div>
            @endif
              </div>  
              </div>

            <div style="box-shadow: 1px 1px 10px rgba(0,0,0,0.3);padding: 30px; padding-bottom: 10px; background: #fbfbfb; margin-top: 30px;">

              <label class="payment_method_offline_cc">Credit Card <img src="{!! asset('assets/frontend/images/cards-visa-mc-discover-amex.png') !!}"></label>
              <p>Pay with your credit card.</p>

              <form action="{!! route('checkoutnew') !!}" method="post">
              <input type="hidden" name="address" id ="addValues" value="{{ $user_address->id }}" checked="true">
              <input type="hidden" name="bill_address" id ="addValues2" value="1">
              {{ csrf_field() }}
              
              <div class="row">
                <div class="col-md-6">
                  <label>Card number<span>*</span></label>  
                  <input type="number" name="card_no" required="true" style="margin-bottom: 15px;    box-shadow: inset 2px 0 0 #0f834d; color: #43454b; background: #f2f2f2; border: 0px; height: 40px; padding-left: 10px;">
                </div>
                <div class="col-md-6">
                  <label>Card holder<span>*</span></label>  
                  <input type="text" name="card_holder" required="true" style="margin-bottom: 15px;    box-shadow: inset 2px 0 0 #0f834d; color: #43454b; background: #f2f2f2; border: 0px; height: 40px; padding-left: 10px;">
                </div>
                <div class="col-md-6">
                  <label>Card type<span>*</span></label>  
                  <select name="card_type" required="true" style="margin-bottom: 15px;">
                      <option value="">-- Select card type --</option>
                      <option value="Credit card">Credit card</option>
                      <option value="Debit card">Debit card</option>
                  </select>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <label>Expiration date<span>*</span></label>  
                  <select name="expiration_month" required="true">
                      <option value="">Month</option>
                      <option value="January">January</option>
                      <option value="February">February</option>
                      <option value="March">March</option>
                      <option value="April">April</option>
                      <option value="May">May</option>
                      <option value="June">June</option>
                      <option value="July">July</option>
                      <option value="August">August</option>
                      <option value="September">September</option>
                      <option value="October">October</option>
                      <option value="November">November</option>
                      <option value="December">December</option>
                  </select>
                  <select name="expiration_year" required="true">
                      <option value="">Year</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                      <option value="2026">2026</option>
                      <option value="2027">2027</option>
                      <option value="2028">2028</option>
                      <option value="2029">2029</option>
                      <option value="2030">2030</option>
                      <option value="2031">2031</option>
                      <option value="2032">2032</option>
                      <option value="2033">2033</option>
                      <option value="2034">2034</option>
                      <option value="2035">2035</option>
                      <option value="2036">2036</option>
                      <option value="2037">2037</option>
                  </select>
                </div>
               
                <div class="col-md-6">
                  <label>Card security code<span>*</span></label>  
                  <input type="number" name="card_security_code" maxlength="4" required="true" style="    box-shadow: inset 2px 0 0 #0f834d; color: #43454b; background: #f2f2f2; border: 0px; width: 70px;height: 40px; padding-left: 10px;">
                </div>
                <div class="col-md-12">
                  <p style="margin-bottom: 0px; margin-top: 20px;"><input type="checkbox" required="true" value="1" name="terms_and_conditions" style="width: 16px; height: 16px; float: left;
    margin-top: 5px; margin-right: 10px;">I have read and agree to the website <a href="{{ route('terms-and-conditions') }}" target="_blank" style="color: #00f;">terms and conditions</a></p>
                </div>
                <div class="col-md-12 text-center">
                  <button type="submit">Place Order</button>
                </div>
              </div>
              </form>
              @if(\Auth::user()->premium == 1)
              <form action="{!! route('pay-later') !!}" method="post" style="text-align:center;">
              <input type="hidden" name="address" id ="addValues" value="{{ $user_address->id }}" checked="true">
              <input type="hidden" name="bill_address" id ="addValues2" value="1">
              {{ csrf_field() }}
              <button type="submit" style="margin-top:0px;">Place Order and Pay Later</button>
              </form>
              @endif
            </div>
    
            </div>
             
          </div>
        </div>
        </div>
     </div>
  </section>

  
  @endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){ 
    $("#dform input" ).change(function() {
    var val_ad = $("input[name=address]:checked", "#dform").val();  
    
    $("#addValues").val(val_ad); 
 
   });
});

$(document).ready(function(){ 
    $("#dform1 input" ).change(function() {
    var val_ad = $("input[name=billing_address]:checked", "#dform1").val();  
    
    $("#addValues1").val(val_ad); 
 
   });
});



function HideBilling(val) {

  $('.billing_ad').show();
  $('#add-address').hide();
  $('#add-address123').hide(); 
  $("#addValues2").val(0); 
   smoothScrollTo('.billing_ad', 1500, 100);
}

function HideBilling1(val) {

   $('.billing_ad').show();
   smoothScrollTo('.billing_ad', 1500, 100);

}

</script>


@if(session()->has('create_address_bil'))
<script type="text/javascript">
 $('.billing_ad').show();
   smoothScrollTo('.billing_ad', 1500, 100);
</script>
@endif
