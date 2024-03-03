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
                                <a href="{{ route('dashboard.index') }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                                    @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.clients.index') }}"> @lang('site.clients')</a>
                            </li>
                            {{--                            <li class="breadcrumb-item"> --}}
                            {{--                               <a href="{{route('dashboard.orders.index')}}"> @lang('site.orders')</a> --}}
                            {{--                            </li> --}}
                            <li class="breadcrumb-item active">
                                @lang('site.add_order')
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content ">
            <div class="row ">
                <div class=" card col-6 ">
                    <div class="card-header border-primary">
                        <h5>@lang('site.categories')</h5>
                    </div>
                    @if ($categories->count() > 0)
                        @foreach ($categories as $category)
                            <div class="card collapsed-card">

                                <div class="card-header row ">
                                    <a class="btn btn-outline-primary" role="button" aria-expanded="false"
                                        href="#{{ str_replace(' ', '-', "$category->name") }}" style="cursor: pointer"
                                        aria-controls="{{ str_replace(' ', '-', "$category->name") }}"
                                        data-card-widget="collapse">{{ $category->name }}</a>
                                </div>
                                <div class="card-body  collapse" id="{{ str_replace(' ', '-', "$category->name") }}">
                                    @if ($category->products->count() > 0)
                                        <table class="table table-borderless">
                                            <tr>
                                                <th>@lang('site.name')</th>
                                                <th>@lang('site.stock')</th>
                                                <th>@lang('site.price')</th>
                                                <th>@lang('site.action')</th>

                                            </tr>

                                            @foreach ($category->products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>{{ $product->sale_price - $product->discount_count }}</td>
                                                    <td>
                                                        <a href="#" data-id="{{ $product->id }}"
                                                            data-name="{{ $product->name }}"
                                                            data-price="{{ $product->sale_price - $product->discount_count }}"
                                                            class="btn btn-success btn-sm add-product-btn {{ $product->id }}">
                                                            {{ __('site.add') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>


                            </div>
                        @endforeach
                    @endif


                </div>


                <div class="col-6 card ">
                    <form method="post" action="{{ route('dashboard.clients.orders.store', $client->id) }}">
                        @csrf
                        {{ method_field('post') }}
                        <div class="card-header border-primary">
                            <h5>@lang('site.orders')</h5>
                        </div>
                        <div class="card-body  row ">


                            <table class="table table-borderless">

                                <thead>
                                    <th>
                                        <h5>@lang('site.products')</h5>
                                    </th>
                                    <th>
                                        <h5>@lang('site.quantity')</h5>
                                    </th>
                                    <th>
                                        <h5>@lang('site.price')</h5>
                                    </th>
                                    <th>
                                        <h5>@lang('site.action')</h5>
                                    </th>
                                </thead>

                                <tbody class="order-list">

                                </tbody>




                            </table>


                        </div>

                        <div>
                            <h5 class="sum-products">@lang('site.total') :
                                <span class="sum"></span>
                            </h5>

                        </div>



                        <div>
                            <button class="btn btn-success disabled add-form-btn w-100" type="submit"><i
                                    class="fa fa-plus"></i>@lang('site.add_order')</button>
                        </div>
                    </form>
                </div>
            </div>

        </section>
    </div>

@endsection
