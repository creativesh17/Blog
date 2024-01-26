@extends('layouts.admin')
@section('title', 'Comments')
@section('content')

<section class="content">
    <div class="container-fluid">

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All Comments
                {{-- <span class="badge bg-blue">{{$posts->comments->count()}}</span> --}}
                </h2>
            </div>
            <div class="body">
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
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="allTable">
                        <thead>
                            <tr>
                                <th class="text-center">Comments Info</th>
                                <th class="text-center">Posts Info</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                @foreach($post->comments as $comment)
                                <tr>
                                    <td>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="{{ Storage::disk('public')->url('profile/'.$comment->user->photo) }}" alt="photo" width="64" height="64">    
                                                </a>    
                                            </div>
                                            <div class="media-body">
                                                <h4>{{ $comment->user->name }}
                                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                                </h4>
                                                <p>{{ $comment->comment }}</p> 
                                                <a target="_blank" href="{{ route('post.details', $comment->post->post_slug."#comments") }}">Reply</a>   
                                            </div>                                            
                                        </div>
                                    </td>
                                    <td>
                                        <div class="media">
                                            <div class="media-right">
                                                <a target="_blank" href="{{ route('post.details', $comment->post->post_slug) }}">
                                                    <img class="media-object" src="{{ Storage::disk('public')->url('posts/'.$comment->post->post_image) }}" alt="photo" width="64" height="64">
                                                </a>    
                                            </div>
                                            <div class="media-body">
                                                <a target="_blank" href="{{ route('post.details', $comment->post->post_slug) }}">
                                                    <h4 class="media-heading">{{ Str::limit($comment->post->post_title, 40) }}</h4>
                                                </a>
                                                <p> by <strong>{{ $comment->post->author->name }}</strong></p>  
                                            </div>                                            
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger waves-effect" onclick="deleteComment({{ $comment->id }})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <form id="delete-form-{{ $comment->id }}" action="{{ route('author.comment.delete', $comment->id) }}" method="POST" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="{{asset('contents/admin')}}/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
    <script src="{{asset('contents/admin')}}/js/pages/tables/jquery-datatable.js"></script>
    <script type="text/javascript">
        // To delete
        function deleteComment(id) {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endpush