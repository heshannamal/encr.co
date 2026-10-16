@extends('layouts.app', ['activePage' => 'product_catalog', 'titlePage' => __('Product Catalog')])

@section('content')
<style>

#productCard{
    background-color: transparent;
}

.dropdown {
        position: relative;
        display: inline-block;
        margin-left: 10%;
        color: black;
        font-size: 15px;
        font-weight: 700;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        margin-top: 10px;
    }

    .dropdown-content label {
        display: block;
        cursor: pointer;
    }
    /* .filterbtn:hover {
        box-shadow: 0 6px 6px rgba(0, 0, 0, 0.2);
    } */
    .filterbtn{
        width: 127%;
        background-color: rgba(162, 162, 162, 0.18);
        border: unset;
        color: rgb(94, 94, 94);
        cursor: pointer;
        border-radius: 0.2rem;
        font-size: 10px;
        text-align: left;
        padding: 6%;
        padding-top: 6%;
        padding-bottom: 6%;
    }
    .filterbtnClear{
        width: 127%;
        background-color: rgba(162, 162, 162, 0.18);
        border: unset;
        color: rgb(94, 94, 94);
        cursor: pointer;
        border-radius: 0.2rem;
        font-size: 10px;
        padding: 6%;
        padding-top: 6%;
        padding-bottom: 6%;
    }
    .custom-control-input:checked ~ .custom-control-label::before {
            background-color: aquamarine !important;
            border-color: aquamarine  !important;
        }
    .page-item.active .page-link{
        background-color: grey;
    }

    .main-content{
        background-color: #F8F8F8;
    }
    .filterContainer {
        max-width: 100px;
        min-width: 100px;
    }
    .product_image {
        width: 100%;
        height: auto;
        padding-left: 10px;
        padding-right: 10px;
    }
    .product-link {
        font-size: .8rem;
        color: rgba(202, 201, 201, 1);
    }
    .product-link:hover {
        color: rgba(202, 201, 201, 1);
    }
    .image_card {
        height: fit-content;
        width: 100%;
        padding: 10px;
    }
    .filterbtn::after {
        content: '';
        position: absolute;
        right: 0px;
        top: 45%;
        transform: translateY(-59%);
        border: 6px solid rgba(198, 198, 198, 0);
        border-top-color: #888;
    }
