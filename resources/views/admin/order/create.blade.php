@extends('admin.layouts.master')
@section('css')
<!-- tables -->
<link rel="stylesheet" type="text/css" href="{!! asset('css/table-style.css') !!}" />
<!-- //tables -->
@endsection
@section('content')
@include('admin.layouts.messages')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">{!! lang('order.order') !!}   <a class="btn btn-sm btn-primary pull-right" href="{!! route('order.index') !!}"> <i class="fa fa-arrow-left"></i> All {!! lang('order.order') !!}</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>{!! lang('order.order_info') !!}</h4>                        
                            </div>
                            <div class="form-body">
                                   @if(session()->has('transaction'))
                    <p style="color: #f00; font-size: 16px; margin-bottom: 15px; margin-top: -7px;">Kindly update Transaction ID</p>
                                @endif 
                              
                                <table class="order_info" style="text-align: center;">
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Customer Name</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $user_name->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Order No.</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $result->order_nr }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Order Date</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;"> {!! date('d M, Y', strtotime($result->created_at)) !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Total Amount</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;"> <i class="fa fa-dollar-sign"></i>{!! $result->total_price !!}</td>
                                    </tr>
                                    @if($result->discount)
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Discount</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;"> <i class="fa fa-dollar-sign"></i>{!! $result->discount !!}</td>
                                    </tr>
                                    @endif
                                    @if($result->offer_id)
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Offer</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;"> <i class="fa fa-dollar-sign"></i>{!! $offer->title !!}</td>
                                    </tr>
                                    @endif
                                </table>

                                @if($result->pay_later != 1)
                                <div class="form-title" style="float: left; width: 100%; margin-top: 20px;">
                                    <h4>Card Information</h4>
                                </div>
                                <table class="order_info" style="text-align: center;float: left; width: 100%; margin-top: 20px;">
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Card No</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;"> {{ substr($result->card_no, 0, 4) }} XXXX XXXX {{ substr($result->card_no, 12, 4) }} </td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Card Holder</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $result->card_holder }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Card Type</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;"> {!! $result->card_type !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Expiration date</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{!! $result->expiration_month !!}, {!! $result->expiration_year !!}</td>
                                    </tr>
                                
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Card Security Code</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{!! $result->card_security_code !!}</td>
                                    </tr>
                                </table>
                                @endif
                                
                                
                                @if($shipping)
                                <div class="form-title" style="float: left; width: 100%; margin-top: 20px;">
                                    <h4>Shipping Address</h4>
                                </div>
                                <table class="order_info" style="text-align: center;margin-top: 30px; float: left;">
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Name</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $shipping->name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Address</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $shipping->address }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">City</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $shipping->city }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">State</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{!! $shipping->state !!}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Pin Code</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $shipping->pincode }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Country</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{{ $country->country_name }}</td>
                                    </tr>
                                    <tr>
                                        <td width="45%" style="text-align: right; font-size: 16px;">Mobile</td>
                                        <td width="10%">:</td>
                                        <td width="45%" style="text-align: left;font-size: 15px;">{!! $shipping->mobile !!}</td>
                                    </tr>
                                </table>

                                    @endif
                                    <div class="row" id="Products_Detail">
                                    <div class="col-md-12">
                                    <div class="form-title" style="float: left; width: 100%; margin-top: 20px;">
                                        <h4>Products Detail</h4>
                                    </div>
                                    </div>
                                    <div class="col-md-12">
                                     <table class="table table-hover">                          
<thead>
<tr>
    <th style="text-align: center;">Item No.</th>
    <th>Name</th>
    <th>SKU</th>
    <th class="text-center">Quantity</th>
    <th class="text-center">Price</th>
    <th class="text-center">Total Price</th>
