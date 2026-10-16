<style>
    .primary_logo_footer {
        width: auto;
        height: auto;
        max-width: 28rem;
        max-height: 10rem;
    }
    .email_con_details {
        text-align: center;
        padding: 3%;
        padding-top: 10px;
        color: {{ $teamStore->footer_text_color ?? '#717070' }};
    }

    /* Theme colour change */
    .input_dark {
        background-color: transparent !important;
        color: white !important;
    }
    .font_color_footer{
        font-size: 1.1rem;
        color: {{ $teamStore->footer_text_color ?? '#717070' }};
    }
    .gray_font_footer{
        font-size: 1rem;
    }

    /* =========================================================
   COMPACT MODERN MOBILE FOOTER
   ========================================================= */

@media (max-width: 767.98px) {

    .common-footer {
        width: 100% !important;
        margin-top: 15px !important;
        padding: 20px 14px !important;
        overflow: hidden !important;
    }

    .common-footer .section_new,
    .common-footer .section_new > .col-lg-12 {
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .common-footer .section_new > .col-lg-12 > .row {
        display: flex !important;
        flex-direction: column !important;
        width: 100% !important;
        margin: 0 !important;
    }


    /* =========================
       LOGO
       ========================= */

    .common-footer .col-lg-4:first-child {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 0 15px !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        border-bottom: 1px solid rgba(255,255,255,.15) !important;
    }

    .common-footer .primary_logo_footer {
        display: block !important;
        max-width: 125px !important;
        max-height: 50px !important;
        width: auto !important;
        height: auto !important;
        object-fit: contain !important;
    }


    /* =========================
       CONTACT DETAILS
       ========================= */

    .common-footer .col-lg-4:nth-child(2) {
        width: 100% !important;
        max-width: 100% !important;
        padding: 15px 0 2px !important;
    }

    .common-footer .col-lg-4:nth-child(2) > div {
        width: 100% !important;
        padding-top: 0 !important;
        margin: 0 !important;

        display: flex !important;
        flex-direction: row !important;
        align-items: stretch !important;
        justify-content: space-between !important;
    }

    .common-footer .email_con_details {
        width: 32% !important;
        padding: 7px 4px !important;
        margin: 0 !important;

        text-align: center !important;

        border: none !important;
        border-radius: 7px !important;
        background: rgba(255,255,255,.06) !important;
    }

    .common-footer .email_con_details b {
        display: block !important;
        margin-bottom: 2px !important;

        font-size: 11px !important;
        font-weight: 600 !important;
    }

    .common-footer .email_con_details a,
    .common-footer .email_con_details span {
        display: block !important;

        font-size: 10px !important;
        line-height: 1.25 !important;

        word-break: break-word !important;
        overflow-wrap: anywhere !important;
    }


    /* =========================
       SUBSCRIBE
       ========================= */

    .common-footer .col-lg-4:nth-child(3) {
        width: 100% !important;
        max-width: 100% !important;
        padding: 14px 0 0 !important;
    }

    .common-footer .col-lg-4:nth-child(3) > div:first-child {
        padding-top: 0 !important;
        text-align: center !important;
    }

    .common-footer .col-lg-4:nth-child(3) > div:first-child b {
        font-size: 16px !important;
        font-weight: 600 !important;
    }

    .common-footer .col-lg-4:nth-child(3) > div:nth-child(2) {
        padding: 3px 8px 0 !important;
        text-align: center !important;
    }

    .common-footer .col-lg-4:nth-child(3) > div:nth-child(2) span {
        font-size: 10px !important;
        line-height: 1.3 !important;
    }


    /* =========================
       EMAIL + BUTTON
       ========================= */

    .common-footer .col-lg-4:nth-child(3) > .row {
        width: 100% !important;
        padding: 10px 0 0 !important;
        margin: 0 !important;

        display: flex !important;
        flex-direction: row !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .common-footer #team-store-subscriber {
        width: calc(100% - 90px) !important;
        height: 38px !important;

        padding: 6px 9px !important;

        border-radius: 7px !important;

        font-size: 13px !important;
    }

    .common-footer .sub_btn {
        width: 82px !important;
        height: 38px !important;

        margin-left: 8px !important;
        margin-top: 0 !important;

        padding: 5px 7px !important;

        border-radius: 7px !important;

        font-size: 11px !important;
        font-weight: 600 !important;
    }


    /* =========================
       SOCIAL ICONS
       ========================= */

    .common-footer .col-lg-4:nth-child(3) > .row:last-child {
        width: 100% !important;

        padding-top: 12px !important;
        padding-bottom: 0 !important;

        margin: 0 !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .common-footer .col-lg-4:nth-child(3) > .row:last-child a {
        width: 32px !important;
        height: 32px !important;

        margin: 0 4px !important;
        padding: 0 !important;

        border-radius: 50% !important;

        display: flex !important;
        align-items: center !important;
        justify-content: center !important;

        background: rgba(255,255,255,.08) !important;
    }

    .common-footer .col-lg-4:nth-child(3) > .row:last-child i {
        margin: 0 !important;
        font-size: 17px !important;
    }
}


/* =========================================================
   EXTRA SMALL PHONES
   ========================================================= */

@media (max-width: 380px) {

    .common-footer {
        padding: 17px 9px 11px !important;
    }

    .common-footer .col-lg-4:first-child {
        padding-bottom: 12px !important;
    }

    .common-footer .primary_logo_footer {
        max-width: 110px !important;
        max-height: 42px !important;
    }

    .common-footer .col-lg-4:nth-child(2) {
        padding-top: 12px !important;
    }

    .common-footer .email_con_details {
        padding: 6px 2px !important;
    }

    .common-footer .email_con_details b {
        font-size: 10px !important;
    }

    .common-footer .email_con_details a,
    .common-footer .email_con_details span {
        font-size: 9px !important;
    }

    .common-footer .col-lg-4:nth-child(3) {
        padding-top: 11px !important;
    }

    .common-footer .col-lg-4:nth-child(3) > div:first-child b {
        font-size: 15px !important;
    }

    .common-footer .col-lg-4:nth-child(3) > div:nth-child(2) span {
        font-size: 9px !important;
    }

    .common-footer .col-lg-4:nth-child(3) > .row {
        padding-top: 8px !important;
    }

    .common-footer #team-store-subscriber,
    .common-footer .sub_btn {
        height: 36px !important;
    }

    .common-footer #team-store-subscriber {
        width: calc(100% - 82px) !important;
        font-size: 12px !important;
    }

    .common-footer .sub_btn {
        width: 74px !important;
        font-size: 10px !important;
    }

    .common-footer .col-lg-4:nth-child(3) > .row:last-child {
        padding-top: 9px !important;
    }

    .common-footer .col-lg-4:nth-child(3) > .row:last-child a {
        width: 29px !important;
        height: 29px !important;
    }

    .common-footer .col-lg-4:nth-child(3) > .row:last-child i {
        font-size: 15px !important;
    }
}

    /* End Theme colour change */
</style>
@php
    $secondaryColor = $teamStore->secondary_color ? $teamStore->secondary_color : 'rgb(242, 242, 242)';
@endphp

@include('pages.customer_team_store.home.subscriber_modal')

<footer class="col common-footer py-5 {{ $teamStore->theme == 1 ? 'top_nav_dark' : '' }}" style=" margin-top: 25px; background-color: {{ $secondaryColor }};">
    <div class="section_new">
        <div class="col-lg-12 col-12">
            <div class="row" style="margin: unset;">
                <div class="col-lg-4 d-flex align-items-center justify-content-center">
                    <a href="{{ makeStoreDomainRoute($store->direct_access_url.(request()->has('view-only') && request()->query('view-only') == 'true' ? '?view-only=true' : '')) }}">
                        <img src="{{ asset($teamStore->primary_logo ?  : 'assets/img/teamStore/logo_dark.png') }}"   onerror="this.onerror=null; this.src='{{ asset('assets/img/teamStore/logo_dark.png') }}';" alt="image" class="primary_logo_footer">
                    </a>
                </div>
                <div class="col-lg-4 d-flex align-items-center justify-content-center">
                    <div style="display: flex; justify-content: center; padding-top: 20px;" class="row">
                        <div class="email_con_details" style="padding-left: unset;">
                            <b>Write Us</b> <br>
                            <a href="mailto:{{$store->service_email ? $store->service_email : 'teamstore@encr.co'}}" class="font_color_footer">{{$store->service_email ? $store->service_email : 'teamstore@encr.co'}}</a>
                        </div>
                        <div class="email_con_details">
                            <b>Call Us</b> <br>
                            <span class="font_color_footer">{{$store->service_phone ? $store->service_phone : '+1 888-501-4999'}}</span>
                        </div>
                        <div class="email_con_details">
                            <b>Visit Us</b> <br>
                            <a href="https://www.google.com/maps/search/?api=1&query=891+4th+St,+San+Rafael,+CA+94901,+USA"
                            target="_blank"
                            class="font_color_footer">
                                891 4th St, San Rafael, CA 94901, USA
                            </a>
                        </div>
                    </div>

                </div>
                <div class="col-lg-4 justify-content-center">
                    <div style="text-align: center; padding-top: 25px;">
                        <b class="font_color_footer">Don’t Miss Out</b>
                    </div>

                    <div style="text-align: center; padding-top: 5px; color: gray;">
                        <span class="font_color_footer">Subscribe to our mailing list and we'll keep you updated with the latest collections, exclusive offers, and promotions.</span>
                        {{-- <span class="gray_font_footer"> </span> --}}
                    </div>
                    @php
                        $primaryColor = $teamStore->primary_color ? $teamStore->primary_color : '#47D6B6';
                    @endphp
                    <div style="display: flex; justify-content: center; padding-top: 25px; color: gray;" class="row">
                        <input type="email" id="team-store-subscriber" class="form-control {{ $teamStore->theme == 1 ? 'input_dark' : '' }}" style="width: 250px;">
                        <button class="btn btn-success sub_btn" id="team-store-subscriber-btn" type="button" style="margin-left: 20px; background-color: {{ $primaryColor }}; border: unset;">Subscribe</button>
                    </div>
                    <div class="row" style="display: flex; justify-content: center; padding-top: 30px; padding-bottom: 30px;">
                        <a href="https://www.facebook.com/encrcstm" target="_blank" style=" padding-right: 10px;">
                            <i class="fa fa-facebook-square font_color_footer" aria-hidden="true" style="font-size: 2rem;"></i>
                        </a>
                        <a href="https://www.instagram.com/encrcstm" target="_blank" style=" padding-left: 10px;">
                            <i class="fa fa-instagram ml-3 font_color_footer" aria-hidden="true" style="font-size: 2rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