</style>
{{-- <div class="row" style="margin: 2%">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" style="background-color: transparent; border: none;">
                  <img src="{{ asset('assets/img/icons/catlog/search_1x.png') }}" alt="search" style="height: 20px;">
                </span>
              </div>
              <input type="text" class="form-control" id="exampleFormControlInput" placeholder="Search Products" style="background-color: transparent; border: none;font-size:15px">
            </div>
        <div class="col-lg-2">
            <select name="selectedorder" id="selectedorder" style="border: none;font-size: 15px;font-weight: 700; outline: unset;cursor: pointer;background: none;"  title="Select order">
                <option value="0">SORT BY</option>
                <option value="1">Acending</option>
                <option value="2">Decending</option>
            </select>
        </div>
</div> --}}
@section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection
<div class="row mb-4 mt-2" style="margin: 2%">
        {{-- <div class="col-lg-1" style="width: 100px; min-width: 100px;">
                <button class="filterbtn" type="button" id="filterButton_call" style="outline:none; cursor: pointer;border:none; width: 100px; font-size:14px;" disabled>
                    FILTER BY
                </button>
        </div> --}}
        <div class="filters col-lg-1 filterContainer">
                <button class="filterbtn" onclick="toggleDropdown('category')">
                    <i class="fa " aria-hidden="true" id="categoryIcon"></i>&nbsp;CATEGORY
                </button>
                <div id="categoryDropdown" class="dropdown-content" style="width:150%; background-color:white; border: 1px solid rgb(194, 194, 194);color:black">
                    <div>
                        <label style="font-size: 12px;margin: 10%;">FILTER BY CATEGORY</label>
                    </div>
                    @foreach ($mainCategory as $MainCategory)
                        @if($MainCategory->category_name !== 'Sport')
                        <div class="custom-control custom-checkbox custom-control-lg mb-3">
                            <input type="checkbox" name="category[]" class="custom-control-input" id="{{$MainCategory->category_name}}" value="{{$MainCategory->category_name}}" data-value="{{ $MainCategory->id }}">
                            <label class="custom-control-label ml-3 mt-2" for="{{$MainCategory->category_name}}">{{$MainCategory->category_name}}</label>
                        </div>
                        @endif
                    @endforeach
                </div>
        </div>
            <div class="filters col-lg-1 filterContainer">
                    <button class="filterbtn" onclick="toggleDropdown('gender')">
                        <i class="fa " aria-hidden="true"></i>&nbsp;GENDER
                    </button>
                    <div id="genderDropdown" class="dropdown-content" style="width:100%;color:black; background-color:white; border: 1px solid rgb(194, 194, 194)">
                        <div>
                            <label style="font-size: 12px;margin: 10%;">FILTER BY GENDER</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-lg mb-3">
                            <input type="checkbox" name="genders[]" class="custom-control-input" id="Men" value="Men">
                            <label class="custom-control-label ml-3 mt-2" for="Men">Men</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-lg mb-3">
                            <input type="checkbox" name="genders[]" class="custom-control-input" id="Women" value="Women">
                            <label class="custom-control-label ml-3 mt-2" for="Women">Women</label>
                        </div>
                        <div class="custom-control custom-checkbox custom-control-lg mb-4 mb-3">
                            <input type="checkbox" name="genders[]" class="custom-control-input" id="Uni" value="Uni">
                            <label class="custom-control-label ml-3 mt-2" for="Uni">Uni</label>
                        </div>
                    </div>
            </div>
            <div class="filters col-lg-1 filterContainer">
                    <button class="filterbtn" onclick="toggleDropdown('sport')">
                        <i class="fa " aria-hidden="true"></i>&nbsp;SPORT
                    </button>
                    <div id="sportDropdown" class="dropdown-content" style="width:100%; color:black; background-color:white; border: 1px solid rgb(194, 194, 194)">
                        <div>
                            <label style="font-size: 12px;margin: 10%;">FILTER BY SPORT</label>
                        </div>
                        @foreach ($sports as $sport)
                        {{-- @if ($sport->sport_name !== 'Field Hockey' && $sport->sport_name !== 'Muay Thai' && $sport->sport_name !== 'Lifestyle' && $sport->sport_name !== 'Training') --}}
                            <div class="custom-control custom-checkbox custom-control-lg mb-3">
                                <input type="checkbox" name="sports[]" class="custom-control-input" id="{{ $sport->sport_name }}" value="{{ $sport->sport_name }}" data-value="{{ $sport->id }}">
                                <label class="custom-control-label ml-3 mt-2" for="{{ $sport->sport_name }}">{{ $sport->sport_name }}</label>
                            </div>
                        {{-- @endif --}}
                        @endforeach
                    </div>
            </div>
            <div class="filters col-lg-1 filterContainer">
                    <button class="filterbtn" onclick="toggleDropdown('style')">
                        <i class="fa " aria-hidden="true"></i>&nbsp;STYLE
                    </button>
                    <div id="styleDropdown" class="dropdown-content" style="width:190px; color:black; background-color:white; border: 1px solid rgb(194, 194, 194)">
                        <div>
                            <label style="font-size: 12px;margin: 10%;">FILTER BY STYLE</label>
                        </div>
                        @foreach ($productCategory as $productCategory)
                                <div class="custom-control custom-checkbox custom-control-lg mb-3">
                                    <input type="checkbox" name="style[]" class="custom-control-input" id="{{$productCategory->product_category_name}}" value="{{$productCategory->product_category_name}}" data-value="{{ $productCategory->id }}">
                                    <label class="custom-control-label ml-3 mt-2" for="{{$productCategory->product_category_name}}" style="color: black;font-size: 16px;">{{$productCategory->product_category_name}}</label>
                                </div>
                        @endforeach
                    </div>
            </div>
            <div class="col-lg-1" style="margin-right: 5%; margin-left: 15px; width: 100px; padding-bottom: 5px;">
                <a href="{{ Request::url() }}">
                    <button class="filterbtnClear" style="outline:none; background-color: rgb(193, 193, 193); cursor: pointer;border:none; width: 81px; height: 28px; font-size:10px; color: white;">CLEAR FILTER</button>
                </a>
            </div>
            <div class="col-lg-2 ml-auto">
                <div class="input-group" style="border: 1px solid rgb(221, 221, 221);">
                    <div class="input-group-prepend">
                      <span class="input-group-text" style="background-color: transparent; border: none; padding-left: 5px; padding-right: 5px;">
                        <img src="{{ asset('assets/img/icons/catlog/search_1x.png') }}" alt="search" style="height: 14px;">
                      </span>
                    </div>
                    <input type="text" class="form-control" id="exampleFormControlInput" placeholder="Search Products" style="background-color: transparent; border: none;font-size:11px">
                  </div>
            </div>
