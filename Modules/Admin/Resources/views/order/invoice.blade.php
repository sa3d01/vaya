@extends('admin::layouts.master')
@section('title')  Invoice @endsection
@section('content')
    @component('admin::common-components.breadcrumb')
         @slot('title')  Invoice  @endslot
         @slot('li_1') {{$order->id}}  @endslot
     @endcomponent
     <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="invoice-title">
                    <h4 class="float-right font-size-16"> # {{$order->id}}</h4>
                </div>
                <hr>
                <div class="row">
                    <div class="col-4">
                        <address>
                                <h4>Client Info</h4>
                                <br>
                                <b>Name:</b>
                                {{$order->client_name}}
                                <br>
                                <b>Phone:</b>
                                {{$order->client_phone}}
                                <br>
                                @if($order->created_by=='client')
                                <b>Address:</b>
                                {{$order->client_address->address['address']}}
                                @endif
                        </address>
                    </div>
                    <div class="col-4">
                        <address>
                                <h4>Brand Info</h4>
                                <br>
                                <b>Name:</b>
                                {{$order->brand->title_en}}
                                <br>
                                <b>Phone:</b>
                                {{$order->brand->phone}}
                        </address>
                    </div>
                    <div class="col-4">
                        <address>
                                <h4>Employee Info</h4>
                                @if($order->brand_employee)
                                <br>
                                <b>Name:</b>
                                {{$order->brand_employee->name}}
                                <br>
                                <b>Phone:</b>
                                {{$order->brand_employee->phone}}
                                @else
                                    not assigned yet
                                @endif
                        </address>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6 mt-3">
                        <b>Created From:</b>
                        {{$order->created_by}}
                        <br>
                        <b>Date:</b>
                        {{\Carbon\Carbon::parse($order->date)->format('Y-M-d')}}
                        <br>
                        <b>Time</b>
                        {{$order->time}}
                    </div>
                </div>
                <div class="py-2 mt-3">
                    <h3 class="font-size-15 font-weight-bold">details</h3>
                </div>
                <div class="table-responsive">
                    <table class="table table-nowrap">
                        <thead>
                            <tr>
                                <th>service name</th>
                                <th>service description</th>
                                <th>period</th>
                                <th>price</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{$order->service->name}}</td>
                            <td>{{$order->service->description}}</td>
                            <td>{{(int)$order->service->period}}</td>
                            <td>{{(int)$order->service->price}}</td>
                        </tr>
                            <tr>
                                <td colspan="2" class="text-right">
                                    <h2>Subtotal</h2>
                                </td>
                                <td class="text-right">
                                    <h4 class="m-0">{{$order->service->price}} SR </h4>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-0 text-right">
                                    <h2>Discount</h2></td>
                                <td class="border-0 text-right">
                                    <h4 class="m-0">{{$order->service->price - $order->price}} SR </h4>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-0 text-right">
                                    <h2>Total</h2>
                                </td>
                                <td class="border-0 text-right">
                                    <h4 class="m-0">{{$order->price}} SR </h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-print-none">
                    <div class="float-right">
                        <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
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
