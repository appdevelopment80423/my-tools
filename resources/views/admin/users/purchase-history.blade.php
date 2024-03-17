@extends('admin.layout.main')
@section('title', 'User Purchase Product List')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">User Purchase Product List</h5>
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
                    <div class="col-8"></div>
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
{{--                            <th class="text-center sortable cursor-pointer" data-sort="users.name">Name<span--}}
{{--                                    class="sort-indicator"></span></th>--}}
{{--                            <th class="text-center sortable cursor-pointer" data-sort="users.email">Email<span--}}
{{--                                    class="sort-indicator"></span></th>--}}
                            <th class="text-center sortable cursor-pointer" data-sort="products_types.name">Product Type<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="products.uid">Product UID<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="products.name">Product Name<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="products.price">Price<span
                                    class="sort-indicator"></span></th>
                            <th class="text-center sortable cursor-pointer" data-sort="products.delivery_fees">Delivery Fees<span
                                    class="sort-indicator"></span></th>
                        </tr>
                        </thead>
                        <tbody id="data-table">
                        <tr>
                            <td colspan="8" class="text-center table-loader">Loading...</td>
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
            let column = 'user_carts.updated_at';
            let sortOrder = 'desc';
            let userId = "<?php echo "$user_details->id"; ?>";
            let data_total = 0;

            fetchData(1, page_length, column, sortOrder);

            function fetchData(page, page_length, column, sortOrder) {
                $.ajax({
                    url: '{{ url('admin/user-purchase-product-history/get-list') }}',
                    method: 'GET',
                    data: {
                        page: page,
                        per_page: page_length,
                        sort_column: column,
                        sort_order: sortOrder,
                        search: $('#search').val(),
                        user_id: userId
                    },
                    success: function (response) {
                        var data = response.data.data;
                        var html = '';
                        if (data === null || data.length === 0) {
                            html += '<tr><td colspan="8" class="text-center">No data found</td></tr>';
                        } else {

                            // Populate table rows
                            for (var i = 0; i < data.length; i++) {
                                var serialNumber = i + 1 + ((response.data.current_page - 1) * parseInt(
                                    page_length));
                                html += '<tr>';

                                html += '<td class="text-center">' + serialNumber + '</td>';

                                // html += '<td class="text-center">' + data[i].name + '</td>';
                                //
                                // html += '<td class="text-center">' + data[i].email + '</td>';

                                html += '<td class="text-center">' + data[i].Typename + '</td>';

                                html += '<td class="text-center">' + data[i].uid + '</td>';

                                html += '<td class="text-center">' + data[i].product_name + '</td>';

                                if (data[i].is_free == 1) {
                                    html += '<td class="text-center"> <span class="badge bg-label-primary me-1">Free</span> </td>';
                                }else{
                                    html += '<td class="text-center">₹' + data[i].price + '</td>';
                                }

                                if (data[i].is_free == 1) {
                                    html += '<td class="text-center"> - </td>';
                                }else{
                                    html += '<td class="text-center">' + data[i].delivery_fees + '</td>';
                                }

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
        </script>
    @endpush
@endsection
