@extends('layouts.admin')
@section('title', 'Post')
@section('content') 

@push('css')
    <link href="{{asset('contents/admin')}}/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
@endpush

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <h2>Post</h2>
        </div>

        <form action="{{route('admin.post.update', $post->post_id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div class="row">
                <div class="row clearfix">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <div class="card">
                            <div class="header">
                                <h2>Update Post</h2>
                            </div>
                            <div class="body">
                                @if(Session::has('success'))
                                    <div class="alert alert-success alert-dismissible alertsuccess" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Success! </strong> Post has been updated successfully. 
                                    </div>
                                @endif
                                @if(Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible alerterror" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Error! </strong> An error occurred;
                                    </div>
                                @endif
                                <div class="form-group form-float {{$errors->has('title') ? ' has-error' : ''}}">
                                    <div class="form-line">
                                        <input type="text" class="form-control" name="title" id="title" value="{{$post->post_title}}">
                                        <label class="form-label">Post Title</label>
                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" alert="role"> 
                                                <strong>{{$errors->first('title')}}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{$errors->has('pic') ? ' has-error' : ''}}">
                                    <label for="">Featured Image</label>
                                    <input type="file" name="pic">
                                    @if ($errors->has('pic'))
                                        <span class="invalid-feedback" alert="role"> 
                                            <strong>{{$errors->first('pic')}}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" class="form-check-input" name="status" id="publish" value="1" {{ $post->post_status == 1 ? 'checked':'' }}>
                                    <label for="publish" class="form-check-label">Publish</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <div class="card">
                            <div class="header"><h2>Categories and Tags</h2></div>
                            <div class="body">
                                <div class="form-group form-float {{$errors->has('category') ? ' has-error' : ''}}">
                                    <div class="form-line">
                                        <label for="category">Select Category</label>
                                        <select name="category[]" id="category" class="form-control show-tick" data-live-search="true" multiple>
                                            @foreach($categories as $category)
                                            <option
                                                @foreach($post->categories as $postCate)
                                                    {{$postCate->cate_id == $category->cate_id ? 'selected':''}}
                                                    {{-- @if($postCate->cate_id == $category->cate_id) selected @endif --}}
                                                @endforeach 
                                                value="{{ $category->cate_id }}">{{ $category->cate_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('category'))
                                            <span class="invalid-feedback" alert="role"> 
                                                <strong>{{$errors->first('category')}}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group form-float {{$errors->has('tag') ? ' has-error' : ''}}">
                                    <div class="form-line">
                                        <label for="tag">Select Tag</label>
                                        <select name="tag[]" id="tag" class="form-control show-tick" data-live-search="true" multiple>
                                            @foreach($tags as $tag)
                                                <option 
                                                    @foreach ($post->tags as $postTag)
                                                        @if($postTag->tag_id == $tag->tag_id)
                                                        selected @endif
                                                    @endforeach 
                                                    value="{{ $tag->tag_id }}">{{ $tag->tag_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tag'))
                                            <span class="invalid-feedback" alert="role"> 
                                                <strong>{{$errors->first('tag')}}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect">SUBMIT</button>
                                <a href="{{route('admin.post.index')}}" type="button" class="btn btn-danger m-t-15 waves-effect">BACK</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h2>Body</h2>
                            </div>
                            <div class="body">
                                <textarea name="body" id="tinymce" cols="30" rows="10">{{$post->post_body}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('js')
<script src="{{asset('contents/admin')}}/plugins/bootstrap-select/js/bootstrap-select.js"></script>
<script src="{{asset('contents/admin')}}/plugins/tinymce/tinymce.js"></script>
<script>
    $(function () {
        //TinyMCE
        tinymce.init({
            selector: "textarea#tinymce",
            theme: "modern",
            height: 300,
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,
            force_br_newlines : true,
            force_p_newlines : false,
            forced_root_block : '',
        });
        tinymce.suffix = ".min";
        tinyMCE.baseURL = "{{asset('contents/admin')}}/plugins/tinymce";
    });
</script>
@endpush