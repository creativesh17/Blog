@extends('layouts.admin')
@section('title', 'Category')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Category</h2>
        </div>

<div class="row">
    <!-- Vertical Layout | With Floating Label -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Update CATEGORY</h2>
                </div>
                <div class="body">
                        @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible alertsuccess" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Success! </strong> Category has been updated successfully. 
                        </div>
                        @endif
                        @if(Session::has('error'))
                        <div class="alert alert-danger alert-dismissible alerterror" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong>Error!</strong> An error occurred;
                        </div>
                        @endif
                    <form action="{{route('admin.category.update', $category->cate_id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group form-float {{$errors->has('name') ? ' has-error' : ''}}">
                            <div class="form-line">
                                <input type="hidden" class="form-control" name="slug" id="slug" value="{{$category->cate_slug}}">
                                <input type="text" class="form-control" name="name" id="name" value="{{$category->cate_name}}">
                                <label class="form-label">Category Name</label>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" alert="role"> 
                                        <strong>{{$errors->first('name')}}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{$errors->has('pic') ? ' has-error' : ''}}">
                            <input type="file" name="pic">
                            @if ($errors->has('pic'))
                                <span class="invalid-feedback" alert="role"> 
                                    <strong>{{$errors->first('pic')}}</strong>
                                </span>
                            @endif
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                        <a href="{{route('admin.category.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">BACK</a>
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