@extends('layouts.admin')
@section('title', 'Post')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <a href="{{route('author.post.create')}}" class="btn btn-primary waves-effect">
                <i class="material-icons">add</i>
                <span>Add New Post</span>
            </a>
        </div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All Posts
                <span class="badge bg-blue">{{$posts->count()}}</span>
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
                @if(Session::has('warning'))
                    <div class="alert alert-danger alert-dismissible alerterror" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Warning! </strong> You are not allowed to view or edit or delete this post!
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="allTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Body</th>
                                <th>Author</th>
                                <th><i class="material-icons">visibility</i></th>
                                <th>Is Approved</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $key=>$post)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ Str::words($post->post_title, 3)}}</td>
                                <td>{{ Str::words($post->post_body, 2)}}</td>
                                <td>{{ $post->author->name}}</td>
                                <td>{{ $post->view_count}}</td>
                                <td>
                                    @if ($post->post_approved == 1)
                                        <span class="badge bg-blue">Approved</span>
                                    @else
                                        <span class="badge bg-pink">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($post->post_status == 1)
                                        <span class="badge bg-blue">Published</span>
                                    @else
                                        <span class="badge bg-pink">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d-M, | h:i:s a') }}</td>
                                <td class="text-center">
                                    <a href="{{route('author.post.show', $post->post_id)}}" class="btn btn-info waves-effect" style="margin: 2px;">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                    <a href="{{route('author.post.edit', $post->post_id)}}" class="btn btn-info waves-effect" style="margin: 2px;">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <button class="btn btn-danger waves-effect" type="button" onclick="deletePost({{ $post->post_id }})" style="margin: 2px;">
                                        <i class="material-icons">delete</i>
                                    </button>
                                    <form id="delete-form-{{ $post->post_id }}" action="{{ route('author.post.destroy',$post->post_id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
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
        function deletePost(id) {
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