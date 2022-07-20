<footer class="footer">
<div class="container">	
<div class="row">
<div class="col-md-2">
<h3>Important Links</h3>
<ul>
<li><a href="{{ route('about-us') }}">About Us</a></li>
<li><a href="{{ route('e-catalogs') }}">e.Catalogs</a></li>
<li><a href="{{ route('forms') }}">Forms</a></li>
<li><a href="{{ route('contact') }}">Contact Us</a></li>
<li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
<li><a href="{{ route('terms-and-conditions') }}">Terms and Conditions</a></li>
</ul>

</div>
<div class="col-md-5 offset-md-2">
<h3>Closeout Products</h3>
<div class="row">
@foreach(get_closeout_parduct() as $product)       
<div class="col-md-2">
<a href="#"><img src="{!! asset($product->thumbnail) !!}" class="img-fluid mx-auto d-block" alt="{{ $product->name }}"></a>
</div>
<div class="col-md-10">
<h5><a href="#">{{ $product->name }}</a></h5>
<p>@if($product->regular_price > $product->offer_price)<del>${{ $product->regular_price }}</del>@endif ${{ $product->offer_price }}</p>
</div>
@endforeach


</div>
</div>
<div class="col-md-2">
<h3>Hours & Info</h3>
<p>16840 South Main St<br>
Gardena CA 90248-3122 U.S.A<br>
323-233-2010<br>
<a href="mailto:sezer@pukacreations.com">sezer@pukacreations.com</a><br>
Office Hours: 8AM-5PM</p>


</div>
</div>
</div>
</footer>




