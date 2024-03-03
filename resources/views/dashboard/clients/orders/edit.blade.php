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
                                @lang('site.edit')
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('site.edit')</h5>
                </div>
                <div class="card-body">

                    @include('partials.errors')
                    <form action="{{route('dashboard.clients.orders.update' , [$client->id , $order->id])}}"  method="POST" >
                        @csrf
                        {{ @method_field('put')  }}

                        <div><input type="number" name="product" value="{{$order->products()->first()->id}}" class="d-none"></div>

                        <div class="form-group">
                            <label for="name">@lang('site.name')</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $client->name }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">@lang('site.phone')</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $client->phone }}">
                        </div>

                        <div class="form-group">
                            <label for="quantity">@lang('site.quantity')</label>
                            <input type="number" name="quantity" min="1"  id="quantity" class="form-control" value="{{ $order->products->first()->pivot->quantity }}">
                        </div>

                        <div class="form-group">
                            <label for="price">@lang('site.ar.name')</label>
                            <input type="text" name="product_name" class="form-control" value="{{ $order->products()->first()->name  }}">
                        </div>

                        <div class="form-group">
                            <label for="price">@lang('site.image')</label>
                            <img src="{{  asset('uploads/products_images/'. $order->products()->first()->image) }}">
                            <input class="form-control" name="image" type="file">
                        </div>

                        <div class="form-group">
                            <label for="address">@lang('site.address')</label>
                            <input type="text" name="address" id="address" class="form-control" value="{{$client->address}}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary"><i class="fa fa-plus"></i>@lang('site.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@endsection
