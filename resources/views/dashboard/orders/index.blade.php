@extends('layouts.dashboard.app')
@section('content')

    <div class="content-wrapper text-right">


        <section class="content">

            <div class="content-header">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>@lang('site.orders')</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-left">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('dashboard.index')}}"> <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        @lang('site.orders')
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </section>

                <form action="{{ route('dashboard.orders.index') }}" method="get" >
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" value="{{ request()->search }}"  placeholder="@lang('site.search')" >
                        </div>
{{--                        <div class="col-md-4">--}}
{{--                            <select name="category_id" class="form-control">--}}
{{--                                <option value="">@lang('site.all_categories')</option>--}}

{{--                                @foreach($categories as $category)--}}
{{--                                    <option value="{{ $category->id }}" {{ request()->category_id == $category->id  ? 'selected' :'' }}>{{ $category->name  }} </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>


                        </div>
                    </div>
                </form>
            </div>


           <div class="row">
               <div class="card col-md-8">
                   @include('partials.session')
                   <div class="card-header">
                       <h5 >{{ __('site.orders') }}<small class="mr-3">{{ $orders->total() }}</small></h5>
                   </div>
                   <!-- /.card-header -->
                   <div class="card-body">
                       @if ($orders->count() > 0)
                           <table class="table table-hover text-center">
                               <thead>
                               <tr>
                                   <th style="width: 10px">#</th>
                                   <th >@lang('site.client_name')</th>
                                   <th >@lang('site.status')</th>
                                   <th >@lang('site.created_at')</th>
                                   <th >@lang('site.action')</th>
                               </tr>
                               </thead>
                               <tbody>
                               @if($orders->count()  > 0)

                                   @foreach ($orders as $index=>$order)
                                       <tr>
                                           <td> {{ $index + 1 }} </td>
                                           <td> {{ $order->client->name }} </td>
                                            <td>
                                            <form action="{{route('dashboard.orders.update_status' , $order->id)}}" method="POST">
                                                @csrf
                                                {{ method_field('PUT') }}
                                                @if($order->isCanceled == false)
                                                    <button
                                                        data-status = "@lang('site.' . $order->status)"
                                                        data-url="{{route('dashboard.orders.update_status' , $order->id)}}"
                                                        class="order-status-btn btn text-white {{ $order->status == 'uncompleted' ? 'btn-warning' : 'btn-success disabled' }} btn-sm"
                                                    >
                                                        @lang('site.' . $order->status)

                                                    </button>
                                                @else
                                                    <button class="btn btn-danger disabled btn-sm">
                                                        @lang('site.order_canceled')
                                                    </button>
                                                @endif
                                            </form>
                                           </td>
                                           <td>{{ $order->created_at->toFormattedDateString() }}</td>

                                           <td>
                                               <button class="btn btn-primary btn-sm order-products"
                                                       data-url="{{ route('dashboard.orders.products', $order->id) }}"
                                                       data-method="get"
                                               >
                                                   <i class="fa fa-list"></i>
                                                   @lang('site.show')
                                               </button>
                                               @if(auth()->user()->hasPermission('orders_update'))
                                                   <a class="btn btn-outline-info btn-sm" href="{{route('dashboard.clients.orders.edit' , [$order->client->id,$order->id ] )}}"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                               @else
                                                   <a href="#" class="btn btn-info disabled">@lang('site.edit')</a>
                                               @endif
                                               @if(auth()->user()->hasPermission('orders_delete'))

                                                   <!-- Button trigger modal -->
                                                   <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{$order->id}}">
                                                       <i class="fa fa-trash"></i> @lang('site.canceled')
                                                   </button>

                                                   <form action="{{route('dashboard.orders.destroy',$order->id)}}" method="POST" style="display: inline-block">
                                                       @csrf
                                                       <!-- Modal -->
                                                       <div class="modal fade" id="delete{{$order->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                           <div class="modal-dialog">
                                                               <div class="modal-content">
                                                                   <div class="modal-header">
                                                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                           <span aria-hidden="true">&times;</span>
                                                                       </button>
                                                                   </div>
                                                                   <div class="modal-body">
                                                                       <h5>@lang('site.delete_body_order') <small>{{ $order->client->name }}</small></h5>
                                                                   </div>
                                                                   <div class="modal-footer">
                                                                       <button type="button" class="btn btn-outline-primary" data-dismiss="modal">@lang('site.close')</button>
                                                                       <button type="submit" class="btn btn-outline-danger btn-sm" ><i class="fa fa-trash"></i> @lang('site.confirm_delete')</button>                                                    </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       {{ method_field('delete') }}

                                                   </form>
                                               @else

                                                   <button class="btn btn-danger disabled">@lang('site.delete')</button>
                                               @endif
                                           </td>
                                       </tr>
                                   @endforeach
                               @else

                                   <div class="box-body">
                                       <h3>@lang('site.no_records')</h3>
                                   </div>

                               @endif


                               </tbody>

                           </table>

                           <div class="mt-4">
                               {{ $orders->appends(request()->query())->links() }}
                           </div>

                       @else
                           <h2>@lang('site.no_data_found')</h2>
                       @endif

                   </div>
                   <!-- /.card-body -->

               </div>
               <div class="card col-md-4">

                   <div class="card-header">
                       <h5>@lang('site.show_orders')</h5>
                   </div>

                   <div class="card-body ">

                       <div style="display: none; flex-direction: column ; align-items: center" id="loading">
                           <div class="loader"></div>
                           <p style="">@lang('site.loading')</p>
                       </div>
                       <div id="order-products-list"></div>

                   </div>


               </div>
           </div>
        </section>
    </div>
@endsection
