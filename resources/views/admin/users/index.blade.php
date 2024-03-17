@extends('admin.layout.main')
@section('title', 'User List')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Users</h5>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-xl-2 col-xxl-1 col-4 col-lg-2 col-sm-3 col-md-2">
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
                    <div class="col-xl-6 col-xxl-8 col-2 col-lg-6 col-sm-5 col-md-6">
                        @can('user_approval_access')
                            <button type="button" onclick="earningApproveUpdate()"
                                    class="btn btn-primary waves-effect waves-light">UPDATE</button>
                        @endcan
                    </div>
                    <div class="col-xl-4 col-xxl-3 col-6 col-lg-4 col-sm-4 col-md-4">
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
                            @can('user_approval_access')
                                <th class="text-center" style="font-size:unset;">
                                    <div class="form-check form-check-danger">
                                        <input class="form-check-input" type="checkbox" value=""
                                               id="checkbox-primary-all" />

                                    </div>
                                </th>
                            @endcan
                            <th class="text-center">SN</th>
                            <th class="text-center">Profile</th>
                            <th class="text-center sortable cursor-pointer" data-sort="name">Name<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="email">Email<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="gender">Gender<span
                                        class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="mobile_number">Mobile No<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="dob">DOB<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="pin">Pin<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="referral_code">Referral Code<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="created_at">Date & Time<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="status">Status<span
                                    class="sort-indicator"></span></th>
                        </tr>
                        </thead>
                        <tbody id="data-table">
                        <tr>
                            <td colspan="13" class="text-center table-loader">Loading...</td>
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
    <!-- Status Approval  Modal -->
    <div class="modal fade" id="statusUpadateModel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel2">User Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-4 mt-2">
                            <div class="form-floating form-floating-outline">
                                <select class="form-select @error('approveStatus') is-invalid @enderror" value=""
                                        name="approveStatus" id="approvalStatus">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" id="update-status-approval" class="btn btn-primary">UPDATE</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Status Approval  Modal -->
    @push('script')
        <script>
            let page = 1
            let currentPage = 1;
            let totalPages = 1;
            let page_length = 10;
            let column = 'created_at';
            let sortOrder = 'desc';
            let viewLink = "{{ url('admin/users/view-detail/earning-history') }}";
            let viewPurchase = "{{ url('admin/users/view-detail/purchase-history') }}";
            let logsLink = "{{ url('admin/users/logs-list') }}";
            let image_path = "{{ config('constants.USER_PROFILE_IMAGES_FULL_PATH') }}";
            let data_total = 0;

            fetchData(1, page_length, column, sortOrder);

            function fetchData(page, page_length, column, sortOrder) {
                $.ajax({
                    url: '{{ url('admin/users/get-list') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: page_length,
                        sort_column: column,
                        sort_order: sortOrder,
                        search: $('#search').val()
                    },
                    success: function (response) {
                        var data = response.data;
                        var html = '';
                        if (data === null || data.length === 0) {
                            html += '<tr><td colspan="13" class="text-center">No data found</td></tr>';
                        } else {

                            // Populate table rows
                            for (var i = 0; i < data.length; i++) {
                                var serialNumber = i + 1 + ((response.current_page - 1) * parseInt(page_length));
                                html += '<tr>';

                                @can('user_approval_access')
                                    html += `<td class="text-center"><div class="form-check form-check-danger">
                                        <input class="form-check-input web-check-all" type="checkbox" value=""
                                            id="${data[i].id}"  />
                                    </div></td>`;
                                @endcan

                                html += '<td class="text-center">' + serialNumber + '</td>';


                                if (data[i].image) {
                                    let imageSrc = data[i].image.startsWith('https') ? data[i].image : image_path + data[i].image;
                                    html += '<td class="text-center">' +
                                        '<a href="' + imageSrc + '" target="_blank">' +
                                        '<img loading="lazy" style="width: 50px; height: 50px; border-radius: 10px;" src="' + imageSrc + '" alt="Profile">' +
                                        '</a>' +
                                        '</td>';
                                }
                                else{
                                    if(data[i].gender == 'male'){
                                            html += '<td class="text-center">' + '<a href="{{ asset('assets/img/avatars/male/5.png') }}" target="_blank"><img loading="lazy" style="width: 50px; height: 50px; border-radius: 10px;" src="{{ asset('assets/img/avatars/male/5.png') }}" alt="Profile"></a>' + '</td>';

                                        } else {
                                        html += '<td class="text-center">' + '<a href="{{ asset('assets/img/avatars/female/5.png') }}" target="_blank"><img loading="lazy" style="width: 50px; height: 50px; border-radius: 10px;" src="{{ asset('assets/img/avatars/female/5.png') }}" alt="Profile"></a>' + '</td>';

                                        }
                                    }
                                html += '<td class="text-center">' + data[i].name + '</td>';
                                html += '<td class="text-center ">' + data[i].email +'</td>';
                                html += '<td class="text-center">' + data[i].gender + '</td>';

                                html += '<td class="text-center">' + data[i].mobile_number + '</td>';
                                if(data[i].dob) {
                                    html += '<td class="text-center">' + data[i].dob + '</td>';
                                } else {
                                    html += '<td class="text-center">-</td>';
                                }

                                html += '<td class="text-center">' + data[i].pin + '</td>';

                                if (data[i].referral_code) {
                                    html += '<td class="text-center">' + data[i].referral_code + '</td>';
                                } else {
                                    html += '<td class="text-center">-</td>';
                                }

                                html += '<td class="text-center">' + data[i].created_at + '</td>';

                                if (data[i].status == 1) {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-success me-1">Active</span></td>`;
                                } else {
                                    html +=
                                        `<td class="text-center"><span class="badge bg-label-danger me-1">Inactive</span></td>`;
                                }
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
                fetchData(page, page_length, column, sortOrder);
            });

            // Search input keyup event
            $('#search').on('keyup', function () {
                currentPage = 1;
                fetchData(currentPage, page_length, column, sortOrder);
            });

            // Page length evenet
            $('#p-length').on('change', function () {
                currentPage = 1;
                page_length = this.value;
                fetchData(currentPage, page_length, column, sortOrder);
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
                fetchData(currentPage, page_length, column, sortOrder);

            });

            //checkbox select data  client delete
            $("#checkbox-primary-all").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            var statusIdsArray = [];

            function checkCheckedWeb() {
                statusIdsArray = [];

                $('.web-check-all:checked').each(function() {
                    statusIdsArray.push($(this).attr('id'));
                });
                if (statusIdsArray.length <= 0) {
                    return false;
                } else {
                    return true;
                }
            }

            window.onload = function() {
                $('#checkbox-primary-all,.web-check-all').prop(
                    "checked", false);

            };


            function earningApproveUpdate() {
                if (checkCheckedWeb()) {
                    $("#approvalStatus").val(1);
                    $('#statusUpadateModel').modal('show');

                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Please select at least one column',
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            }

            $("#update-status-approval").click(function() {
                $('#statusUpadateModel').modal('hide');
                let approvalStatus = $('#approvalStatus').val();

                if (checkCheckedWeb()) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('admin/users/update-status') }}",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        data: JSON.stringify({
                            statusids: statusIdsArray,
                            approveStatus: approvalStatus
                        }),
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            let code = data.code;
                            let message = data.message;
                            if (code == 200) {
                                statusIdsArray = [];
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: message,
                                    customClass: {
                                        confirmButton: 'btn btn-success waves-effect'
                                    }
                                }).then(function() {
                                    $('#statusUpadateModel').modal('hide');
                                    $('#checkbox-primary-all,.web-check-all').prop(
                                        "checked", false);
                                    fetchData(1, page_length, column, sortOrder,
                                        status);
                                });

                            } else {

                                Swal.fire({
                                    position: 'center',
                                    icon: 'error',
                                    title: message,
                                    showConfirmButton: false,
                                    timer: 2500
                                })
                                statusIdsArray = [];
                            }
                        },
                        error: function(err) {
                            $('#statusUpadateModel').modal('hide');
                            statusIdsArray = [];

                        },
                    });

                } else {
                    statusIdsArray = [];

                }
            });
        </script>
    @endpush
@endsection