</div>

<div class="row">
    <div class="row col-lg-9 mb-3" id="addlable" style="margin-left: 2%;">
        {{-- <div class="col-lg-1" style="display: flex; align-items: center;margin-right:5px">
            <div style="background-color: #ccc; display: flex; flex-direction: row; align-items: center;border-radius:1rem">
                <span id="addtext" style="padding: 5%;">Outewear&nbsp;&nbsp;</span>
                <span>
                    <i class="fas fa-times" style="padding-right: 25px;"></i>
                </span>
            </div>
        </div> --}}
    </div>
    <div class="col-lg-2 ml-auto product_count" style="text-align: right; padding-right: 3.5rem;">
        <p class="item_count" style="font-size: 13px; color: grey;"></p>
    </div>
</div>

{{-- {{dd($userData)}} --}}


<div class="row mb-5" id="paste_container" style="display: flex;margin: 2%;  width: 95%; max-width: 95%;">

        {{-- products paste here --}}
        {{-- Loader --}}
        <div id="loader" class="text-center" style="position: relative;top: 78px;left: 48%;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        {{-- <div class="col-lg-2" style="padding: .5%;">
            <div class="card position-relative" data-toggle="modal" id="productCard" data-target="#productModal" data-product-name="data-product-description" style="border-radius: .5rem" onmouseover="showOverlay()" onmouseout="hideOverlay()">
                    <i class="far fa-heart position-absolute top-2" style="right: 5%; color: black;"></i>
                    <i class="far fa-building position-absolute bottom-2" style="bottom:5%; right: 5%;background-color:red; padding:2%; border-radius:.2rem; color:white"></i>
                    <img src="https://i.ebayimg.com/images/g/B8EAAOSwKCljwfIS/s-l400.jpg" class="card-img-top" alt="Product Image" style="border-top-left-radius: .5rem; border-top-right-radius:.5rem">
                    <div class="overlay position-absolute" id="overlay" style="background-color: white;left: 30%;top: 30%; display:none">
                        <a href="{{ route('product_view', ['id' => 5]) }}" class="btn btn-sm">
                             See More&nbsp;&nbsp;<i class="far fa-eye"></i>
                        </a>
                    </div>
                <div class="card-body">
                    <p class="card-title" style="margin:0%;font-family: revert; font-weight: 600;font-size: 19px;font-stretch: semi-condensed; color:black">This is a test</p>
                    <p style="color: rgb(0, 0, 0); font-size: 14px;margin:1%;">PRO-5</p>
                    <p style="color: grey; font-size: 14px;margin:2%;">
                        <i class="fas fa-light fa-tag"></i>&nbsp;&nbsp;Customizable Product
                    </p>
                    <p style="font-size: 19px;font-weight: 600;color: black;margin-bottom: unset;margin-top: 9%;margin-left: 1%;">$60</p>
                </div>
            </div>
        </div> --}}

</div>

<div class="mb-5" style="width: 95%; max-width: 95%;">
    <div id="paginationbar" class="row justify-content-center">
        {{-- pagination bar paste here --}}
    </div>
</div>
<div class="mb-5" style="width: 95%; max-width: 95%;">
    <div class="row justify-content-center" style="height: 70px">

    </div>
