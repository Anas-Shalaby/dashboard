@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper text-right">


    <section class="content">

            <div class="content-header">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>@lang('site.clients')</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-left">
                                    <li class="breadcrumb-item">
                                      <a href="{{route('dashboard.index')}}"> <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        @lang('site.clients')
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </section>

                <form action="{{ route('dashboard.clients.index') }}" method="get" >
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" value="{{ request()->search }}" a placeholder="@lang('site.search')" >
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                            @if(auth()->user()->hasPermission('clients_create'))
                            <a href="{{route('dashboard.clients.create')}}" class="btn btn-outline-success"><i class="fa fa-plus"></i>@lang('site.add')</a>
                            @else
                                <a class="btn btn-outline-success disabled" href="#"> <i class="fa fa-plus"></i>@lang('site.add') </a>
                            @endif

                        </div>
                    </div>
                </form>
            </div>



          <div class="card ">
            @include('partials.session')
            <div class="card-header">
                <h5 >{{ __('site.clients') }}<small class="mr-3">{{ $clients->total() }}</small></h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($clients->count() > 0)
                <table class="table table-hover text-center">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                          <th >@lang('site.name')</th>
                        <th >@lang('site.phone')</th>
                        <th >@lang('site.address')</th>
                        <th >@lang('site.add_order')</th>
                        <th >@lang('site.action')</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ($clients as $index=>$client)

                            <tr>
                                <td> {{ $index + 1 }} </td>
                                <td> {{ $client->name }} </td>
                                <td> {{ $client->phone }} </td>
                                <td> {{ $client->address }} </td>
                               @if(auth()->user()->hasPermission('orders_create'))
                                    <td data-toggle="tooltip" data-placement="top" title="اضف طلب"> <a href="{{ route('dashboard.clients.orders.create' , $client->id) }}" class="btn btn-outline-success" >@lang('site.add_order')</a> </td>
                                @else
                                    <td data-toggle="tooltip" data-placement="top" title="اضف طلب"> <a href="#" class="btn btn-outline-success disabled" >@lang('site.add_order')</a> </td>

                                @endif
                                <td>
                                    @if(auth()->user()->hasPermission('clients_update'))
                                    <a class="btn btn-outline-info btn-sm" href="{{route('dashboard.clients.edit' , $client->id  )}}"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                    @else
                                    <a href="#" class="btn btn-info disabled">@lang('site.edit')</a>
                                    @endif
                                     @if(auth()->user()->hasPermission('clients_delete'))

                                            <!-- Button trigger modal -->


                                            <form action="{{route('dashboard.clients.destroy',$client->id)}}" method="POST" style="display: inline-block">

                                    @csrf
                                                <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{$client->id}}">
                                                    <i class="fa fa-trash"></i> @lang('site.delete')
                                                </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="delete{{$client->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>

                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>@lang('site.delete_body_client') <small>{{ $client->name}}</small></h5>
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


                    </tbody>

                  </table>

                   <div class="mt-4">
                       {{ $clients->appends(request()->query())->links() }}
                   </div>

                @else
                  <h2>@lang('site.no_data_found')</h2>
                @endif

            </div>
            <!-- /.card-body -->

          </div>
    </section>
</div>
@endsection
