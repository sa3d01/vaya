@extends('admin::layouts.master')
@section('title') Show All @endsection
@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('admin::common-components.breadcrumb')
        @slot('title') Brand Owners  @endslot
        @slot('li_1') Show All @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('admin.brand_owner.create')}}">
                        <button type="button" class="btn btn-block btn-sm btn-success waves-effect waves-light">Add </button>
                    </a>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Owner Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Brand Name</th>
                            <th>Brand Logo</th>
                            <th>Active</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->phone}}</td>
                                <td>{{$row->email}}</td>
                                <td>{{$row->brand?$row->brand->title_ar:''}}</td>
                                <td data-toggle="modal" data-target="#imgModal{{$row->id}}">
                                    <img width="50px" height="50px" class="img_preview" src="{{ $row->avatar}}">
                                </td>
                                <div id="imgModal{{$row->id}}" class="modal fade" role="img">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <img data-toggle="modal" data-target="#imgModal{{$row->id}}" class="img-preview" src="{{ $row->avatar}}" style="max-height: 500px">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">exit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <td>
                                    <div class="button-list">
                                        @if($row->banned==0)
                                            <button data-id="{{$row->id}}" data-href="{{ route('admin.brand_owner.ban',$row->id) }}" class="ban btn btn-danger waves-effect waves-light">
                                                <i class="fa fa-archive mr-1"></i> <span>block</span>
                                            </button>
                                        @else
                                            <button data-id="{{$row->id}}" data-href="{{ route('admin.brand_owner.activate',$row->id) }}" class="activate btn btn-success waves-effect waves-light">
                                                <i class="fa fa-user-clock mr-1"></i> <span>activate</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="button-list">
                                        <a href="{{route('admin.brand_owner.edit',$row->id)}}">
                                            <button class="btn btn-warning waves-effect waves-light">
                                                <i class="fa fa-pen mr-1"></i> <span>Edit</span>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="button-list">
                                        <form class="delete" data-id="{{$row->id}}" method="POST" action="{{ route('admin.brand_owner.destroy',[$row->id]) }}">
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" value="{{$row->id}}">
                                            <button type="button" class="btn p-0 no-bg">
                                                <i class="fa fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection
@section('script')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>
    <!-- Datatable init js -->
    <script src="{{ URL::asset('/js/pages/datatables.init.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(document).on('click', '.ban', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: "?????????? ?????????? ?????????? ??",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: '?????? !',
                cancelButtonText: '??? , ???????? ??????????????!',
                closeOnConfirm: false,
                closeOnCancel: false,
                preConfirm: () => {
                    $.ajax({
                        url: $(this).data('href'),
                        type:'GET',
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then(() => {
                location.reload();
            })
        });
        $(document).on('click', '.activate', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: "?????????? ?????????? ?????????????? ??",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: '?????? !',
                cancelButtonText: '??? , ???????? ??????????????!',
                closeOnConfirm: false,
                closeOnCancel: false,
                preConfirm: () => {
                    $.ajax({
                        url: $(this).data('href'),
                        type:'GET',
                    })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then(() => {
                location.reload();
            })
        });
    </script>
    <script>
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: "???? ?????? ?????????? ???? ?????????? ??",
                text: "???? ???????????? ?????????????? ?????? ???????????? ?????? ????????!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: '?????? , ???? ????????????!',
                cancelButtonText: '??? , ???????? ?????????? ??????????!',
                closeOnConfirm: false,
                closeOnCancel: false,
                preConfirm: () => {
                    $("form[data-id='" + id + "']").submit();
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        });
    </script>
@endsection
