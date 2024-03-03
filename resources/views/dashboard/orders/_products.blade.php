
<div >

    <table class="table table-bordered">
        <thead>
            <tr>

                <th>@lang('site.name')</th>
                <th>@lang('site.quantity')</th>
                <th>@lang('site.price')</th>
            </tr>
        </thead>


        <tbody>

            @foreach($products as $product)
                <tr>
                    <td> {{$product->name}} </td>
                    <td> {{$product->pivot->quantity}} </td>
                    <td> {{ ($product->sale_price - $product->discount_count) * $product->pivot->quantity }} </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    <h3>@lang('site.total')<span>{{number_format($order->total_price , 2)}}</span></h3>




</div>
<a class="btn btn-outline-primary   add-form-btn w-100" href="{{route('dashboard.clients.orders.details' , [$order->client->id , $order->id])}}">@lang('site.details')</a>
