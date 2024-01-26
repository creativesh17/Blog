@extends('layouts.admin')
@section('title', 'Tag')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <a href="{{route('admin.tag.create')}}" class="btn btn-primary waves-effect">
                <i class="material-icons">add</i>
                <span>Add New Tag</span>
            </a>
        </div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All Tags
                <span class="badge bg-blue">{{$tags->count()}}</span>
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
                        <strong>Success! </strong> Tag has been updated successfully. 
                    </div>
                    @endif
                    @if(Session::has('error'))
                    <div class="alert alert-danger alert-dismissible alerterror" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error!</strong> An error occurred;
                    </div>
                    @endif
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" id="allTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tag Name</th>
                                <th>Post Count</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tags as $key=>$tag)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $tag->tag_name}}</td>
                                <td>{{ $tag->posts->count()}}</td>
                                <td>{{ $tag->created_at}}</td>
                                <td>{{ $tag->updated_at}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.tag.edit', $tag->tag_id)}}" class="btn btn-info waves-effect">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteTag({{ $tag->tag_id }})">
                                        <i class="material-icons">delete</i>
                                    </button>
                                    <form id="delete-form-{{ $tag->tag_id }}" action="{{ route('admin.tag.destroy',$tag->tag_id) }}" method="POST" style="display: none;">
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
        function deleteTag(id) {
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