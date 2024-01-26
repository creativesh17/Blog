@extends('layouts.admin')
@section('title', 'Post')
@section('content') 

@push('css')

@endpush
<section class="content">
    <a href="{{ route('admin.post.index') }}" class="btn btn-danger waves-effect">Back</a>
    @if ($post->post_approved == 0)
        <button type="button" class=" btn btn-warning waves-effect pull-right" onclick="approvePost({{ $post->post_id }})">
            <i class="material-icons">done</i>
            <span>Approve</span>
        </button>
    <form id="approval-form" action="{{route('admin.post.approve', $post->post_id)}}" method="POST" style="display: none;">
        @csrf
        @method('PUT')
    </form>
    @else
        <button type="button" class=" btn btn-success pull-right" disabled>
            <i class="material-icons">done</i>
            <span>Approved</span>
        </button>
    @endif
    <br><br>

    @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible alertsuccess" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success! </strong> Opeartion Success. 
        </div>
    @endif
    @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible alerterror" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Error! </strong> An error occurred;
        </div>
    @endif

    <div class="container-fluid">
        <div class="block-header">
            <h2><strong>Post</strong></h2>
        </div>
        <div class="row">
            <div class="row clearfix">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                    <div class="card">
                        <div class="header">
                            <h2>{{ $post->post_title }}</h2>
                            <small>Posted by <strong>{{ $post->author->name }}</strong> on {{ $post->created_at->format('d-M, Y | h:i:s a') }}</small>
                        </div>
                        <div class="body">
                            {{$post->post_body}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="card">
                        <div class="header bg-cyan"><h2>Categories</h2></div>
                        <div class="body">
                            @foreach ($post->categories as $category)
                                <span class="label bg-cyan">{{ $category->cate_name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header bg-green"><h2>Tags</h2></div>
                        <div class="body">
                            @foreach ($post->tags as $tag)
                                <span class="label bg-green">{{ $tag->tag_name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="card">
                        <div class="header bg-amber"><h2>Featured Image</h2></div>
                        <div class="body">
                            <img class="img-responsive thumbnail" src="{{ Storage::disk('public')->url('posts/'.$post->post_image) }}" alt="photo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
<script type="text/javascript">
    function approvePost(id) {
        swal({
            title: 'Are you sure?',
            text: "You want to approve this post!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                event.preventDefault();
                document.getElementById('approval-form').submit();
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swal(
                    'Cancelled',
                    'The post is still pending :)',
                    'error'
                )
            }
        })
    }
</script>
@endpush


{{-- {{ Storage::disk('public')->url('post/'.$post->image) }} --}}
{{-- {{asset('storage/posts/'.$post->post_image)}} --}}