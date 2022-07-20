<section class="top-header">
<div class="container">
<div class="row">
<div class="col-md-3 logo_box">
<a href="{{ route('home') }}" class="logo"><img src="{!! asset('assets/frontend/images/logo.png') !!}" class="img-fluid d-inline-block" alt="logo"></a>
</div>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
   <ul>
        <li><a href="{{ route('home') }}">HOME</a></li>
        <li><a href="{{ route('e-catalogs') }}">e.CATALOGS</a></li>
        <li><a href="{{ route('closeouts') }}">CLOSEOUTS</a> </li>
        <li><a href="{{ route('tradeshows') }}">TRADESHOWS</a></li>
        <li><a href="{{ route('forms') }}">FORMS</a></li>
        <li><a href="{{ route('contact') }}">CONTACT US</a></li>
    </ul>
</div>
<a onclick="openNav()" class="openNav">
    <span></span>
    <span></span>
    <span></span>
</a>

<div class="col-md-6">
<form id="labnol" method="get" action="{{ route('search_product')}}" style="margin-bottom: 0;">
    <div class="row">
    	<div class="col-md-3">
           <select name="category_id" id="category_id" onChange="getCategoryFilter(this.value);">
           	   <option value="0">All</option>
               @foreach(get_cat_par() as $cat_par) 
                    <option value="{{ $cat_par->id }}">{{ $cat_par->name }}</option>
               @endforeach
           </select>
    	</div>
    	<div class="col-md-7">
            <input type="text" name="q" id="transcript" autocomplete="off" placeholder="Search products..." class="main-search">
            <ul id="total_records1"></ul>
        </div>
        <div class="col-md-2">
        <span><img onclick="startDictation()" src="{!! asset('assets/frontend/images/speaker.png') !!}" class="img-fluid spkr-img" alt=""></span>
    <button type="submit" class="d-none"></button>
        </div>
    </div>
</form>
</div>
@php  $ip = $_SERVER['HTTP_USER_AGENT']; @endphp
<div class="col-md-3 top_box">
<ul>
<li><a href="{{ route('wishlist')}}"><i class="fa fa-heart-o"></i> <span>@if(\Auth::check()) {{ user_wishlist_count(\Auth::user()->id) }} @else 0 @endif</span></a></li>
<li><a href="{{ route('cartDetail') }}"><i class="fa-solid fa-cart-shopping"></i> <span id="cart_product_count">@if(\Auth::check()) {{ user_cart_count(\Auth::user()->id) }} @else {{ cart_count($ip) }} @endif</span></a></li>
@if(\Auth::check())
<li style="max-width: 250px;"><i class="fa fa-user-o"></i><a style="padding-top: 7px;" href="#">{{ str_limit(\Auth::user()->name, 13)}}</a>
<ul class="header_sub-menu">   
<li><a href="{{ route('my-profile') }}">My Profile</a></li>
<li><a href="{{ route('wishlist')}}">Wishlist</a></li>
<li><a href="{!! route('my-orders') !!}">My Orders</a></li>
<li><a href="{{ route('user-address')}}">My Address</a></li>
<li><a href="{{ route('change-password')}}">Change Password</a></li>
<li><a href="{!! route('logout') !!}">Log Out</a></li>
</ul>
</li>

@else
<li><i class="fa-solid fa-user"></i><a href="/log-in">Login</a><a href="/sign-up">Signup</a></li>
@endif
</ul>
</div>
</div>
</div>
</section>

<section class="header">
<nav class="navigation">
            <div class="container">
                <div class="navigation__left">
                    <div class="menu--product-categories">
                        <div class="menu__toggle"><i class="fa-solid fa-bars" style="color: #fff;"></i><span> Product categories</span></div>
                        <div class="menu__content">
                            <ul class="menu--dropdown">
                            	@foreach(get_cat_par() as $cat_par) 
                                <li><a href="{{ route('categoryDetail', $cat_par->url) }}"><i class="fa-solid fa-folder"></i>{{ $cat_par->name }}</a></li>  
                                @endforeach     
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="navigation__right">
                    <ul class="menu">
                    	<li><a href="{{ route('home') }}">HOME</a></li>
                        <li><a href="{{ route('e-catalogs') }}">e.CATALOGS</a></li>
                        <li><a href="{{ route('categoryDetail', 'closeouts') }}">CLOSEOUTS</a> </li>
                        <li><a href="{{ route('tradeshows') }}">TRADESHOWS</a></li>
                        <li><a href="{{ route('forms') }}">FORMS</a></li>
                        <li><a href="{{ route('contact') }}">CONTACT US</a></li>
                    </ul>
                </div>
            </div>
        </nav>
</section>


