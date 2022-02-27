@extends('admin::layouts.master')
@section('title') عرض الكل @endsection
@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('admin::common-components.breadcrumb')
        @slot('title') Orders  @endslot
        @slot('li_1') عرض الكل  @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>Brand Name</th>
                            <th>Service</th>
                            <th>Order From</th>
                            <th>Price</th>
                            <th>Final Price</th>
                            <th>Date</th>
                            <th>Hour</th>
                            <th>Customer Name</th>
                            <th>Mobile</th>
                            <th>Location</th>
                            <th>Employee</th>
                            <th>Evaluation of order</th>
                            <th>Evaluation of employee</th>
                            <th>Chat</th>
                            <th>Invoice</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($rows as $row)
                            <tr>
                                <td>{{$row->brand->title_ar}}</td>
                                <td>{{$row->service->name}}</td>
                                <td>{{$row->created_by}}</td>
                                <td>{{$row->service->price}}</td>
                                <td>{{$row->price}}</td>
                                <td>{{\Carbon\Carbon::parse($row->date)->format('Y-m-d')}}</td>
                                <td>{{$row->time}}</td>
                                <td>{{$row->client_name}}</td>
                                <td>{{$row->client_phone}}</td>
                                <td>
                                    <script async defer
                                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjBZsq9Q11itd0Vjz_05CtBmnxoQIEGK8&&callback=initMap" type="text/javascript">
                                    </script>
                                    @if($row->created_by=='client')
                                        <div class="modal fade" id="showMapModal-{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="showMapModal-{{$row->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showMapModal-{{$row->id}}">location</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div id="map" class="gmaps" style="position: relative; overflow: hidden;" data-lat="{{$row->client_address->address['lat']}}" data-lng="{{$row->client_address->address['lng']}}"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="button" value="location" data-toggle='modal' data-target='#showMapModal-{{$row->id}}' />
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>{{$row->brand_employee?$row->brand_employee->name:'--'}}</td>
                                <td>{{\App\Models\Rate::where('order_id',$row->id)->value('rate')}}</td>
                                <td>{{\App\Models\Rate::where('brand_employee_id',$row->brand_employee_id)->value('rate')}}</td>
                                <td>
                                    <div class="button-list">
                                        <button data-id="{{$row->id}}" data-href="{{ route('admin.order.chat',$row->id) }}" class="btn btn-info waves-effect waves-light">
                                            <i class="fa fa-facebook-messenger"></i> <span>Chat</span>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="button-list">
                                        <a href="{{route('admin.order.invoice',$row->id)}}">
                                            <button class="btn btn-warning waves-effect waves-light">
                                                <i class="fa fa-pen mr-1"></i> <span>Invoice</span>
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
    <script>
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: "هل انت متأكد من الحذف ؟",
                text: "لن تستطيع استعادة هذا العنصر مرة أخرى!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'نعم , قم بالحذف!',
                cancelButtonText: 'ﻻ , الغى عملية الحذف!',
                closeOnConfirm: false,
                closeOnCancel: false,
                preConfirm: () => {
                    $("form[data-id='" + id + "']").submit();
                },
                allowOutsideClick: () => !Swal.isLoading()
            })
        });
    </script>
    <script type="text/javascript">
        let map;
        let marker;
        function initMap() {
            // show map
            let lat_str = document.getElementById('map').getAttribute("data-lat");
            let long_str = document.getElementById('map').getAttribute("data-lng");
            let uluru = {lat:parseFloat(lat_str), lng: parseFloat(long_str)};
            let centerOfOldMap = new google.maps.LatLng(uluru);
            let oldMapOptions = {
                center: centerOfOldMap,
                zoom: 10
            };
            map = new google.maps.Map(document.getElementById('map'), oldMapOptions);
            marker = new google.maps.Marker({position: centerOfOldMap,animation:google.maps.Animation.BOUNCE});
            marker.setMap(map);
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
@endsection
