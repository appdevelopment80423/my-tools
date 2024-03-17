@extends('admin.layout.main')
@section('title', 'Member List')
@section('content')
    @push('vendor-css')
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    @endpush
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <h5 class="card-header">Members</h5>
            @can('member_create')
                <div class="dt-action-buttons text-end">
                    <a class="btn btn-secondary create-new btn-primary pt-2 waves-effect waves-light" style="margin-right:12px"
                       tabindex="0" aria-controls="DataTables_Table_0" href="{{ url('admin/members/create') }}">
                        <span><i class="mdi mdi-plus me-sm-1"></i> <span class="d-none d-sm-inline-block">Add Member</span>
                        </span>
                    </a>
                </div>
            @endcan
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
                                <th class="text-center">SR</th>
                                <th class="text-center sortable cursor-pointer" data-sort="name">Full name<span
                                        class="sort-indicator"></span></th>
                                <th class="text-center sortable cursor-pointer" data-sort="email">Email<span
                                        class="sort-indicator"></span></th>
                                <th class="text-center sortable cursor-pointer" data-sort="role_name">Role<span
                                        class="sort-indicator"></span></th>
                                <th class="text-center">IP Restriction</th>

                            @canany(['member_edit','member_delete'])
                                    <th class="text-center">Action</th>
                                       @endcan
                            </tr>
                        </thead>
                        <tbody id="data-table">
                        <tr>
                            <td colspan="6" class="text-center table-loader">Loading...</td>
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
            let page = 1
            let currentPage = 1;
            let totalPages = 1;
            let page_length = 10;
            let column = 'admins.id';
            let sortOrder = 'asc';
            let data_total = 0;

            fetchData(1, page_length, column, sortOrder);

            function fetchData(page, page_length, column, sortOrder) {
                $.ajax({
                    url: '{{ route('admin.members.get-list') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: page_length,
                        sort_column: column,
                        sort_order: sortOrder,
                        search: $('#search').val()
                    },
                    success: function(response) {
                        var data = response.data;
                        var html = '';
                        if (data === null || data.length === 0) {
                            html += '<tr><td colspan="6" class="text-center">No data found</td></tr>';
                        } else {

                            // Populate table rows
                            for (var i = 0; i < data.length; i++) {

                                let edit_url = "{{ url('admin/members/edit') }}";
                                let delete_url = "{{ url('admin/members/delete') }}";

                                var serialNumber = i + 1 + ((response.current_page - 1) * parseInt(page_length));
                                html += '<tr>';
                                html += '<td class="text-center">' + serialNumber + '</td>';
                                html += '<td class="text-center">' + data[i].name + '</td>';
                                html += '<td class="text-center">' + data[i].email + '</td>';
                                html += '<td class="text-center">' + data[i].role_name + '</td>';

                                if (data[i].allow_ip !== null) {
                                    html += `<td class="text-center">
                                            <label class="switch">
                                             <input type="checkbox" class="switch-input" class="switch" data-id="${data[i].id}" onchange="ipUpdateStatus(this);" `;
                                    if (data[i].ip_restriction === 1) {
                                        html += 'checked';
                                    } else {
                                        html += '';
                                    }
                                    html += ` />
                                            <span class="switch-toggle-slider">
                                                <span  class="switch-on"> </span>
                                                <span class="switch-off"></span>
                                            </span>
                                               </label>
                                            </td>`;
                                }else{
                                    html += '<td class="text-center">-</td>';

                                }
                                @canany(['member_edit', 'member_delete'])
                                    html +=
                                        '<td class="text-center"><div class="dropdown"> <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false"> <i class="mdi mdi-dots-vertical"></i> </button><div class="dropdown-menu" style=""><a href="' +
                                        edit_url + '/' + data[i].id +
                                        '" id="editbutton" class="dropdown-item waves-effect"><i class="mdi mdi-pencil-outline me-1"></i> Edit</a><a class="dropdown-item waves-effect" onclick="deleteRecord(`' +
                                delete_url + '/' + data[i].id +
                                '`,`.settings`)" href="javascript:void(0);"><i class="mdi mdi-trash-can-outline me-1"></i> Delete</a></div></div></td>';
                                @endcanany
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

            function updatePaginationInfo() {
                var pageText = 'Showing Page ' + currentPage + ' of ' + totalPages + ' Total ' + data_total + ' Entries ';
                $('#pagination-info').html(pageText);
            }

            // Page link click event
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                page = $(this).data('page');
                fetchData(page, page_length, column, sortOrder);
            });

            // Search input keyup event
            $('#search').on('keyup', function() {
                currentPage = 1;
                fetchData(currentPage, page_length, column, sortOrder);
            });

        // Page length event
        $('#p-length').on('change', function () {
            currentPage = 1;
            page_length = this.value;
            fetchData(currentPage, page_length, column, sortOrder);
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
                fetchData(currentPage, page_length, column, sortOrder);

            });
            function ipUpdateStatus(element) {

                let admin_id = $(element).attr("data-id");
                let ip_restriction = $(element).prop('checked') ? 1 : 0;
                $.ajax({
                    url: '{{ url('admin/members/update-ip-restriction') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {id: admin_id, ip_restriction: ip_restriction},
                    success: function (data) {
                        let code = data.code;
                        let message = data.message;
                        if (code == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: message,
                                customClass: {
                                    confirmButton: 'btn btn-success waves-effect'
                                }
                            }).then(function () {
                                $('#checkbox-primary-all,.web-check-all').prop(
                                    "checked", false);
                                fetchData(currentPage, page_length, column, sortOrder);
                            });

                        } else {
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: message,
                                showConfirmButton: false,
                                timer: 2500
                            })
                        }
                    },
                    error: function (err) {

                    },
                });
            }


        </script>
    @endpush
@endsection
