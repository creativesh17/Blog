@extends('layouts.admin')
@section('title', 'Tag')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Tag</h2>
        </div>

<div class="row">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Update TAG</h2>
                </div>
                <div class="body">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible alertsuccess" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success! </strong> Tag has been updated successfully. 
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible alerterror" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> An error occurred;
                        </div>
                        @endif
                    <form action="{{route('admin.tag.update', $data->tag_id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group form-float {{$errors->has('name') ? ' has-error' : ''}}">
                            <div class="form-line">
                                <input type="text" class="form-control" name="name" id="name" value="{{$data->tag_name}}">
                                <label class="form-label">Tag Name</label>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" alert="role"> 
                                        <strong>{{$errors->first('name')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                        <a href="{{route('admin.tag.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">BACK</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Vertical Layout | With Floating Label -->
</div>

@endsection

@push('js')
    
    
@endpush