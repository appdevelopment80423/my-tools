@extends('admin.layout.main')
@section('title', 'Permission List')
@section('content')
    @push('vendor-css')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        @can('permission_create')
            <div class="card mb-4">
                <h5 class="card-header">Add Permission</h5>
                <form id="permission-form" class="card-body" method="POST" action="{{ route('admin.permissions.store') }}"
                    autocomplete="off">
                    @csrf
                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="row mb-4">
                                            <div class="col-sm-12">
                                                <label for="name">Permission<span>*</span></label>
                                                <input id="name" type="text" class="form-control" name="name"
                                                    value="" placeholder="Enter user name">
                                                @error('name')
                                                    <span id="name" class="error">{{ $message }}</span>
                                                @enderror
                                                <span id="name_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row mb-4">
                                            <div class="col-sm-12">
                                                <label for="name">Assigned to Role<span>*</span></label>
                                                <div class="select2-primary">
                                                    <select id="select2Primary" name="roles[]" class="select2 form-select"
                                                        multiple>
                                                        @foreach ($roles as $id => $role)
                                                            <option value="{{ $id }}">{{ $role }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                @error('roles')
                                                    <span id="roles" class="error">{{ $message }}</span>
                                                @enderror
                                                <span id="error-roles"></span>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="row mb-4">
                                            <div class="col-sm-12">
                                                <div class="pt-4">
                                                    <button type="submit"
                                                        class="btn btn-primary me-sm-3 me-1 proceed-btn">Save</button>
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
        @endcan
    </div>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Permissions</h5>

            <div class="card-datatable text-nowrap">

                <table class="table permission_table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Permission</th>
                            <th>Assigned Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            $(document).ready(function() {
                $("#permission-form").validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        'roles[]': {
                            required: true,
                        }
                    },
                    messages: {
                        name: {
                            required: "Please enter permission name.",
                        },
                        'roles[]': {
                            required: "Please select role.",
                        }
                    },
                    errorPlacement: function(error, element) {
                        if (element.attr("name") == "roles[]") {
                            error.insertAfter($("#error-roles"));
                        } else {
                            error.insertAfter($("#" + element.attr("name") + "_error"));
                        }
                    },
                    submitHandler: function(form) {
                        return true;
                    }
                });
            });

            $('#select2Primary').change(function(e) {
                var selected = $(e.target).val();
                $("#permission-form").valid();
            });
        </script>
        <script>
            $(function() {

                $('.permission_table').DataTable({
                    dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row mb-3'<'col-sm-5'i><'col-sm-7 mt-3'p>>",
                    ajax: {
                        url: "{{ route('admin.permissions.get-list') }}",
                        type: "get",
                        bAutoWidth: false,
                    },
                    columns: [
                        /*{data:'serial_no', name: 'serial_no'},*/
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: "text-center"
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: "text-center"
                        },
                        {
                            data: 'roles',
                            name: 'roles',
                            className: "text-center"
                        },

                        //only those have manage_user permission will get access
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: "text-center"
                        }

                    ],
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_ Total _TOTAL_ Entries",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [7, 10, 20, 50],
                    "pageLength": 10
                });
            });
        </script>
    @endpush
@endsection
