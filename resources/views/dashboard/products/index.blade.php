@extends('layouts.dashboard.app')
@section('content')

<div class="content-wrapper text-right">


    <section class="content">

            <div class="content-header">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>@lang('site.products')</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-left">
                                    <li class="breadcrumb-item">
                                      <a href="{{route('dashboard.index')}}"> <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                                    </li>
                                    <li class="breadcrumb-item active">
                                        @lang('site.products')
                                    </li>

                                </ol>
                            </div>
                        </div>
                    </div>
                </section>

                <form action="{{ route('dashboard.products.index') }}" method="get" >
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" value="{{ request()->search }}"  placeholder="@lang('site.search')" >
                        </div>
                        <div class="col-md-4">
                            <select name="category_id" class="form-control">
                                <option value="">@lang('site.all_categories')</option>

                            @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request()->category_id == $category->id  ? 'selected' :'' }}>{{ $category->name  }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>@lang('site.search')</button>
                            @if(auth()->user()->hasPermission('products_create'))
                            <a href="{{route('dashboard.products.create')}}" class="btn btn-outline-success"><i class="fa fa-plus"></i>@lang('site.add')</a>
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
                <h5 >{{ __('site.products') }}<small class="mr-3">{{ $products->total() }}</small></h5>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                @if ($products->count() > 0)
                <table class="table table-hover text-center">
                    <thead>
                      <tr>
                        <th style="width: 10px">#</th>
                          <th >@lang('site.name')</th>
                          <th >@lang('site.description')</th>
                          <th >@lang('site.image')</th>
                        <th >@lang('site.purchase_price')</th>
                          <th >@lang('site.discount') %</th>

                          <th >@lang('site.sale_price')</th>
                         <th >@lang('site.profit_percent') %</th>
                        <th >@lang('site.stock')</th>

                        <th >@lang('site.action')</th>
                      </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $index=>$product)
                            <tr>
                                <td> {{ $index + 1 }} </td>
                                <td> {{ $product->name }} </td>
                                <td> {!! $product->description !!} </td>
                                <td> <img src="{{ $product->image_path }}" width="100px" height="100px" class="img-thumbnail img-circle"> </td>
                                <td> {{ $product->purchase_price }} </td>
                                <td> {{ $product->discount }} %</td>
                                @if($product->discount > 0)
                                    <td><s > {{ $product->sale_price }} </s> <p>{{ $product->sale_price - $product->discount_count  }}</p></td>

                                @endif
                                <td> {{ $product->profit_percent }} %</td>

                                <td> {{ $product->stock }} </td>

                                <td>
                                    @if(auth()->user()->hasPermission('products_update'))
                                    <a class="btn btn-outline-info btn-sm" href="{{route('dashboard.products.edit' , $product->id  )}}"><i class="fa fa-edit"></i>@lang('site.edit')</a>
                                    @else
                                    <a href="#" class="btn btn-info disabled">@lang('site.edit')</a>
                                    @endif
                                     @if(auth()->user()->hasPermission('products_delete'))

                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#delete{{$product->id}}">
                                                <i class="fa fa-trash"></i> @lang('site.delete')
                                            </button>

                                            <form action="{{route('dashboard.products.destroy',$product->id)}}" method="POST" style="display: inline-block">
                                    @csrf
                                        <!-- Modal -->
                                        <div class="modal fade" id="delete{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h5>@lang('site.delete_body_category') <small>{{ $product->name }}</small></h5>
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
                       {{ $products->appends(request()->query())->links() }}
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
