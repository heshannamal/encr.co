@extends('layouts.app', ['activePage' => 'Team Stores', 'titlePage' => __('Team Stores')])

@section('sub-sidebar-content')

<style>
    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
        display: none;
    }
    .general_info {
        font-size: 18px;
    }
    .card_div {
        padding: 15px;
    }
    .email_div {
        border: unset;
        margin-bottom: 10px;
        padding-left: 15px;
    }
    .schedule_div {
        border: unset;
        margin-bottom: 10px;
    }
    .compose_btn {
        width: 125px;
        height: 35px;
        background-color: #F8F8F8;
        border: 1px solid #DEDEDE;
        cursor: pointer;
        font-size: 11px;
        font-weight: 600;
        color: #B3B3B3;
    }
    .compose_btn_div {
        margin-right: 15px;
        padding: 15px;
        padding-bottom: unset;
    }
    .email_lable {
        font-size: 16px;
        padding-left: 10px;
        margin-bottom: unset;
        color: #4E4C4C;
    }
    .email_lable2 {
        font-size: 15px;
        padding-left: 27px;
        color: #717070;
    }
    .update_settings {
        width: 100%;
        height: 35px;
        background-color: #F8F8F8 !important;
        color: #333333 !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        border: 1px solid #DEDEDE !important;
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0;
    }
    .tab-content {
      display: none;
      text-align: center;
    }
    .active-tab {
      display: block;
    }
    .email_tab_btn {
        border: unset;
        background-color: transparent;
        cursor: pointer;
        color: #818181;
        font-size: 10px;
    }
    .active-button {
        font-weight: 700;
        border-bottom: 2px solid #020202;
    }
    .email_tab_btn_div {
        width: 100%;
        margin: 15px;
        border-bottom: 1px solid #DEDEDE;
    }
    .empty_email {
        padding-bottom: 100px;
        padding-top: 100px;
    }
    .empty_email_text {
        color: #B3B3B3;
        font-size: 13px;
        padding: 15px;
    }
    .dropdown .dropdown-menu.dropdown-menu-right.show{
        transform: translate3d(0px, 50px, 0px) !important;
    }
    @media (max-width: 767px) {
        .bg-box.container-fluid.fix-nav.header-layout{
            margin-bottom: 0 !important;
        }
        .header-layout {
            margin-bottom: 0 !important;
            height: auto !important;
            min-height: 0 !important;
        }
        .email_div {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .tab-content {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }
        .tab-content table {
            word-break: break-word;
            table-layout: fixed;
            width: 100% !important;
        }
        .tab-content th, .tab-content td {
            font-size: 12px !important;
            padding: 8px 5px !important;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .tab-content td.text-center, .tab-content th.text-center {
            width: 35px;
        }
        .tab-content td:nth-child(2), .tab-content th:nth-child(2) {
            width: 35%;
        }
        /* .tab-content td:nth-child(3), .tab-content th:nth-child(3) {
            width: 55%;
        } */
        /* Prevent iOS Safari from auto-zooming on focus */
        input[type="text"],
        input[type="number"],
        input[type="search"],
        input[type="email"],
        input[type="password"],
        input[type="tel"],
        input[type="url"],
        select,
        textarea,
        .form-control,
        .select2-selection,
        .select2-search__field,
        .select2-search input {
            font-size: 16px !important;
        }
    }
</style>

<div class="container-fluid mb-5" style="padding: 0 !important;">
    <div class="se-pre-con"></div>

    @include('pages.stores.layouts.top_header')

    @yield('stores_header')

    <div class="col-lg-12" style="margin-top: 20px;">
        <div class="row">
            <div class="col-lg-8" style="padding-left: unset; padding-right: 5px;">
                <div class="card email_div" style="border-radius: unset;">
                    <div class="row">
                        <div class="card_div" style="padding-bottom: unset;">
                            <strong class="general_info"> Email Customers</strong>
                        </div>
                        <div class="ml-auto compose_btn_div">
                            <button class="compose_btn" id="compose_email_button"><i class="fa fa-pen-fancy" style="padding: 5px;"></i> COMPOSE</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="email_tab_btn_div">
                            <button class="email_tab_btn active-button" onclick="showTab('all')">ALL</button>
                            <button class="email_tab_btn" onclick="showTab('withoutOrder')">WITHOUT ORDERS</button>
                            <button class="email_tab_btn" onclick="showTab('withOrder')">WITH ORDERS</button>
                          </div>
                    </div>

                    <!-- Tab Contents -->
                    <div id="all" class="tab-content active-tab">
                        @if ($customers->count() > 0)
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border: 1px solid #DEDEDE;">
                                    <th class="text-center" style="padding: 10px; font-size: 14px; color: #4E4C4C;">
                                        <input type="checkbox" id="select-all-checkbox">
                                    </th>
                                    <th class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">Customer Name</th>
                                    <th class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">Email</th>
                                </tr>
                                @foreach ($customers as $key => $customer)
                                    <tr style="border: 1px solid #DEDEDE;">
                                        <td class="text-center">
                                            <input type="checkbox" data-email="{{$customer->email}}" class="row-checkbox">
                                        </td>
                                        <td class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">{{$customer->first_name}} {{$customer->last_name}}</td>
                                        <td class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">{{$customer->email}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="empty_email">
                                <img src="{{asset('assets')}}/img/team_stores/empty_email.png" style="width: 120px;" />
                                <p class="empty_email_text">Haven't sent any emails to customers yet.</p>
                            </div>
                        @endif

                    </div>

                    <div id="withoutOrder" class="tab-content">
                        @if ($customers->where('is_ordered', 0)->count() > 0)
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border: 1px solid #DEDEDE;">
                                    <th class="text-center" style="padding: 10px; font-size: 14px; color: #4E4C4C;">
                                        <input type="checkbox" id="select-all-checkbox">
                                    </th>
                                    <th class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">Customer Name</th>
                                    <th class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">Email</th>
                                </tr>
                                @foreach ($customers->where('is_ordered', 0) as $key => $customer)
                                    <tr style="border: 1px solid #DEDEDE;">
                                        <td class="text-center">
                                            <input type="checkbox" data-email="{{$customer->email}}" class="row-checkbox">
                                        </td>
                                        <td class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">{{$customer->first_name}} {{$customer->last_name}}</td>
                                        <td class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">{{$customer->email}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="empty_email">
                                <img src="{{asset('assets')}}/img/team_stores/empty_email.png" style="width: 120px;" />
                                <p class="empty_email_text">Haven't sent any emails to customers yet.</p>
                            </div>
                        @endif
                    </div>

                    <div id="withOrder" class="tab-content">
                        @if ($customers->where('is_ordered', 1)->count() > 0)
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="border: 1px solid #DEDEDE;">
                                    <th class="text-center" style="padding: 10px; font-size: 14px; color: #4E4C4C;">
                                        <input type="checkbox" id="select-all-checkbox">
                                    </th>
                                    <th class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">Customer Name</th>
                                    <th class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">Email</th>
                                </tr>
                                @foreach ($customers->where('is_ordered', 1) as $key => $customer)
                                    <tr style="border: 1px solid #DEDEDE;">
                                        <td class="text-center">
                                            <input type="checkbox" data-email="{{$customer->email}}" class="row-checkbox">
                                        </td>
                                        <td class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">{{$customer->first_name}} {{$customer->last_name}}</td>
                                        <td class="text-left" style="padding: 10px; font-size: 14px; color: #4E4C4C;">{{$customer->email}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        @else
                            <div class="empty_email">
                                <img src="{{asset('assets')}}/img/team_stores/empty_email.png" style="width: 120px;" />
                                <p class="empty_email_text">Haven't sent any emails to customers yet.</p>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
            <div class="col-lg-4">
                <div class="card schedule_div"  style="border-radius: unset;">
                    <div class="card_div">
                        <strong class="general_info"> Schedule Emails Setting</strong>
                        {{-- <div style="padding-top: 10px;">
                            <input type="checkbox" id="opened" name="opened" value="opened">
                            <label for="opened" class="email_lable"> Store Opened</label><br>
                            <label for="opened" class="email_lable2"> Customers will receive an email with a
                                link to the store as soon as it opens.</label><br>
                        </div> --}}
                        <form action="{{ route('store.updateStoreStatusEmailSettings', $store->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="store_id" value="{{ $store->id }}">
                        <div style="padding-top: 10px;">
                            <input type="checkbox" id="closing_soon" name="send_closing_soon_email" {{ $store->send_closing_soon_email ? 'checked' : '' }}>
                            <label for="closing_soon" class="email_lable"> Store Closing Soon</label><br>
                            <label for="closing_soon" class="email_lable2"> Customers will receive an email warning that the store will be
                                closing in the next 1-3 days.
                            </label><br>
                        </div>
                        <div style="padding-top: 10px;">
                            <input type="checkbox" id="store_closed" name="send_store_close_email" {{ $store->send_store_close_email ? 'checked' : '' }}>
                            <label for="store_closed" class="email_lable"> Store Closed</label><br>
                            <label for="store_closed" class="email_lable2"> Customers will receive an email letting them know store is closed.
                            </label><br>
                        </div>
                        <div style="padding-top: 10px;">
                            <input type="checkbox" id="order_production" name="send_order_production_completed_email" {{ $store->send_order_production_completed_email ? 'checked' : '' }}>
                            <label for="order_production_completed" class="email_lable"> Order Shipped</label><br>
                            <label for="order_production_completed" class="email_lable2"> Customers will receive an email letting them know that
                                their orders redy to ship.
                            </label><br>
                        </div>
                        <div style="padding-top: 10px;">
                            <input type="checkbox" id="final_update" name="send_final_update_email" {{ $store->send_final_update_email ? 'checked' : '' }}>
                            <label for="final_update" class="email_lable">Final Update</label><br>
                            <label for="final_update" class="email_lable2"> Customers will receive an email to confirming their order receiving.
                            </label><br>
                        </div>
                        <div style="padding-top: 20px;">
                            <button type="submit" class="update_settings">UPDATE SETTING</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Compose Email Modal -->
<div class="modal fade" id="composeEmailModal" tabindex="-1" role="dialog" aria-labelledby="composeEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Compose Email</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: .5rem 2rem !important;">

            <div class="col-md-12 mb-2" style="border: 1px solid #f5efef; padding: 8px;">
                <label for="toEmail" class="form-label mb-1" style="font-weight: 600;">To</label>
                <select class="form-control" id="toEmail" multiple>
                </select>
            </div>

            <div class="col-md-12 mb-2" style="border: 1px solid #f5efef; padding: 8px;">
                <label for="ccEmail" class="form-label mb-1" style="font-weight: 600;">CC</label>
                <select class="form-control" id="ccEmail" multiple>
                </select>
            </div>

            <div class="col-md-12 mb-2" style="border: 1px solid #f5efef; padding: 8px;">
                <label for="emailSubject" class="form-label mb-1" style="font-weight: 600;">Subject</label>
                <input type="text" style="border:none" class="form-control" placeholder="Subject" id="emailSubject">
            </div>

            <div class="col-md-12 mb-2" style="padding: 0;">
                <label for="picTemplateDropdown" class="form-label mb-1" style="font-weight: 600;">Pic Template</label>
                <div class="dropdown mt-1 mb-3" style="position: unset;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="picTemplateDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #e1e1e1;color: black;">
                        Pic Template
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="picTemplateDropdown" id="picTemplateDropdownContent" style="max-height: 200px; overflow-y: auto;">
                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-1" style="border: 1px solid #f5efef; padding: 8px;">
                <label for="quillEditor" class="form-label mb-1" style="font-weight: 600;">Message</label>
                <div id="quillEditor" style="height: 250px;"></div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-info" id="saveTemplateBtn">Save as template</button>
          <button type="button" class="btn btn-primary" id="sendEmailBtn">Send</button>
        </div>
      </div>
    </div>
</div>

  <!-- Quill -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    let quill;
    var selectedEmails = [];
    let ccEmail = @json(!empty(auth()->user()->email) ? [auth()->user()->email] : []);

    $(document).ready(function () {
        $('#toEmail, #ccEmail').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            width: '100%',
            placeholder: 'Type email and press Enter'
        });

        $('#compose_email_button').on('click', function () {
            $(".se-pre-con").fadeIn('slow');

            const $toEmail = $('#toEmail');
            const $ccEmail = $('#ccEmail');

            // Clear old values/options
            $toEmail.empty();
            $ccEmail.empty();

            // Add default TO emails
            selectedEmails.forEach(function (email) {
                if (email && email.trim() !== '') {
                    let option = new Option(email, email, true, true);
                    $toEmail.append(option);
                }
            });

            // Add default CC emails
            ccEmail.forEach(function (email) {
                if (email && email.trim() !== '') {
                    let option = new Option(email, email, true, true);
                    $ccEmail.append(option);
                }
            });

            // Refresh Select2
            $toEmail.trigger('change');
            $ccEmail.trigger('change');

            $('#composeEmailModal').modal('show');
            $(".se-pre-con").fadeOut('slow');
        });

        $('#toEmail').on('change', function () {
            selectedEmails = $(this).val() || [];
        });

        $('#ccEmail').on('change', function () {
            ccEmail = $(this).val() || [];
        });

        $('.update_settings').on('click', function () {
            $(".se-pre-con").fadeIn('slow');
        });

        $('#composeEmailModal').on('shown.bs.modal', function () {
            if (!quill) {
                quill = new Quill('#quillEditor', {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ header: [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline'],
                            [{ color: [] }, { background: [] }],
                            [{ list: 'ordered' }, { list: 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });
            }
        });

        $(document).on('click', '.dropdown-menu a.dropdown-item', function(e) {
            e.preventDefault();

            $(".se-pre-con").fadeIn('slow');

            const encodedSubject = $(this).data('subject') || '';
            const encodedTemplate = $(this).data('template') || '';

            const subject = decodeURIComponent(encodedSubject);
            const templateBody = decodeURIComponent(encodedTemplate);

            $('#emailSubject').val(subject);

            quill.setContents([]);
            quill.clipboard.dangerouslyPasteHTML(templateBody);

            $(this).closest('.dropdown-menu').removeClass('show');
            $(".se-pre-con").fadeOut('slow');
        });

        $('#saveTemplateBtn').on('click', function () {
            $('#composeEmailModal').modal('hide');
            Swal.fire({
                title: 'Enter Template Name',
                input: 'text',
                inputLabel: 'Template Name',
                inputPlaceholder: 'Enter template name',
                showCancelButton: true,
                allowOutsideClick: false,
                inputAttributes: {
                    autocapitalize: 'off',
                    autocomplete: 'off',
                    spellcheck: 'false',
                },
                inputValidator: (value) => {
                    if (!value || !value.trim()) {
                        return 'Template name is required!';
                    }
                }
            }).then((result) => {
                if (result.value) {
                    const templateName = result.value.trim();

                    const subject = $('#emailSubject').val();
                    const message = encodeURIComponent(quill.root.innerHTML);

                    if (!subject.trim() || !message.trim()) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Fields',
                            text: 'Please fill all fields before saving.'
                        });
                        return;
                    }

                    $(".se-pre-con").fadeIn('slow');

                    $.ajax({
                        url: "{{ route('store.saveEmailTemplate') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            template_name: templateName,
                            subject: subject,
                            body: message
                        },
                        success: function (response) {
                            $(".se-pre-con").fadeOut('slow');
                            getEmailTemplates();
                            Swal.fire({
                                icon: 'success',
                                title: 'Template Saved',
                                text: response.message || 'Template saved successfully!'
                            });
                            $('#composeEmailModal').modal('show');
                        },
                        error: function () {
                            $(".se-pre-con").fadeOut('slow');
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: 'Something went wrong while saving the template.'
                            });
                        }
                    });
                }
            });
        });



        $('#sendEmailBtn').on('click', function () {
            $(".se-pre-con").fadeIn('slow');
            const subject = $('#emailSubject').val();
            const message = quill.root.innerHTML;
            const to = $('#toEmail').val();

            if (to.length === 0 || subject.trim() === '' || message.trim() === '') {
                $(".se-pre-con").fadeOut('slow');
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Fields',
                    text: 'Please fill all fields before sending.'
                });
                return;
            }

            $.ajax({
                url: "{{ route('store.emailToCucstomer') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    emails: to,
                    cc_emails: ccEmail,
                    subject: subject,
                    message: message
                },
                success: function (response) {
                    $(".se-pre-con").fadeOut('slow');
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Sent',
                        text: response.message || 'Emails sent successfully!'
                    });
                    $('#composeEmailModal').modal('hide');

                },
                error: function (xhr) {
                    $(".se-pre-con").fadeOut('slow');
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: 'Something went wrong while sending emails.'
                    });
                }
            });
        });
    });


    $(document).on('change', '#select-all-checkbox', function () {
        const isChecked = $(this).is(':checked');
        const $table = $(this).closest('table');
        $table.find('.row-checkbox').prop('checked', isChecked).trigger('change');
    });

    $(document).on('change', '.row-checkbox', function () {
        const $table = $(this).closest('table');
        selectedEmails = [];

        $table.find('.row-checkbox:checked').each(function () {
            const email = $(this).data('email');
            if (email) {
                selectedEmails.push(email);
            }
        });
    });

    function showTab(tabId) {
        var tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(function(tabContent) {
        tabContent.style.display = 'none';
        });

        var buttons = document.querySelectorAll('button');
        buttons.forEach(function(button) {
        button.classList.remove('active-button');
        });

        document.getElementById(tabId).style.display = 'block';

        document.querySelector('[onclick="showTab(\'' + tabId + '\')"]').classList.add('active-button');
    }

    function getEmailTemplates() {
        $.ajax({
            url: "{{ route('store.getEmailTemplates') }}",
            method: "GET",
            success: function (response) {
                const $dropdown = $('#picTemplateDropdownContent');
                $dropdown.empty();
                if (response.length === 0) {
                    $dropdown.append('<a class="dropdown-item" href="#">No templates available</a>');
                    return;
                }
                response.forEach(function (template) {
                    const encodedBody = encodeURIComponent(template.body);
                    const encodedSubject = encodeURIComponent(template.subject);
                    $dropdown.append(
                        `<a class="dropdown-item" href="#" data-template="${encodedBody}" data-subject="${encodedSubject}">${template.template_name}</a>`
                    );
                });
            },
            error: function () {
                console.error('Failed to fetch email templates.');
            }
        });
    }
    getEmailTemplates();
  </script>

@endsection
@section('content')
    @include('pages.stores.layouts.sidebar', ['sub_content' => 'overview'])
@endsection
