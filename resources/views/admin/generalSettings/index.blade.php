@extends('admin.layout.main')
@section('title', 'General Setting')
@section('content')
    @push('vendor-css')
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css')}}"/>
        <link rel="stylesheet"
              href="{{asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css')}}"/>
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <h5 class="card-header" id="addTitle">Add Settings</h5>
            <form action="{{ route('admin.settings.store') }}" method="post" id="add-settings" class="card-body"
                  autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="" id="id">
                <hr class="my-4 mx-n4"/>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <select class="form-control valid" id="type" name="type" aria-invalid="false">
                                @foreach($type_data AS $val)
                                    <option value="{{ $val->id }}">{{ $val->type }}</option>
                                @endforeach
                            </select>
                            <label for="Settings Type">Settings Type<span class="text-danger">*</span></label>
                        </div>
                        <div class="invalid-feedback">
                            @error('type')
                            <div class="error">{{ $message }}</div>
                            @enderror
                            <span id="type_error"></span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="setting_key" id="setting_key" class="form-control"
                                   value="{{ old('setting_key') }}" placeholder="Enter settings name"
                                   autocomplete="off">
                            <label for="Settings Key">Settings Key<span class="text-danger">*</span> </label>
                        </div>
                        @error('setting_key')
                        <span class="error">{{ $message }}</span>
                        @enderror
                        <span id="setting_key_error"></span>
                    </div>

                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <input type="text" name="setting_value" id="setting_value" class="form-control"
                                   value="{{ old('setting_value') }}" placeholder="Enter settings value"
                                   autocomplete="off">
                            <label for="Settings Value">Settings Value<span class="text-danger">*</span> </label>
                        </div>
                        @error('setting_value')
                        <span class="error">{{ $message }}</span>
                        @enderror
                        <span id="setting_value_error"></span>
                    </div>

                </div>
                <div class="row mb-3">
                    <div class="col-md-8">
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" name="descriptions" id="descriptions" class="form-control"></textarea>
                            <label for="Descriptions">Descriptions</label>
                        </div>
                        @error('descriptions')
                        <span class="error">{{ $message }}</span>
                        @enderror
                        <span id="descriptions_error"></span>
                    </div>
                    <div class="col-md-4">
                        <div class="form-floating form-floating-outline">
                            <select class="form-control valid" id="status" name="status" aria-invalid="false">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <label for="status">Status<span class="text-danger">*</span></label>
                        </div>
                        <div class="invalid-feedback">
                            @error('status')
                            <div class="error">{{ $message }}</div>
                            @enderror
                            <span id="status_error"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1 proceed-btn" id="submit">
                                    Save
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <h5 class="card-header">Settings List</h5>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-1">
                        <div class="form-group mb-1" style="width:90%">
                            <select class="form-select" id="p-length">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="150">150</option>
                                <option value="250">250</option>
                                <option value="500">500</option>
                                <option value="750">750</option>
                                <option value="1000">1000</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                    </div>
                    <div class="col-3">
                        <div class="form-floating form-floating-outline">
                            <select style="float: left;" class="form-control form-select valid" id="typeFilter"
                                    name="type_filter" aria-invalid="false">
                                <option value="">Select settings type</option>
                                @foreach($type_data AS $val)
                                    <option value="{{ $val->id }}">{{ $val->type }}</option>
                                @endforeach
                            </select>
                            <label for="Settings Type">Settings Type<span class="text-danger">*</span></label>
                        </div>
                        <div class="invalid-feedback">
                            @error('type_filter')
                            <div class="error">{{ $message }}</div>
                            @enderror
                            <span id="type_filter_error"></span>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input id="search" type="text" name="txt" placeholder="Search Here..." class="form-control">
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-center">SN</th>
                            <th class="text-center sortable cursor-pointer" data-sort="settings.key">Setting Name<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="settings.value">Setting
                                Value<span class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="setting_types.type">Setting
                                Type<span class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="settings.description">Description<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="settings.status">Status<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="data-table">
                        <tr>
                            <td colspan="7" class="text-center table-loader">Loading...</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation" class="mt-4" style="float: right;">
                    <ul id="pagination-links" class="pagination">
                        <!-- Pagination links will be dynamically generated here -->
                    </ul>
                </nav>
                <nav aria-label="Page navigation" class="mt-4" style="float: left;">
                    <div id="pagination-info"></div>
                </nav>
            </div>
        </div>
    </div>
    @push('script')
        <script>

            $(document).ready(function () {
                $("#add-settings").validate({
                    rules: {
                        setting_key: {
                            required: true,
                        },
                        setting_value: {
                            required: true,
                        },
                        status: {
                            required: true,
                        },
                        type: {
                            required: true,
                        }

                    },
                    messages: {
                        setting_key: {
                            required: "Please enter setting name.",
                        },
                        setting_value: {
                            required: "Please enter setting value.",
                        },
                        status: {
                            required: "Please select status.",
                        },
                        type: {
                            required: "Please select settings type."
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter($("#" + element.attr("id") + "_error"));
                    },
                    submitHandler: function (form) {
                        $(".proceed-btn").hide();
                        return true;
                    }
                });

                $(document).on('click', '#editbutton', function (e) {
                    e.preventDefault();
                    console.log($(this).data('route'));
                    $.ajax({
                        url: $(this).data('route'),
                        type: 'get',
                        success: function (response) {
                            if (response) {
                                $('#addTitle').text('Edit Setting');
                                $('#submit').text('Update');
                                $('#setting_key').val(response.key);
                                $('#setting_value').val(response.value);
                                $('#type').val(response.type_id);
                                $('#descriptions').val(response.description);
                                $('#status').val(response.status);
                                $('#id').val(response.id);
                            }
                        }
                    })
                });
            });

            window.onload = function () {
                // Get the dropdown element
                var dropdown = document.getElementById("typeFilter");
                // Set the selectedIndex property to -1 to unselect the option
                dropdown.selectedIndex = 0;
            };


            let page = 1
            let currentPage = 1;
            let totalPages = 1;
            let page_length = 10;
            let column = 'settings.updated_at';
            let sortOrder = 'desc';
            let settingType = "";
            let data_total =0;


            fetchData(1, page_length, column, sortOrder, settingType);

            function fetchData(page, page_length, column, sortOrder, settingType) {
                $.ajax({
                    url: '{{ url("admin/settings/get-list") }}',
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: page_length,
                        sort_column: column,
                        sort_order: sortOrder,
                        search: $('#search').val(),
                        type: settingType
                    },
                    success: function (response) {
                        var data = response.data;
                        var html = '';
                        if (data === null || data.length === 0) {
                            html += '<tr><td colspan="7" class="text-center">No data found</td></tr>';
                        } else {

                            // Populate table rows
                            for (var i = 0; i < data.length; i++) {
                                var serialNumber = i + 1 + ((response.current_page - 1) * parseInt(page_length));
                                let edit_url = "{{url('admin/settings/edit')}}";
                                let delete_url = "{{url('admin/settings/delete')}}";
                                html += '<tr>';
                                html += '<td class="text-center">' + serialNumber + '</td>';
                                html += '<td class="text-center">' + data[i].key + '</td>';
                                // html += '<td class="text-center">' + data[i].value + '</td>';

                                if (data[i].value.length > 30) {
                                    html += '<td class="text-center">' + data[i].value.slice(0, 30) + '....</td>';
                                } else {
                                    html += '<td class="text-center">' + data[i].value + '</td>';
                                }

                                html += '<td class="text-center">' + data[i].type + '</td>';
                                html += '<td class="text-center">' + data[i].description + '</td>';

                                if (data[i].status == 1) {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-success me-1">Active</span></td>`;
                                } else {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-danger me-1">Inactive</span></td>`;
                                }

                                html += '<td class="text-center"><div class="dropdown"> <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"> <i class="mdi mdi-dots-vertical"></i> ' +
                                    '</button><div class="dropdown-menu" style=""><a href="javascript:void(0);" id="editbutton" data-route="' + edit_url + '/' + data[i].id + '" class="dropdown-item waves-effect"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a>' +
                                    '<a class="dropdown-item waves-effect" onclick="deleteRecord(`' + delete_url + '/' + data[i].id + '`,`.settings`)" href="javascript:void(0);"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a></div></div></td>';


                                // if (data[i].Status == 'Active') {
                                //     html += `<td class="text-center"><span class="badge badge-success">Active</span></td>`;
                                // } else {
                                //     html += `<td class="text-center"><span class="badge badge-dark">InActive</span></td>`;
                                // }

                                html += '</tr>';
                            }
                        }
                        $('#data-table').html(html);

                        // Update pagination links
                        currentPage = response.current_page;
                        totalPages = response.last_page;
                        updatePaginationLinks();
                        data_total = response.total;
                        updatePaginationInfo();
                    }
                });
            }

            function deleteRecord(model_url, datatable_class) {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Once submitted, you will not be able to cancel!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                        cancelButton: 'btn btn-label-secondary waves-effect'
                    },
                    buttonsStyling: false
                }).then(function (result) {

                    if (result.value) {
                        $.ajax({
                            url: model_url,
                            type: "GET",
                            data: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            dataType: 'json',
                            success: function (result) {
                                if (result) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: 'Your file has been deleted.',
                                        customClass: {
                                            confirmButton: 'btn btn-success waves-effect'
                                        }
                                    });

                                    $(datatable_class).DataTable().ajax.reload();
                                    fetchData(page, page_length, column, sortOrder, settingType);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong!',
                                        customClass: {
                                            confirmButton: 'btn btn-primary waves-effect waves-light'
                                        },
                                        buttonsStyling: false
                                    });
                                }

                            }
                        });

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'Your record is safe.',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success waves-effect'
                            }
                        });
                    }
                });
            }

            $("#typeFilter").on("change", function () {

                let settingType = $(this).val();
                fetchData(page, page_length, column, sortOrder, settingType);
            });

            function updatePaginationLinks() {
                var html = '';

                html += '<nav aria-label="Page navigation justify-content-end">';
                html += '<ul class="pagination">';

                var maxVisiblePages = 10; // Maximum number of visible pages
                var halfVisiblePages = Math.floor(maxVisiblePages / 2); // Half of the visible pages

                var startPage = currentPage - halfVisiblePages;
                var endPage = currentPage + halfVisiblePages;

                if (startPage <= 0) {
                    startPage = 1;
                    endPage = maxVisiblePages;
                }

                if (endPage > totalPages) {
                    endPage = totalPages;
                    startPage = totalPages - maxVisiblePages + 1;
                    if (startPage <= 0) {
                        startPage = 1;
                    }
                }

                if (currentPage > 1) {
                    html += '<li class="page-item previous"><a class="page-link" href="#" data-page="' + (currentPage - 1) + '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></a></li>';
                } else {
                    html += '<li class="page-item previous disabled"><a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></a></li>';
                }

                if (startPage > 1) {
                    html += '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
                    if (startPage > 2) {
                        html += '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                }

                for (var i = startPage; i <= endPage; i++) {
                    html += '<li class="page-item' + (i === currentPage ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        html += '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                    html += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '">' + totalPages + '</a></li>';
                }

                if (currentPage < totalPages) {
                    html += '<li class="page-item next"><a class="page-link" href="#" data-page="' + (currentPage + 1) + '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a></li>';
                } else {
                    html += '<li class="page-item next disabled"><a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a></li>';
                }

                html += '</ul>';
                html += '</nav>';

                $('#pagination-links').html(html);
            }

            // Page Showing Entries
            function updatePaginationInfo() {
                var pageText = 'Showing Page ' + currentPage + ' of ' + totalPages + ' Total ' + data_total + ' Entries ';
                $('#pagination-info').html(pageText);
            }

            // Page link click event
            $(document).on('click', '.pagination a', function (e) {
                let settingType = $("#typeFilter").val();
                e.preventDefault();
                page = $(this).data('page');
                fetchData(page, page_length, column, sortOrder, settingType);
            });

            // Search input keyup event
            $('#search').on('keyup', function () {
                let settingType = $("#typeFilter").val();
                currentPage = 1;
                fetchData(currentPage, page_length, column, sortOrder, settingType);
            });

            // Page length evenet
            $('#p-length').on('change', function () {
                let settingType = $("#typeFilter").val();
                currentPage = 1;
                page_length = this.value;
                fetchData(currentPage, page_length, column, sortOrder, settingType);
            });

            // Sorting click event
            $('.sortable').click(function () {
                let settingType = $("#typeFilter").val();
                column = $(this).data('sort');
                sortOrder = $(this).hasClass('asc') ? 'desc' : 'asc';
                sortAble = $(this).hasClass('asc') ? 'sorting_desc' : 'sorting_asc';

                // Apply sorting logic and update table rows accordingly

                // Remove previous sorting classes
                $('.sortable').removeClass('asc desc');
                $('.sort-indicator').removeClass('sorting_asc sorting_desc');

                // Add sorting class to the clicked column header
                $(this).addClass(sortOrder);
                $(this).find('.sort-indicator').addClass(sortAble);
                fetchData(currentPage, page_length, column, sortOrder, settingType);

            });
        </script>
    @endpush
@endsection
