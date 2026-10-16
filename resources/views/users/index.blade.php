@extends('layouts.app', ['activePage' => 'user.index', 'title' => __('User Profile')])

@section('content')
 <br><BR><BR>
 @if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
    <div class="container">
        <form action="{{ route('invoice.search') }}" method="post">
            @csrf
            <div class="row col-md-12">
                <div class="col-md-5">
                    <label for="">Select the Item</label>
                    <select class="form-control" id="invoice_no" searchable="Search here..">
                        <option value="" disabled selected>Select the Incoice</option>
                        @foreach($orderValues as $orderValue)
                        <option value="{{ $orderValue->id }}">{{ $orderValue->invoice_no }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5">
                    <label for="">Select the Item</label>
                    <select class="form-control" id="itemSelect" searchable="Search here..">
                        <option value="" disabled selected>Select the Incoice</option>
                    </select>
                </div>
                <div class="col-md-12 control-btns mt-4">
                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i>Search</button>
                </div>
            </div>
        </form>
        <br>

        {{-- <div class="container"> --}}


            <section id="tabs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ asset('argon') }}/img/encore/logo.png">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-xs-12 ">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="true">Invoice</a>
                                    <a class="nav-item nav-link" id="tab_1-tab" data-toggle="tab" href="#tab_1" role="tab" aria-controls="tab_1" aria-selected="false">Tab 1</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Tab 2</a>
                                    <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Tab 3</a>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="invoice-tab">
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <table class="table invoice_details">
                                                <tr>
                                                    <th>Invoice:</th>
                                                    <td><input  class="invoice-inputs" name="invoiceNo" id="invoice_no" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Delivery Date:</th>
                                                    <td><input class="invoice-inputs" name="deliveryDate" id="delivery_date" type='date' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Factory:</th>
                                                    <td><input class="invoice-inputs" name="factory" id="factory" type='text' value=''/></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6 mt-3" style="padding-right: 0px;">
                                            <table class="table shipping_details">
                                                <tr>
                                                    <th>Ship To:</th>
                                                </tr>
                                                <tr><td><input class="invoice-inputs text-center" name="shipToName"  type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center" name="shipToAddOne"  type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center" name="shipToAddTwo"  type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center" name="shipToAddThree"  type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center colored-td" name="shipMobileNo"  type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center colored-td" name="shipGmailAdd" type='text' value=''/></td></tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6 mt-3" style="padding-left: 0px;">
                                            <table class="table shipping_details">
                                                <tr>
                                                    <th>BILL TO:</th>
                                                </tr>
                                                <tr><td><input class="invoice-inputs text-center" name="billToName" type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center" name="billToAddOne"  type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center" name="billToAddTwo"  type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center" name="billToAddThree" type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center colored-td" name="billMobileNo" type='text' value=''/></td></tr>
                                                <tr><td><input class="invoice-inputs text-center colored-td" name="billGmailAdd"  type='text' value=''/></td></tr>
                                            </table>
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <table class="table Product_details">
                                                <tr>
                                                    <th>CATEGORY</th>
                                                    <th>DESCRIPTION</th>
                                                    <th>FABRIC</th>
                                                    <th>EMBELISHMENT</th>
                                                    <th>QTY</th>
                                                    <th>UNIT PRICE($)</th>
                                                    <th>AMOUNT($)</th>

                                                </tr>
                                                <tbody id="product_table_body">
                                                    <tr>
                                                        <td style="width:25%">
                                                            <select class="invoice-inputs" name="product[0][category]" id="product_category_id">
                                                                {{-- @foreach($ProductCategory as $ProductCategorys)
                                                                <option value="{{$ProductCategorys->id}}">{{$ProductCategorys->category_name}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </td>
                                                        <td style="width:25%"><input class="invoice-inputs" name="product[0][description]" id="product_description" type='text' value=''/></td>
                                                        <td style="width:10%">
                                                            <select class="invoice-inputs" name="product[0][fabric]" id="product_fabric">
                                                                {{-- @foreach($Fabric as $Fabrics)
                                                                <option value="{{$Fabrics->fabric_name}}">{{$Fabrics->fabric_name}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </td>
                                                        <td style="width:10%">
                                                            <select class="invoice-inputs" name="product[0][estabilishment]" id="product_estabilishment">
                                                                {{-- @foreach($Embellishment as $Embellishments)
                                                                <option value="{{$Embellishments->embellishments_code}}">{{$Embellishments->embellishments_code}}</option>
                                                                @endforeach --}}
                                                            </select>
                                                        </td>
                                                        <td style="width:5%"><input  class="invoice-inputs number" style="text-align: center;" name="product[0][qty]" id="product_qty" type='text' value=''/></td>
                                                        <td style="width:10%"><input class="invoice-inputs number" style="text-align: center;" name="product[0][unit_price]" id="product_unit_price" type='text' value=''/></td>
                                                        <td style="width:15%"><input class="invoice-inputs product_amount" name="product[0][amount]" id="product_amount" type='text' value=''/></td>
                                                        {{-- <td style="width:15%; text-align: center;"><button class="btn btn-danger btn-sm tbl-btn-sm delete_record" id="delete_record" type='button' data-id="0"><i class="far fa-trash-alt"></i></button></td> --}}
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-7">
                                            <h1 class="main-htag mt-4">Thank you for your business!</h1>
                                            <div class="mt-4" style="text-align: center;">
                                                <span>Payment can be submitted via PayPal, Venmo, Debit/Credit Card or Check.
                                                    If submitting via PayPal or Venmo, please include the invoice #, as well as your team and contact information.
                                                </span>
                                            </div>
                                            <div class="mt-4">
                                                <span class="imporatant-color">vPayPal : </span><span>info@encorelacrosse.com</span><br>
                                                <span class="imporatant-color">Venmo : </span><span>@encore-lacrosse</span><br>
                                                <span class="imporatant-color">Credit Card / Check : </span><span> Please make payment through sales rep or accounting dept.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <table id="invoice_summery_table" class="table invoice_summery">
                                                <tr>
                                                    <th>SUBTOTAL:</th>
                                                    <td><input class="invoice-inputs number marked" name="subTotal" id="sub_total" type='text' value='0'/></td>
                                                </tr>
                                                <tr>
                                                    <th>TAX RATE</th>
                                                    <td><input class="invoice-inputs number" name="taxRate" id="tax_rate" type='text' value='0'/></td>
                                                </tr>
                                                <tr>
                                                    <th>TAX:</th>
                                                    <td><input class="invoice-inputs number marked" name="tax" id="tax" type='text' value='0'/></td>
                                                </tr>
                                                <tr>
                                                    <th>SHIPPING:</th>
                                                    <td><input class="invoice-inputs number marked" name="shipping" id="shipping" type='text' value='0'/></td>
                                                </tr>
                                                <tr>
                                                    <th>ARTWORK:</th>
                                                    <td><input class="invoice-inputs number marked" name="artwork" id="artwork" type='text' value='0'/></td>
                                                </tr>
                                                <tr>
                                                    <th>CC/VENMO/PAYPAL FEE:</th>
                                                    <td><input class="invoice-inputs number marked" name="shippingFee" id="shipping_fee" type='text' value='0'/></td>
                                                </tr><br>
                                                <tr>
                                                    <th class="total">TOTAL</th>
                                                    <td><input class="invoice-inputs" style="text-align: right;" name="total" id="total" type='text' value='0.00'/></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 control-btns no-print">
                                        <h3 class="imporatant-color" style="text-align: center;">If you have any questions about this invoice, please contact your sales rep or Accounting@EncoreBrand.com</h3>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab_1" role="tabpanel" aria-labelledby="tab_1-tab">
                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <table class="table shipping_details">
                                                <tr>
                                                    <th>Style Name:</th>
                                                    <td><input class="invoice-inputs" name="styleName" id="styleName" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Fabric:</th>
                                                    <td><input class="invoice-inputs" name="fabric" id="fabric" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Embellishment:</th>
                                                    <td><input class="invoice-inputs" name="estabilishment" id="estabilishment" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Open Date:</th>
                                                    <td><input class="invoice-inputs" name="openDate" id="openDate" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Close:</th>
                                                    <td><input class="invoice-inputs" name="closeDate" id="closeDate" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>In Hand By:</th>
                                                    <td><input class="invoice-inputs" name="in_hand_by" id="in_hand_by" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Quality Control:</th>
                                                    <td><input class="invoice-inputs" name="quality_control" id="quality_control" type='text' value=''/></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table shipping_details" style="height: 94%;">
                                                <tr>
                                                    <th>Team Name:</th>
                                                    <td><input class="invoice-inputs" name="team_name" id="team_name" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Customer Name :</th>
                                                    <td><input class="invoice-inputs" name="customer_name" id="customer_name" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="2">Customer Address:</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input class="invoice-inputs" name="customer_address_one" id="customer_address_one" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><input class="invoice-inputs" name="customer_address_two" id="customer_address_two" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Phone Number:</th>
                                                    <td><input class="invoice-inputs" name="phone_number" id="phone_number" type='text' value=''/></td>
                                                </tr>
                                                <tr>
                                                    <th>Email Address:</th>
                                                    <td><input class="invoice-inputs" name="email_address" id="email_address" type='text' value=''/></td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-12">
                                            <table class="table Product_details">
                                                <tr>
                                                    <th>BLANKS</th>
                                                    <th>QTY</th>
                                                    <th>Sizes</th>
                                                    <th colspan="24" >Number Sequence</th>
                                                </tr>
                                                <tbody id="product_table_body">
                                                            <tr>
                                                                <td style="width:1%"  rowspan="2"><input  style="height: 67px;"  class="invoice-inputs" name="product[0][blanks]"  type='text' value=''/></td>
                                                                <td style="width:1%"  rowspan="2"><input  style="height: 67px;" class="invoice-inputs" name="product[0][qty]"  type='text' value=''/></td>
                                                                <td style="width:15%" rowspan="2"><input style="height: 67px;" class="invoice-inputs" name="product[0][sizes]"  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                                <td style="width:2%"><input class="invoice-inputs" name=""  type='text' value=''/></td>
                                                            </tr>
                                                        <tr style="height: 5px;">
                                                        </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                                </div>
                                <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                    Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            {{-- <form action="{{ route('invoice.create') }}" method="post">
                @csrf

            </form> --}}
            <div class="col-lg-12 control-btns mt-4" style="margin-bottom: 5rem">
                <button type="submit" class="btn btn-success">Send Link</button>
            </div>
        {{-- </div> --}}
    </div>
@endsection
<script>

    $(document).ready(function(){
        // $(".add-record").on("click", function () {
        //         var rowCount = $('#product_table_body >tr').length;
        //         var rowCount
        //         var newRow = $("<tr>");
        //         var cols = "";
        //         cols += '<td style="width:1%"  rowspan="3"><input  style="height: 102px;"  class="invoice-inputs" name="product['+rowCount+'][blanks]"  type="text" value=""/></td>';
        //         cols += '<td style="width:1%"  rowspan="3"><input  style="height: 102px;" class="invoice-inputs" name="product['+rowCount+'][qty]"  type="text" value="text"/></td>';
        //         cols += '<td style="width:15%" rowspan="3"><input style="height: 102px;" class="invoice-inputs" name="product['+rowCount+'][sizes]"  type="text" value=""/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_one]"  type="text" value=""/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_two]"  type="text" value=""/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_three]"  type="" value=""/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_four]"  type="text" value=""/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_five]"  type="text" value=""/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_six]"  type="text" value=""/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_seven]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_eight]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_nine]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_ten]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_eleven]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_twelve]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_thirteen]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_fourteen]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_fifteen]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_sixteen]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_seventeen]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_eighteen]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_nineteen]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_twenty]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_twenty_one]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_twenty_two]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_twenty_three]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_twenty_four]"  type='text' value=''/></td>';
        //         cols += '<td style="width:2%"><input class="invoice-inputs" name="product['+rowCount+'][numseq_twenty_five]"  type='text' value=''/></td>';
        //         newRow.append(cols);
        //         $("#product_table_body").append(newRow);
        //         rowCount++;
        //     });

            $("#invoice_no").on("change", function () {
                    if ($(this).val() != "") {
                    $.ajax({
                        type: 'GET',
                        url: '{{ url("/order_items/get_order_items_by_id") }}/' + $(this).val(),
                        beforeSend: function() {
                        },
                        success: function(data) {
                            document.getElementById("itemSelect").options.length = 0;
                             var customerDetails = JSON.parse(data);
                            for(var i=0;i<customerDetails.length;i++){
                                $('#itemSelect').append($('<option>', {value: customerDetails[i].id,text: customerDetails[i].description}));
                            }
                        },
                        complete: function() {
                        }
                    });
                }
            });

            $("#itemSelect").on("change", function () {
                    if($('#invoice_no').val() ==""){
                        alert("Please Select An Invoice");
                        return;
                    }
                    if ($(this).val() != "") {
                        $('#itemSelect').append($('<option>', {value:"1" ,text:"Please Select An Item"}));
                        $.ajax({
                        type: 'GET',
                        url: '{{ url("/order_items/get_order_items_by_id") }}/' + $(this).val(),
                        beforeSend: function() {
                        },
                        success: function(data) {
                             var customerDetails = JSON.parse(data);
                             for(var i=0;i<customerDetails.length;i++){
                                $('#itemSelect').append($('<option>', {value: customerDetails[i].id,text: customerDetails[i].description}));
                            }
                        },
                        complete: function() {
                        }
                    });
                }
            });
    });
</script>
