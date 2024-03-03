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
                                <a href="{{ route('dashboard.index') }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                                    @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.products.index') }}"> @lang('site.products')</a>
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
                    <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <div class="form-group">
                            <label for="products"> @lang('site.products') </label>

                            <select id="products" name="category_id" class="form-control">
                                <option value=""> @lang('site.all_categories') </option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group">
                                {{--  site.ar.name   --}}
                                <label>@lang('site.' . $locale . '.name')</label>

                                {{--  ar[name]   --}}

                                <input type="text" name="{{ $locale }}[name]" class="form-control"
                                    value="{{ old($locale . 'name') }}">
                            </div>
                        @endforeach

                        <div class="form-group">

                            <label>@lang('site.image')</label>


                            <input class="form-control" type="file" name="image" />
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/products_images/default.jpg') }}" width="150px">
                        </div>

                        <div class="form-group">

                            <label>@lang('site.purchase_price')</label>


                            <input class="form-control" type="number" name="purchase_price"
                                value="{{ old('purchase_price') }}" />
                        </div>
                        <div class="form-group">

                            <label>@lang('site.discount')</label>


                            <input class="form-control" type="number" name="discount" value="{{ old('discount') }}" />
                        </div>
                        <div class="form-group">

                            <label>@lang('site.sale_price')</label>


                            <input class="form-control" type="number" name="sale_price" value="{{ old('sale_price') }}" />
                        </div>
                        <div class="form-group">

                            <label>@lang('site.stock')</label>


                            <input class="form-control" type="number" name="stock" value="{{ old('stock') }}" />
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary"><i
                                    class="fa fa-plus"></i>@lang('site.add')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
