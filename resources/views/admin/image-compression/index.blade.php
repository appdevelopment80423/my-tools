@extends('admin.layout.main')
@section('title', 'Role List')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <h5 class="card-header">Image Compression</h5>
            <form id="images-form" class="card-body" method="POST" action="{{ route('admin.image-compression.compress') }}"
                  enctype="multipart/form-data">
                @csrf
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <label for="image">Choose Images<span>*</span></label>
                                            <input id="image" type="file"
                                                   class="form-control @error('image') is-invalid @enderror"
                                                   name="image[]" multiple>
                                            <span id="image_error"></span>
                                            @error('image')
                                            <div class="error">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9"></div>
                                <div class="col-sm-3">
                                    <div class="row mb-4">
                                        <div class="col-sm-12">
                                            <div class="pt-4">
                                                <button type="submit" class="btn btn-primary me-sm-3 me-1 proceed-btn">
                                                    Compress
                                                </button>
                                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {

            $.validator.addMethod("extension", function(value, element, param) {
                param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g";
                return this.optional(element) || value.match(new RegExp("\\.(" + param + ")$", "i"));
            }, $.validator.format("Please enter a value with a valid extension."));

            $("#images-form").validate({
                rules: {
                    'image[]': {
                        required: true,
                        extension: "jpeg,jpg,png"
                    }
                },
                messages: {
                    'image[]': {
                        required: "Please choose at least one image.",
                        extension: "Please upload only JPEG, JPG, or PNG images."
                    }
                },
                errorPlacement: function (error, element) {
                    error.insertAfter(element);
                },
                submitHandler: function (form) {
                    form.submit();
                }
            });
        });
    </script>
@endpush

