@extends('layouts.customer_portal.app')

@section('content')

<style>
    .body_class {
        background-color: rgba(246, 246, 246, 0.46);
    }
    .font_15 {
        font-size: 15px;
    }
    .fabric_name {
        color: #fff;
        font-size: 23px;
        font-weight: 600;
        text-align: center;
        text-shadow: 0 2px 6px rgba(0,0,0,0.6);
        background-color: rgba(182, 182, 182, 0.5);
        padding: 4px 10px;
        border-radius: 5px;
    }
    .fabric_image {
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 150px;
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .color_wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .color_item {
        text-align: center;
        font-size: 12px;
        color: #444;
    }

    .color_box {
        width: 35px;
        height: 35px;
        border-radius: 6px;
        border: 1px solid #ddd;
        margin-bottom: 4px;
    }
    .embellishment_wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .embellishment_badge {
        background: #f2f2f2;
        color: #333;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        border: 1px solid #ddd;
        white-space: nowrap;
    }

    .fabric_section p:first-of-type {
        font-weight: 600;
        font-size: 14px;
        color: #2f3c48;
        margin-bottom: 6px;
    }

    .fabric_section p:not(:first-of-type) {
        font-size: 12px;
    }
    .fabric_section {
        padding: 5px 0px;
    }
    .fabric_section ul {
        list-style: none;
        padding-left: 0;
        margin: 0;
    }

    .fabric_section ul li {
        position: relative;
        padding-left: 20px;
        font-size: 12px;
        color: #444;
        margin-bottom: 6px;
    }

    .fabric_section ul li::before {
        content: "✔";
        position: absolute;
        left: 0;
        top: 0;
        color: #d32f2f; /* brand red */
        font-size: 13px;
    }

    /* ===============================
    Responsive Fabric Cards Grid
    ================================ */

    /* Default desktop (≥1200px) → 4 cards */
    #fabricContainer > div {
        width: 25%;
    }

    /* Large tablets / small laptops */
    @media (max-width: 1199px) {
        #fabricContainer > div {
            width: 33.3333%; /* 3 cards */
        }
    }

    /* Tablets */
    @media (max-width: 991px) {
        #fabricContainer > div {
            width: 50%; /* 2 cards */
        }
    }

    /* Mobile (smallest screens) */
    @media (max-width: 575px) {
        #fabricContainer > div {
            width: 100%; /* STILL 1 cards */
        }

        .fabric_name {
            font-size: 16px;
            padding: 3px 6px;
        }

        .fabric_image {
            height: 160px;
        }

        .fabric_section p:first-of-type {
            font-size: 13px;
        }

        .fabric_section ul li {
            font-size: 11px;
        }

        .color_box {
            width: 28px;
            height: 28px;
        }
    }


    .search-wrapper {
    position: relative;
    display: inline-flex;
    align-items: center;
    cursor: pointer;
}

.search-icon {
    font-size: 16px;
    color: #333;
}

.search-input {
    position: absolute;
    right: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    opacity: 0;
    padding: 6px 10px;
    font-size: 13px;
    border: 1px solid #ccc;
    border-radius: 4px;
    outline: none;
    transition: all 0.25s ease;
    pointer-events: none;
    background: #fff;
}

/* visible state */
.search-wrapper.active .search-input {
    width: 180px;
    opacity: 1;
    pointer-events: auto;
}
.embellishment_image span{
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}
.embellishment_description p {
    font-size: 12px;
    color: #444;
}

</style>

<div class="content-wrapper" style="padding: 40px 30px;">
    <div class="ml-auto ">
        <div class="row justify-content-end font_15">
            {{-- <div class="col-auto">
                <div>
                    <span>Fabrics For:</span>
                </div>
            </div> --}}

            {{-- <div class="col-auto">
                <div>
                    <select name="styles" id="styles">
                        <option value="all_atyle">All Style</option>
                        <option value="top">Top</option>
                        <option value="bottom">Bottom</option>
                        <option value="hat">Custom Hats</option>
                        <option value="bag">Bags</option>
                    </select>
                </div>
            </div>

            <div class="col-auto">
                <div>
                    <select name="categories" id="categories">
                        <option value="all_categories">All Categories</option>
                        <option value="sportswear">Sportswear</option>
                        <option value="lifestyle">Lifestyle</option>
                        <option value="training">Training</option>
                    </select>
                </div>
            </div> --}}

            <div class="col-auto">
                <div class="search-wrapper">
                <i class="fa fas fa-magnifying-glass search-icon"></i>

                <input
                    type="text"
                    class="search-input"
                    placeholder="Search fabrics..."
                />
            </div>

            </div>
        </div>
    </div>
</div>


<div class="content-wrapper" style="padding: 10px 20px;">
    <div class="col-lg-12">
        <div class="row" id="embellishmentContainer"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ===============================
       DATA
    =============================== */
    const embellishments = @json($embellishmentTypes);
    const container = document.getElementById('embellishmentContainer');

    /* ===============================
       FILTER – IMAGE ONLY
    =============================== */
    const embellishmentsWithImage = embellishments.filter(item =>
        item.image_1 && item.image_1.trim() !== ''
    );

    /* ===============================
       RENDER FUNCTION
    =============================== */
    function renderEmbellishments(list) {
        let html = '';

        if (!list || list.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center text-muted mt-4">
                    No embellishments found
                </div>
            `;
            return;
        }

        list.forEach(item => {
            html += `
                <div class="col-lg-3 col-md-4 col-sm-6 mb-3 embellishment-card">
                    <div class="card" style="padding:10px; height:100%;">

                        <div class="fabric_image"
                            style="
                                background-image:url('${item.image_1}');
                                height:220px;
                                background-size:cover;
                                background-position:center;
                                border-radius:8px;
                                position:relative;
                                overflow:hidden;
                            ">
                            <span class="fabric_name">
                                ${item.embellishment_name ?? ''}
                            </span>
                        </div>

                        <div class="mt-3 embellishment_description">
                            ${item.description ?? ''}
                        </div>

                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    /* ===============================
       INITIAL RENDER
    =============================== */
    renderEmbellishments(embellishmentsWithImage);

    /* ===============================
       SEARCH
    =============================== */
    const searchWrapper = document.querySelector('.search-wrapper');
    const searchInput = document.querySelector('.search-input');

    if (!searchWrapper || !searchInput) {
        console.error('Search elements not found');
        return;
    }

    let isTyping = false;

    searchWrapper.addEventListener('mouseenter', () => {
        searchWrapper.classList.add('active');
        searchInput.focus();
    });

    searchInput.addEventListener('input', () => {
        const value = searchInput.value.trim().toLowerCase();
        isTyping = value.length > 0;

        const filtered = embellishmentsWithImage.filter(item =>
            (item.embellishment_name ?? '')
                .toLowerCase()
                .includes(value)
        );

        renderEmbellishments(filtered);
    });

    searchWrapper.addEventListener('mouseleave', () => {
        if (!isTyping) {
            searchWrapper.classList.remove('active');
            searchInput.value = '';
            renderEmbellishments(embellishmentsWithImage);
        }
    });

    searchInput.addEventListener('focus', () =>
        searchWrapper.classList.add('active')
    );

    searchInput.addEventListener('blur', () => {
        if (!isTyping) {
            searchWrapper.classList.remove('active');
            searchInput.value = '';
            renderEmbellishments(embellishmentsWithImage);
        }
    });

});
</script>




<div class="" style=" z-index:99; padding: unset;">

    @include('pages.customer_product_catlog.layout.footer')

</div>


@endsection
