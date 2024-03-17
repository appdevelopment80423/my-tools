@extends('admin.layout.main')
@section('title', 'Role List')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
        <h5 class="card-header">Add Role</h5>
        <form id="user-form" class="card-body" method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="name">Role<span>*</span></label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name"
                                            value="" placeholder="Enter user name">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="row mb-4">
                                    <label for="name">Assign Permission<span>*</span></label>
                                    @foreach($permissions as $key => $permission)
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="item_checkbox{{$key}}" name="permissions[]" value="{{$key}}">
                                                <label class="form-check-label" for="item_checkbox{{$key}}"> {{$permission}} </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    @error('permissions.*')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9"></div>
                            <div class="col-sm-3">
                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <div class="pt-4">
                                            <button type="submit" class="btn btn-primary me-sm-3 me-1 proceed-btn">Save</button>
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

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <h5 class="card-header">Roles</h5>

        <div class="card-datatable text-nowrap">

            <table class="table role_table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Role</th>
                        <th>Permission</th>
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
    $(function() {

        $('.role_table').DataTable( {
            dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mb-3'<'col-sm-5'i><'col-sm-7 mt-3'p>>",
            ajax: {
                url: "{{route('roles.get-list')}}",
                type: "get",
                bAutoWidth: false,
            },
            columns: [
                /*{data:'serial_no', name: 'serial_no'},*/
                {
                    data: 'DT_RowIndex', name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {data:'name', name: 'name'},
                {data:'permissions', name: 'permissions'},

                //only those have manage_user permission will get access
                {data:'action', name: 'action',orderable: false, searchable: false}

            ],
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [7, 10, 20, 50],
            "pageLength": 10
        } );
    });
</script>
@endpush
@endsection
