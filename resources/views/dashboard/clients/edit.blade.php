@extends('layouts.dashboard.app')
@section('content')


    <div class="content-wrapper text-right">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('site.clients')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.index')}}">  <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{route('dashboard.clients.index')}}"> @lang('site.clients')</a>
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
                    <form action="{{route('dashboard.clients.update' , $client->id)}}"  method="POST" >
                        @csrf
                        {{ @method_field('put')  }}
                        <div class="form-group">
                            <label for="name">@lang('site.name')</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $client->name }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">@lang('site.phone')</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $client->phone }}">
                        </div>

                        <div class="form-group">
                            <label for="name">@lang('site.gender')</label>
                            @php $genders= ['ذكر' , 'انثي'];  @endphp
                            <select name="gender" class="form-control" id="gender">
                                @foreach($genders as $gender )
                                    <option value="{{$gender}}" {{ $client->gender == $gender ? 'selected' :'' }}>{{$gender}}</option>
                                @endforeach
                            </select>
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
