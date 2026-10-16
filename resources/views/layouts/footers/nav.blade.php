<style>
    .text-muted a {
        color: #e40027b0;
    }
    .footer {
        border-top: none;
        margin: 20px 0 0px 0;
    }
    .country-container {
			display: flex;
			align-items: center;
			margin-bottom: 10px;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
            position: relative;
            bottom: 0%;
            width: 100%;
		}

		.country-flag {
			margin-right: 10px;
			width: 30px;
			height: 20px;
			background-repeat: no-repeat;
			background-size: contain;
            position: relative;
            top: 2px;
		}

		.country-name {
			font-weight: bold;
			margin-right: 10px;
		}

		.country-time {
			margin-right: 10px;
            color: #ccc;
            position: relative;
            right: -16px;
            top: -5px;
            width: 100px;
            font-size: 185%;
            left: -5px;
		}

		.country-date {
			margin-right: 10px;
            color: #ccc;
            position: relative;
            right: 33px;
            width: 150px;
            font-size: xx-small;
            letter-spacing: 0.064rem;
            left: -55px;
		}
        .color {
            background-color: #ffffff;
        }
        .iconDiv {
            width: 200px;
            height: 30px;
        }
        .textsize {
            font-size: 60%;
        }
        .timeplace {
            right: 1%;
        }
        .divbottom {
            position: relative;
            margin-bottom: -8px;
            width: 102%;
        }
    .footer-position {
        height: 44px;
        position: relative;
        top: 2px;
    }
    .time-div {
        width: 12.5%;
        position: relative;
        left: 13px;
        text-align: right;
    }
    .time-div-position {
        position: relative;
        left: 2%;
    }
    .impersonate-exit {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: red;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    font-weight: bold;
    text-decoration: none;
}
.impersonate-exit:hover {
    background: darkred;
    color: #fff;
}

/* ================= MOBILE FIX ================= */
.mobile-footer{
    display:none;
}

@media (max-width:768px){

    /* hide desktop */
    .maxwidth-none-footer{
        display:none !important;
    }
    .large_screen_footer{
        display:none !important;
    }
    .display-none-footer{
        display:none !important;
    }

    /* mobile grid */
    .mobile-footer{
        display:grid;
        grid-template-columns: repeat(4, 1fr);
        gap:10px;
        padding:10px;
        justify-items:center;
        align-items:center;
        width: 100%;
    }

    /* card */
    .m-box{
        width:100%;
        max-width:85px;
        background:transparent;
        border-radius:10px;
        padding:8px 6px;

        display:flex;
        flex-direction:column;
        align-items:flex-start; /* LEFT ALIGN CONTENT */
        text-align:left;
    }

    /* flag */
    .m-flag{
        width:32px;
        height:20px;
        background-size:cover;
        background-position:center;
        margin-bottom:6px;
    }

    /* text */
    .m-time{
        font-size:14px;
        font-weight:700;
        color:#CCCCCC;
        line-height:1.2;
    }

    .m-day{
        font-size:11px;
        color:#CCCCCC;
        line-height:1.2;
    }

    .m-date{
        font-size:11px;
        color:#CCCCCC;
        line-height:1.2;
    }

    /* footer height adjust */
    .footer{
        height:auto;
        padding-bottom:10px;
        position: relative;
    }
    .mobile_footer {
        width: 102%;
        padding-right: unset;
    }
}

</style>

