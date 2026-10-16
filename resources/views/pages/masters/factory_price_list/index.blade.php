@extends('layouts.app', ['activePage' => 'fabrics', 'titlePage' => __('Fabrics')])

@section('content')

<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }
    .filter_btn {
        padding: 4px;
        text-align: center;
        width: 70px;
        padding-right: 6px;
        background-color: rgb(0, 254, 0);
        border-radius: 5px;
        cursor: pointer;
        color: white !important;
    }
    .filter_div {
        margin-top: 15px;
        margin-bottom: 15px;
        border-radius: 2px;
        border: unset;
        padding: 10px;
        width: 100%;
    }
    .table_header_text {
        color: white;
        height: 40px;
    }
    .row_padding {
        padding-top: 10px !important;
        padding-bottom: 10px !important;
    }
    .date_selection {
        background-color: transparent;
        padding: unset;
        border: unset;
        color: #47D6B6;
        font-size: 11px;
    }
    .date_p {
        margin: unset;
        font-size: 11px;
        color: #B3B3B3;
        font-weight: 500;
    }
    .filter_row {
        margin-left: unset;
        padding-left: 8px;
        padding-right: 9px;
        background-color: #F8F8F8;
        border: 1px solid#DEDEDE;
        border-radius: 16px;
        padding-top: 2px;
    }
    .styled-button{
        outline: unset;
        color: #d3d3d3;
        background-color: #fafafa;;
        border: 1px solid #d3d3d3;
        padding: .3rem;
        padding-left: .7rem;
        padding-right: .7rem;
        margin: 0rem;
        cursor: pointer;
    }
    .submit-changes-icon {
        text-align: right;
    }
    .save_filter {
        border-radius: 16px;
        padding-top: unset;
        padding-bottom: unset;
        margin-top: 3px;
        height: 24px;
    }
    .product-search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        width: 320px;
        max-width: 100%;
    }

    .product-search-input {
        width: 100%;
        height: 38px;
        padding: 8px 38px 8px 38px;
        border: 1px solid #dcdfe4;
        border-radius: 8px;
        background-color: #fff;
        color: #333;
        font-size: 13px;
        outline: none;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .product-search-input::placeholder {
        color: #a0a4aa;
    }

    .product-search-input:focus {
        border-color: #47D6B6;
        box-shadow: 0 0 0 3px rgba(71, 214, 182, 0.12);
    }

    .product-search-icon {
        position: absolute;
        left: 13px;
        color: #8d9298;
        font-size: 13px;
        pointer-events: none;
    }

    .product-search-clear {
        position: absolute;
        right: 8px;
        border: none;
        background: transparent;
        color: #9ca3af;
        width: 26px;
        height: 26px;
        padding: 0;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .product-search-clear:hover {
        background-color: #f1f3f5;
        color: #555;
    }

    @media (max-width: 768px) {
        .product-search-wrapper {
            width: 100%;
            margin-top: 8px;
        }

        .print_btn {
            width: 100%;
        }
    }
    .items-per-page-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 0;
        font-size: 13px;
        color: #6b7280;
    }

    .items-per-page-label {
        white-space: nowrap;
    }

    .items-per-page-select-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
    }

    .items-per-page-select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;

        height: 38px;
        min-width: 74px;

        padding: 7px 30px 7px 12px;

        border: 1px solid #dcdfe4;
        border-radius: 8px;

        background-color: #fff;
        color: #333;

        font-size: 13px;
        font-weight: 500;

        outline: none;
        cursor: pointer;

        transition: all 0.2s ease;

        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    }

    .items-per-page-select:hover {
        border-color: #bfc5cb;
    }

    .items-per-page-select:focus {
        border-color: #47D6B6;
        box-shadow: 0 0 0 3px rgba(71, 214, 182, 0.12);
    }

    .items-per-page-icon {
        position: absolute;
        right: 11px;

        font-size: 10px;
        color: #8d9298;

        pointer-events: none;
    }

    @media (max-width: 768px) {
        .items-per-page-wrapper {
            width: 100%;
            justify-content: flex-start;
        }
    }
</style>

