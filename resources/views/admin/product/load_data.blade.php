<thead>
<tr>
    <th width="5%" class="text-center">{!! lang('common.id') !!}</th>
    <th>{!! lang('common.name') !!}</th>
    <th>SKU</th>
    <th class="text-center">Category</th>
    <th class="text-center">Offer Price</th>
    <th class="text-center">Regular Price</th>
    <!-- <th class="text-center">Quantity</th> -->
    <th width="6%" class="text-center"> {!! lang('common.status') !!} </th>
    <th class="text-center">{!! lang('common.action') !!}</th>
</tr>
</thead>
<tbody>
<?php $index = 1; ?>
@foreach($data as $detail)

<tr id="order_{{ $detail->id }}">
    <td class="text-center">{!! pageIndex($index++, $page, $perPage) !!}</td>
    <td><a href="{!! route('product.edit', [$detail->id]) !!}">{{ str_limit($detail->name,60)}} </a> </td>
    <td>{!! $detail->sku !!}</td>
    <td class="text-center">{!! $detail->category !!}@if($detail->cat2), {{ $detail->cat2  }},@endif @if($detail->cat3) {{ $detail->cat3  }},@endif @if($detail->cat4) {{ $detail->cat4  }},@endif @if($detail->cat5) {{ $detail->cat5  }} @endif @if($detail->cat6), {{ $detail->cat6  }} @endif</td>
    <td class="text-center">{!! $detail->offer_price !!}</td>
    <td class="text-center">{!! $detail->regular_price !!}</td>
     <!--  <td class="text-center">{{ $detail->quantity }}</td> -->
    <td class="text-center">
        <a href="javascript:void(0);" class="toggle-status" data-message="{!! lang('messages.change_status') !!}" data-route="{!! route('product.toggle', $detail->id) !!}" title="@if($detail->status == 0) Deactive @else Active @endif">
            {!! HTML::image('images/' . $detail->status . '.gif') !!}
        </a>
    </td>
    <td class="text-center col-md-1">
        <a class="btn btn-xs btn-primary" href="{{ route('product.edit', [$detail->id]) }}"><i class="fa fa-edit"></i></a>
    </td>    
</tr>

@endforeach
@if (count($data) < 1)
<tr>
    <td class="text-center" colspan="9"> {!! lang('messages.no_data_found') !!} </td>
</tr>
@else
<tr>
    <td colspan="11">
        {!! paginationControls($page, $total, $perPage) !!}
    </td>
</tr>
@endif
</tbody>