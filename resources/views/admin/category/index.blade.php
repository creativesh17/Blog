@extends('layouts.admin')
@section('title', 'Category')
@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="block-header">
            <a href="{{route('admin.category.create')}}" class="btn btn-primary waves-effect">
                <i class="material-icons">add</i>
                <span>Add New Category</span>
            </a>
        </div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    All Categories
                <span class="badge bg-blue">{{$categories->count()}}</span>
                </h2>
            </div>
            <div class="body">
                    @if(Session::has('success'))
                    <div class="alert alert-success alert-dismissible alertsuccess" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Success! </strong> Categories has been updated successfully. 
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
                                <th>Category Name</th>
                                <th>Post Count</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key=>$cate)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $cate->cate_name}}</td>
                                <td>{{ $cate->posts->count()}}</td>
                                <td>{{ $cate->created_at}}</td>
                                <td>{{ $cate->updated_at}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.category.edit', $cate->cate_id)}}" class="btn btn-info waves-effect">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <button class="btn btn-danger waves-effect" type="button" onclick="deleteCategory({{ $cate->cate_id }})">
                                        <i class="material-icons">delete</i>
                                    </button>
                                    <form id="delete-form-{{ $cate->cate_id }}" action="{{ route('admin.category.destroy',$cate->cate_id) }}" method="POST" style="display: none;">
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
        function deleteCategory(id) {
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