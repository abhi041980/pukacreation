@extends('frontend.layouts.app')
@section('content')
 @if($order)
  @php $total_pr1 = 0; @endphp
    @foreach(get_order_product($order->id) as $o_pro1)
    @php $total_pr1 += $o_pro1->price*$o_pro1->quantity; @endphp
@endforeach
@endif
  <section class="bredcrum">
    <div class="container">
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li>&nbsp;/&nbsp;<a href="{{ route('my-orders') }}">My Orders</a></li>
        <li>&nbsp;/&nbsp;Order Details</li>
      </ul>
    </div>
  </section>
  <div class="clearfix"></div>
  <!-- ORDER-DETAILS STARTS -->
    <section class="order-details">
      <div class="container">
        <div class="row">
          <div class="col-xl-12">
            <div class="txt-box">
                <div class="detail_hd">
                  <div class="row">
                    <div class="col-xl-12">
                      <h4>Order Details</h4>
                    </div>
                 </div>
                </div>  
                <div class="detail_dt">
                  <div class="row">
                    <div class="col-xl-6 col-xs-6">
                      <p>Dated: {{ date('d', strtotime($order->created_at)) }} {{ date('M', strtotime($order->created_at)) }}  {{ date('Y', strtotime($order->created_at)) }} | Order No: {{ $order->order_nr }} | Status: <span style="color: #9D1515;"> {{ $order->type }}</span> </p>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-8">
                <div class="od_detail"> 
                <div class="row">
                  <div class="col-md-6">
                    <h6 class="shipping_hd">Shipping Address</h6>
                    <div class="shipping-summry" style="margin-top: 22px;">
                      <p class="name mb-1" style="text-transform: uppercase;">{{ $order->name }}</p>
                      <p class="mb-1">{{ $order->address }}, {{ $order->city }},<br> {{ $order->state }} - {{ $order->pincode }}</p>
                      <p class="mb-1">Phone: {{ $order->mobile }}</p>
                    </div>
                  </div>
                    <!-- <div class="col-md-5">
                    
                    </div> -->
                  <div class="col-md-6">

                    <h6 class="shipping_hd">Order Summary</h6>
                      <div class="summary-box">
                        @if($order->transaction_id) <p class="name mb-1" style="margin-top: 2px;">Transaction Id: {{ $order->transaction_id }}</p> @endif
                        <div class="row">
                        <div class="col-7">
                          <p class="mb-1" style="text-transform: uppercase;">Items Subtotal:</p>
                        </div>
                        <div class="col-5">
                          <p class="mb-1"><i class="fa fa-dollar"></i> {{ $total_pr1 }} </p>
                        </div>
                  <!--       @if($order->discount)
                          <div class="col-7">
                            <p class="mb-1" style="text-transform: uppercase;">Discount:</p>
                          </div>
                          <div class="col-5">
                            <p class="mb-1"><i class="fa fa-inr"></i>{{ $order->discount }}</p>
                          </div>
                        @endif -->
                        <div class="col-7">
                          <p class="mb-1" style="color: #be0027;margin-top: 0px;font-size: 19px;"><strong>Grand Total:</strong></p>
                        </div>
                        <div class="col-5">
                          <p class="mb-1" style="color: #be0027;margin-top: 0px;font-size: 19px;"><strong><i class="fa fa-dollar"></i>{{ $order->total_price }}</strong></p>
                        </div>
                      </div>
                      </div>
                    </div>
                </div>
                </div>
                </div>
              </div>



                <div class="deliver-box mt-3">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center mb-4">
                      <thead>
                        <tr class="text-uppercase" style="background: #EBEBEB;">
                          <th><p class="mb-0" style="max-width: 190px;font-weight: 500;">product</p></th>
                          <th><p class="mb-0" style="text-align: left;font-weight: 500;">name</p></th>
                          <th><p class="mb-0" style="font-weight: 500;">quantity</p></th>
                          <th><p class="mb-0" style="font-weight: 500;">price</p></th>
                          <th><p class="mb-0" style="font-weight: 500;">total</p></th>
                        </tr>
                      </thead>
                      <tbody>
                        @if(isset($order))
                        @php $total_pr = 0; @endphp
                        @if($order)
                        @php $total_pr = 0; @endphp
                        @foreach(get_order_product($order->id) as $o_pro)
                        @php $total_pr += $o_pro->price*$o_pro->quantity; @endphp
                        <tr style="border-top: 1px solid #d9d9d9;">
                          <td>
                            <a href="{{ route('productDetail', $o_pro->url)}}">
                                <img class="img-fluid d-block max-h-100" style="max-width: 70px; margin: 0 auto;" src="{!! asset($o_pro->thumbnail) !!}" alt=""></a>
                          </td>
                          <td class="text-left" style="vertical-align: middle;">
                            <h6 class="mb-0" style="color: #212529;font-weight: 300;">{{ $o_pro->name }}</h6>
                          </td>
                          <td style="vertical-align: middle;">
                            <p class="mb-0">{{ $o_pro->quantity }}</p>
                          </td>
                          <td style="vertical-align: middle;">
                            <p class="mb-0 text-capitalize"><i class="fa fa-dollar"></i>{{ round($o_pro->price) }}</p>
                          </td>
                          <td style="vertical-align: middle;">
                            <p class="mb-0 text-capitalize"><i class="fa fa-dollar"></i>{{ round($o_pro->price*$o_pro->quantity) }}</p>
                          </td>
                        </tr>
                        @endforeach
                        @endif
                        @endif

                      </tbody>
                    </table>
                  </div>

                </div>

              </div>
            </div>

          </div>
        </div>
         @if(isset($order->current_status))
                <div id="order-track">
              <h4 style="margin-top: 36px;text-align: center;margin-bottom: 5px; text-transform: uppercase; font-size: 24px;font-family: 'Poppins', sans-serif;">Order Status</h4>
              @if($order->current_status == 1)
              <ol class="progtrckr" data-progtrckr-steps="5">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-todo">In Process</li>
                <li class="progtrckr-todo">Out For Delivery</li>
                <li class="progtrckr-todo">Delivered</li>
              </ol>
              @endif
              @if($order->current_status == 2)
              <ol class="progtrckr" data-progtrckr-steps="5">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-done">In Process</li>
                <li class="progtrckr-todo">Out For Delivery</li>
                <li class="progtrckr-todo">Delivered</li>
              </ol>
              @endif
              @if($order->current_status == 3)
              <ol class="progtrckr" data-progtrckr-steps="5">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-done">In Process</li>
                <li class="progtrckr-done">In Transit</li>
                <li class="progtrckr-todo">Out For Delivery</li>
                <li class="progtrckr-todo">Delivered</li>
              </ol>
              @endif
              @if($order->current_status == 4)
              <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-done">In Process</li>
                <li class="progtrckr-done">Out For Delivery</li>
                <li class="progtrckr-todo">Delivered</li>
              </ol>
              @endif
              @if($order->current_status == 5)
              <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-done">In Process</li>
                <li class="progtrckr-done">Out For Delivery</li>
                <li class="progtrckr-done">Delivered</li>
              </ol>
              @endif

              @if($order->current_status == 6)
              <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-done">In Process</li>
                <li class="progtrckr-done">In Transit</li>
                <li class="progtrckr-done">Declined</li>
              </ol>
              @endif
              
              @if($order->current_status == 7)
              <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-done">In Process</li>
                <li class="progtrckr-done">In Transit</li>
                <li class="progtrckr-done">Failed</li>
              </ol>
              @endif

              @if($order->current_status == 8)
              <ol class="progtrckr" data-progtrckr-steps="4">
                <li class="progtrckr-done">Order Placed</li>
                <li class="progtrckr-done">In Process</li>
                <li class="progtrckr-done">In Transit</li>
                <li class="progtrckr-done">Cancelled</li>
              </ol>
              @endif
              </div>
              @endif
      </div>
    </section>
  <!-- ORDER-DETAILS EDNDS -->

@endsection 