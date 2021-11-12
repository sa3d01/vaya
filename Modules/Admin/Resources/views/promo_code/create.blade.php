@extends('admin::layouts.master')
@section('title') Add Promo Code @endsection
@section('css')
    <link href="{{URL::asset('libs/select2/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{URL::asset('libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}" rel="stylesheet" />
    <link href="{{asset('libs/dropify/dist/css/dropify.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('admin::common-components.breadcrumb')
        @slot('title') Promo Codes  @endslot
        @slot('li_1') Add Promo Code  @endslot
    @endcomponent
    @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <form method="POST" action="{{route('admin.promo_code.store')}}" enctype="multipart/form-data" data-parsley-validate novalidate>
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input required type="text" class="form-control"  name="name" />
                        </div>
                        <div class="form-group">
                            <label class="control-label">Start Date</label>
                            <input type="date" id="example-date-input" class="form-control" name="start_date">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Type</label>
                            <select required name="type" class="form-control select2">
                                <option disabled selected>--</option>
                                <option value="percent">Percent</option>
                                <option value="amount">Amount</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="control-label">Code</label>
                            <input required type="text" class="form-control" name="code"  />
                        </div>
                        <div class="form-group">
                            <label class="control-label">End Date</label>
                            <input type="date" id="example-date-input" class="form-control" name="end_date">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Value</label>
                            <input type="number" value="1" min="0" class="form-control" name="value"   />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <button class="btn btn-primary waves-effect waves-light mr-12" type="submit">
                    Store
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

    <script src="{{URL::asset('/js/pages/form-advanced.init.js')}}"></script>

    <script src="{{asset('/libs/dropify/dist/js/dropify.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>
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
@endsection