</tr>
</thead>
<tbody>
<?php $i = 1;
$p = 0; ?>
@foreach($OrderProduct as $Product)
<tr>
    <td class="text-center"> {{ substr($Product->sku, -5) }}</td>
    <td>{{ str_limit($Product->name,80)}}</td>
    <td>{{ $Product->sku }}</td>
    <td class="text-center">{!! $Product->quantity !!}</td>
    <td class="text-center"><i class="fa fa-dollar-sign"></i> @if($result->id <= 1273) {!! $Product->price/$Product->quantity !!} @else {!! $Product->price !!} @endif </td>
    <td class="text-center"><i class="fa fa-dollar-sign"></i> @if($result->id <= 1273) {!! $Product->price !!} @else {!! $Product->price*$Product->quantity !!}  @endif </td>
</tr>
@if($result->id <= 1273)
@php $i++; $p += $Product->price @endphp   
@else
@php $i++; $p += $Product->price*$Product->quantity @endphp   
@endif

@endforeach
<tr>
<td colspan="4">Total</td>
<td class="text-center"><i class="fa fa-dollar-sign"></i> {{ $p }}</td>
</tr>
@if($result->offer_id)
<tr>
<td colspan="4">Discount</td>
<td class="text-center"><i class="fa fa-dollar-sign"></i> {{ $result->discount }}</td>
</tr>
@endif

<tr>
<td colspan="4"><b>Grand Total</b></td>
<td class="text-center"><b><i class="fa fa-dollar-sign"></i> {{ $result->total_price }}</b></td>
</tr>
</tbody>
</table>                              
</div>
</div>
                    
<!--<div class="row">
<div class="col-md-12">
<button type="submit" class="btn btn-default w3ls-button">Submit</button> 
 </div> 
</div>-->
                                  
                            
                                <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-title" style="float: left; width: 100%;margin-top: 15px;
    margin-bottom: 20px;">
                                        <h4>Order Status</h4>
                                    </div>
                                    </div>
                                <div class="col-md-6">
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-body">
                  
                                {!! Form::open(array('method' => 'POST', 'route' => array('order-product-status'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" value="{{ $id }}" name="order_id">
                                         <div class="form-group"> 
                                            {!! Form::label('type', lang('Current Status'), array('class' => '')) !!}
                                            <select name="status" class="form-control" required ="true">
                                            <option value="">-Select-</option>   
                                            @foreach($statusType as $statusType) 
                                            <option value="{{ $statusType->id }}" @if($statusType->id == $result->current_status) selected @endif>{{ $statusType->type }}</option> 

                                            @endforeach
                                            
                                            </select>
                                        </div> 
                                    </div>   
                                    <div class="col-md-12 mgn20">
                                         <div class="form-group"> 
                                            {!! Form::label('transaction_id', lang('Transaction ID'), array('class' => '')) !!}
                                            <input type="text" class="form-control" name="transaction_id" value="{{ $result->transaction_id }}"> 
                                        </div> 
                                    </div>


                                                                         
                                    </div>
                                      
                                <div class="row">
                                    <p>&nbsp;</p>
                                    <div class="col-md-12">
                                         <button type="submit" class="btn btn-default w3ls-button">Submit</button> 
                                    </div>
                                </div>
                                    
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">                
                <div class="agile-tables">
                    <div class="w3l-table-info">

                        {{-- for message rendering --}}
                        @include('admin.layouts.messages')
<table class="table table-hover" style="margin-top: 0px;">  
                       <thead>
<tr>
    <th class="text-center">#</th>
    <th>Date</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
<?php $index = 2; ?>


<tr>
    <td class="text-center">1</td>
    <td>{!! $result->created_at !!}</td>
    <td>Order Received</td>
</tr>
@foreach($orderStatus as $detail)
<tr>
    <td class="text-center">{!! $index !!}</td>
    <td>{!! $detail->date !!}</td>
    <td>{!! $detail->type !!}</td>
</tr>
<?php $index++; ?>
@endforeach

</tbody>
</table>

                    </div>
                    
                </div>
            </div>
        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

<style type="text/css">
.order_info  tr,
.order_info tr td {
    background: transparent !important;
    border: 0px !important;
    text-align: center;
}  





</style>