</div>

<script>
    function hideDropdowns() {
        var dropdowns = document.querySelectorAll('.dropdown-content');

        // Hide all dropdown-content elements
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].style.display = 'none';
        }
    }

    document.addEventListener('click', function (event) {
        var targetElement = event.target;

        // Check if the clicked element is inside any filterContainer or dropdown-content
        var filterContainers = document.querySelectorAll('.filterContainer');
        var dropdownContents = document.querySelectorAll('.dropdown-content');

        for (var i = 0; i < filterContainers.length; i++) {
            if (filterContainers[i].contains(targetElement) || dropdownContents[i].contains(targetElement)) {
                // Clicked inside filterContainer or dropdown-content, do nothing (keep the dropdown open)
                return;
            }
        }

        // Clicked outside filterContainer and dropdown-content, hide all dropdown-contents
        hideDropdowns();
    });

    function toggleDropdown(id) {
        hideDropdowns();
        var dropdown = document.getElementById(id + 'Dropdown');
        var countElement = document.getElementById(id + 'count');

        if (dropdown.style.display === 'block') {
            dropdown.style.display = 'none';
        } else {
            dropdown.style.display = 'block';
        }

        // Update the count for the respective dropdown
        // var checkboxes = document.querySelectorAll('input[name="' + id + '[]"]:checked');
        // countElement.innerText = checkboxes.length;
        const categoryIcon = document.getElementById(id +'Icon');
        //console.log(categoryIcon);
        if (categoryIcon.classList.contains('fa-plus-circle')) {
            categoryIcon.classList.remove('fa-plus-circle');
            categoryIcon.classList.add('fa-times-circle');
        }

    }

    // Optional: Close the dropdown when the document is loaded initially
    document.addEventListener('DOMContentLoaded', function () {
        hideDropdowns();
    });
</script>
<script>
    function toggleCheckboxList(id) {
        var checkboxList = document.getElementById(id);

        if (checkboxList.style.display === "none") {
            checkboxList.style.display = "block";
        } else {
            checkboxList.style.display = "none";
        }
    }
