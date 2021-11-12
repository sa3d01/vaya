@extends('admin::layouts.master')
@section('title') Show All @endsection
@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('admin::common-components.breadcrumb')
        @slot('title') Promo Codes  @endslot
        @slot('li_1') Show All @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('admin.promo_code.create')}}">
                        <button type="button" class="btn btn-block btn-sm btn-success waves-effect waves-light">Add </button>
                    </a>
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>No. of usage</th>
                            <th>No. of customer usage</th>
                            <th>Active</th>
                            <th>Edit</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$row->name}}</td>
                                <td>{{$row->code}}</td>
                                <td>{{$row->start_date}}</td>
                                <td>{{$row->end_date}}</td>
                                <td>{{$row->type}}</td>
                                <td>{{$row->value}}</td>
                                <td>0</td>
                                <td>0</td>
                                <td>
                                    <div class="button-list">
                                        @if($row->banned==0)
                                            <button data-id="{{$row->id}}" data-href="{{ route('admin.promo_code.ban',$row->id) }}" class="ban btn btn-danger waves-effect waves-light">
                                                <i class="fa fa-archive mr-1"></i> <span>block</span>
                                            </button>
                                        @else
                                            <button data-id="{{$row->id}}" data-href="{{ route('admin.promo_code.activate',$row->id) }}" class="activate btn btn-success waves-effect waves-light">
                                                <i class="fa fa-user-clock mr-1"></i> <span>activate</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="button-list">
                                        <a href="{{route('admin.promo_code.edit',$row->id)}}">
                                            <button class="btn btn-warning waves-effect waves-light">
                                                <i class="fa fa-pen mr-1"></i> <span>Edit</span>
                                            </button>
                                        </a>
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
                title: "تأكيد عملية الحظر ؟",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'نعم !',
                cancelButtonText: 'ﻻ , الغى العملية!',
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
                title: "تأكيد عملية التفعيل ؟",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'نعم !',
                cancelButtonText: 'ﻻ , الغى العملية!',
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
@endsection
