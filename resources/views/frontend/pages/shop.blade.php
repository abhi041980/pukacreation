@extends('frontend.layouts.app')
@section('content')
<!-- BANNER STARTS -->
    <section class="banners">
      <img src="{!! asset('assets/frontend/images/Shop.png') !!}" class="img-fluid d-inline-block" alt="">
    </section>
  <!-- BANNER ENDS -->

 <!-- BREAD-CRUMBS STARTS -->
    <section class="breadcrumbs py-3">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="bread-crumbs">
              <ul>
                <li><a href="{{ route('home')}}"> Home</a></li>
                <li>/ Shop</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  <!-- BREAD-CRUMBS ENDS -->
  <div class="clearfix"></div>
  <!-- PRODUCT-LISTING-PANEL STARTS -->
    <section class="product-listing-panel">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-3 d-md-block d-none">
            <aside>
              <div class="accordion" id="accordionExample">
  <h4 style="border-bottom: 1px dashed #555; padding-bottom: 10px; margin-top: -43px; width: 84%; font-size: 17px;">Filter By</h4>                
<div class="card">
  <div class="card-header" id="headingOne1">
    <h5 class="mb-0"><button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Category</button></h5>
  </div>
  <div id="collapseOne" class="in collapse show" aria-labelledby="headingOne1" data-parent="#accordionExample" style="">
    <div class="card-body">
      <ul id="selective">
        @if($Categorys)
          @foreach($Categorys as $category)
            <li><input value="{{ $category->id }}" name="category_id" class="category_value" onChange="getCategoryID(this.value);" type="checkbox"> <a href="{{ route('categoryDetail',  $category->url) }}"><span>{{ $category->name}}</span></a></li>
          @endforeach
        @endif
      </ul>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header" id="headingOne2">
    <h5 class="mb-0"><button class="btn btn-link collapsed"  type="button" data-toggle="collapse" data-target="#collapseOne1" aria-expanded="true" aria-controls="collapseOne1">Colors</button></h5>
  </div>
  <div id="collapseOne1" class="in collapse" aria-labelledby="headingOne2" data-parent="#accordionExample" style="">
    <div class="card-body">
      <ul>
        @if($colors)
          @foreach($colors as $color)
            <li><input value="{{ $color->id }}" name="color_id" class="color_value" onChange="getColorID(this.value);" type="checkbox"> <span class="ct_box" style="background-color:{{ $color->name}}; "></span> <span class="pull-left">{{ $color->name}}</span></li>
          @endforeach
        @endif
      </ul>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-header" id="headingOne3">
    <h5 class="mb-0"><button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">Style</button></h5>
  </div>
  <div id="collapseOne2" class="in collapse" aria-labelledby="headingOne3" data-parent="#accordionExample" style="">
    <div class="card-body">
      <ul>
        @if($styles)
          @foreach($styles as $style)
            <li><input value="{{ $style->id }}" name="style_id" class="style_value" onChange="getStyleID(this.value);" type="checkbox"> <span>{{ $style->style}}</span></li>
          @endforeach
        @endif
      </ul>
    </div>
  </div>
</div> 
<div class="card">
  <div class="card-header" id="headingOne4">
    <h5 class="mb-0"><button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne3" aria-expanded="true" aria-controls="collapseOne3">Price</button></h5>
  </div>
  <div id="collapseOne3" class="in collapse" aria-labelledby="headingOne4" data-parent="#accordionExample" style="">
    <div class="card-body">
      <form>
        <input type="hidden" value="Category" name="page">  
        <input type="hidden" value="{{ $category->id }}" name="f_id">
        <input type="number" placeholder="Min Price" name="min" class="min-price" required="true"> To
        <input type="number" placeholder="Max Price" name="max" class="max-price" required="true">
        <button class="ajax_sub">Find</button>
      </form>
    </div>
  </div>
</div>      
<div class="card">
  <div class="card-header" id="headingOne5">
    <h5 class="mb-0"><button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne4" aria-expanded="true" aria-controls="collapseOne4">Avg. Customer Review</button></h5>
  </div>
  <div id="collapseOne4" class="in collapse" aria-labelledby="headingOne5" data-parent="#accordionExample" style="">
    <div class="card-body">
      <ul class="star-filter">
        <li><button value="4" class="d-inline-block" onclick="ratingfilter(this.value)"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> & up</button></li>
        <li><button value="3" class="d-inline-block" onclick="ratingfilter(this.value)"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> & up</button></li>
        <li><button value="2" class="d-inline-block" onclick="ratingfilter(this.value)"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> & up</button></li>
        <li><button value="1" class="d-inline-block" onclick="ratingfilter(this.value)"><i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> & up</button></li>
      </ul>
    </div>
  </div>
</div> 
<div class="card">
  <div class="card-header" id="headingOne6">
    <h5 class="mb-0"><button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseOne5" aria-expanded="true" aria-controls="collapseOne5">Availability</button></h5>
  </div>
  <div id="collapseOne5" class="in collapse" aria-labelledby="headingOne6" data-parent="#accordionExample" style="">
    <div class="card-body">
      <ul class="pl-0 mb-0">
        <li><input value="1" name="availability_stock" onChange="getAvailabilityID(this.value);" type="radio"> <span>In Stock</span></li>
        <li><input value="0" name="availability_stock" onChange="getAvailabilityID(this.value);" type="radio"> <span>Out Of Stock</span></li>
      </ul>
    </div>
  </div>
