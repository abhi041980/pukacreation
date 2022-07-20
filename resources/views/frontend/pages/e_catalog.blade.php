@extends('frontend.layouts.app')
@section('content')
  
   <section class="bredcrum">
    <div class="container">
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li>&nbsp;/ &nbsp;e.Catalogs</li>
      </ul>
    </div>
  </section>
  <div class="clearfix"></div>

<div id="add-cart"></div>
  <!-- PRODUCT-LISTING-PANEL STARTS -->
    <section class="catalogs tradeshows">
      <div class="container">
        <div class="row">
            @php $count = 0; @endphp
            @if($catalogs_2022)
            @foreach($catalogs_2022 as $ecatalog)
            @php $count++; @endphp
              <div class="col-md-3">
                <h5 style="text-align: center;">{{ $count }}</h5>
                @if($ecatalog->url)<a href="{{ $ecatalog->url }}" target="_blank">  @else<a href="{{ route('home') }}{{ $ecatalog->catalog_file }}" target="_blank">@endif 
                <img src="{!! asset($ecatalog->background_image) !!}" class="img-fluid mx-auto d-block" alt="{{ $ecatalog->title }}">
                <h4 style="font-size: 17px; text-align: center; margin-top: 15px;">{{ $ecatalog->title }}</h4>
                </a>
              </div>
            @endforeach
            @endif
        </div>
        <div class="row">
            @if($speciality_catalogs)
            @foreach($speciality_catalogs as $ecatalog)
             @php $count++; @endphp
              <div class="col-md-3">
                  <h5 style="text-align: center;">{{ $count }}</h5>
                @if($ecatalog->url)<a href="{{ $ecatalog->url }}" target="_blank">  @else<a href="{{ route('home') }}{{ $ecatalog->catalog_file }}" target="_blank">@endif 
                <img src="{!! asset($ecatalog->background_image) !!}" class="img-fluid mx-auto d-block" alt="{{ $ecatalog->title }}"><h4 style="font-size: 17px; text-align: center; margin-top: 15px;">{{ $ecatalog->title }}</h4></a>
              </div>
            @endforeach
            @endif
        </div>
      </div>
</section>
@endsection