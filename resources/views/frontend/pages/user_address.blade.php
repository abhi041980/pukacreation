@extends('frontend.layouts.app')
@section('content')  
@php
    $route  = \Route::currentRouteName();    
@endphp

<div id="add-cart"></div>

<section class="bredcrum">
    <div class="container">
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li>&nbsp;/&nbsp;<a href="{{ route('cartDetail') }}">Cart</a></li>
        <li>&nbsp;/&nbsp;Shipping Address</li>
      </ul>
    </div>
  </section>
@if($user_addresses_count != 0)
<section class="shipping-page" style="padding-top: 0px;">
  <div class="container">
    <form action="{{ route('delivery-address') }}" method="post">
      {{ csrf_field() }}
    <div class="row">  
      <div class="col-md-10 offset-md-1">
        <div class="checkout-page manage-address-main">
          <h2>Delivery Confirmation</h2>
          <div class="delivery_line"></div>
          <div class="clearfix"></div>
          <div class="row">
              @php $i = 0;  @endphp
              @foreach($user_addresses as $user_address)
              @php $i++;  @endphp
              @if(isset($user_address->name))
              <div class="col-md-4">
                <div class="user_addresse_box">
                  <a href="{{ route('default_address', $user_address->id) }}" title="Make Default Address">
                @if($df_address)
                <input type="radio" name="address" @if($df_address->address_id == $user_address->id) checked=""  @endif value="{{ $user_address->id }}" class="chk_address">
                @else
                 <input type="radio" name="address" @if($i == 1) checked=""  @endif value="{{ $user_address->id }}" class="chk_address">
                @endif
                <h6> {{ $user_address->name }} </h6>
                <p> {{ $user_address->address }}, {{ $user_address->city }}, 
                  {{ $user_address->state }} - {{ $user_address->pincode }} <br> Phone: {{ $user_address->mobile }} </p>
                </a>
                <a class="address_del" href="{{ route('delAddress', $user_address->id) }}"><i class="fa fa-trash"></i></a>
             
                <a class="address_edit" href="{{ route('user-address.edit', $user_address->id)}}">Edit</a>
              </div>
              </div>
              @endif
              @endforeach
              </div> 
          <div class="clearfix"></div>
          @if($cart)
          <button type="submit" class="deliver_address">Deliver to the address</button>
          @endif
     
        </div>
      </div>
    </div>
  </form>
  </div>
</section>
@endif

  <div class="clearfix"></div>

    @if($route == 'user-address.edit')
    <section class="aad-address-main">
      <div class="container">
        <div class="row">  
          <div class="col-md-10 offset-md-1">
            <div class="form">
              <div style="position: relative;">
              <h2>Edit Shipping Address</h2>
              <div class="delivery_line"></div>
              <div class="clearfix"></div>
              <form action="{{ route('save-address.update')}}" method="post">
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" name="name" placeholder="Name" value="{{ $result->name }}" maxlength="40" onKeyPress="return ValidateAlpha(event);" class="form-control" required="true">
                    @if($errors->has('name'))
                      <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="company_name" maxlength="100" value="{{ $result->company_name }}" placeholder="Company name (optional)" class="form-control">
                    @if($errors->has('company_name'))
                      <span class="text-danger">{{$errors->first('company_name')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="country" required="true">
                      <option value="">Select Country*</option>
                      @foreach($countries as $country)
                      <option value="{{ $country->id }}" @if($result->country == $country->id) selected @endif>{{ $country->name }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('country'))
                      <span class="text-danger">{{$errors->first('country')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="state" placeholder="State" value="{{ $result->state }}" class="form-control" required="true"> 
                    @if($errors->has('state'))
                      <span class="text-danger">{{$errors->first('state')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="city" placeholder="City" value="{{ $result->city }}" class="form-control" required="true"> 
                    @if($errors->has('state'))
                      <span class="text-danger">{{$errors->first('state')}}</span>
                    @endif
                  </div> 
                  <div class="col-md-6">
                   <input type="text" name="pincode" maxlength="6" placeholder="Pincode" value="{{ $result->pincode }}" class="form-control" required="true"> 
                    @if($errors->has('pincode'))
                      <span class="text-danger">{{$errors->first('pincode')}}</span>
                    @endif
                  </div>
                   <div class="col-md-6">
                    <input type="text" value="{{ $result->address }}" placeholder="Address" class="form-control" required="true" name="address">
                    @if($errors->has('address'))
                      <span class="text-danger">{{$errors->first('address')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="mobile" placeholder="Mobile" value="{{ $result->mobile }}" onkeypress="return isNumberKey(event)" maxlength="10" minlength="10" class="form-control" required="true">
                    @if($errors->has('mobile'))
                      <span class="text-danger">{{$errors->first('mobile')}}</span>
                    @endif
                  </div>
                 <input type="hidden" name="id" value="{{ $result->id }}">
                  <div class="col-md-6 text-right">
                    <button id="submitButtonId" type="submit">Update Address</button>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    @else

    <!-- MANAGE-ADDRESS-MAIN STARTS -->
    <section class="aad-address-main">
      <div class="container">
        <div class="row">  
          <div class="col-md-10 offset-md-1">
            <div class="form">
              <h2>Add Shipping Address</h2>
              <div class="delivery_line"></div>
              <div class="clearfix"></div>
              <form action="{{ route('save-addresses') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" name="name" maxlength="40" placeholder="Name*" class="form-control" required="true">
                    @if($errors->has('name'))
                      <span class="text-danger">{{$errors->first('name')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="company_name" maxlength="100" placeholder="Company name (optional)" class="form-control">
                    @if($errors->has('company_name'))
                      <span class="text-danger">{{$errors->first('company_name')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <select class="form-control" name="country" required="true">
                      <option value="">Select Country*</option>
                      @foreach($countries as $country)
                      <option value="{{ $country->id }}">{{ $country->name }}</option>
                      @endforeach
                    </select>
                    @if($errors->has('country'))
                      <span class="text-danger">{{$errors->first('country')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" required="true" placeholder="State / County*" name="state" class="statename form-control user_state"> 
                    @if($errors->has('state'))
                      <span class="text-danger">{{$errors->first('state')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" required="true" placeholder="Town / City*" name="city" class=" form-control">
                    @if($errors->has('city'))
                      <span class="text-danger">{{$errors->first('city')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="number" name="pincode" placeholder="Postcode / ZIP*" maxlength="6" class="form-control" required="true">
                    @if($errors->has('pincode'))
                      <span class="text-danger">{{$errors->first('pincode')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" class="form-control" required="true" placeholder="Street address*" name="address">
                    @if($errors->has('address'))
                      <span class="text-danger">{{$errors->first('address')}}</span>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <input type="text" name="mobile" placeholder="Mobile*" maxlength="13" minlength="10" class="form-control" required="true">
                    @if($errors->has('mobile'))
                      <span class="text-danger">{{$errors->first('mobile')}}</span>
                    @endif
                  </div>
                  
                  <div class="col-md-6 text-right">
                    <button id="submitButtonId" type="submit">Add Address</button>
                  </div>
                </div>
              </form>
          </div>
          </div>
       </div>
      </div>      
      
    </section>
  <!-- MANAGE-ADDRESS-MAIN ENDS -->

  @endif

@endsection
<script type="text/javascript">
function getCity(val) {
  $.ajax({
    type: "GET",
    url: "{{ route('getCity') }}",
    data: {'state_id' : val},
    success: function(data){
        $("#city-list").html(data);
    }
  });
}  


function HideBilling1(val) {

   $('#add-address123').show();
   smoothScrollTo('#add-address123', 1500, 100);


}
</script>