<div class="row align-items-center justify-content-xl-between container-fluid divbottom" style="padding-right: 0pc !important; padding-left: 0px !important;">
        <div class="row col-md-12 textsize footer-position large_screen_footer">
            <div class=" col-md-2 iconDiv timeplace display-none-footer"></div>

            <div class="row col-md-10 time-div-position maxwidth-none-footer">
                <div class="time-div timeplace">
                    <div class="country-container" title="USA-California" style="display: contents;">
                        <div class="country-flag" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/a/a4/Flag_of_the_United_States.svg')">
                            <div class="country-time" id="usa-time"></div>
                        </div>
                        <div class="country-date" id="usa-date"></div>
                    </div>
                </div>
                <div class="time-div timeplace">
                    <div class="country-container" title="SL" style="display: contents;">
                        <div class="country-flag l-10" style="background-image: url('https://cdn.britannica.com/13/4413-004-3277D2EF/Flag-Sri-Lanka.jpg')"><div class="country-time" id="sl-time"></div></div>

                        <div class="country-date" id="sl-date"></div>
                    </div>
                </div>
                <div class="time-div timeplace">
                    <div class="country-container" title="Colombia-Bogota" style="display: contents;">
                        <div class="country-flag l-10" style="width: 25px; background-image: url('https://cdn.britannica.com/68/7668-004-08492AB7/Flag-Colombia.jpg')"><div class="country-time" id="colombia-time"></div></div>

                        <div class="country-date" id="colombia-date"></div>
                    </div>
                </div>
                <div class="time-div timeplace">
                    <div class="country-container" title="Indonesia-Jakarta" style="display: contents;">
                        <div class="country-flag l-10" style="width: 25px; background-image: url('https://cdn.britannica.com/48/1648-004-A33B72D8/Flag-Indonesia.jpg')"><div class="country-time" id="jakarta-time"></div></div>

                        <div class="country-date" id="jakarta-date"></div>
                    </div>
                </div>
                <div class="time-div timeplace">
                    <div class="country-container" title="Pakistan-Makassar" style="display: contents;">
                        <div class="country-flag l-10" style="width: 25px; background-image: url('https://bali.com/wp-content/uploads/2020/08/pakistan-flag.jpg')"><div class="country-time" id="makassar-time"></div></div>

                        <div class="country-date" id="makassar-date"></div>
                    </div>
                </div>
                <div class="time-div timeplace">
                    <div class="country-container" title="China & Philippines" style="display: contents;">
                        <div class="country-flag l-10" style="width: 20px; height: 15px; background-image: url('https://upload.wikimedia.org/wikipedia/commons/f/fa/Flag_of_the_People%27s_Republic_of_China.svg')">
                            <img src="https://cdn.britannica.com/73/3473-004-6E573BFA/Flag-Philippines.jpg" style="width: 20px; height: 13px; position: relative; left: 25px; top: 1px;" alt="">
                            <div class="country-time" style="position: relative; top: -18px; left: 3px;" id="china-time"></div>
                        </div>
                        <div class="country-date" style="position: relative; top: 6px; left: -45px;" id="china-date-time"></div>
                    </div>
                </div>
                {{-- <div class="time-div timeplace">
                    <div class="country-container" title="Philippines" style="display: contents;">
                        <div class="country-flag l-10" style="background-image: url('https://cdn.britannica.com/73/3473-004-6E573BFA/Flag-Philippines.jpg')">
                          <div class="country-time" id="philippine-time"></div>
                        </div>
                        <div class="country-date" id="philippine-date"></div>
                    </div>
                </div> --}}
                <div class="time-div timeplace">
                    <div class="country-container" title="Brazil" style="display: contents;">
                        <div class="country-flag l-10" style="background-image: url('https://static.vecteezy.com/system/resources/previews/002/431/840/original/illustration-of-the-brazil-flag-free-vector.jpg')">
                          <div class="country-time" id="floripa-time"></div>
                        </div>
                        <div class="country-date" id="floripa-date"></div>
                    </div>
                </div>
                <div class="time-div timeplace">
                    <div class="country-container" title="Thailand" style="display: contents;">
                        <div class="country-flag l-10" style="background-image: url('https://cdn.britannica.com/38/4038-004-111388C2/Flag-Thailand.jpg')">
                          <div class="country-time" id="thailand-time"></div>
                        </div>
                        <div class="country-date" id="thailand-date"></div>
                    </div>
                </div>
            </div>


        </div>
        <div class="row col-md-12 textsize mobile_footer">

            <div id="mobile-footer" class="mobile-footer"></div>

        </div>
</div>
@if(session()->has('original_user_id'))
    <a href="{{ route('impersonate.revert') }}" class="impersonate-exit">
        <i class="fas fa-user-shield"></i> Admin Mode
    </a>
@endif