<div class="container-fluid mb-5 content-position">
    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PRODUCTS PRICE LIST & WEIGHT</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="row col-md-12" style="padding: 0rem;">

        <div class="card filter_div">
            <div class="row" style="padding-left: 15px; margin: unset;">

                <div style="margin-right: 20px; margin-top: 3px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Product Status |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="activeInactive" class="date_selection">
                                <option value="">All</option>
                                <option value="1" {{ (isset($activeStatus) && $activeStatus == 1) ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ (isset($activeStatus) && $activeStatus == 0) ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px; margin-top: 3px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Price Types |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="pricetypes" class="date_selection">
                                <option value="">All</option>
                                <option value="1" {{ (isset($pricetype) && $pricetype == 1) ? 'selected' : '' }}>General</option>
                                <option value="2" {{ (isset($pricetype) && $pricetype == 2) ? 'selected' : '' }}>Silver</option>
                                <option value="3" {{ (isset($pricetype) && $pricetype == 3) ? 'selected' : '' }}>Gold</option>
                                <option value="4" {{ (isset($pricetype) && $pricetype == 4) ? 'selected' : '' }}>Platinum</option>
                                <option value="5" {{ (isset($pricetype) && $pricetype == 5) ? 'selected' : '' }}>Manufacturer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="margin-right: 20px; margin-top: 3px;">
                    <div class="row filter_row" style="padding-bottom: 2px;">
                        <p class="font_color date_p">Pricing |  </p>
                        <div class="paymen_type_div date_selection">
                            <select id="pricingOrNot" class="date_selection">
                                <option value="">All</option>
                                <option value="1" {{ (isset($pricingStatus) && $pricingStatus == 1) ? 'selected' : '' }}>Available</option>
                                <option value="2" {{ (isset($pricingStatus) && $pricingStatus == 2) ? 'selected' : '' }}>Not Available</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="">
                    <button class="styled-button save_filter" style="outline: unset;" href="#" id="save_filter" title="Save Filter">
                        Save & Filter
                    </button>
                </div>

                <div class="ml-auto row buttonDiv">
                    <button class="styled-button download_btn" style="outline: unset; margin-left: 14px;" href="#" id="display_csv" title="Display CSV">
                        Export
                    </button>
                </div>

            </div>
        </div>


        <div class="card orders_summary print_content" style="border: unset; padding: 10px; width: 100%;">

            <div class="row" style="margin: unset;">
                <div class="items-per-page-wrapper">
                    <span class="items-per-page-label">Show</span>

                    <div class="items-per-page-select-wrap">
                        <select
                            id="itemsPerPage"
                            class="items-per-page-select"
                            onchange="changeItemsPerPage(this.value)"
                        >
                            <option value="30" selected>30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="500">500</option>
                        </select>

                        <i class="fas fa-chevron-down items-per-page-icon"></i>
                    </div>

                    <span class="items-per-page-label">per page</span>
                </div>

                <div class="ml-auto print_btn">
                    <div class="product-search-wrapper">
                        <i class="fas fa-search product-search-icon"></i>

                        <input
                            class="search_class product-search-input"
                            id="searchOrder"
                            type="text"
                            placeholder="Search by product no or name..."
                            value="{{ isset($searchValue) ? $searchValue : '' }}"
                            autocomplete="off"
                        >

                        <button type="button" class="product-search-clear" id="clearSearch" title="Clear search">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>


            </div>



            <div class="order_sammary_table" style="overflow-x: auto;">

                <div id="global_check_icon" style="text-align: right; padding-right: 10px;"></div>

                <table class="table align-items-center" id="order_sammary_table" style="min-width: 100%;">

                    <thead style="background-color: #717070;">
                        <th scope="col" class="table_header_text">PRODUCT NO</th>
                        <th scope="col" class="table_header_text">PRODUCT NAME</th>
                        <th scope="col" class="table_header_text">PATTERN CODE</th>

                            <th scope="col" class="table_header_text" style="text-align: right;">WEIGHT(lbs)</th>

                            <th scope="col" class="table_header_text Manufacturer_price" style="text-align: right;">MANUFACTURER PRICE</th>

                            <th scope="col" class="table_header_text General_price" style="text-align: right;">GENERAL PRICE</th>

                            <th scope="col" class="table_header_text Platinum_price" style="text-align: right;">PLATINUM PRICE</th>

                            <th scope="col" class="table_header_text Gold_price" style="text-align: right;">GOLD PRICE</th>

                            <th scope="col" class="table_header_text Silver_price" style="text-align: right;">SILVER PRICE</th>



                        <th scope="col" class="table_header_text"></th>
                    </thead>

                    <tbody id="table_body">

                    </tbody>
                </table>

            </div>
            <div style="padding-top: 10px;">
                <div id="paginationbar" class="row justify-content-center" style="width: 100%;">
                  {{-- pagination bar paste here --}}
                </div>
            </div>
        </div>

    </div>

</div>

<script>
$(function () {
    $(".se-pre-con").fadeOut('slow');

    let changedPrices = [];
    let tableBody = document.getElementById('table_body');
    let paginationBar = document.getElementById('paginationbar');
    let ordersPerPage = 30;
    let currentPage = 1;
    let orderArray = @json($subProduct);
    let pricetype = @json($pricetype);

    // ----------- Render Table -----------
    function showOrders(page, data, pricetype) {
        updateColumnsVisibility(pricetype);
        tableBody.innerHTML = '';

        let startIndex = (page - 1) * ordersPerPage;
        let endIndex = Math.min(startIndex + ordersPerPage, data.length);
        let totalPages = Math.ceil(data.length / ordersPerPage);

        for (let i = startIndex; i < endIndex; i++) {
            let transaction = data[i];
            let patternCode = transaction.pattern_code || '';
            let weight = transaction.weight || '';
            let row = tableBody.insertRow();

            if (transaction.active == 0) {
                row.style.color = 'red';
            }

            // Build price columns dynamically
            let priceColumns = '';

            if (pricetype == null || pricetype == 5) {
                priceColumns += createPriceColumn('Manufacturer_price', transaction.price);
            }
            if (pricetype == null || pricetype == 1) {
                priceColumns += createPriceColumn('General_price', transaction.General_price);
            }
            if (pricetype == null || pricetype == 4) {
                priceColumns += createPriceColumn('Platinum_price', transaction.Platinum_price);
            }
            if (pricetype == null || pricetype == 3) {
                priceColumns += createPriceColumn('Gold_price', transaction.Gold_price);
            }
            if (pricetype == null || pricetype == 2) {
                priceColumns += createPriceColumn('Silver_price', transaction.Silver_price);
            }

            row.innerHTML = `
                <td class="font_color row_padding">${transaction.sub_product_no}</td>
                <td class="font_color row_padding">${transaction.product_name}</td>
                <td class="font_color row_padding">${patternCode}</td>
                <td class="font_color row_padding" style="text-align: right;">
                    <input type="number"
                        class="form-control form-input weight"
                        value="${transaction.weight ? parseFloat(transaction.weight) : ''}"
                        step="0.001"
                        min="0"
                        style="text-align: right; width: 100px; display: inline-block; height: 25px;"
                        data-type="weight" />
                </td>
                ${priceColumns}
                <td style="background-color: rgb(240 255 234);" class="font_color row_padding check-icon"></td>
            `;

            attachInputListeners(row, transaction.sub_product_no);
        }

        updatePagination(totalPages, currentPage);
    }

    function createPriceColumn(className, value) {
        return `
            <td class="font_color row_padding" style="text-align: right;background-color: rgb(240 255 234);">
                <input type="number" class="form-control form-input ${className}"
                       value="${value || ''}"
                       step="0.01"
                       style="text-align: right; width: 100px; display: inline-block; height: 25px;background-color: transparent;"
                       data-type="${className}" />
            </td>`;
    }

    function attachInputListeners(row, subProductNo) {
        let checkIconCell = row.querySelector('.check-icon');

        row.querySelectorAll('input[type="number"]').forEach(input => {
            let priceType = input.dataset.type;

            input.addEventListener('input', function () {
                checkIconCell.innerHTML = `<i class="fa fas fa-circle-check"
                                             style="color: lime; font-size: 18px; cursor: pointer;"></i>`;

                let newPrice = this.value.trim();
                let existingIndex = changedPrices.findIndex(change => change.sub_product_no === subProductNo);

                if (existingIndex !== -1) {
                    changedPrices[existingIndex][priceType] = newPrice;
                } else {
                    let change = { sub_product_no: subProductNo };
                    change[priceType] = newPrice;
                    changedPrices.push(change);
                }

                ensureSaveButton();
            });
        });
    }

    // ----------- Save Button -----------
    function ensureSaveButton() {
        let existingSubmitIcon = document.querySelector('.submit-changes-icon');
        if (!existingSubmitIcon) {
            let submitIcon = document.createElement('div');
            submitIcon.className = 'submit-changes-icon';
            submitIcon.innerHTML = `
                <button class="styled-button save_btn"
                        style="outline: unset; background-color: rgb(23, 217, 23); color: white; height: 30px;"
                        id="save_prices" title="Save Prices">Save</button>`;

            let exportButtonContainer = document.querySelector('.buttonDiv');
            let exportButton = exportButtonContainer.querySelector('#display_csv');

            exportButtonContainer.insertBefore(submitIcon, exportButton);

            submitIcon.addEventListener('click', function () {
                if (changedPrices.length > 0) {
                    $.ajax({
                        url: 'manufacturerPrice',
                        method: 'POST',
                        data: {
                            changes: changedPrices,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function () {
                            console.log('Prices updated successfully');
                            changedPrices = []; // reset after save
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error('Error sending data:', error);
                        }
                    });
                } else {
                    alert('No changes have been made.');
                }
            });
        }
    }

    // ----------- Pagination -----------
    function updatePagination(totalPages, currentPage) {
        paginationBar.innerHTML = '';
        if (totalPages <= 1) return;

        let pagination = '<nav aria-label="Page navigation"><ul class="pagination">';

        pagination += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">&laquo;</a></li>`;

        let startPage = Math.max(1, currentPage - 3);
        let endPage = Math.min(totalPages, currentPage + 3);

        for (let i = startPage; i <= endPage; i++) {
            pagination += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a></li>`;
        }

        pagination += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">&raquo;</a></li>`;

        pagination += '</ul></nav>';
        paginationBar.innerHTML = pagination;
    }

    window.changePage = function (page) {
        let totalPages = Math.ceil(orderArray.length / ordersPerPage);
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;
        showOrders(currentPage, orderArray, pricetype);
    };

    window.changeItemsPerPage = function (itemsPerPage) {
        ordersPerPage = parseInt(itemsPerPage);
        currentPage = 1;
        showOrders(currentPage, orderArray, pricetype);
    };

    // ----------- Search / Filter -----------
    let searchValue = null, prevActive = '', prevPricing = '', prevPricetype = '';

    function performSearch() {
        let inputValue = $('#searchOrder').val().trim();
        let activeStatus = $('#activeInactive').val();
        let pricingStatus = $('#pricingOrNot').val();
        let pricetype = $('#pricetypes').val();

        if (inputValue !== searchValue || activeStatus !== prevActive ||
            pricingStatus !== prevPricing || pricetype !== prevPricetype) {

            searchValue = inputValue;
            prevActive = activeStatus;
            prevPricing = pricingStatus;
            prevPricetype = pricetype;

            $.ajax({
                url: "{{ route('subProductSearch') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    searchValue,
                    activeStatus,
                    pricingStatus,
                    pricetype
                },
                beforeSend: function () {
                    $(".se-pre-con").fadeIn('slow');
                },
                success: function (response) {
                    orderArray = response.subProducts;
                    pricetype = response.pricetype;
                    currentPage = 1;
                    showOrders(currentPage, orderArray, pricetype);
                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                },
                complete: function () {
                    $(".se-pre-con").fadeOut('slow');
                }
            });
        }
    }

    $('#searchOrder').on('keyup blur', function (e) {
        if (e.type === 'blur' || e.key === 'Enter') performSearch();
    });

    $('#activeInactive, #pricingOrNot, #pricetypes').on('change', performSearch);

    // ----------- Save Filters -----------
    $('#save_filter').click(function () {
        let inputValue = $('#searchOrder').val().trim() || '';
        let activeStatus = $('#activeInactive').val() || '';
        let pricingStatus = $('#pricingOrNot').val() || '';
        let pricetype = $('#pricetypes').val() || '';

        $.ajax({
            url: "{{ route('saveFactoryPriceFilter') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                searchValue: inputValue,
                activeStatus,
                pricingStatus,
                pricetype
            },
            success: function (response) {
                console.log('Filter saved successfully:', response);
                window.location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Error saving filter:', error);
            }
        });
    });

    // ----------- Download CSV -----------
    $('.download_btn').click(function () {
        let activeInactive = $('#activeInactive').val() || 'all';
        let pricingOrNot = $('#pricingOrNot').val() || 'all';
        let inputValue = $('#searchOrder').val().trim() || 'all';
        let pricetype = $('#pricetypes').val().trim() || 'all';

        let routeUrl = "{{ url('/factoryPriceList_CSV_download') }}" +
            '/' + activeInactive + '/' + pricingOrNot + '/' + inputValue + '/' + pricetype;

        window.location.href = routeUrl;
    });

    // ----------- Column Visibility -----------
    function updateColumnsVisibility(pricetype) {
        const columnClasses = {
            5: 'Manufacturer_price',
            4: 'Platinum_price',
            3: 'Gold_price',
            2: 'Silver_price',
            1: 'General_price'
        };

        Object.values(columnClasses).forEach(className => {
            document.querySelectorAll(`.${className}`).forEach(column => {
                column.style.display = 'none';
            });
        });

        if (pricetype === null) {
            Object.values(columnClasses).forEach(className => {
                document.querySelectorAll(`.${className}`).forEach(column => {
                    column.style.display = '';
                });
            });
        } else {
            let className = columnClasses[pricetype];
            if (className) {
                document.querySelectorAll(`.${className}`).forEach(column => {
                    column.style.display = '';
                });
            }
        }
    }

    // Initial render
    showOrders(currentPage, orderArray, pricetype);
});
</script>



@endsection