</div>
           
              </div>
            </aside>
          </div>
          <div class="col-lg-9 col-md-9" id="category-list">
            <ul class="sort_filter">
              <li style="color: #212529;font-size: 15px; font-weight: 500; font-family: 'Roboto', sans-serif;margin-right: 10px; ">Sort by:</li>
              <li><button value="1" class="d-inline-block" onclick="SortFilter(this.value)">New Arrivals</button></li>
              <li><button value="2" class="d-inline-block" onclick="SortFilter(this.value)">High Price to Low</button></li>
              <li><button value="3" class="d-inline-block" onclick="SortFilter(this.value)">Low Price to High</button></li>
              <li><button value="4" class="d-inline-block" onclick="SortFilter(this.value)">Best Sellers</button></li>
              <li><button value="5" class="d-inline-block" onclick="SortFilter(this.value)">Latest Style</button></li>
            </ul>
            <div class="row">
            @if($products)
            @php $already_pro6 = []; @endphp
              @foreach($products as $product)
              @php
              $s_type = null;
              if(get_flash_price($product->id)){
                $s_type = 'flash';
                $sale_discount = get_flash_price($product->id);
              } else if(get_clearence_price($product->id)){
                $s_type = 'clearence';
                $sale_discount = get_clearence_price($product->id);
              } else if(get_happyhour_price($product->id)){
               $s_type = 'happy_hour';
                $sale_discount = get_happyhour_price($product->id);
              } else if(get_festive_price($product->id)){
               $s_type = 'festive';
                $sale_discount = get_festive_price($product->id);
              } else {
                $sale_discount = 0;
              }
             @endphp

              @php
               if(in_array($product->id, $already_pro6)) {
                  } else{              
                  $already_pro6[] = $product->id; 
              @endphp 

              <div class="col-lg-4 col-md-6 col-6 mt-md-0 mt-5">
                <div class="prod-box">
                  <a href="{!! route('productDetail', $product->url) !!}">
                    <div class="img">
                    @if($s_type == 'clearence') 
                    <img src="{!! asset('assets/frontend/images/clearence.png') !!}" class="img-fluid mx-auto d-block flash-icon" alt="">  
                    @endif
                    @if($s_type == 'flash') 
                    <img src="{!! asset('assets/frontend/images/disc.png') !!}" class="img-fluid mx-auto d-block flash-icon" alt="">  
                    @endif
                    @if($s_type == 'happy_hour') 
                    <img src="{!! asset('assets/frontend/images/happy-hour.png') !!}" class="img-fluid mx-auto d-block flash-icon" alt="">  
                    @endif  
                    @if($s_type == 'festive') 
                   <img src="{!! asset('assets/frontend/images/festive.png') !!}" class="img-fluid mx-auto d-block flash-icon" alt=""> 
                    @endif 
                
                      <img src="{!! asset($product->featured_image) !!}" class="img-fluid mx-auto front_img" alt="">
                      <img src="{!! asset($product->back_img) !!}" class="img-fluid mx-auto back_img" alt="">
                      

                    </div>
                  </a>
                    <div class="txt mt-3" style="padding: 6px;">
                      <h6 class="mb-3"> <a href="{!! route('productDetail', $product->url) !!}">{{ $product->name }}</a></h6>
                     <!--  <p class="rating mb-2">
                      @if(rating($product->id))
                      @php $p_rat = rating($product->id);   @endphp
                      @if($p_rat == 1)
                      <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                      @endif
                      @if($p_rat == 2)
                      <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                      @endif
                      @if($p_rat == 3)
                      <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                      @endif
                      @if($p_rat == 4)
                      <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i>
                      @endif
                      @if($p_rat == 5)
                      <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                      @endif
                      @if($p_rat > 1 && $p_rat < 2)
                      <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                      @endif
                      @if($p_rat > 2 && $p_rat < 3)
                      <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                      @endif
                      @if($p_rat > 3 && $p_rat < 4)
                      <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i>
                      @endif
                      @if($p_rat > 4 && $p_rat < 5)
                      <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i>
                      @endif
                      @else
                        <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i>
                      @endif &nbsp;&nbsp;&nbsp; <span>({{ rating_count($product->id) }} Comments)</span></p> -->
                  
                     
                    </div>
                </div>
              </div>
              @php } @endphp
              @endforeach
            @endif
            @if($counts == 0)
           <div class="text-center" style="width: 100%;">
              <img src="{!! asset('assets/frontend/images/No-Product-found.jpg') !!}" class="img-fluid d-inline-block max-height-400" alt=""> 
            </div>
            @endif
            </div>
            <div class="text-center">
            @if(isset($products))
              {{ $products->links() }}
            @endif
          </div>
          </div>
        </div>
      </div>
    </section>
  <!-- PRODUCT-LISTING-PANEL ENDS -->

@endsection