<script>
    function updateTimes() {
        const usaTime = new Date().toLocaleTimeString("en-US", { timeZone: "America/Los_Angeles", hour12: true, hour: 'numeric', minute: 'numeric' });
        document.getElementById("usa-time").innerHTML = usaTime;

        const usaDate = new Date().toLocaleDateString("en-US", { timeZone: "America/Los_Angeles", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById("usa-date").innerHTML = usaDate;

        const slTime = new Date().toLocaleTimeString("en-US", { timeZone: "Asia/Colombo", hour12: true, hour: 'numeric', minute: 'numeric' });
        document.getElementById("sl-time").innerHTML = slTime;

        const slDate = new Date().toLocaleDateString("en-US", { timeZone: "Asia/Colombo", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById("sl-date").innerHTML = slDate;

        const colombiaTime = new Date().toLocaleTimeString("en-US", { timeZone: "America/Bogota", hour12: true, hour: 'numeric', minute: 'numeric' });
        document.getElementById("colombia-time").innerHTML = colombiaTime;

        const colombiaDate = new Date().toLocaleDateString("en-US", { timeZone: "America/Bogota", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById("colombia-date").innerHTML = colombiaDate;

        const jakartaTime = new Date().toLocaleTimeString("en-US", { timeZone: "Asia/Jakarta", hour12: true, hour: 'numeric', minute: 'numeric' });
        document.getElementById("jakarta-time").innerHTML = jakartaTime;

        const jakartaDate = new Date().toLocaleDateString("en-US", { timeZone: "Asia/Jakarta", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById("jakarta-date").innerHTML = jakartaDate;

        const makassarTime = new Date().toLocaleTimeString("en-US", { timeZone: "Asia/Karachi", hour12: true, hour: 'numeric', minute: 'numeric' });
        document.getElementById("makassar-time").innerHTML = makassarTime;

        const makassarDate = new Date().toLocaleDateString("en-US", { timeZone: "Asia/Karachi", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById("makassar-date").innerHTML = makassarDate;

          const chinaTime = new Date().toLocaleTimeString("en-US", { timeZone: "Asia/Shanghai", hour12: true, hour: 'numeric', minute: 'numeric' });
          document.getElementById("china-time").innerHTML = chinaTime;

          const chinaDateTime = new Date().toLocaleDateString("en-US", { timeZone: "Asia/Shanghai", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
          document.getElementById("china-date-time").innerHTML = chinaDateTime;

        // const philippineTime = new Date().toLocaleTimeString("en-US", { timeZone: "Asia/Manila", hour12: true, hour: 'numeric', minute: 'numeric' });
        // document.getElementById("philippine-time").innerHTML = philippineTime;

        // const philippineDate = new Date().toLocaleDateString("en-US", { timeZone: "Asia/Manila", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        // document.getElementById("philippine-date").innerHTML = philippineDate;

        const floripaTime = new Date().toLocaleTimeString("en-US", { timeZone: "America/Sao_Paulo", hour12: true, hour: 'numeric', minute: 'numeric' });
        document.getElementById("floripa-time").innerHTML = floripaTime;

        const floripaDate = new Date().toLocaleDateString("en-US", { timeZone: "America/Sao_Paulo", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById("floripa-date").innerHTML = floripaDate;

        const thailandTime = new Date().toLocaleTimeString("en-US", { timeZone: "Asia/Bangkok", hour12: true, hour: 'numeric', minute: 'numeric' });
        document.getElementById("thailand-time").innerHTML = thailandTime;

        const thailandDate = new Date().toLocaleDateString("en-US", { timeZone: "Asia/Bangkok", weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById("thailand-date").innerHTML = thailandDate;

    }


    setInterval(updateTimes, 1000);

    const countries = [
    { id:"usa", zone:"America/Los_Angeles", flag:"https://upload.wikimedia.org/wikipedia/commons/a/a4/Flag_of_the_United_States.svg" },
    { id:"sl", zone:"Asia/Colombo", flag:"https://cdn.britannica.com/13/4413-004-3277D2EF/Flag-Sri-Lanka.jpg" },
    { id:"colombia", zone:"America/Bogota", flag:"https://cdn.britannica.com/68/7668-004-08492AB7/Flag-Colombia.jpg" },
    { id:"jakarta", zone:"Asia/Jakarta", flag:"https://cdn.britannica.com/48/1648-004-A33B72D8/Flag-Indonesia.jpg" },
    { id:"makassar", zone:"Asia/Karachi", flag:"https://bali.com/wp-content/uploads/2020/08/pakistan-flag.jpg" },
    { id:"china", zone:"Asia/Shanghai", flag:"https://upload.wikimedia.org/wikipedia/commons/f/fa/Flag_of_the_People%27s_Republic_of_China.svg" },
    { id:"brazil", zone:"America/Sao_Paulo", flag:"https://static.vecteezy.com/system/resources/previews/002/431/840/original/illustration-of-the-brazil-flag-free-vector.jpg" },
    { id:"thailand", zone:"Asia/Bangkok", flag:"https://cdn.britannica.com/38/4038-004-111388C2/Flag-Thailand.jpg" }
];

function getInfo(zone){
    const now = new Date();

    return {
        time: now.toLocaleTimeString("en-US",{timeZone:zone,hour:'numeric',minute:'numeric',hour12:true}),
        day: now.toLocaleDateString("en-US",{timeZone:zone,weekday:'short'}),
        date: now.toLocaleDateString("en-US",{timeZone:zone,year:'numeric',month:'short',day:'numeric'})
    };
}

function renderMobile(){

    const container = document.getElementById("mobile-footer");

    if(window.innerWidth > 768){
        container.innerHTML = "";
        return;
    }

    let html = "";

    countries.forEach(c => {
        const d = getInfo(c.zone);

        html += `
            <div class="m-box">
                <div class="m-flag" style="background-image:url('${c.flag}')"></div>
                <div class="m-time">${d.time}</div>
                <div class="m-day">${d.day}</div>
                <div class="m-date">${d.date}</div>
            </div>
        `;
    });

    container.innerHTML = html;
}

setInterval(renderMobile, 1000);
renderMobile();
window.addEventListener("resize", renderMobile);

</script>
