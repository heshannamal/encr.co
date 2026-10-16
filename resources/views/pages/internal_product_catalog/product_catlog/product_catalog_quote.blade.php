<!doctype html>
<html lang="en">

<head>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Encore Cloud</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Extra details for Live View on GitHub Pages -->

        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/4e5c8d5a83.js" crossorigin="anonymous"></script>

        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/custom_css.css" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/timeline.css" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

        <!-- DataTables css -->
        <link rel="stylesheet" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{ asset('argon') }}/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="{{ asset('argon') }}/css/colReorder.dataTables.min.css">

        <!--Datepicker-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

        <!--Timepicker-->
        <link rel="stylesheet" href="{{ asset('argon') }}/css/mdtimepicker.css">
        <script src="{{ asset('argon') }}/js/plugins/mdtimepicker.js"></script>

        <link rel="stylesheet" href="{{ asset('argon') }}/css/duDatepicker.css">
        <script src="{{ asset('argon') }}/js/plugins/duDatepicker.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/moment.js"></script>

        {{-- PDf Plugins --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/html2canvas.js"></script>
        <script src="{{ asset('argon') }}/js/plugins/html2pdf.bundle.min.js"></script>

        {{-- Rich Text Editor --}}
        <link rel="stylesheet" href="{{ asset('argon') }}/css/editor.css" type="text/css" />
        <script src="{{ asset('argon') }}/js/plugins/editor.js"></script>

        {{-- JsZip --}}
        <script src="{{ asset('argon') }}/js/plugins/jszip.js" type="text/javascript"></script>
    </head>
    <style>


    </style>


    <body style="background-color: white;">
           {{-- navbar --}}

    <nav class="navbar row" style="background-color: black; height: 125px;">
        <div class="col-lg-12" style="text-align: center; position: relative;top: -10%;">
            <a href="">
            <img src="https://encr.co/argon/img/encore/logo.png" alt="image" style="height: 90px;">
            </a>
        </div>

            {{-- <a href="{{ route('product_quote') }}" style="position: relative; left: 67%; top: 12px;">
                <i class="fa fa-calculator fa-lg" style="color: white;"></i>
                <span class="badge rounded-pill" id="quoteCountBadge" style="color: white; background-color: red; position: relative; top: -84%; left: 25%; border-radius: 3rem; width: 53%;">0</span>
            </a> --}}
    </nav>
        <style>
            .main-content{
                background-color: white;
            }
        </style>

        {{-- content --}}
            <div class="row" style="margin: 2%;">
                <div class="col-lg-2 ml-auto">
                    <a href="">
                        <button class="filterbtn" style="height: 50px; width: 100%; font-size: 15px; background: none; cursor: pointer; border-radius:.3rem">
                            NEED HELP
                        </button>
                    </a>
                </div>
            </div>
            <div class="row ml-4 mr-4" style="margin-top: 4%;border-bottom: 3px solid #ededed; margin:2%">
                <div class="col-lg-6" style="margin-bottom: .5%;">
                    <a href="{{route('product_catlog')}}">
                        {{-- <button class="filterbtn" style="height: 50px; width: 100%; font-size: 15px; background: black; cursor: pointer;color:white; border-radius:.3rem">
                            BACK TO PRODUCTS
                        </button> --}}
                        <button style="font-size: 14px;font-weight: 700;background: none; outline:unset; border:none;cursor:pointer"><i class="fa fa-arrow-left" aria-hidden="true" style="margin: 10px;"></i>BACK TO PRODUCT CATALOG</button>
                    </a>
                </div>
                <div class="col-lg-6" style="text-align: end;color: black;font-size: 14px;font-weight: 700; cursor: pointer;">
                    <button style="background: none; outline:unset; border:none" onclick="pdfDownload()"><i class="fa fa-file-pdf-o" aria-hidden="true" id="downloadPdfBtn" style="margin: 10px;"></i>DOWNLOAD INQUIRY</button>
                </div>
            </div>
            <div class="row" style="margin:3%">
                <div class="col-lg-12">
                    <h1 style="font-size: 30px; color:black">Make an Inquiry</h1>
                </div>
            </div>
            <div id="pdfContent" style="margin: 2%">
                <div class="row" style="margin-left: 2%">
                    <div class="col-lg-5">
                        <div class="form-group" id="organization_input">
                            <div class="input-group" id="organization_input-group" style="height: 50px; border: 1px solid black; border-radius: 0.7rem;">
                                <div class="input-group-prepend" style="background-color: white; border-radius: 0.7rem;">
                                    <span class="input-group-text" style="border-radius: .7rem; border-color: transparent;">
                                        <i class="fas fa-building" style="color: black; border-right: 1px solid black; padding-right: 10px;"></i>
                                    </span>
                                </div>
                                <input type="text" placeholder="Enter organization" id="organization" name="organization" class="form-control form-control-alternative" style="height: 100%; font-size: 17px;border-radius: .7rem; outline: none; padding-left: 10px; background-color: transparent;" onchange="validateInput('organization')">
                                <span id="organization_required" style="background-color: white;padding-left: 5px;padding-right: 5px;position: absolute; top: -10px; left: 40px; color: red; font-size: 12px; font-weight: bold; display: none;">Cannot be empty</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group" id="address_input">
                            <div class="input-group" id="address_input-group" style="height: 50px; border: 1px solid black; border-radius: 0.7rem;">
                                <div class="input-group-prepend" style="background-color: white; border-radius: 0.7rem;">
                                    <span class="input-group-text" style="border-radius: .7rem; border-color: transparent;">
                                        <i class="fas fa-map-marker-alt" style="color: black; border-right: 1px solid black; padding-right: 10px;"></i>
                                    </span>
                                </div>
                                <input type="text" placeholder="Enter address" id="address" name="address" class="form-control form-control-alternative" style="height: 100%; font-size: 17px;border-radius: .7rem; outline: none; padding-left: 10px; background-color: transparent;" onchange="validateInput('address')">
                                <span id="address_required" style="background-color: white;padding-left: 5px;padding-right: 5px;position: absolute; top: -10px; left: 40px; color: red; font-size: 12px; font-weight: bold; display: none;">Cannot be empty</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-left: 2%">
                    <div class="col-lg-5">
                        <div class="form-group" id="emailInput_input">
                            <div class="input-group" id="email_input-group" style="height: 50px; border: 1px solid black; border-radius: 0.7rem;">
                                <div class="input-group-prepend" style="background-color: white; border-radius: 0.7rem;">
                                    <span class="input-group-text" style="border-radius: .7rem; border-color: transparent;">
                                        <i class="fas fa-envelope" style="color: black; border-right: 1px solid black; padding-right: 10px;"></i>
                                    </span>
                                </div>
                                <input type="email" placeholder="Enter email" id="emailInput" name="emailInput" class="form-control form-control-alternative" style="height: 100%; font-size: 17px;border-radius: .7rem; outline: none; padding-left: 10px; background-color: transparent;" onchange="validateInput('emailInput')">
                                <span id="emailInput_required" style="background-color: white;padding-left: 5px;padding-right: 5px;position: absolute; top: -10px; left: 40px; color: red; font-size: 12px; font-weight: bold; display: none;">Cannot be empty</span>
                                <span id="not_a_mail" style="background-color: white;padding-left: 5px;padding-right: 5px;position: absolute; top: -10px; left: 40px; color: red; font-size: 12px; font-weight: bold; display: none;">Not a email</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group" id="phoneNumber_input">
                            <div class="input-group" id="phoneNumber_input-group" style="height: 50px; border: 1px solid black; border-radius: 0.7rem;">
                                <div class="input-group-prepend" style="background-color: white; border-radius: 0.7rem;">
                                    <span class="input-group-text" style="border-radius: .7rem; border-color: transparent;">
                                        <i class="fas fa-phone" style="color: black; border-right: 1px solid black; padding-right: 10px;"></i>
                                    </span>
                                </div>
                                <input type="text" placeholder="Enter phone number (Eg: +44 XXX XXX XXX)" id="phoneNumber" name="phoneNumber" class="form-control form-control-alternative" style="height: 100%; font-size: 17px;border-radius: .7rem; outline: none; padding-left: 10px; background-color: transparent;" onchange="validateInput('phoneNumber')">
                                <span id="phoneNumber_required" style="background-color: white;padding-left: 5px;padding-right: 5px;position: absolute; top: -10px; left: 40px; color: red; font-size: 12px; font-weight: bold; display: none;">Cannot be empty</span>
                                {{-- <span id="phoneNumber_not" style="background-color: white;padding-left: 5px;padding-right: 5px;position: absolute; top: -10px; left: 40px; color: red; font-size: 12px; font-weight: bold; display: none;">Not a phone number</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-left: 2%">
                    <div class="col-lg-5">
                        <div class="form-group" id="contactPerson_input">
                            <div class="input-group" id="contactPerson_input-group" style="height: 50px; border: 1px solid black; border-radius: 0.7rem;">
                                <div class="input-group-prepend" style="background-color: white; border-radius: 0.7rem;">
                                    <span class="input-group-text" style="border-radius: .7rem; border-color: transparent;">
                                        <i class="fas fa-user" style="color: black; border-right: 1px solid black; padding-right: 10px;"></i>
                                    </span>
                                </div>
                                <input type="text" placeholder="Enter contact person" id="contactPerson" name="contactPerson" class="form-control form-control-alternative" style="height: 100%; font-size: 17px;border-radius: .7rem; outline: none; padding-left: 10px; background-color: transparent;" onchange="validateInput('contactPerson')">
                                <span id="contactPerson_required" style="background-color: white;padding-left: 5px;padding-right: 5px;position: absolute; top: -10px; left: 40px; color: red; font-size: 12px; font-weight: bold; display: none;">Cannot be empty</span>
                            </div>
                        </div>
                    </div>
                </div>

            {{-- <div class="row ml-4 mr-4">
                <div class="col-lg-4 row" style="margin-top: 3%;">
                    <div class="col-lg-6" style="color: grey;">
                        <div class="row"><input type="text" placeholder="Organization"></div>
                    </div>
                </div>
            </div>
            <div class="row ml-2 mr-4" style="margin-top: 5%;color: black;">
                <div class="col-lg-6">
                    <table>
                        <tr><td><input type="text" placeholder="&nbsp;&nbsp;Name"></td></tr>
                        <tr><td><input type="text" placeholder="&nbsp;&nbsp;Address"></td></tr>
                        <tr><td><input type="text" placeholder="&nbsp;&nbsp;E-mail"></td></tr>
                        <tr><td><input type="text" placeholder="&nbsp;&nbsp;Phone"></td></tr>
                    </table>
                </div>
            </div> --}}
            <div class="row ml-4 mr-4" style="margin-top: 5%;color: black;">
                <h3 style="color: black;">ITEMS</h3>
            </div>
            <div class="row ml-4 mr-4" style="margin-top: 1%;color: black;">
                <table style="width: 100%;text-align: center;">
                    <tr style="height: 50px;background-color: #f6f6f6;">
                        <th style="text-align: left;">&nbsp;&nbsp;ITEM</th>
                        <th style="width: 5%;">QUANTITY</th>
                        <th>UNIT PRICE($)</th>
                        <th style="text-align: end;">TOTAL($)</th>
                        <th>ACTION</th>
                    </tr>
                    <tbody id="tbodyrows">

                    {{-- <tr style="height: 50px;border-bottom: 2px solid #e9e9e9;color: grey;">
                        <td style="text-align: left;">&nbsp;&nbsp;Men's Collegiate Lacrosse Reversible</td>
                        <td>Quote</td>
                        <td>Sep 3, 2023</td>
                        <td>29</td>
                        <td>30.00</td>
                        <td>870.00</td>
                    </tr> --}}

                    </tbody>
                </table>
            </div>
            <div class="row" style="margin-top: 2%;font-size: 15px;font-size: 15px;">
                <div class="col-lg-12" style="text-align: -webkit-right;">
                    <table style="width: 20%;color: grey;font-size: 18px;margin-right: 10.5%;">
                        <tr style="height: 40px;font-weight: 700; color:black">
                            <td>EST.TOTAL ($)</td>
                            <td id="subtotalValue" style="text-align: end;padding-right:40px">00.00</td>
                            <td></td>
                        </tr>
                        <tr style="height: 40px;" hidden>
                            <td>TAX (9.250% RATE)</td>
                            <td id="taxValue" style="text-align: end;padding-right:40px">00.00</td>
                        </tr>
                        <tr style="height: 40px;" hidden>
                            <td>SHIPPING ($)</td>
                            <td id="shippingValue" style="text-align: end;padding-right:40px">00.00</td>
                        </tr>
                        <tr style="height: 40px;" hidden>
                            <td>ARTWORK ($)</td>
                            <td id="artworkValue" style="text-align: end;padding-right:40px">00.00</td>
                        </tr>
                        <tr style="height: 40px;height: 40px;border-bottom: 2px solid #e9e9e9;" hidden>
                            <td>PROCESSING FEE ($)</td>
                            <td id="processingValue" style="text-align: end;padding-right:40px">00.00</td>
                        </tr>
                        <tr style="height: 40px; color: black" hidden>
                            <th>AMOUNT DUE ($)</th>
                            <th id="dueValue" style="text-align: end;padding-right:40px">0.00</th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mb-6" style="margin: 2%;">
            <div class="col-lg-2 ml-auto">
                    <button class="filterbtn" onclick="redirectToProductCatalog()" style="color:white; border:none; height: 50px; width: 100%; font-size: 15px; background: grey; cursor: pointer; border-radius:.3rem">
                        CANCEL
                    </button>
            </div>
            <div class="col-lg-2 mb-4">

                    <button class="filterbtn" onclick="addToEnquery()" style="color:white; border:none; height: 50px; width: 100%; font-size: 15px; background: red; cursor: pointer; border-radius:.3rem">
                        SUBMIT INQUIRY
                    </button>

            </div>
        </div>

            <input type="hidden" id="userId" value="{{$token}}">

        <script>

             function pdfDownload(){
                const element = document.getElementById("pdfContent");
                const opt = {
                    margin: 10,
                    filename: 'MyQuotation.pdf',
                    image: { type: 'pdf', quality: 1 },
                    html2canvas: { scale: 1 },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
                };

                html2pdf().from(element).set(opt).save();
            }

            view_user_quotes();

            function view_user_quotes() {

            //console.log("works!");

            var userId = document.getElementById('userId').value;

            var subtotal=0;

            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('view_user_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                    },
            success: function(response) {

                //console.log(response.quotes)

                //console.log(response.products)

                var item = response.products;
                var quotes = response.quotes;
                //console.log(quotes);

                var Quantity = 0;

                var tableRowsHtml = '';

                var parsedQuantity = 0;
                var itemPrice = 0;
                var totalPrice = 0;
                var totalSum = 0;
                var status = null;
                var est_date = null;



            // Iterate over each cart item and generate the HTML
            item.forEach(function(item) {

                quotes.forEach(function(quote) {
                    if (quote.product_id == item.id) {
                        Quantity = quote.qty;
                        status = quote.status;
                        est_date = quote.est_date;
                        //console.log(Quantity);
                    }
                });
                parsedQuantity = Quantity;
                itemPrice = item.default_price;
                totalPrice = itemPrice * parsedQuantity;
                totalSum = totalSum + totalPrice;
                //console.log(totalPrice);

                //subtotal +=item.default_price;

                tableRowsHtml += '<tr id="' + item.id + 'trData" name="tr" style="height: 50px;border-bottom: 2px solid #e9e9e9;color: grey;">' +
                '<input type="hidden" id="' + item.id + '" name="itemId"></input>' +
                '<td style="text-align: left;">&nbsp;&nbsp;' + item.product_name + '</td>' +
                '<td><input type="number" id="' + item.id + 'quantityInput" name="quantityInput" style="border: none; outline: unset; width: 75%;background-color:transparent" onchange="handleQuantityChange(this.value,' + item.id + ')"  name="inputQty" value="'+Quantity+'" min="0"></td>' +
                '<td id="' + item.id + 'itemprice">' + item.default_price + '</td>' +
                '<td id="' + item.id + 'itemtotal" name="singleItemTotal" style="text-align:end;">'+totalPrice+'.00</td>' +
                '<td><button style="background: none;border: none;outline: unset;cursor: pointer;position: relative;top: 8%;"><i class="fa fa-trash" aria-hidden="true" style="color: black;" onclick="deleteRecord('+item.id+')"></i></button></td>' +
                '</tr>';


            });

            calculateTotalSum(totalSum);
            //console.log(tableRowsHtml);


            // Update the HTML of the cart items section
            $('#tbodyrows').html(tableRowsHtml);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
            }

            function removeFromQuote(productId) {

            var userId = document.getElementById('userId').value;
            var totalSum = 0;



            // Send an AJAX request to the server
            $.ajax({
            url: "{{ route('product_removefrom_quotes') }}",
            method: "GET",
            data: {
                user_id: userId,
                product_id: productId,
                    },
            success: function(response) {

                calculateTotalSum(totalSum);
                view_user_quotes();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error:", textStatus, errorThrown);
            }
            });
            }

            function handleQuantityChange(quantity, itemId) {
                if (!(quantity > 0)) {
                    const quantityInput = document.getElementById(itemId + 'quantityInput')
                    quantityInput.value = 0;
                }else{
                    var parsedQuantity = parseInt(quantity, 10);
                    var itemPrice = parseFloat(document.getElementById(itemId + 'itemprice').textContent);
                    var totalPrice = itemPrice * parsedQuantity;

                    // Update the total price cell with the calculated value
                    document.getElementById(itemId + 'itemtotal').textContent = totalPrice.toFixed(2);

                    // Perform any additional logic or actions based on the updated total price
                    //console.log("Total price updated:", totalPrice);
                    calculateTotalSum(0);
                }

            }
            function calculateTotalSum(totalSum) {
            var totalSum = totalSum;
            var totalElements = document.getElementsByName("singleItemTotal");

            if(totalSum == 0){
            for (var i = 0; i < totalElements.length; i++) {
                var totalValue = parseInt(totalElements[i].textContent);
                totalSum += totalValue;
            }
            }else{
                totalSum = totalSum;
            }
            //console.log(totalElements);
            var taxSum = 0;
            var shippingSum = 0;
            var artworkSum = 0;
            var processingSum = 0;
            var dueSum = 0;

            totalSum = parseFloat(totalSum.toFixed(2));
            //shippingSum = parseFloat(shippingSum.toFixed(2));

            //taxSum = totalSum * 9.25/100;

            dueSum = totalSum+taxSum+shippingSum+artworkSum+processingSum;
            //dueSum = totalSum;

            document.getElementById("subtotalValue").textContent = totalSum+'.00';
            // document.getElementById("taxValue").textContent = taxSum;
            // document.getElementById("shippingValue").textContent = shippingSum+'.00';
            // document.getElementById("artworkValue").textContent = artworkSum;
            // document.getElementById("processingValue").textContent = processingSum;
            // document.getElementById("dueValue").textContent = dueSum;
            }
            function validateInput(functionId){

                var functionId = functionId;
                var elementId = document.getElementById(functionId);

                var validationMessage = document.getElementById(functionId + '_required');

                var inputElement = document.getElementById(functionId + '_input');

                var NotEmail = document.getElementById('not_a_mail');

                if(functionId == 'emailInput'){
                    if(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(elementId.value)){
                        inputElement.classList.remove('has-danger');
                        inputElement.classList.add('has-success');
                        NotEmail.style.display = 'none';
                        validationMessage.style.display = 'none';
                    }else{
                        //Type not a email
                        inputElement.classList.add('has-danger');
                        validationMessage.style.display = 'none';
                        NotEmail.style.display = 'block';
                    }
                }else{
                    if (!elementId.value) {
                        //console.log('EMPTY');
                        inputElement.classList.add('has-danger');
                        NotEmail.style.display = 'none';
                        validationMessage.style.display = 'block';
                    } else {
                        //console.log('ENTERED');
                        inputElement.classList.remove('has-danger');
                        inputElement.classList.add('has-success');
                        NotEmail.style.display = 'none';
                        validationMessage.style.display = 'none';
                    }
                }


            }

            function addToEnquery(){

                var organizationValue = document.getElementById('organization').value;
                var addressValue = document.getElementById('address').value;
                var emailValue = document.getElementById('emailInput').value;
                var phoneNumberValue = document.getElementById('phoneNumber').value;
                var contactPersonValue = document.getElementById('contactPerson').value;

                if(organizationValue){
                    if(addressValue){
                        if(emailValue){
                            if(/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue)){
                                if(phoneNumberValue){
                                    if(contactPerson){
                                        //console.log('All fields are filled');
                                        //Query();
                                        nullCheck();
                                    }else{
                                        validateInput('contactPerson');
                                    }
                                }else{
                                    validateInput('phoneNumber');
                                }
                            }else{
                                //Type not a email
                                validateInput('emailInput');
                            }
                        }else{
                            validateInput('emailInput');
                        }
                    }else{
                        validateInput('address');
                    }
                }else{
                    validateInput('organization');
                }
            }

            function nullCheck(){

                //console.log('Works');

                var byPass = true;

                var inputQtyElements = document.getElementsByName("quantityInput");

                for (var i = 0; i < inputQtyElements.length; i++) {
                    var inputValue = inputQtyElements[i].value;

                    if (inputValue == '' || inputValue == 0) {
                        //console.log('Input quantity is null');
                        byPass = false;
                    } else {
                        //console.log('Input quantity is not null for element');
                    }
                }

                if(byPass){
                    Query();
                }else{
                    //console.log('Empty');
                    inputQtyError();

                }
            }


            function Query() {

            var userId = document.getElementById('userId').value;
                const dataArray = [];
                const tableRows = document.querySelectorAll('#tbodyrows tr');

                tableRows.forEach((row) => {
                const rowData = [];
                const userId = document.getElementById('userId').value;
                const itemId = row.querySelector('[name="itemId"]').id;
                const itemQuantity = parseInt(row.querySelector('[name="quantityInput"]').value);

                rowData.push(userId, itemId, itemQuantity,);
                dataArray.push(rowData);
                });

                var organization;
                var address;
                var emailInput;
                var phoneNumber;
                var contactPerson;

            organization = document.getElementById('organization').value;
            address = document.getElementById('address').value;
            emailInput = document.getElementById('emailInput').value;
            phoneNumber = document.getElementById('phoneNumber').value;
            contactPerson = document.getElementById('contactPerson').value;

            // console.log(organization);
            // console.log(address);
            // console.log(emailInput);
            // console.log(phoneNumber);
            // console.log(contactPerson);

            var userInputData = [
                organization,
                address,
                emailInput,
                phoneNumber,
                contactPerson
            ];

            var commonArray = [];

            var subTotal = document.getElementById("subtotalValue").textContent;
            var taxValue = document.getElementById("taxValue").textContent;
            var shippingValue = document.getElementById("shippingValue").textContent;
            var artworkValue = document.getElementById("artworkValue").textContent;
            var processingValue = document.getElementById("processingValue").textContent;

            commonArray.push(subTotal, taxValue, shippingValue, artworkValue, processingValue,);

            //console.log(commonArray);

            //console.log(userInputData);

            //console.log(dataArray);

            //console.log(userId);

            $.ajax({
            url: "{{ route('submit_query') }}",
            method: "GET",
            data: {
                user_token: userId,
                dataArray: dataArray,
                userInputData: userInputData,
                commonArray: commonArray,
                    },
            success: function(response) {

                console.log(response.message);
                // console.log(response.user);
                // console.log(response.sbmittedData);
                // console.log(response.userInputData);

                if(response.status == 201){
                    //window.location.href='{{ route('product_catlog') }}';
                    submitConfirmEnquery();
                }else{
                    submitEnqueryError();
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                submitEnqueryError()
                console.error("Error:", textStatus, errorThrown);
            }
            });
            }


        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            function redirectToProductCatalog() {
                Swal.fire({
                    title: 'Redirecting',
                    text: 'Do you want to go back to the Product Catalog page?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: 'rgb(57 144 43)',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, go ahead!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('product_catlog') }}';
                    }
                });
            }
            function submitConfirmEnquery() {
                Swal.fire({
                    title: 'Inquiry Submitted Successfully!',
                    text: 'We appreciate your inquiry. A member of our sales team will be in touch with you shortly. Thank you.',
                    icon: 'success',
                    confirmButtonColor: 'rgb(57 144 43)',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Go to Product Catalog',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to Product Catalog page
                        window.location.href = '{{ route('product_catlog') }}';
                    }
                });
            }
            function submitEnqueryError() {
                Swal.fire({
                    title: 'Inquiry Submission Error',
                    text: 'There was an error submitting your inquiry. Please try again later.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });
            }
            function inputQtyError() {
                Swal.fire({
                    title: 'Quantity Error',
                    text: 'Quantity can not be null.',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                });
            }
            function deleteRecord(itemId) {
                var itemId = itemId;
                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Do you want to delete this record?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Delete'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //console.log(itemId);
                        removeFromQuote(itemId);
                    }
                });
            }




        </script>


</body>

</html>
