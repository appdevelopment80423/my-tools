@extends('admin.layout.main')
@section('title', 'User Log List')
@section('content')
    @push('page-css')
        <style>
            .btn-delete {
                width: 30px;
                height: 35px;
                min-width: 95px;
                --bs-gutter-x: 1.5rem;
                margin-left: calc(0.2 * var(--bs-gutter-x));
            }
        </style>
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- users details Address  -->

        @if (isset($user_data))
            <div class="card card-action mb-4">
                <div class="card-header align-items-center">
                    <h5 class="card-action-title mb-0">User Details</h5>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="card-body pt-1 pb-1">
                            <div class="row">
                                <span style="width:140px">
                                  @if($user_data->image)
                                        <a href="{{ strpos($user_data->image, 'http') === 0 ? $user_data->image : config('constants.USER_PROFILE_IMAGES_FULL_PATH') . $user_data->image }}" target="_blank">
                                    <img loading="lazy" class="img-fluid rounded border-radius-10"
                                         src="{{ strpos($user_data->image, 'http') === 0 ? $user_data->image : config('constants.USER_PROFILE_IMAGES_FULL_PATH') . $user_data->image }}"
                                         height="110" width="110" alt="Profile"/>
                                </a>

                                    @else
                                        @if($user_data->gender == 'male')
                                            <a href="{{ asset('assets/img/avatars/male/5.png') }}" target="_blank">
                                            <img loading="lazy" class="img-fluid rounded  border-radius-10"
                                                 src="{{ asset('assets/img/avatars/male/5.png') }}" height="110" width="110"
                                                 alt="Profile"/>
                                                </a>
                                        @else
                                            <a href="{{ asset('assets/img/avatars/female/5.png') }}" target="_blank">
                                            <img loading="lazy" class="img-fluid rounded  border-radius-10"
                                                 src="{{ asset('assets/img/avatars/female/5.png') }}" height="110" width="110"
                                                 alt="Profile"/>
                                            </a>
                                   @endif
                                    @endif
						    </span>
                                <span style="width:85%">
							<div class="row border-bottom border-secondary pl-0 pr-0">
								<p class="col pr-3 mb-2"><span
                                        class="blue custom-font-weight font-medium user-card-head">Name : </span><span
                                        class="custom-font-weight font-medium gray">
                                         @if (isset($user_data->name))
                                            {{ $user_data->name }}
                                        @else
                                            -
                                        @endif
                                             </span></p>
								<p class="col pr-3 mb-2"><span
                                        class="blue font-weight-normal user-card-head">Email : </span><span
                                        class="gray font-weight-normal">{{ $user_data->email }}</span></p>
								<p class="col mb-2"><span
                                        class="blue font-weight-normal user-card-head">Contact : </span><span
                                        class="gray font-weight-normal">@if (isset($user_data->mobile_number))
                                            {{ $user_data->mobile_number }}
                                        @else
                                            -
                                        @endif
                                        </span></p>

                                 <p class="col mb-2"><span
                                         class="blue font-weight-normal user-card-head">Gender : </span><span
                                         class="gray font-weight-normal">
                                         @if (isset($user_data->gender))
                                             {{ $user_data->gender }}
                                         @else
                                             -
                                         @endif</span></p>

							</div>
							<div class="row border-bottom border-secondary pl-0 pr-0 mt-2">

								<p class="col pr-3 mb-2"><span
                                        class="blue font-weight-normal user-card-head">Referral Code : </span><span
                                        class="gray font-weight-normal">@if (isset($user_data->referral_code))
                                            {{ $user_data->referral_code }}
                                        @else
                                            -
                                        @endif</span></p>
								<p class="col pr-3 mb-2"><span
                                        class="blue font-weight-normal user-card-head">Pin : </span><span
                                        class="gray font-weight-normal"> @if (isset($user_data->pin))
                                            {{ $user_data->pin }}
                                        @else
                                            -
                                        @endif</span></p>
                                 <p class="col pr-3 mb-2"><span
                                         class="blue font-weight-normal user-card-head">Pincode : </span><span
                                         class="gray font-weight-normal">
                                         @if (isset($user_data->pincode))
                                             {{ $user_data->pincode }}
                                         @else
                                             -
                                         @endif
                                     </span></p>
								<p class="col pr-3 mb-2"><span
                                        class="blue font-weight-normal user-card-head">Address : </span><span
                                        class="font-weight-normal gray"> @if (isset($user_data->city))
                                            {{ $user_data->city }} , {{ $user_data->state }}
                                        @else
                                            -
                                        @endif</span></p>
							</div>
							<div class="row border-bottom  pl-0 pr-0 mt-2">


								<p class="col pr-3 mb-2"><span
                                        class="blue font-weight-normal user-card-head">Device Name : </span><span
                                        class="gray font-weight-normal"> @if (isset($user_data->device_info->mobile_name))
                                            {{ $user_data->device_info->mobile_name }}
                                        @else
                                            -
                                        @endif</span></p>
                                <p class="col mb-2"><span
                                        class="blue font-weight-normal user-card-head">Device Model : </span><span
                                        class="gray font-weight-normal"> @if (isset($user_data->device_info->device_model))
                                            {{ $user_data->device_info->device_model }}
                                        @else
                                            -
                                        @endif</span></p>
                                 <p class="col mb-2"><span
                                         class="blue font-weight-normal user-card-head">Version : </span><span
                                         class="gray font-weight-normal"> @if (isset($user_data->device_info->device_version))
                                             {{ $user_data->device_info->device_version }}
                                         @else
                                             -
                                         @endif</span></p>
                                 <p class="col mb-2">
{{--                                     <span--}}
{{--                                         class="blue font-weight-normal user-card-head">IMEI No : </span><span--}}
{{--                                         class="gray font-weight-normal"> @if (isset($user_data->device_info->imei_number))--}}
{{--                                             {{ $user_data->device_info->imei_number }}--}}
{{--                                         @else--}}
{{--                                             ---}}
{{--                                         @endif</span>--}}
                                 </p>
							</div>

						</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- End users details Address  -->

        <div class="card">
            <h5 class="card-header">Users Activity Logs</h5>
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
                    <div class="col-8">
                        @can('user_activity_delete')
                            <button type="button" id="updateAll"
                                    class="btn btn-outline-danger btn-delete waves-effect"><i
                                    class="fa fa-trash"></i></button>
                        @endcan
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <input id="search" type="text" name="txt" placeholder="Search Here..."
                                   class="form-control">
                        </div>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            @can('user_activity_delete')
                                <th style="font-size: unset;">
                                    <div class="form-check form-check-danger"><input class="form-check-input"
                                                                                     type="checkbox" value=""
                                                                                     id="checkbox-primary-all"></div>
                                </th>
                            @endcan
                            <th class="text-center">SN</th>
                            @if(empty($user_data))
                                <th class="text-center sortable cursor-pointer" data-sort="name">users Name<span
                                        class="sort-indicator"></span></th>
                                <th class="text-center sortable cursor-pointer" data-sort="email">users Email<span
                                        class="sort-indicator"></span></th>
                            @endif
                            <th class="text-center sortable cursor-pointer" data-sort="url">URL<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="ip">IP Address<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="user_agent">User Agent<span
                                    class="sort-indicator"></span></th>

                        </tr>
                        </thead>
                        <tbody id="data-table">
                        <tr>
                            <td colspan="7" class="text-center table-loader">Loading...</td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="hidden" value="{{ $id }}" id="users_id" name="users_id">
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
            let page = 1
            let currentPage = 1;
            let totalPages = 1;
            let page_length = 10;
            let column = 'user_activity_logs.created_at';
            let sortOrder = 'desc';
            let usersId = $("#users_id").val();
            let data_total = 0;

            fetchData(1, page_length, column, sortOrder, usersId);

            function fetchData(page, page_length, column, sortOrder, usersId) {
                $.ajax({
                    url: '{{ url('admin/users/users-logs') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: page_length,
                        sort_column: column,
                        sort_order: sortOrder,
                        search: $('#search').val(),
                        users_id: usersId
                    },
                    success: function (response) {
                        var data = response.data.data;
                        var html = '';
                        if (data === null || data.length === 0) {
                            html += '<tr><td colspan="7" class="text-center">No data found</td></tr>';
                        } else {

                            // Populate table rows
                            for (var i = 0; i < data.length; i++) {
                                var serialNumber = i + 1 + ((response.data.current_page - 1) * parseInt(
                                    page_length));
                                html += '<tr>';
                                @can('user_activity_delete')
                                    html +=
                                    '<td><div class="form-check form-check-danger"><input class="form-check-input web-check-all" type="checkbox" value="" id="' +
                                    data[i].id + '"></div></td>';
                                @endcan
                                    html += '<td class="text-center">' + serialNumber + '</td>';
                                if (usersId == '') {
                                    html += '<td class="text-center">' + data[i].name + '</td>';
                                    html += '<td class="text-center">' + data[i].email + '</td>';
                                }
                                html += '<td class="text-center">' + data[i].url + '</td>';
                                html += '<td class="text-center">' + data[i].ip + '</td>';
                                html += '<td class="text-center">' + data[i].user_agent + '</td>';

                                html += '</tr>';
                            }
                        }
                        $('#data-table').html(html);

                        // Update pagination links
                        currentPage = response.data.current_page;
                        totalPages = response.data.last_page;
                        updatePaginationLinks();
                        data_total = response.data.total;
                        updatePaginationInfo();
                    }
                });
            }

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
                    html += '<li class="page-item previous"><a class="page-link" href="#" data-page="' + (currentPage - 1) +
                        '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></a></li>';
                } else {
                    html +=
                        '<li class="page-item previous disabled"><a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></a></li>';
                }

                if (startPage > 1) {
                    html += '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
                    if (startPage > 2) {
                        html += '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                }

                for (var i = startPage; i <= endPage; i++) {
                    html += '<li class="page-item' + (i === currentPage ? ' active' : '') +
                        '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                }

                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        html += '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                    }
                    html += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '">' + totalPages +
                        '</a></li>';
                }

                if (currentPage < totalPages) {
                    html += '<li class="page-item next"><a class="page-link" href="#" data-page="' + (currentPage + 1) +
                        '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a></li>';
                } else {
                    html +=
                        '<li class="page-item next disabled"><a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a></li>';
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
                e.preventDefault();
                page = $(this).data('page');
                fetchData(page, page_length, column, sortOrder, usersId);
            });

            // Search input keyup event
            $('#search').on('keyup', function () {
                currentPage = 1;
                fetchData(currentPage, page_length, column, sortOrder, usersId);
            });

            // Page length evenet
            $('#p-length').on('change', function () {
                currentPage = 1;
                page_length = this.value;
                fetchData(currentPage, page_length, column, sortOrder, usersId);
            });

            // Sorting click event
            $('.sortable').click(function () {
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
                fetchData(currentPage, page_length, column, sortOrder, usersId);

            });

            //checkbox select data  users delete
            $("#checkbox-primary-all").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
            window.onload = function () {
                $('#checkbox-primary-all,.web-check-all').prop(
                    "checked", false);
                fetchData(1, page_length, column, sortOrder,
                    usersId);
            };

            var logValueArray = [];

            function checkCheckedWeb() {
                logValueArray = [];

                $('.web-check-all:checked').each(function () {
                    logValueArray.push($(this).attr('id'));
                });

                if (logValueArray.length <= 0) {
                    return false;
                } else {
                    return true;
                }

            }

            $("#updateAll").click(function () {
                if (checkCheckedWeb()) {

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete!",
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
                                type: "POST",
                                url: "{{ url('admin/users/delete-logs') }}",
                                headers: {
                                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                },
                                data: JSON.stringify({
                                    log_ids: logValueArray
                                }),
                                contentType: false,
                                processData: false,
                                success: function (data) {
                                    let code = data.code;
                                    let message = data.data.message;
                                    if (code == 200) {
                                        logValueArray = [];
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Deleted!',
                                            text: message,
                                            customClass: {
                                                confirmButton: 'btn btn-success waves-effect'
                                            }
                                        }).then(function () {
                                            $('#checkbox-primary-all,.web-check-all').prop(
                                                "checked", false);
                                            fetchData(1, page_length, column, sortOrder,
                                                usersId);
                                        });

                                    } else {
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'error',
                                            title: message,
                                            showConfirmButton: false,
                                            timer: 2500
                                        })
                                        logValueArray = [];

                                    }
                                },
                                error: function (err) {
                                    logValueArray = [];

                                },
                            });

                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            Swal.fire({
                                title: 'Cancelled',
                                text: 'Your record is safe.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-success waves-effect'
                                }
                            }).then(function () {
                                $('#checkbox-primary-all,.web-check-all').prop(
                                    "checked", false);
                                fetchData(1, page_length, column, sortOrder,
                                    usersId);
                            });
                        }
                    });

                } else {
                    logValueArray = [];
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Please select at least one column',
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            });
        </script>
    @endpush
@endsection
