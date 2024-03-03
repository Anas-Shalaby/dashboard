@extends('layouts.dashboard.app')
@section('content')


    <div class="content-wrapper text-right">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('site.users')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-left">
                            <li class="breadcrumb-item">
                              <a href="{{route('dashboard.index')}}">  <i class="nav-icon fas fa-tachometer-alt"></i>  @lang('site.dashboard')</a>
                            </li>
                            <li class="breadcrumb-item">
                               <a href="{{route('dashboard.users.index')}}"> @lang('site.users')</a>
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
                    <form action="{{route('dashboard.users.store')}}"  method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label >@lang('site.first_name')</label>
                            <input type="text" name="first_name"  class="form-control" value="{{old('first_name')}}">
                        </div>
                        <div class="form-group">
                            <label >@lang('site.last_name')</label>
                            <input type="text" name="last_name"  class="form-control" value="{{old('last_name')}}">
                        </div>
                        <div class="form-group">
                            <label >@lang('site.email')</label>
                            <input type="email" name="email"  class="form-control" value="{{old('email')}}">
                        </div>
                        <div class="form-group">
                            <label >@lang('site.password')</label>
                            <input type="password" name="password"  class="form-control" >
                        </div>
                        <div class="form-group">
                            <label >@lang('site.password_confirmation')</label>
                            <input type="password" name="password_confirmation"  class="form-control" >
                        </div>
                        <div class="form-group">

                            <label>@lang('site.image')</label>


                            <input class="form-control" type="file"  name="image" />
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('uploads/users_images/default.png') }}" width="100px" >
                        </div>
                        <div class="form-group">
                            <label for="">@lang('site.permissions')</label>
                            <div class="card">
                                <div class="card-header d-flex p-0">


                                    @php
                                     $models = ['users' , 'categories' , 'products' , 'clients' , 'orders'] ;
                                     $maps  = ['create' , 'read' , 'update' , 'delete'];
                                    @endphp

                                  <ul class="nav nav-pills  p-2">
                                    @foreach ($models as $index=>$model)
                                    <li class="nav-item">
                                        <a class="nav-link {{ $index == 0 ? 'active' : '' }}" href="#{{$model}}" data-toggle="tab">@lang('site.' . $model)</a>
                                    </li>

                                    @endforeach

                                  </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                  <div class="tab-content">
                                    @foreach ($models as $index => $model)
                                    <div class="tab-pane {{ $index == 0 ? 'active' : '' }}  " id="{{ $model }}">


                                        @foreach($maps as $map)
                                        <label class="mx-2" ><input type="checkbox" name="permissions[]" value={{$model  ."_".$map}}>@lang('site.'.$map)</label>
                                        @endforeach

                                    </div>
                                    @endforeach

                                  </div>
                                </div><!-- /.card-body -->
                              </div>
                        </div>



                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

@endsection
