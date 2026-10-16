@extends('layouts.app', ['activePage' => 'customer_enquiries', 'titlePage' => __('Customer Enquiries')])

@section('content')
    <style>
        .main-content {
            background-color: #F8F8F8;
        }
    </style>

@section('back-btn')
    <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
@endsection
    <div class="card-body" style="margin-bottom: 1%;">
        <div class="row mb-3" style="border-bottom: 1px solid #c7c7c7">
            <div class="col-lg-4">
                <div class="form-group d-flex align-items-center" style="position: absolute; bottom:-13px">
                  <label for="rowsPerPageSelect" class="col-form-label" style="color: #838383">Show rows per page</label>
                  <select class="form-control form-control-alternative form-control-sm rounded-pill ml-2" id="rowsPerPageSelect" style="color:rgb(22, 199, 140); border-radius: 1rem; border: 1px solid #aeadad; width: 65px; height: 35px; font-size: 15px; background-color:#f0f0f0">
                    <option value="2" selected>2</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                  </select>
                </div>
              </div>
            <div class="col-lg-5 input-group-prepend mt-3 mb-3">
                <span class="input-group-text" style="background-color: transparent; width: 12%;top: -15%;margin-right: 6px;left: 6px;border-left: unset;border-right: unset;border-top: unset;border-bottom: 1px solid #c7c7c7;position: relative;">
                    <img src="{{ asset('assets/img/icons/catlog/search_1x.png') }}" alt="search">
                </span>
                <input type="text" class="form-control" id="searchKeyInput" onchange="renderRecords('default')" placeholder="Search Products" style="background-color: transparent; width: 50%; border-left: unset; border-right: unset;border-top: unset;border-bottom: 1px solid #c7c7c7;font-size: 16px; border-radius: unset;">
            </div>
            <div class="col-lg-4"></div>
        </div>
        <div style="width: 100%; overflow-x: scroll;">
            <table style="width: 120%; text-align: center;" class="table table-striped">
                <tr style="height: 50px;background-color: #616060;color:white;">
                    <th style="width:8%">&nbsp;&nbsp;ENQUIRY NO&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('enquiry_no');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 14%; text-align: left;">&nbsp;&nbsp;ORGANIZATION&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('organization_name');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 15%; text-align: left;">&nbsp;&nbsp;ADDRESS&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('address');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 15%; text-align: left;">&nbsp;&nbsp;EMAIL&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('email');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 10%; text-align: left;">&nbsp;&nbsp;PHONE NUMBER&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('phone_number');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 14%; text-align: left;">&nbsp;&nbsp;CONTACT PERSON&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('contact_person');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 8%;">QTY&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('qty');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 8%;">TOTAL AMOUNT ($)&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('organization_name');" style="color: white; cursor:pointer"></i></th>
                    <th style="width: 8%;">RECIVED DATE&nbsp;&nbsp;<i class="fa fa-sort ml-auto" onclick="renderRecords('sub_total');" style="color: white; cursor:pointer"></i></th>
                </tr>
                <tbody id="tbodyrows">
                    {{-- <tr style="height: 50px; color:grey; border-bottom: 2px solid grey">
                        <td style=" color:rgb(22, 199, 140)">&nbsp;&nbsp;En-01</td>
                        <td style="text-align: left;">Samson Perera</td>
                        <td style="text-align: left;">United kingdom, Asia</td>
                        <td style="text-align: left;">samsonperera@gmail.com</td>
                        <td style="text-align: left;">+978563214</td>
                        <td style="text-align: left;">Peterson Henri</td>
                        <td>45</td>
                        <td>254.00</td>
                        <td>13 Sep 2023</td>
                    </tr> --}}
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" style="margin-bottom: 10%">
        <div class="col-lg-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <div class="row">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                              {{-- <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous">
                                  <span aria-hidden="true">&laquo;</span>
                                </a>
                              </li> --}}
                              <div id="paginationBarHere" style="display: flex">
                                {{-- <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li> --}}
                              </div>
                              {{-- <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                  <span aria-hidden="true">&raquo;</span>
                                </a>
                              </li> --}}
                            </ul>
                          </nav>
                    </div>
                </ul>
            </nav>
        </div>
    </div>

    <button type="button" class="btn btn-primary" id="modal_open" data-toggle="modal" data-target="#imageModal" hidden>Open Modal</button>

    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="card">
                    <button type="button" class="close ml-auto mt-3 mr-3" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="card-header d-flex justify-content-between align-items-center" style="padding-left: 5%; padding-right: 5%">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 style="color: black">Order Enquire Details</h1>
                            </div>
                            <div class="col-lg-12">
                                <p style="color: grey">Refer the full order enquiry below.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 5%">
                        <div class="row mt-3">
                            <div class="col-lg-4">
                                <table style="display:table; font-size:15px; width:100%">
                                    <tr>
                                        <td style="color: #616060">Enquiry No</td>
                                        <td style="color: black" id="enquiry_no">EN - 01</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #616060">Received Date</td>
                                        <td style="color: black" id="recived_date">5 June 2023</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 mt-4">
                                <h3 style="color: black">CONTACT DETAILS</h3>
                            </div>
                            <div class="col-lg-6 mt-3">
                                <table style="display:table; font-size:15px; width:100%">
                                    <tr>
                                        <td style="color: #616060">Organization</td>
                                        <td style="color: black" id="organization_name">Jane Cooper</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #616060">Address</td>
                                        <td style="color: black" id="address_user">New Jersey 45463</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #616060">Email</td>
                                        <td style="color: black" id="email_user">tim.jennings@example.com</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #616060">Phone Number</td>
                                        <td style="color: black" id="phone_number">(316) 555-0116</td>
                                    </tr>
                                    <tr>
                                        <td style="color: #616060">Contact Person</td>
                                        <td style="color: black" id="contact_person">Jane Cooper</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row mt-3 mb-3">
                            <div class="col-lg-12 mt-2 mb-2">
                                <h3 style="color: black">ITEMS</h3>
                            </div>
                            <div class="col-lg-12 mt-2 mb-4">
                                <table style="display:table; font-size:15px; width:100%" class="table-striped">
                                    <tr style="height: 45px;background-color: #616060;color:white; text-align: center">
                                        <th style="text-align: left">&nbsp;&nbsp;ITEM</th>
                                        <th>QUANTITY</th>
                                        <th>UNIT PRICE ($)</th>
                                        <th>AMOUNT ($)</th>
                                    </tr>
                                    <tbody id="modal_body">
                                        {{-- <tr style="height: 45px; border-bottom: 1px solid #959595; text-align: center">
                                            <td style="color: #616060; text-align: left">&nbsp;&nbsp;Mens collagiate</td>
                                            <td style="color: #616060">20</td>
                                            <td style="color: #616060">60</td>
                                            <td style="color: #616060">1200</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    var headerSpan = document.getElementById('header');
    headerSpan.textContent = 'CUSTOMER ENQUIRIES';
</script>
<script>

    renderRecords('default');

    var selectElementLoad = document.getElementById('rowsPerPageSelect');
    var selectedValue = selectElementLoad.value;
    selectElementLoad.addEventListener('change', function() {
        console.log(selectElementLoad.value);
        renderRecords('default');
    });


    var commonData = [];
    var commonEnquiriesItems = [];
    var sortingFor = null;
    var tempsortingFor = null;
    var htmlElements = [];
    var currentIndex = 0;
    var tableBodyElement = document.getElementById('tbodyrows');
    var rowPerPage = 0;
    var numOfPages = 0;
    var paginationLinkMax = 0;
    var startPagination = 0;

    function showDataRows(index){

        if( index !== -1 && index !== -2){
            if(htmlElements.length > index){
                currentIndex = index;
                activePage(currentIndex);
            }else{
                tableBodyElement.innerHTML = '';
            }
        }else{
            if(index == -1){
                //console.log('Prev');
                if(currentIndex > 0){
                    currentIndex = currentIndex -1;
                }
                activePage(currentIndex);
            }
            if(index == -2){
                //console.log('Prev');
                if(currentIndex < htmlElements.length - 1){
                    currentIndex = currentIndex +1;
                }
                activePage(currentIndex);
            }
        }

    }

    function activePage(currentIndex){

        console.log('Existing:'+currentIndex);

        tableBodyElement.innerHTML = '';
        tableBodyElement.insertAdjacentHTML('beforeend', htmlElements[currentIndex]);
        //console.log(currentIndex);

        var pageLinks = document.querySelectorAll('.page-item');
        pageLinks.forEach(link => {
            link.classList.remove('active');
        });

        // Add active class to the clicked pagination link
        var activeLink = document.getElementById('activeIndex' + currentIndex);
        //console.log(activeLink);
        if (activeLink) {
            activeLink.classList.add('active');
        }
        // if(paginationLinkMax < numOfPages){
        //     if(currentIndex > 0){
        //     remakePagination(currentIndex + 1)
        //     }
        // }
    }

    function renderRecords(sortingForInput){

        var sortingForInput = sortingForInput;

        if (sortingFor == sortingForInput){
            if(tempsortingFor == sortingForInput+'_dsc'){
                tempsortingFor = sortingForInput+'_asc';
            }else{
                tempsortingFor = sortingForInput+'_dsc'
            }
        }else{
            tempsortingFor = sortingForInput+'_asc';
        }
        sortingFor = sortingForInput;

        //console.log(sortingForInput);

    $.ajax({
          url: "{{ route('getData') }}",
          method: "GET",
          data: {
            message:'Test msg'
                },
                success: function(response) {

                    //console.log(response.message);

                    var tempEnquiries = (response.tempEnquiries);
                    var enquiriesItems = (response.enquiriesItems);
                    var products = (response.products);
                    var catalogTemporyUsers = (response.catalogTemporyUsers);

                    var tableBodyHTML ='';
                    var newRowHTML ='';
                    var userDetails = null;

                    var rowDetails = [];

                    tempEnquiries.forEach(function(tempEnquiry) {

                        var qty = 0;
                        var enquiryItemFiltered = [];

                        catalogTemporyUsers.forEach(function(catalogTemporyUser) {
                            if(tempEnquiry.user_id == 'TEMP-' + catalogTemporyUser.id){
                                userDetails = catalogTemporyUser;
                            }
                        });
                        enquiriesItems.forEach(function(enquiriesItem) {
                            if(tempEnquiry.id == enquiriesItem.order_id){

                                qty = enquiriesItem.qty + qty;

                                var product_name = '';
                                var product_price = 0;

                                products.forEach(function(product){
                                    if(enquiriesItem.product_id == product.id){
                                        product_name = product.product_name;
                                        product_price = product.default_price;
                                    }
                                });
                                var enquiryItemFilteredRow = {
                                    item: enquiriesItem.product_id,
                                    qty: enquiriesItem.qty,
                                    product_name: product_name,
                                    product_price: product_price,
                                }
                                enquiryItemFiltered.push(enquiryItemFilteredRow);
                            }
                        });


                        var rowDetail = {
                        id: tempEnquiry.id,
                        organization: userDetails ? userDetails.organization : '',
                        address: userDetails ? userDetails.address : '',
                        email: userDetails ? userDetails.email : '',
                        phone_number: userDetails ? userDetails.phone_number : '',
                        contact_person: userDetails ? userDetails.contact_person : '',
                        qty: qty,
                        sub_total: tempEnquiry.sub_total,
                        updated_at: new Date(tempEnquiry.updated_at).toISOString().split('T')[0],
                        products : enquiryItemFiltered
                    };

                        rowDetails.push(rowDetail);


                    });

                    var inputKeyword = document.getElementById('searchKeyInput').value;
                    console.log(inputKeyword);

                    if(inputKeyword !== ''){
                        const filteredResults = rowDetails.filter(rowDetail =>
                            rowDetail.organization.toLowerCase().includes(inputKeyword.toLowerCase()) ||
                            rowDetail.address.toLowerCase().includes(inputKeyword.toLowerCase()) ||
                            rowDetail.email.toLowerCase().includes(inputKeyword.toLowerCase()) ||
                            rowDetail.contact_person.toLowerCase().includes(inputKeyword.toLowerCase())
                        );
                        rowDetails = filteredResults;
                        //console.log(filteredResults);
                    }

                        if(tempsortingFor == 'default'){
                            rowDetails = rowDetails;
                        }
                        if(tempsortingFor == 'enquiry_no_asc'){
                            rowDetails.sort((a, b) => b.id - a.id); //acending
                        }
                        if(tempsortingFor == 'enquiry_no_dsc'){
                            rowDetails.sort((a, b) => a.id - b.id); //decending
                        }
                        if(tempsortingFor == 'organization_name_asc'){
                            rowDetails.sort((a, b) => a.organization.localeCompare(b.organization)); //acending
                        }
                        if(tempsortingFor == 'organization_name_dsc'){
                            rowDetails.sort((a, b) => b.organization.localeCompare(a.organization)); //decending
                        }
                        if(tempsortingFor == 'address_asc'){
                            rowDetails.sort((a, b) => a.address.localeCompare(b.address)); //acending
                        }
                        if(tempsortingFor == 'address_dsc'){
                            rowDetails.sort((a, b) => b.address.localeCompare(a.address)); //decending
                        }
                        if(tempsortingFor == 'email_asc'){
                            rowDetails.sort((a, b) => a.email.localeCompare(b.email)); //acending
                        }
                        if(tempsortingFor == 'email_dsc'){
                            rowDetails.sort((a, b) => b.email.localeCompare(a.email)); //decending
                        }
                        if(tempsortingFor == 'contact_person_asc'){
                            rowDetails.sort((a, b) => a.contact_person.localeCompare(b.contact_person)); //acending
                        }
                        if(tempsortingFor == 'contact_person_dsc'){
                            rowDetails.sort((a, b) => b.contact_person.localeCompare(a.contact_person)); //decending
                        }
                        if(tempsortingFor == 'received_date_asc'){
                            rowDetails.sort((a, b) => new Date(a.updated_at) - new Date(b.updated_at)); //acending
                        }
                        if(tempsortingFor == 'received_date_dsc'){
                            rowDetails.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at)); //decending
                        }
                        if (tempsortingFor == 'phone_number_asc') {
                        rowDetails.sort((a, b) => a.phone_number.localeCompare(b.phone_number)); // ascending
                        }
                        if (tempsortingFor == 'phone_number_dsc') {
                            rowDetails.sort((a, b) => b.phone_number.localeCompare(a.phone_number)); // descending
                        }
                        if (tempsortingFor == 'sub_total_asc') {
                            rowDetails.sort((a, b) => a.sub_total - b.sub_total); // ascending
                        }
                        if (tempsortingFor == 'sub_total_dsc') {
                            rowDetails.sort((a, b) => b.sub_total - a.sub_total); // descending
                        }
                        if (tempsortingFor == 'qty_asc') {
                            rowDetails.sort((a, b) => a.qty - b.qty); // ascending
                        }
                        if (tempsortingFor == 'qty_dsc') {
                            rowDetails.sort((a, b) => b.qty - a.qty); // descending
                        }


                    console.log(rowDetails);
                    commonData = rowDetails;

                    rowPerPage = parseInt(document.getElementById('rowsPerPageSelect').value);

                    paginationLinkMax = 5;

                    numOfPages = Math.ceil(rowDetails.length / rowPerPage);
                    htmlElements = [];

                        for (var i = 0; i < rowDetails.length; i += rowPerPage) {
                            var groupHTML = ''; // HTML for the current group of rows

                            for (var j = i; j < i + rowPerPage && j < rowDetails.length; j++) {
                                var rowDetail = rowDetails[j];
                                var rowHTML = '<tr style="height: 50px; color:grey; border-bottom: 2px solid grey;">' +
                                            '<td style=" color:rgb(22, 199, 140); cursor:pointer;" onclick="modalOpening(' + j + ')">EN-' + rowDetail.id + '</td>' +
                                            '<td style="text-align: left;">' + rowDetail.organization + '</td>' +
                                            '<td style="text-align: left;">' + rowDetail.address + '</td>' +
                                            '<td style="text-align: left;">' + rowDetail.email + '</td>' +
                                            '<td style="text-align: left;">' + rowDetail.phone_number + '</td>' +
                                            '<td style="text-align: left;">' + rowDetail.contact_person + '</td>' +
                                            '<td>' + rowDetail.qty + '</td>' +
                                            '<td>' + rowDetail.sub_total + '.00</td>' +
                                            '<td>' + rowDetail.updated_at + '</td>' +
                                            '</tr>';
                                groupHTML += rowHTML;
                            }

                            htmlElements.push(groupHTML); // Add the current group's HTML to the array
                        }

                    showDataRows(0);


                    //pagination bar

                    // if(paginationLinkMax > numOfPages){

                        var paginationLinks = '';
                        var paginationPrev = '<li class="page-item"><a class="page-link" aria-label="Previous" onclick="showDataRows(-1)"><span aria-hidden="true">&laquo;</span></a></li>';
                        var paginationNext = '<li class="page-item"><a class="page-link" aria-label="Next" onclick="showDataRows(-2)"><span aria-hidden="true">&raquo;</span></a></li>';

                        if(numOfPages == 1){
                            var paginationLinks = '<li class="page-item active"><a class="page-link">1</a></li>'
                        }else{

                            for (var i = 1; i<= numOfPages; i++){
                                var paginationLink = '<li class="page-item" id="activeIndex'+ (i-1) +'"><a class="page-link" onclick="showDataRows('+ (i-1) +')">'+ i +'</a></li>'
                                paginationLinks += paginationLink;
                            }
                            paginationLinks = paginationPrev + paginationLinks + paginationNext;
                        }

                        var paginationBarElement = document.getElementById('paginationBarHere');
                        paginationBarElement.innerHTML = '';
                        paginationBarElement.insertAdjacentHTML('beforeend', paginationLinks);
                        var activeLink = document.getElementById('activeIndex0');
                        activeLink.classList.add('active');
                    // }else{
                    //     remakePagination(1);
                    // }

                },

          error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error:", textStatus, errorThrown);
          }
        });
    }

    // function remakePagination(startPagination){

    //     var paginationLinks = '';
    //     var paginationDotted = '<li class="page-item"><a class="page-link" ><span aria-hidden="true">...</span></a></li>';
    //     var paginationPrev = '<li class="page-item"><a class="page-link" aria-label="Previous" onclick="showDataRows(-1)"><span aria-hidden="true">&laquo;</span></a></li>';
    //     var paginationNext = '<li class="page-item"><a class="page-link" aria-label="Next" onclick="showDataRows(-2)"><span aria-hidden="true">&raquo;</span></a></li>';

    //     if(startPagination + paginationLinkMax < numOfPages){startPagination = startPagination;}
    //     var endPagination = '<li class="page-item" id="activeIndex'+ (numOfPages-1) +'"><a class="page-link" onclick="showDataRows('+ (numOfPages-1) +')">'+ numOfPages +'</a></li>';

    //     for (var i = startPagination; i<= startPagination + paginationLinkMax; i++){
    //             var paginationLink = '<li class="page-item" id="activeIndex'+ (i-1) +'"><a class="page-link" onclick="showDataRows('+ (i-1) +')">'+ i +'</a></li>'
    //             paginationLinks += paginationLink;
    //         }

    //     paginationLinks = paginationPrev + paginationLinks + paginationDotted + endPagination + paginationNext;

    //     var paginationBarElement = document.getElementById('paginationBarHere');
    //     paginationBarElement.innerHTML = '';
    //     paginationBarElement.insertAdjacentHTML('beforeend', paginationLinks);
    // }


    function modalOpening(index) {

        var userDataRecived = commonData[index];

        var enquiryItemsReceived = [];
        var newFullRowHTML = '';
        enquiryItemsReceived = userDataRecived.products;


        //asign values

        const enquiryNoTd = document.getElementById('enquiry_no');
        const receivedDateTd = document.getElementById('recived_date');
        const organizationNameTd = document.getElementById('organization_name');
        const addressUserTd = document.getElementById('address_user');
        const emailUserTd = document.getElementById('email_user');
        const phoneNumberTd = document.getElementById('phone_number');
        const contactPersonTd = document.getElementById('contact_person');

        enquiryNoTd.textContent = 'EN -'+ userDataRecived.id;
        receivedDateTd.textContent = userDataRecived.updated_at;
        organizationNameTd.textContent = userDataRecived.organization;
        addressUserTd.textContent = userDataRecived.address;
        emailUserTd.textContent = userDataRecived.email;
        phoneNumberTd.textContent = userDataRecived.phone_number;
        contactPersonTd.textContent = userDataRecived.contact_person;



        enquiryItemsReceived.forEach(function(enquiryItemReceived) {

            var newRowHTML = `
                    <tr style="height: 45px; border-bottom: 1px solid #959595; text-align: center">
                        <td style="color: #616060; text-align: left">&nbsp;&nbsp;${enquiryItemReceived.product_name}</td>
                        <td style="color: #616060">${enquiryItemReceived.qty}</td>
                        <td style="color: #616060">${enquiryItemReceived.product_price}</td>
                        <td style="color: #616060">15.00</td>
                    </tr>`;

            newFullRowHTML += newRowHTML;

        })

            var tbodyElement = document.getElementById('modal_body');
            tbodyElement.innerHTML = '';
            tbodyElement.insertAdjacentHTML('beforeend', newFullRowHTML);


        //open the modal

        var modalOpenButton = document.getElementById('modal_open');
        modalOpenButton.click();

    }

</script>

@endsection
