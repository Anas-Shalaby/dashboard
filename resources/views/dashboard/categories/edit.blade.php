@extends('layouts.dashboard.app')
@section('content')


    <div class="content-wrapper text-right">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('site.categories')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.index')}}">  <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.categories.index')}}"> @lang('site.categories')</a>
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
                    <form action="{{route('dashboard.categories.update' , $category->id)}}"  method="POST" >
                        @csrf
                        {{ @method_field('put')  }}
                       @foreach(config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label >@lang('site.'.$locale. '.name')</label>
                                <input type="text" value="{{  $category->translate($locale)->name }}" name="{{ $locale }}[name]"  class="form-control">
                            </div>
                       @endforeach

                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary"><i class="fa fa-plus"></i>@lang('site.edit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@endsection
