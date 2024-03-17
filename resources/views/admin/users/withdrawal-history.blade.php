@extends('admin.layout.main')
@section('title', 'User Withdrawal History List')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">User /</span> Details</h4>
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                @if (isset($user_details->image))
                                    @php
                                        $imageSrc = Str::startsWith($user_details->image, 'https') ? $user_details->image : config('constants.USER_PROFILE_IMAGES_FULL_PATH') . $user_details->image;
                                    @endphp

                                    <a href="{{ $imageSrc }}" target="_blank">
                                        <img loading="lazy" class="img-fluid rounded mb-3 mt-4"
                                             src="{{ $imageSrc }}"
                                             height="120" width="120" alt="User Profile" />
                                    </a>
                                @else
                                    @if($user_details->gender == 'male')
                                        <a href="{{ asset('assets/img/avatars/male/5.png') }}" target="_blank">
                                        <img loading="lazy" class="img-fluid rounded mb-3 mt-4"
                                             src="{{ asset('assets/img/avatars/male/5.png') }}" height="120" width="120"
                                             alt="User Profile" />
                                        </a>
                                    @else  <a href="{{ asset('assets/img/avatars/female/5.png') }}" target="_blank">
                                        <img loading="lazy" class="img-fluid rounded mb-3 mt-4"
                                             src="{{ asset('assets/img/avatars/female/5.png') }}" height="120" width="120"
                                             alt="User Profile" />
                                    </a>
                                    @endif
                                @endif
                                <div class="user-info text-center">
                                    <h4>{{ $user_details->name }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap my-2 py-3">
                            <div class="d-flex align-items-center me-4 mt-3 gap-3">
                                <div class="avatar"  style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/teamnew.png') }}" alt="team">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{$user_total_team}}</h4>
                                    <span>Total team</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center me-4 mt-3 gap-3">
                                <div class="avatar"  style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/point.png') }}" alt="earning">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{number_format($user_total_earning,2)}} Points</h4>
                                    <span>Total Earning</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 gap-3">
                                <div class="avatar" style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/point.png') }}" alt="earning">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{$availableBalance}} Points</h4>
                                    <span>Available Balance</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mt-3 gap-3">
                                <div class="avatar" style="cursor: default">
                                    <div class="avatar-initial bg-label-primary rounded">
                                        <img loading="lazy" src="{{ asset('assets/img/dashboard/withdrawnew.png') }}" alt="earning">
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-0 fw-normal">{{$withdrawBalance}} Points</h4>
                                    <span>Withdrawal Balance</span>
                                </div>
                            </div>
                        </div>
                        <h5 class="pt-3 border-top mt-3">Details:</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Status:</span>
                                    @if ($user_details->status == 1)
                                        <span class="badge bg-label-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-label-danger">
                                            Inactive
                                        </span>
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">My Pin:</span>
                                    <span>
                                         @if (isset($user_details->pin))
                                            {{ $user_details->pin }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Referral Code:</span>
                                    <span>
                                        @if (isset($user_details->referral_code))
                                            {{ $user_details->referral_code }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Date  of joining:</span>
                                    <span>
                                        @if (isset($user_details->created_at))
                                            {{date("d M, Y",strtotime($user_details->created_at)) }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <h5 class="pt-3 border-top mb-3">Personal Details:</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Email:</span>
                                    <span>{{ $user_details->email }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Mobile No:</span>
                                    <span>{{ $user_details->mobile_number }}</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Gender:</span>
                                    <span>
                                        @if (isset($user_details->gender))
                                            {{ $user_details->gender }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">DOB:</span>
                                    <span>
                                        @if (isset($user_details->dob))
                                            {{ $user_details->dob }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Address:</span>
                                    <span>
                                        @if (isset($user_details->city))
                                            {{ $user_details->city }} , {{ $user_details->state }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
{{--                                <li class="mb-3">--}}
{{--                                    <span class="fw-semibold text-heading me-2">Pincode:</span>--}}
{{--                                    <span>--}}
{{--                                        @if (isset($user_details->pincode))--}}
{{--                                            {{ $user_details->pincode }}--}}
{{--                                        @else--}}
{{--                                            ---}}
{{--                                        @endif--}}
{{--                                    </span>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                        <h5 class="pt-3 border-top mb-3">Device Details:</h5>
                        <div class="info-container">
                            <ul class="list-unstyled mb-4">
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Device Name:</span>
                                    <span>
                                        @if (isset($user_details->device_info->mobile_name))
                                            {{ $user_details->device_info->mobile_name }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Model:</span>
                                    <span>
                                        @if (isset($user_details->device_info->device_model))
                                            {{ $user_details->device_info->device_model }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li class="mb-3">
                                    <span class="fw-semibold text-heading me-2">Version:</span>
                                    <span>
                                        @if (isset($user_details->device_info->device_version))
                                            {{ $user_details->device_info->device_version }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
{{--                                <li class="mb-3">--}}
{{--                                    <span class="fw-semibold text-heading me-2">IMEI No:</span>--}}
{{--                                    <span>--}}
{{--                                        @if (isset($user_details->device_info->imei_number))--}}
{{--                                            {{ $user_details->device_info->imei_number }}--}}
{{--                                        @else--}}
{{--                                            ---}}
{{--                                        @endif--}}
{{--                                    </span>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->

            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                <!-- User Tabs -->
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <a class="nav-link " id="earning-segment" href="{{url('admin/users/view-detail/earning-history/')}}/{{$user_details->id}}"><i class="me-1"> <img
                                    src="{{ asset('assets/img/dashboard/earnings.png') }}" width="30"
                                    alt="earning"></i>Earning History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" id="withdrawal-segment" href="{{url('admin/users/view-detail/withdrawal-history/')}}/{{$user_details->id}}"><i class="me-1"><img
                                    src="{{ asset('assets/img/dashboard/withdrawnew.png') }}" alt="withdraw" width="30">
                            </i>Withdrawal History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="team-segment"
                            href="{{ url('admin/users/view-detail/view-team/') }}/{{ $user_details->id }}"><i
                                class="me-1"><img loading="lazy" src="{{ asset('assets/img/dashboard/teamnew.png') }}" alt="team"
                                    width="30">
                            </i>View Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="referral-segment"
                            href="{{ url('admin/users/view-detail/view-referral/') }}/{{ $user_details->id }}"><i
                                class="me-1"><img loading="lazy" src="{{ asset('assets/img/dashboard/referral.png') }}" alt="referral"
                                    width="30">
                            </i>View Referral</a>
                    </li>
                </ul>
                </ul>
                <!--/ User Tabs -->

                <!-- Earning History table -->
                <div class="card mb-4">
                    <h5 class="card-header"> Withdrawal History List</h5>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-2">
                                <div class="form-group mb-1" style="width:60%">
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
                            <div class="col-4">
                            </div>
                            <div class="col-3">
                                <div class="form-floating form-floating-outline">
                                    <select class="form-control valid" id="status" name="status" aria-invalid="false">
                                        <option value="0">Select status</option>
                                        <option value="1">Pending</option>
                                        <option value="2">Success</option>
                                        <option value="3">Rejected</option>
                                        <option value="4">Approved</option>
                                        <option value="5">Cancelled</option>
                                        <option value="6">Hold</option>
                                    </select>
                                    <label for="status">Status</label>
                                </div>
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
                                        <th class="text-center">SN</th>
                                        <th class="text-center sortable cursor-pointer" data-sort="transaction_id">Transaction
                                            Id<span class="sort-indicator"></span></th>
                                        <th class="text-center sortable cursor-pointer" data-sort="mobile_no">Mobile No<span
                                                class="sort-indicator"></span></th>
                                        <th class="text-center sortable cursor-pointer" data-sort="point">Point<span
                                                class="sort-indicator"></span></th>
                                        <th class="text-center sortable cursor-pointer" data-sort="charge_point">Charge Point<span
                                                class="sort-indicator"></span></th>
                                        <th class="text-center sortable cursor-pointer" data-sort="transfer_types.type_name">
                                            Withdrawal Type<span class="sort-indicator"></span></th>
                                        <th class="text-center sortable cursor-pointer" data-sort="created_at">Date & Time<span
                                                class="sort-indicator"></span></th>
                                        <th class="text-center sortable cursor-pointer" data-sort="status">Status<span
                                                class="sort-indicator"></span></th>

                                    </tr>
                                </thead>
                                <tbody id="product-data-table">
                                <tr>
                                    <td colspan="9" class="text-center table-loader">Loading...</td>
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
                <!-- /Earning History table -->

            </div>
            <!--/ User Content -->
        </div>


    </div>
    <!-- / Content -->
    @push('script')
        <script>
            let page = 1
            let currentPage = 1;
            let totalPages = 1;
            let page_length = 10;
            let column = 'users_withdrawal_history.updated_at';
            let sortOrder = 'desc';
            let imagepath = "{{ config('constants.PRODUCT_IMAGES_FULL_PATH') }}";
            let status = 0;
            let userId ="<?php echo "$user_details->id" ?>";
            let data_total = 0;

            fetchData(1, page_length, column, sortOrder, status,userId);

            function fetchData(page, page_length, column, sortOrder, status,userId) {
                $.ajax({
                    url: '{{ url('admin/user-withdrawal-history/get-list') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: page_length,
                        sort_column: column,
                        sort_order: sortOrder,
                        search: $('#search').val(),
                        status: status,
                        userid   : userId
                    },
                    success: function(response) {
                        var data = response.data.data;
                        var html = '';
                        if (data === null || data.length === 0) {
                            html += '<tr><td colspan="9" class="text-center">No data found</td></tr>';
                        } else {

                            // Populate table rows
                            for (var i = 0; i < data.length; i++) {
                                var serialNumber = i + 1 + ((response.data.current_page - 1) * parseInt(
                                    page_length));
                                html += '<tr>';

                                html += '<td class="text-center">' + serialNumber + '</td>';

                                html += '<td class="text-center">' + data[i].transaction_id + '</td>';

                                html += '<td class="text-center">' + data[i].mobile_no + '</td>';

                                html += '<td class="text-center">' + data[i].amount + '</td>';

                                html += '<td class="text-center">' + data[i].charge_amount + '</td>';

                                html += '<td class="text-center">' + data[i].type_name + '</td>';



                                html += '<td class="text-center">' + data[i].created_at + '</td>';


                                if (data[i].status == "Pending") {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-primary me-1">${data[i].status}</span></td>`;
                                } else if (data[i].status == "Success") {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-success me-1">${data[i].status}</span></td>`;
                                }else if (data[i].status == "Rejected") {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-danger me-1">${data[i].status}</span></td>`;
                                }else if (data[i].status == "Approved") {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-success me-1">${data[i].status}</span></td>`;
                                }else if (data[i].status == "Cancelled") {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-warning me-1">${data[i].status}</span></td>`;
                                }else if (data[i].status == "Hold") {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-dark me-1">${data[i].status}</span></td>`;
                                }  else {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-secondary me-1">${data[i].status}</span></td>`;
                                }

                                html += '</tr>';
                            }
                        }
                        $('#product-data-table').html(html);

                        // Update pagination links
                        currentPage = response.data.current_page;
                        totalPages = response.data.last_page;
                        updatePaginationLinks();
                        data_total = response.data.total;
                        updatePaginationInfo();
                    }
                });
            }

            $("#status").on('change', function() {
                status = $("#status").val();
                fetchData(1, page_length, column, sortOrder, status,userId);
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
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                page = $(this).data('page');
                fetchData(page, page_length, column, sortOrder, status,userId);
            });

            // Search input keyup event
            $('#search').on('keyup', function() {
                currentPage = 1;
                fetchData(currentPage, page_length, column, sortOrder, status,userId);
            });

            // Page length evenet
            $('#p-length').on('change', function() {
                currentPage = 1;
                page_length = this.value;
                fetchData(currentPage, page_length, column, sortOrder, status,userId);
            });

            // Sorting click event
            $('.sortable').click(function() {
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
                fetchData(currentPage, page_length, column, sortOrder, status,userId);

            });

            window.onload = function() {
                // Get the dropdown element
                var dropdown = document.getElementById("status");
                // Set the selectedIndex property to -1 to unselect the option
                dropdown.selectedIndex = 0;
            };

        </script>
    @endpush
@endsection
