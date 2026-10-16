<style>

    .logo_div {
        margin-top: 1rem;
        margin-bottom: 1rem;
        text-align: center;
    }
    .website_div {
        border-left: 2px solid #e6e6e6;
        margin-top: 1rem;
        margin-bottom: 1rem;
        padding-left: 6%;
    }

    @media only screen and (min-width: 320px ) and (max-width: 767px )
    {
        .logo_div {
            border-right: unset;
            text-align: center;
        }
        .email_div {
            text-align: center;
            padding-left: 15px !important;
        }
        .website_div {
            text-align: center;
            border-left: unset;
            padding-left: 15px !important;
        }
    }
    @media only screen and (min-width: 485px ) and (max-width: 765px )
    {
        .common-footer {
            position: unset !important;
        }
    }
    @media only screen and (max-width: 575px )
    {
        .thumbmail-style {
            flex-direction: row !important;
            margin-left: 0 !important;
        }
        .image-position-small{
            display: block !important;
            margin-left: 0 !important;
            position: unset !important;
        }
        #defaultThumbnail{
            display: flex;
            justify-content: center;
        }
    }
    .flag_img {
        margin-right: 9px;
        width: 20px;
    }
    .font_size_13 {
        font-size: 13px;

    }

</style>

<footer class="col common-footer" style="background-color: rgb(242, 242, 242); z-index: 100; border-top: rgb(235, 232, 232) solid 0.5px; bottom: 0px;">
    <div class="section_new" style="margin-left: 2%;margin-right: 2%;">
        <div class="row">
            <div class="col-lg-3 col-sm-12 col-md-4 email_div" style="margin-top: 1rem; margin-bottom: 1rem; border-right: 2px solid #e6e6e6;">
                <div class="row">
                    <div class="col-md-12 sub-header-style mt-3">
                        Contact
                    </div>
                    <div class="col-md-12 mt-3 font_size_13" style="color: grey">
                        <i class="fa fa-envelope-o" aria-hidden="true" style="font-size: 1rem;"></i>&nbsp;&nbsp;info@encorecustom.com
                    </div>
                    <div class="col-md-12 mt-3 font_size_13" style="color: grey">
                        <i class="fa fa-phone" aria-hidden="true" style="font-size: 1rem;"></i>&nbsp;&nbsp;+1 888-501-4999
                    </div>
                    <div class="col-md-12 mt-3 font_size_13" style="color: grey">
                        <i class="fa fa-map-marker" aria-hidden="true" style="font-size: 1rem;"></i>&nbsp;&nbsp;891 4th St, San Rafael, <br> &nbsp;&nbsp;&nbsp;&nbsp;CA 94901, USA
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12 col-md-4 logo_div" style="">
                <div class="row">
                    <div class="col-md-12 mt-3 d-flex justify-content-center">
                        <img src="{{ asset('argon') }}/img/encore/logo_dark.png" alt="image" style="width: 250px;">
                    </div>

                    <div class="col-md-12 mt-3 font_size_13" style="color: #4E4C4C;">
                        Manufacturer & Clothier
                    </div>
                    <div class="col-md-12 mt-3 row justify-content-center" style="color: #4E4C4C; margin: unset;">
                        <img src="{{ asset('assets/img/flags/usa.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/SriLanka.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/thailand.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/ndonesia.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/pakistan.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/colombia.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/philippines.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/china.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/thaiwan.svg') }}" alt="label" class="flag_img">
                        <img src="{{ asset('assets/img/flags/argentina.svg') }}" alt="label" class="flag_img">
                    </div>
                    <div class="col-md-12 mt-3 font_size_13" style="color: rgb(190, 190, 190); font-size: 11px;">
                        © Encore Custom {{ date('Y') }}. All Rights Reserved.
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-12 col-md-4 website_div" style="">
                <div class="row">
                    <div class="col-md-12 sub-header-style mt-3" style="">
                        Explore
                    </div>
                    <div class="col-md-12 mt-3 d-flex align-items-center justify-content-center justify-content-md-start">
                        <a href="http://www.encorecustom.com" target="_blank" style="color: grey; padding-right: 13px;">
                            <img src="{{ asset('assets/img/icons/catlog/fb.png') }}" alt="Facebook" style="width: 20px;">
                        </a>
                        <a href="http://www.encorecustom.com" target="_blank" style="color: grey; padding-right: 14px;">
                            <img src="{{ asset('assets/img/icons/catlog/instagram.png') }}" alt="Instagram" style="width: 20px;">
                        </a>
                        <a href="http://www.encorecustom.com" target="_blank" style="color: grey; padding-right: 13px;">
                            <img src="{{ asset('assets/img/icons/catlog/web.png') }}" alt="Website" style="width: 20px;">
                        </a>
                    </div>

                    <div class="col-md-12 sub-header-style mt-3">
                        Subscribe Now
                    </div>
                    <div class="col-md-12 mt-3" style="color: grey">
                        <div style="position: relative; padding-right: 4%;">
                            <input type="text" class="form-control font_size_13"
                                   style="border: 1px solid rgb(221, 221, 221); padding-right: 35px; padding-left: 10px;"
                                   placeholder="Enter your email">
                            <button type="button" style="color: gray; position: absolute; top: 50%; right: 10px; transform: translateY(-50%); border: none; background: none; cursor: pointer;">
                                ➔
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
    function adjustFooterPosition() {
        const footer = document.querySelector('footer');
        const bodyHeight = document.body.offsetHeight;
        const windowHeight = window.innerHeight;

        // Check if the body's height is less than the window's height
        if (bodyHeight < windowHeight) {
            footer.style.position = 'relative';
            footer.style.bottom = '0';
        } else {
            footer.style.position = 'relative';
            footer.style.bottom = 'auto';
        }
    }

    // Run on load
    window.addEventListener('load', adjustFooterPosition);
    // Run on resize
    window.addEventListener('resize', adjustFooterPosition);
</script>
