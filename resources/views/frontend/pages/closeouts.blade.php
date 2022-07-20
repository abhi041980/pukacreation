@extends('frontend.layouts.app')
@section('content')
  
   <section class="bredcrum">
    <div class="container">
      <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li>&nbsp;/ &nbsp;Closeouts</li>
      </ul>
    </div>
  </section>
  <div class="clearfix"></div>

<div id="add-cart"></div>
<div id="add-cart_full"></div>
  <!-- PRODUCT-LISTING-PANEL STARTS -->
    <section class="product-listing">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-3 d-md-block d-none">
            <aside>
              <div class="accordion" id="accordionExample">        
          <div class="card">
            <div class="card-header" id="headingOne1">
              <h5>Categories</h5>
            </div>
              <input type="hidden" name="search_key" id="search_cat" value="0001">
              <div class="card-body">
                <ul id="selective">
                  @if($Categorys)
                  @php $ci = 0;   @endphp
                  @foreach($Categorys as $category)
                   @php $ci++;   @endphp
                      <li><input value="{{ $category->id }}" name="category_id" class="category_value" onChange="getCategoryID(this.value);" type="checkbox"> {{ $category->name}}</li>
                    @endforeach
                  @endif
                </ul>
              </div>
          </div>
              </div>
            </aside>
          </div>
          
          
          <div class="col-lg-9 col-md-9" id="category-list">
            <ul class="sort_filter">
              <li><button value="4" onclick="SortFilter(this.value)">Top Trending</button></li>
              <li><button value="3" onclick="SortFilter(this.value)">Low Price to High</button></li>
              <li><button value="2" onclick="SortFilter(this.value)">High Price to Low</button></li>
              <li><button value="1" onclick="SortFilter(this.value)">New Arrivals</button></li>
              <li>Sort by:</li>
            </ul>
            <div class="row new_products">
            @if($products)
              @foreach($products as $product)
                <div class="col-md-3">
                  <h6>{{ round(100-($product->offer_price/$product->regular_price)*100) }}%</h6>
                  <a href="{{ route('productDetail', $product->url) }}"><img src="{!! asset($product->thumbnail) !!}" class="img-fluid mx-auto d-block" alt="{{ $product->name }}"></a>
                  <p>${{ $product->offer_price }} <del>${{ $product->regular_price }}</del></p>
                  <h3><a href="{{ route('productDetail', $product->url) }}">{{ $product->name }}</a></h3>
                </div>
              @endforeach
            @endif
            @if($counts == 0)
           <div class="text-center" style="width: 100%;">
              <img src="{!! asset('assets/frontend/images/No-Product-found.jpg') !!}" class="img-fluid d-inline-block max-height-400" alt=""> 
            </div>
            @endif
            </div>
            @if(isset($products))
              {{ $products->links() }}
            @endif
          </div>
        </div>
      </div>
    </section>
  <!-- PRODUCT-LISTING-PANEL ENDS -->

@endsection