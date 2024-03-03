@extends('layouts.dashboard.app')
@section('content')


    <div class="content-wrapper text-right">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('site.orders')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.index')}}">  <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.clients.index')}}"> @lang('site.clients')</a>
                            </li>
                                                        <li class="breadcrumb-item">
                                                           <a href="{{route('dashboard.orders.index')}}"> @lang('site.orders')</a>
                                                        </li>
                            <li class="breadcrumb-item active">
                                @lang('site.details')
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content ">
                <div class="card">

                    <div class="card-body" id="print-area">
                        <div class="row">
                            <div class="col-md-4">
                                <h5>@lang('site.order_number'): <span>{{  $order->id }}</span></h5>
                                <h5 class="mb-3">@lang('site.name') : <span>{{ $client->name }}</span></h5>
                            </div>
                            <div class="col-md-4">
                                <h5 class="mb-3"> @lang('site.order_time') : <span>{{ $order->created_at->toFormattedDateString() }}</span></h5>
                                <h5>@lang('site.phone') : <span>{{ $client->phone }}</span></h5>
                            </div>
                            <div class="col-md-4">
                                <h5>@lang('site.address') : <span>{{$client->address}}</span></h5>
                            </div>
                        </div>

                        <hr>
                        <table class="table table-hover">
                            <thead>
                            <tr>

                                <th >@lang('site.product_name')</th>
                                <th >@lang('site.category_name')</th>
                                <th>@lang('site.quantity')</th>
                                <th >@lang('site.price')</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->products->first()->name}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>{{$order->products->first()->pivot->quantity}}</td>
                                    <td>${{$order->total_price}}</td>

                                </tr>

                            </tbody>

                        </table>
                    </div>
                    <button class="btn btn-success print-btn  add-form-btn w-100" ><i class="fa fa-print"></i>@lang('site.print')</button>

                </div>




        </section>



    </div>

@endsection
