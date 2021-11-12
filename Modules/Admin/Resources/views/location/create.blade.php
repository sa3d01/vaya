@extends('admin::layouts.master')
@section('title') Add Location @endsection
@section('css')
<link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{URL::asset('libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}" rel="stylesheet" />
<link href="{{asset('libs/dropify/dist/css/dropify.min.css')}}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
 @component('admin::common-components.breadcrumb')
         @slot('title') Locations  @endslot
         @slot('li_1') Add Location  @endslot
 @endcomponent
 @if($errors->any())
     <div class="alert alert-danger" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
         @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
         @endforeach
     </div>
 @endif
 <form method="POST" action="{{route('admin.location.store')}}" enctype="multipart/form-data" data-parsley-validate novalidate>
     @csrf
     @method('POST')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Name ar</label>
                            <input required type="text" class="form-control" maxlength="50" name="title_ar" id="alloptions" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Name en</label>
                            <input required type="text" class="form-control" maxlength="50" name="title_en" id="alloptions" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div id="map" class="polygon-map gmaps"></div>
                        <input type="hidden" id="Form-field-Zone-area" name="polygon">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <button class="btn btn-primary waves-effect waves-light mr-12" type="submit">
                    Submit
                </button>
            </div>
        </div>
    </form>
<!-- end row -->


<!-- end row -->
@endsection

@section('script')

<script src="{{URL::asset('/libs/select2/select2.min.js')}}"></script>
<script src="{{URL::asset('/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
<script src="{{URL::asset('/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<script src="{{URL::asset('/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
<script src="{{URL::asset('/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>

<!-- form advanced init -->
<script src="{{URL::asset('/js/pages/form-advanced.init.js')}}"></script>

<script src="{{asset('/libs/dropify/dist/js/dropify.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/wicket/1.3.2/wicket.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wicket/1.3.2/wicket-gmap3.js"></script>

<script>
    var drawingManager;
    var selectedShape;
    var map;
    var wkt = new Wkt.Wkt();
    var wkt2 = new Wkt.Wkt();

    function clearSelection() {
        if (selectedShape) {
            selectedShape.setEditable(false);
            selectedShape = null;
        }
    }

    function setSelection(shape) {
        clearSelection();
        selectedShape = shape;
        shape.setEditable(true);
    }

    function deleteSelectedShape(e) {
        if (selectedShape && e.keyCode==46) {
            selectedShape.setMap(null);
        }
        // To show:
        drawingManager.setOptions({
            drawingControl: true
        });
        drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
    }
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 21.2854, lng: 39.2376},
            zoom: 8,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDefaultUI: true,
            zoomControl: true
        });

        drawingManager = new google.maps.drawing.DrawingManager({
            drawingMode: google.maps.drawing.OverlayType.POLYGON,
            drawingControl: true,
            drawingControlOptions: {
                position: google.maps.ControlPosition.TOP_CENTER,
                drawingModes: ['polygon', 'rectangle']
            },
            markerOptions: {icon: 'https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png'},
            circleOptions: {
                fillColor: '#ffff00',
                fillOpacity: 1,
                strokeWeight: 5,
                clickable: false,
                editable: true,
                zIndex: 1
            }
        });
        drawingManager.setMap(map);
        google.maps.event.addListener(drawingManager, 'overlaycomplete', function(e) {
            console.log('drawing completed');
            if (e.type != google.maps.drawing.OverlayType.MARKER) {
                // Switch back to non-drawing mode after drawing a shape.
                drawingManager.setDrawingMode(null);
                // To hide:
                drawingManager.setOptions({
                    drawingControl: false
                });

                // Add an event listener that selects the newly-drawn shape when the user
                // mouses down on it.
                var newShape = e.overlay;
                newShape.type = e.type;
                google.maps.event.addListener(newShape, 'click', function() {
                    setSelection(newShape);
                });
                setSelection(newShape);
                wkt.fromObject(e.overlay);
                console.log(wkt.write());
                $('#Form-field-Zone-area').val(wkt.write());
                wkt2.fromObject(newShape);
                overlayClickListener(newShape);
            }
        });


        function overlayClickListener(overlay) {
            google.maps.event.addListener(overlay, "mouseup", function(event){

                wkt2.fromObject(overlay);
                $('#Form-field-Zone-area').val(wkt2.write());
                console.log(wkt2.write());

                // $('#vertices').val(wkt2.write());
            });
        }
// Clear the current selection when the drawing mode is changed, or when the
// map is clicked.
// google.maps.event.addListener(drawingManager, 'drawingmode_changed', clearSelection);
// google.maps.event.addListener(map, 'click', clearSelection);
// google.maps.event.addListener(map, 'dragend', function(e){
//   wkt.fromObject(e.overlay);
//   console.log(wkt.write());
//   $('#Form-field-Zone-area').val(wkt.write());
// });
        google.maps.event.addDomListener(document, 'keyup', deleteSelectedShape);

        if($('#Form-field-Zone-area').val()){
            console.log($('#Form-field-Zone-area').val());
            wkt.read($('#Form-field-Zone-area').val());
            var obj = wkt.toObject(map.defaults);
            obj.setMap(map); // Add it to the map
            //map.features.push(obj);

            drawingManager.setDrawingMode(null);
            // To hide:
            drawingManager.setOptions({
                drawingControl: false
            });

            // Add an event listener that selects the newly-drawn shape when the user
            // mouses down on it.
            var newShape = obj;
            google.maps.event.addListener(newShape, 'click', function() {
                setSelection(newShape);
            });
            setSelection(newShape);
        }

    }

</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgvVNSoY_mQ5CwdZ4qCmr2xf-_E_dmMA0&callback=initMap&libraries=drawing">
</script>
@endsection
