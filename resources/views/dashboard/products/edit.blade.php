@extends('layouts.dashboard.app')
@section('content')


    <div class="content-wrapper text-right">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('site.products')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.index')}}">  <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.products.index')}}"> @lang('site.products')</a>
                            </li>
                            <li class="breadcrumb-item active">
                                @lang('site.add')
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <h5>@lang('site.add')</h5>
                </div>
                <div class="card-body">

                    @include('partials.errors')
                    <form action="{{route('dashboard.products.update' , $product->id)}}"  method="POST" enctype="multipart/form-data">
                        @csrf
                        {{ @method_field('put')  }}


                        <div class="form-group">
                            <label for="categories" > @lang('site.categories') </label>

                            <select id="categories" name="category_id" class="form-control">
                                <option value="">  @lang('site.all_categories')  </option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id  }}" {{ $product->category_id == $category->id  ? 'selected' :'' }}>{{ $category->name  }}</option>
                                @endforeach
                            </select>
                        </div>
                       @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label >@lang('site.'.$locale. '.name')</label>
                                <input type="text" value="{{  $product->translate($locale)->name }}" name="{{ $locale }}[name]"  class="form-control">
                            </div>
                            <div class="form-group">
                                {{--  site.ar.name   --}}
                                <label >@lang('site.'.$locale. '.description')</label>

                                {{--  ar[name]   --}}

                                <textarea    name="{{$locale}}[description]"    class="form-control ckeditor" >{{$product->translate($locale)->description}}</textarea>
                            </div>
                       @endforeach

                        <div class="form-group">

                            <label>@lang('site.image')</label>


                            <input class="form-control" type="file"  name="image" />
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/products_images/default.jpg') }}" width="150px" >
                        </div>

                        <div class="form-group">

                            <label>@lang('site.purchase_price')</label>


                            <input class="form-control" type="number"  name="purchase_price" value="{{ $product->purchase_price }}" />
                        </div>
                        <div class="form-group">

                            <label>@lang('site.sale_price')</label>


                            <input class="form-control" type="number"  name="sale_price" value="{{ $product->sale_price }}" />
                        </div>
                        <div class="form-group">

                            <label>@lang('site.stock')</label>


                            <input class="form-control" type="number"  name="stock" value="{{ $product->stock }}"  />
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
