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
                                <a href="{{ route('dashboard.index') }}"> <i class="nav-icon fas fa-tachometer-alt"></i>
                                    @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.categories.index') }}"> @lang('site.categories')</a>
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
                    <form action="{{ route('dashboard.categories.store') }}" method="POST" e>
                        @csrf
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
                            <button type="submit" class="btn btn-outline-primary"><i
                                    class="fa fa-plus"></i>@lang('site.add')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