</script>

    <script>

        filter();

            //Canging the order
            $('#selectedorder').change(function() {
                filter();
            });

           // {{-- After clicked filter button --}}

        function filter() {
            // Initialize empty arrays
            var selectedStyles = [];
            var selectedCategories = [];
            var selectedGenders = [];
            var selectedSports = [];

            var selectedOrder;

            // Get selected style checkboxes
            $('input[name="style[]"]:checked').each(function() {
            selectedStyles.push($(this).data('value'));
            });

            // Get selected category checkboxes
            $('input[name="category[]"]:checked').each(function() {
            selectedCategories.push($(this).data('value'));
            });

            // Get selected gender checkboxes
            $('input[name="genders[]"]:checked').each(function() {
            selectedGenders.push($(this).val());
            });

            // Get selected sports checkboxes
            $('input[name="sports[]"]:checked').each(function() {
            selectedSports.push($(this).data('value'));
            });

            console.log(selectedStyles);
            console.log(selectedCategories);
            console.log(selectedGenders);
            console.log(selectedSports);

            $(document).ready(function() {
            selectedOrder = $('#selectedorder').val();
            // Call a separate function that relies on selectedOrder
            performAction(selectedOrder);
            });

            function performAction(selectedOrder) {

                $.ajax({
                url: "{{ route('adminProductFilter') }}",
                method: "GET",
                data: {
                    style: selectedStyles,
                    category: selectedCategories,
                    genders: selectedGenders,
                    sports: selectedSports,
                },
                success: function(response) {
                    //console.log(response.message);
                    console.log(response);

                    // Access the products data and perform desired actions
                    var products = response.products;
                    //console.log(selectedOrder);

                    if (selectedOrder == 2) {
                    products.sort(function(a, b) {
                        if (a.product_name < b.product_name) {
                        return 1;
                        } else if (a.product_name > b.product_name) {
                        return -1;
                        }
                        return 0;
                    });
                    } else if (selectedOrder == 1) {
                    products.sort(function(a, b) {
                        if (a.product_name < b.product_name) {
                        return -1;
                        } else if (a.product_name > b.product_name) {
                        return 1;
                        }
                        return 0;
                    });
                    }

                    const matchingData = response.products;

                    let totalValues;

                    // Check if matchingData is an array
                    if (Array.isArray(matchingData)) {
                        totalValues = matchingData.length;
                    } else if (typeof matchingData === 'object') {
                        // Check if matchingData is an object
                        totalValues = Object.keys(matchingData).length;
                    } else {
                        console.error('matchingData is not an array or object.');
                    }

                    // Set the value of the <p> element
                    const itemCountElement = document.querySelector('.item_count');
                    if (itemCountElement) {
                        itemCountElement.textContent = `Showing ${totalValues} Products`;
                    } else {
                        console.error('Element with class "item_count" not found.');
                    }

                    showProducts(matchingData);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error:", textStatus, errorThrown);
                }
            })};

        }

           // {{-- search functions --}}

        $(document).ready(function() {
            // Bind keyup event to the search input field
            $('#exampleFormControlInput').keyup(function(event) {
                if (event.keyCode === 13) {
                // Enter key is pressed
                var searchValue = $(this).val();
                performSearch1(searchValue);
                }
            });

            // Bind blur event to the search input field (when user clicks outside the field)
            $('#exampleFormControlInput').blur(function() {
                var searchValue = $(this).val();
                performSearch1(searchValue);
            });
    console.log(searchValue);
            // Function to perform the search
            function performSearch1(value) {
            // Do something with the search value
            //console.log(value);

            // Send AJAX request to search route
            $.ajax({
                url: "{{ route('productSearchAdminCatalog') }}",
                method: "GET",
                data: {
                keyword: value,
                },
                success: function(response) {
                    //console.log(response.message);

                    if (response.searchValue == null || response.searchValue == undefined) {
                        location.reload(); // Refresh the page
                        return; // Exit function
                    }

                    // Access the search results and perform desired actions
                    var products = response.products;
                    console.log(response);

                    //console.log(userproductIds);

                    const matchingData = response.products;

                    let totalValues;

                    // Check if matchingData is an array
                    if (Array.isArray(matchingData)) {
                        totalValues = matchingData.length;
                    } else if (typeof matchingData === 'object') {
                        // Check if matchingData is an object
                        totalValues = Object.keys(matchingData).length;
                    } else {
                        console.error('matchingData is not an array or object.');
                    }

                    // Set the value of the <p> element
                    const itemCountElement = document.querySelector('.item_count');
                    if (itemCountElement) {
                        itemCountElement.textContent = `Showing ${totalValues} Products`;
                    } else {
                        console.error('Element with class "item_count" not found.');
                    }


                    renderProducts(products);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
                }
            });
            }
        });

    function renderProducts(products){
        var filteredProducts = products.filter(function(product) {
            return product.mockup_img_1 !== null;
        });
        showProducts(filteredProducts);
    }

        function showProducts(products) {
            $('#paste_container').empty();
            // console.log(products);
            // Iterate over the fetched products and append them to the container
            $.each(products, function (index, product) {
            var imageURL = "{{asset('assets/img/products/product defaul image.jpg')}}";

            if (product.mockup_img_1) {
                imageURL = product.mockup_img_1;
            }

            var id = product.id;
            var type = product.sub_product_no ? 'subproduct' : 'product';

            var productUrl = "{{ route('portal_product', ['id' => ':id', 'type' => ':type']) }}";
            productUrl = productUrl.replace(':id', id).replace(':type', type);
            //productUrl = "#";

            var productCard = `<div class="col-lg-3" style="padding: .5%;">
                <div class="card position-relative" data-toggle="modal" id="productCard" style="border: none;min-height: 100%; box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px; border: unset;">

                    <div class="image_card">
                        <a href="${productUrl}">
                            <img class="product_image" src="{{ asset('assets') }}${imageURL}" id="${imageURL}" alt="" onerror="this.src='assets/img/products/default-loading.gif'">
                        </a>
                    </div>
                    <div class="product_name" style="text-align: center;">
                        <a href="#" class="product-link" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; max-width: 100%;">${product.product_name.length <= 40 ? product.product_name : product.product_name.slice(0, 40) + '...'}</a>
                        <p class="product-link" style="margin-bottom: unset;">${product.default_price}</p>
                        <p class="product-link">${product.sub_product_no ? product.sub_product_no : product.product_no}</p>
                    </div>
                </div>
            </div>`;

            $('#paste_container').append(productCard);
        });

        // Pagination
            var productsPerPage = 12;
            var totalPages = Math.ceil(products.length / productsPerPage);
            var maxDisplayedPages = 6;
            var currentPage = 1;

            renderPagination();

            function renderPagination() {
                $('#paginationbar').empty(); // Clear any existing pagination

                // Check if there are products to paginate
                if (totalPages > 0) {
                    var pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="prev">&laquo;</a></li>';

                    if (totalPages <= maxDisplayedPages) {
                        for (var i = 1; i <= totalPages; i++) {
                            pagination += '<li class="page-item ' + (i === currentPage ? 'active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                        }
                    } else {
                        var startPagination = 1;
                        var endPagination = maxDisplayedPages;

                        if (currentPage > Math.floor(maxDisplayedPages / 2)) {
                            startPagination = currentPage - Math.floor(maxDisplayedPages / 2);
                            endPagination = currentPage + Math.ceil(maxDisplayedPages / 2) - 1;

                            if (endPagination > totalPages) {
                                endPagination = totalPages;
                                startPagination = endPagination - maxDisplayedPages + 1;
                            }
                        }

                        for (var i = startPagination; i <= endPagination; i++) {
                            pagination += '<li class="page-item ' + (i === currentPage ? 'active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
                        }

                        if (endPagination < totalPages) {
                            pagination += '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            pagination += '<li class="page-item"><a class="page-link" href="#" data-page="' + totalPages + '">' + totalPages + '</a></li>';
                        }
                    }

                    pagination += '<li class="page-item"><a class="page-link" href="#" data-page="next">&raquo;</a></li>';
                    pagination += '</ul></nav>';

                    $('#paginationbar').append(pagination);
                } else {
                    $('#paginationbar').append('<p class="text-center"></p>');
                }
            }


            function showPage(pageNum, productsPerPage) {
                var startIndex = (pageNum - 1) * productsPerPage;
                var endIndex = startIndex + productsPerPage;

                $('#paste_container .col-lg-3').hide();
                $('#paste_container .col-lg-3').slice(startIndex, endIndex).show();

                // Update active page in pagination bar
                $('#paginationbar .page-item').removeClass('active');
                $('#paginationbar .page-link[data-page="' + pageNum + '"]').parent().addClass('active');
            }

            if (totalPages >= 1) {
                renderPagination();
                showPage(currentPage, productsPerPage);

                // Pagination click event
                $('#paginationbar').on('click', '.page-link', function (e) {
                    e.preventDefault();

                    var page = $(this).data('page');

                    if (page === 'prev') {
                        currentPage = Math.max(1, currentPage - 1);
                    } else if (page === 'next') {
                        currentPage = Math.min(totalPages, currentPage + 1);
                    } else {
                        currentPage = page;
                    }

                    showPage(currentPage, productsPerPage);
                    renderPagination();
                });

                // Always show the previous and next link buttons
                $('#paginationbar .page-item:first-child').removeClass('d-none');
                $('#paginationbar .page-item:last-child').removeClass('d-none');
            }
        }


        </script>
           {{-- checkbox clicked count --}}


           <script>
            // Get all the checkboxes
            // const checkboxes = document.querySelectorAll('.custom-control-input');
            // const badgeCount = document.getElementById('badgeCount'); // Get the badgeCount element

            // // Add event listener to each checkbox
            // checkboxes.forEach(function(checkbox) {
            // checkbox.addEventListener('change', function() {
            //     const checkedCheckboxes = document.querySelectorAll('.custom-control-input:checked');
            //     badgeCount.innerText = checkedCheckboxes.length; // Update the badgeCount with the count of checked checkboxes
            // });
            // });
        </script>

        {{-- checkbox clicked count individually--}}

        <script>
            //updateCount();
            function updateCount(){
            const categoryCheckboxes = document.querySelectorAll('input[name="category[]"]');
            const genderCheckboxes = document.querySelectorAll('input[name="genders[]"]');
            const sportCheckboxes = document.querySelectorAll('input[name="sports[]"]');
            const styleCheckboxes = document.querySelectorAll('input[name="style[]"]');
            const categoryCount = document.getElementById('categorycount');
            const genderCount = document.getElementById('genderscount');
            const sportCount = document.getElementById('sportscount');
            const styleCount = document.getElementById('stylecount');

            // Function to update the count
            function updateCount(checkboxes, countElement) {
            let checkedCount = 0;
            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                checkedCount++;
                }
            });
            //countElement.innerText = checkedCount;
            }

            // Add event listeners to each checkbox group
            categoryCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(categoryCheckboxes, categoryCount);
            });
            });

            genderCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(genderCheckboxes, genderCount);
            });
            });

            sportCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(sportCheckboxes, sportCount);
            });
            });

            styleCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateCount(styleCheckboxes, styleCount);
            });
            });

            // Initial count updates
            updateCount(categoryCheckboxes, categoryCount);
            updateCount(genderCheckboxes, genderCount);
            updateCount(sportCheckboxes, sportCount);
            updateCount(styleCheckboxes, styleCount);
        }

        const textArray = [];
    $(document).ready(function() {

        // Declare the textArray variable outside the event listener
        const closeArray = [];

        // Attach event listener to checkboxes
        $('input[type="checkbox"]').change(function() {
        // Check if the checkbox is checked
        if ($(this).is(':checked')) {

            filter();
            // Get the value of the checked checkbox
            const value = $(this).val();
            let text;

            // Check the value and assign the desired text
            if (value === '[["Tops"]]') {
                    text = 'Tops';
            } else if (value === '[["Bottoms"]]') {
                    text = 'Bottoms';
            } else if (value === '[["Shorts"]]') {
                    text = 'Shorts';
            } else if (value === '[["Outerwear"]]') {
                    text = 'Outerwear';
            } else if (value === '[["Headwear"]]') {
                    text = 'Hats';
            } else if (value === '[["Socks"]]') {
                    text = 'Socks';
            } else if (value === '[["Bags"]]') {
                    text = 'Bags';
            } else if (value === '[["Game Jerseys"]]') {
                    text = 'Jerseys';
            } else if (value === '[["Racerbacks"]]') {
                    text = 'Racerbacks';
            } else if (value === '[["Reversibles"]]') {
                    text = 'Reversibles';
            } else if (value === '[["Sweats"]]') {
                    text = 'Sweats';
            } else {
                    // Default text if no condition matches
                    text = value;
            }

            //console.log(text);

            textArray.push('div_'+text);
            closeArray.push(text);
            //console.log(textArray);

            // Create a new div element

            printLables(textArray);

        }else{

            filter();
            const uncheckedValue = $(this).val();

            var holder;

            if (uncheckedValue === '[["Tops"]]') {
                    holder = 'Tops';
            } else if (uncheckedValue === '[["Bottoms"]]') {
                    holder = 'Bottoms';
            } else if (uncheckedValue === '[["Shorts"]]') {
                    holder = 'Shorts';
            } else if (uncheckedValue === '[["Outerwear"]]') {
                    holder = 'Outerwear';
            } else if (uncheckedValue === '[["Headwear"]]') {
                    holder = 'Hats';
            } else if (uncheckedValue === '[["Socks"]]') {
                    holder = 'Socks';
            } else if (uncheckedValue === '[["Bags"]]') {
                    holder = 'Bags';
            } else if (uncheckedValue === '[["Game Jerseys"]]') {
                    holder = 'Jerseys';
            } else if (uncheckedValue === '[["Racerbacks"]]') {
                    holder = 'Racerbacks';
            } else if (uncheckedValue === '[["Reversibles"]]') {
                    holder = 'Reversibles';
            } else if (uncheckedValue === '[["Sweats"]]') {
                    holder = 'Sweats';
            } else {
                    // Default text if no condition matches
            holder = uncheckedValue;
            }

            var removeDivision='div_'+holder;

            //console.log(holder);


            //remove from front-end


            if ($('#'+removeDivision).length > 0) {
            // Remove the div and its content
            $('#'+removeDivision).remove();
            }

            updateCount();

            // remove from array

            const index = textArray.indexOf(removeDivision);
            if (index > -1) {
                textArray.splice(index, 1);
            }

            // printLablesDiv(modifiedArray);
            printLables(textArray);
            //console.log(textArray);



        }
        });
        });
        function printLables(textArray) {

            const addLabelContainer = document.getElementById('addlable');
            const modifiedArray = textArray.map(item => item.replace('div_', ''));
            addLabelContainer.innerHTML = '';

            //console.log(modifiedArray);

            modifiedArray.forEach(text => {
            const newDiv = document.createElement('div');
            newDiv.id = `div_${text}`;
            newDiv.style.backgroundColor = '#ededed';
            newDiv.style.display = 'flex';
            newDiv.style.flexDirection = 'row';
            newDiv.style.alignItems = 'center';
            newDiv.style.borderRadius = '1rem';
            newDiv.style.padding = '2px';
            newDiv.style.margin = '2px';
            newDiv.style.width = '165px';
            newDiv.style.border = '1px solid #cbcbcb';

            // Set the HTML content for the new div
            newDiv.innerHTML = `
                <span id="addtext" style="padding: 5%; max-width: 275px; width: 100%;">${text}</span>
                <span>
                    <button style="outline:unset; background-color:Transparent; border:none;">
                        <i class="fas fa-times" style="padding-right: 15px;" onclick="handleSpanClick('${text}','${textArray}')"></i>
                    </button>
                </span>
            `;

            // Append the new div to the addlabel container
            addLabelContainer.appendChild(newDiv);
        });
            }


            function handleSpanClick(closevalue) {
                //console.log(closevalue);

                var tempory;

                if (closevalue === 'Tops') {
                tempory = '[["Tops"]]';
                } else if (closevalue === 'Bottoms') {
                tempory = '[["Bottoms"]]';
                } else if (closevalue === 'Shorts') {
                tempory = '[["Shorts"]]';
                } else if (closevalue === 'Outerwear') {
                tempory = '[["Outerwear"]]';
                } else if (closevalue === 'Hats') {
                tempory = '[["Headwear"]]';
                } else if (closevalue === 'Socks') {
                tempory = '[["Socks"]]';
                } else if (closevalue === 'Bags') {
                tempory = '[["Bags"]]';
                } else if (closevalue === 'Jerseys') {
                tempory = '[["Game Jerseys"]]';
                } else if (closevalue === 'Racerbacks') {
                tempory = '[["Racerbacks"]]';
                } else if (closevalue === 'Reversibles') {
                tempory = '[["Reversibles"]]';
                } else if (closevalue === 'Sweats') {
                tempory = '[["Sweats"]]';
                } else {
                // Default text if no condition matches
                tempory = closevalue;
                }

                  //console.log(tempory);


                  var closediv='div_'+closevalue;
                if ($('#'+closediv).length > 0) {
                    // Remove the div and its content
                    $('#'+closediv).remove();
                }

                    const index = textArray.indexOf(closediv);
                    //console.log(textArray);
                    //console.log(index);
                    if (index > -1) {
                        textArray.splice(index, 1);
                    }
                    //console.log(textArray);
                    printLables(textArray);

                const checkbox = document.getElementById(tempory);

                //console.log(checkbox);

                if (checkbox.checked) {
                    checkbox.checked = false;
                    filter();
                }
                const checkedCheckboxes = document.querySelectorAll('.custom-control-input:checked');
                badgeCount.innerText = checkedCheckboxes.length;
                updateCheckCount();
            }
            </script>
            <script>
                var headerSpan = document.getElementById('header');
                headerSpan.textContent = 'PRODUCT CATALOG';
            </script>


@endsection
