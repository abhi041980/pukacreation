@extends('admin.layouts.master')
@section('css')
<!-- tables -->
<link rel="stylesheet" type="text/css" href="{!! asset('css/table-style.css') !!}" />
<!-- //tables -->

{!! HTML::script('js/nicEdit-latest.js') !!} <script type="text/javascript">
//<![CDATA[
bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
//]]>

</script>

@stop
@section('content')
@include('admin.layouts.messages')
@php
    $route  = \Route::currentRouteName();    
@endphp
<div class="agile-grids">   
    <div class="grids">       
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">{!! lang('product.product') !!} <a class="btn btn-sm btn-primary pull-right" href="{!! route('product.index') !!}"> <i class="fa fa-solid fa-arrow-left"></i> All {!! lang('product.products') !!}</a></h1>
                
                <div class="panel panel-widget forms-panel">
                    <div class="forms">
                        <div class="form-grids widget-shadow" data-example-id="basic-forms"> 
                            <div class="form-title">
                                <h4>{!! lang('product.product_info') !!}</h4>   
                                @if(isset($result->url))
                                <p style="margin-top: 8px; font-size: 14px;">Permalink: <a target="_blank" href="{{ route('productDetail', $result->url) }}">{{ route('productDetail', $result->url) }}</a>
                                @endif
                            </div>
                            <div class="form-body">
                                @if($route == 'product.create')
                                    {!! Form::open(array('method' => 'POST', 'route' => array('product.store'), 'id' => 'ajaxSave', 'class' => '', 'files'=>'true')) !!}
                                @elseif($route == 'product.edit')
                                    {!! Form::model($result, array('route' => array('product.update', $result->id), 'method' => 'PATCH', 'id' => 'product-form', 'class' => '', 'files'=>'true')) !!}
                                @else
                                    Nothing
                                @endif
                                
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                    <div class="col-md-4">
                                         <div class="form-group"> 
                                            <label>Product Name<span>*</span></label>
                                            {!! Form::text('name', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('name'))
                                             <span class="text-danger">{{$errors->first('name')}}</span>
                                            @endif
                                        </div> 
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group"> 
                                            <label>SKU<span>*</span></label>
                                            {!! Form::text('sku', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('sku'))
                                             <span class="text-danger">{{$errors->first('sku')}}</span>
                                            @endif
                                        </div> 
                                    </div>
                                    <input type="hidden" value="2000" name="quantity">
                                    <!-- <div class="col-md-3" style="margin-top: 20px;">
                                         <div class="form-group"> 
                                            <label>Quantity<span>*</span></label>
                                            {!! Form::number('quantity', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if($errors->has('quantity'))
                                             <span class="text-danger">{{$errors->first('quantity')}}</span>
                                            @endif
                                        </div> 
                                    </div> -->
                                    <div class="col-md-4">
                                        <div class="form-group"> 
                                            <label>Offer Price<span>*</span></label>
                                            <!-- {!! Form::number('offer_price', null, array('class' => 'form-control', 'required' => 'true')) !!} -->
                                            @if(isset($result))
                                            <input class="form-control" value="{{ $result->offer_price }}" step=".01" required="true" name="offer_price" type="number"> 
                                            @else
                                            <input class="form-control" value="{{ old('offer_price') }}" step=".01" required="true" name="offer_price" type="number">
                                            @endif
                                            @if($errors->has('offer_price'))
                                            <span class="text-danger">{{$errors->first('offer_price')}}</span>
                                            @endif
                                        </div> 
                                    </div>
                                    <div class="col-md-4" style="margin-top: 20px;">
                                         <div class="form-group"> 
                                            <label>Regular Price<span>*</span></label>
                                            <!-- {!! Form::number('regular_price', null, array('class' => 'form-control', 'required' => 'true')) !!} -->
                                            @if(isset($result))
                                            <input class="form-control" value="{{ $result->regular_price }}" step=".01" required="true" name="regular_price" type="number"> 
                                            @else
                                            <input class="form-control" value="{{ old('regular_price') }}" step=".01" required="true" name="regular_price" type="number">
                                            @endif
                                            @if($errors->has('regular_price'))
                                             <span class="text-danger">{{$errors->first('regular_price')}}</span>
                                            @endif
                                        </div> 
                                    </div>
                                    <div class="col-md-4" style="margin-top: 20px;">
                                         <div class="form-group"> 
                                            <label>SRP</label>
                                            @if(isset($result))
                                            <input class="form-control" value="{{ $result->srp }}" step=".01" name="srp" type="number"> 
                                            @else
                                            <input class="form-control" value="{{ old('srp') }}" step=".01" name="srp" type="number">
                                            @endif
                                            @if($errors->has('srp'))
                                             <span class="text-danger">{{$errors->first('srp')}}</span>
                                            @endif
                                        </div> 
                                    </div>
                                    
                                    
                                    <!-- <div class="col-md-3 category" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                        <label for="sub_category" class="">Second Level Category</label>
                                        <select name="sub_category" onChange="getSubcategory_2(this.value);" id="category-list" class="select2 form-control1">
                                        <option value="">-Select-</option>
                                        @if(isset($category_list_2))
                                        @foreach($category_list_2 as $cat_list2)
                                         <option value="{{ $cat_list2->id }}" @if($result->sub_category == $cat_list2->id) selected @endif>{{ $cat_list2->name }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 category" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                        <label for="sub_sub_category" class="">Third Level Category</label>
                                        <select name="sub_sub_category" onChange="getSubcategory_3(this.value);" id="category-list_3" class="select2 form-control1">
                                        <option value="">-Select-</option>
                                        @if(isset($category_list_3))
                                        @foreach($category_list_3 as $cat_list3)
                                         <option value="{{ $cat_list3->id }}" @if($result->sub_sub_category == $cat_list3->id) selected @endif>{{ $cat_list3->name }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 category" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                        <label for="four_lavel" class="">Four Level Category</label>
                                        <select name="four_lavel" onChange="getSubcategory_4(this.value);" id="category-list_4" class="select2 form-control1">
                                        <option value="">-Select-</option>
                                        @if(isset($category_list_4))
                                        @foreach($category_list_4 as $cat_list4)
                                         <option value="{{ $cat_list4->id }}" @if($result->four_lavel == $cat_list4->id) selected @endif>{{ $cat_list4->name }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 category" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                        <label for="five_lavel" class="">Five Level Category</label>
                                        <select name="five_lavel" onChange="getSubcategory_5(this.value);" id="category-list_5" class="select2 form-control1">
                                        <option value="">-Select-</option>
                                        @if(isset($category_list_5))
                                        @foreach($category_list_5 as $cat_list5)
                                         <option value="{{ $cat_list5->id }}" @if($result->five_lavel == $cat_list5->id) selected @endif>{{ $cat_list5->name }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 category" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                        <label for="six_lavel" class="">Six Level Category</label>
                                        <select name="six_lavel" onChange="getSubcategory_6(this.value);" id="category-list_6" class="select2 form-control1">
                                        <option value="">-Select-</option>
                                        @if(isset($category_list_6))
                                        @foreach($category_list_6 as $cat_list6)
                                         <option value="{{ $cat_list6->id }}" @if($result->six_lavel == $cat_list6->id) selected @endif>{{ $cat_list6->name }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 category" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                        <label for="seven_lavel" class="">Seven Level Category</label>
                                        <select name="seven_lavel" id="category-list_7" class="select2 form-control1">
                                        <option value="">-Select-</option>
                                        @if(isset($category_list_7))
                                        @foreach($category_list_7 as $cat_list7)
                                         <option value="{{ $cat_list7->id }}" @if($result->seven_lavel == $cat_list7->id) selected @endif>{{ $cat_list7->name }}</option>
                                        @endforeach
                                        @endif
                                        </select>
                                        </div>
                                    </div> -->

                                    <div class="col-md-4" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                        <label for="trending" class="">Trending Product</label>
                                        <select name="trending" class="select2 form-control1" required="true">
                                        <option value="">-Select-</option>
                                        <option {{ old('trending') == '1' ? 'selected' : '' }} value="1" @if(isset($result)) @if($result->trending == 1) selected @endif @endif>Yes</option>
                                        <option {{ old('trending') == '0' ? 'selected' : '' }} value="0" @if(isset($result)) @if($result->trending == 0) selected @endif @endif>No</option>
                                        </select>
                                        @if($errors->has('trending'))
                                            <span class="text-danger">{{$errors->first('trending')}}</span>
                                        @endif
                                        </div>
                                    </div>
                                    </div>
                                    </div>
                                    
                                    <div class="col-md-3 category">
                                        <div class="form-group"> 
                                        <label for="category_id" class="">Category<span>*</span></label>
                                        <!--<select name="category_id" onChange="getSubcategory(this.value);" class="select2 form-control1">-->
                                        <!--<option value="">-Select-</option>-->
                                        <div style="max-height: 113px; overflow: auto;">
                                        @foreach($Categorys as $cat)
                                        <label style="width: 100%;"><input style="margin-top: 2px; float: left; margin-right: 6px;" type="checkbox" value="{{ $cat->id }}" @if(isset($selected_cat)) @if(in_array($cat->id, $selected_cat)) checked=""  @endif @endif name="category_id[]">{{ $cat->name }}</label>
                                        @endforeach
                                        <!--</select>-->
                                        </div>
                                        </div>
                                        </div>
                           
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                            <label for="description" class="">Short Description<span>*</span></label>
                                            {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
                                            @if ($errors->has('description'))
                                             <span class="text-danger">{{$errors->first('description')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                            <label for="product_description" class="">Product Description<span>*</span></label>
                                            {!! Form::textarea('product_description', null, array('class' => 'form-control')) !!}
                                            @if ($errors->has('product_description'))
                                             <span class="text-danger">{{$errors->first('product_description')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                            <label for="meta_title" class="">Meta Title<span>*</span></label>
                                            {!! Form::text('meta_title', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if ($errors->has('meta_title'))
                                             <span class="text-danger">{{$errors->first('meta_title')}}</span>
                                            @endif
                                        </div>
                                    </div>
                        
                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                            <label for="meta_title" class="">Meta Description<span>*</span></label>
                                            {!! Form::text('meta_description', null, array('class' => 'form-control', 'required' => 'true')) !!}
                                            @if ($errors->has('meta_description'))
                                             <span class="text-danger">{{$errors->first('meta_description')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                                                     
                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <div class="form-group"> 
                                            <label>Featured Image<span>*</span></label> 
                                            @if(!empty($result->featured_image))
                                          <!--   {!! Form::file('featured_image', array()) !!} -->
                                            <input name="featured_image" type='file' accept="image/png, image/jpeg" id="imgInp" />
                                            @else
                                            <!-- {!! Form::file('featured_image', array('required' => 'true')) !!} -->
                                            <input name="featured_image" type='file' accept="image/png, image/jpeg" required="true" id="imgInp" />

                                            @endif
                                            @if ($errors->has('featured_image'))
                                             <span class="text-danger">{{$errors->first('featured_image')}}</span>
                                            @endif
                                            <img id="blah" src="#" style="max-width: 170px;margin-top: 10px;" alt="" />
                                        </div>
                                        @if(!empty($result->featured_image))
                                            <div class="form-group"> 
                                                 {!! HTML::image(asset($result->featured_image),'' ,array('width' => 170 ,'class'=>'img-responsive') ) !!}
                                            </div>
                                        @endif
                                    </div> 
                                    
                                    <div class="col-md-6" style="margin-top: 20px;">
                                        <div class="form-group" id="gallery_fileds" style="margin-bottom: 10px;">
                                            {!! Form::label('file', lang('Gallery Image (Max 1mb)'), array('class' => '')) !!}
                                            {!! Form::file('gallery[]', null, array('class' => 'form-control')) !!}
                                        </div> 
                                        
                                       <input type="button" id="more_fields" style="margin-bottom: 15px;" onclick="add_fields();" value="Add More" />
                                       @if(isset($result))
                                        <ul class="del_vid_list">
                                            @foreach(get_gallery_image($result->id) as $gallery)
                                            <li>{!! HTML::image(asset($gallery->product_image),'' ,array('width' => 70 , 'height' => 70,'class'=>'img-responsive') ) !!} <a href="{{route('gallery.delete', $gallery->id)}}">Remove</a></li>
                                            @endforeach
                                        </ul>
                                        @endif
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
        </div>
    </div>
</div>

<script>
function getSubcategory(val) {
  $.ajax({
    type: "GET",
    url: "{{ route('getSubcategory') }}",
    data: {'main_id' : val},
    success: function(data){
        $("#category-list").html(data);
    }
  });
}

function yesnoCheck() { 
   
    if (document.getElementById('yesCheck').checked) {
      document.getElementById('ifYes').style.display = 'block';
    }
    else{
      document.getElementById('ifYes').style.display = 'none';
    } 
}
</script> 

<script type="text/javascript">
var gallery = 1;
var lot = 0;
var gallery1 = 0;

function add_fields() {
    gallery++;
    var objTo = document.getElementById('gallery_fileds')
    var divtest = document.createElement("div");
    divtest.innerHTML = '<label class="t_space">Gallery Image  ' + gallery +'</label><input type="file" name="gallery[]" class="">';
    
    objTo.appendChild(divtest)
}

imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    blah.src = URL.createObjectURL(file)
  }
}

</script>

@stop
