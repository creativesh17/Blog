@extends('layouts.admin')
@section('title', 'Settings')
@push('css')

@endpush

@section('content') 
<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Settings</h2>
        </div>

        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Settings
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible alertsuccess" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Success! </strong> 
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible alerterror" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>Error! </strong> An error occurred;
                            </div>
                        @endif
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#profile_with_icon_title" data-toggle="tab">
                                    <i class="material-icons">face</i> PROFILE
                                </a>
                            </li>
                            <li role="presentation" >
                                <a href="#change_password_with_icon_title" data-toggle="tab">
                                    <i class="material-icons">change_history</i> Password
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="profile_with_icon_title">
                                <form method="POST" action="{{ route('author.profile.update') }}" class="form-horizontal" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label {{$errors->has('name') ? ' has-error' : ''}}">
                                            <label for="name">Name : </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}">
                                                    @if ($errors->has('name'))
                                                        <span class="invalid-feedback" alert="role"> 
                                                            <strong>{{$errors->first('name')}}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label {{$errors->has('email') ? ' has-error' : ''}}">
                                            <label for="email">Email Address</label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="text" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}">
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label">
                                            <label for="abot">About : </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <textarea class="form-control" rows="5" name="about" id="about">{{ Auth::user()->about }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label {{$errors->has('photo') ? ' has-error' : ''}}">
                                            <label for="photo">Profile Picture : </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="file" name="photo">
                                                    @if ($errors->has('photo'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('photo') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div role="tabpanel" class="tab-pane fade in" id="change_password_with_icon_title">
                                <form method="POST" action="{{ route('author.password.update') }}" class="form-horizontal">
                                    @csrf
                                    @method('PUT')
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label {{$errors->has('old_password') ? ' has-error' : ''}}">
                                            <label for="old_password">Old Password : </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" name="old_password" id="old_password" class="form-control">
                                                    @if ($errors->has('old_password'))
                                                        <span class="invalid-feedback" alert="role"> 
                                                            <strong>{{$errors->first('old_password')}}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label {{$errors->has('password') ? ' has-error' : ''}}">
                                            <label for="password">New Password : </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" name="password" id="password" class="form-control">
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" alert="role"> 
                                                            <strong>{{$errors->first('password')}}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 form-control-label {{$errors->has('password_confirmation') ? ' has-error' : ''}}">
                                            <label for="password_confirmation">confirm Password : </label>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-8 col-xs-7">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                                                    @if ($errors->has('password_confirmation'))
                                                        <span class="invalid-feedback" alert="role"> 
                                                            <strong>{{$errors->first('password_confirmation')}}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row clearfix">
                                        <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('js')
    
@endpush


