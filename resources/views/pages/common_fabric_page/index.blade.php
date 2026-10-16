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

.sublimation_palette {
    width: 35px;
    height: 35px;

    background: conic-gradient(
        red, orange, yellow, green, cyan, blue, violet, red
    );
}
.palette-row {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Palette size control */
.sublimation_palette {
    flex: 0 0 35px;
    height: 35px;
    /* border: 0.1px solid rgb(193, 193, 193); */
    width: 35px;
    border-radius: 6px;
}

/* Text */
.shine-text {
    flex: 1;
    font-size: 12px;
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
        <div class="row" id="fabricContainer" style="margin: unset;"></div>
    </div>
</div>

<script>
/* ===============================
   Parse Fabric Description
=============================== */
function parseFabricDescription(html) {
    if (!html) {
        return { listHtml: '', opacityHtml: '', weightHtml: '' };
    }

    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = html;

    // UL list
    const ul = tempDiv.querySelector('ul');
    const listHtml = ul ? ul.outerHTML : '';

    // OPACITY
    let opacityHtml = '';
    const opacityStrong = [...tempDiv.querySelectorAll('strong')]
        .find(el => el.textContent.toUpperCase().includes('OPACITY'));
    if (opacityStrong) {
        const parent = opacityStrong.parentElement;
        opacityHtml = parent.outerHTML;
        if (parent.nextElementSibling) {
            opacityHtml += parent.nextElementSibling.outerHTML;
        }
    }

    // WEIGHT
    let weightHtml = '';
    const weightStrong = [...tempDiv.querySelectorAll('strong')]
        .find(el => el.textContent.toUpperCase().includes('WEIGHT'));
    if (weightStrong) {
        let current = weightStrong.parentElement;
        weightHtml += current.outerHTML;
        let next = current.nextElementSibling;
        while (next && next.tagName !== 'STRONG') {
            weightHtml += next.outerHTML;
            next = next.nextElementSibling;
        }
    }

    return { listHtml, opacityHtml, weightHtml };
}

/* ===============================
   Render Fabric Colors
=============================== */
function renderFabricColors(colorsJson) {
    if (!colorsJson) return '';

    let colors;
    try {
        colors = typeof colorsJson === 'string'
            ? JSON.parse(colorsJson)
            : colorsJson;
    } catch {
        return '';
    }

    if (!Array.isArray(colors) || colors.length === 0) return '';

    let html = '<div class="color_wrap">';
    colors.forEach(color => {
        html += `
            <div class="color_item">
                <div class="color_box" style="background-color:${color.code};"></div>
                <span class="color_name">${color.name}</span>
            </div>
        `;
    });
    html += '</div>';

    return html;
}

/* ===============================
   Render Embellishments
=============================== */
function renderEmbellishments(embellishmentsJson) {
    if (!embellishmentsJson) return '';

    let items;
    try {
        items = typeof embellishmentsJson === 'string'
            ? JSON.parse(embellishmentsJson)
            : embellishmentsJson;
    } catch {
        return '';
    }

    if (!Array.isArray(items) || items.length === 0) return '';

    let html = '<div class="embellishment_wrap">';
    items.forEach(item => {
        html += `<span class="embellishment_badge">${item}</span>`;
    });
    html += '</div>';

    return html;
}

/* ===============================
   Generic Section Renderer
=============================== */
function renderSection(contentHtml, title = '') {
    if (!contentHtml || contentHtml.trim() === '') return '';
    return `
        <div class="fabric_section mt-2">
            ${title ? `<p class="section_title">${title}</p>` : ''}
            ${contentHtml}
        </div>
    `;
}

/* ===============================
   DATA & FILTER (IMAGE ONLY)
=============================== */
const allFabrics = @json($fabrics);

// 👉 ONLY fabrics WITH image_1
const fabricsWithImage = allFabrics.filter(fabric =>
    fabric.image_1 && fabric.image_1.trim() !== ''
);

const container = document.getElementById('fabricContainer');

/* ===============================
   Render Fabrics
=============================== */
function renderFabrics(fabricList) {
    let html = '';

    fabricList.forEach(fabric => {
        const parsed = parseFabricDescription(fabric.description);

        const listSection = renderSection(parsed.listHtml);
        // Check if Sublimation exists
        let hasSublimation = false;

        if (fabric.embellishments) {
            try {
                const emb = typeof fabric.embellishments === 'string'
                    ? JSON.parse(fabric.embellishments)
                    : fabric.embellishments;

                hasSublimation = emb.some(item =>
                    item.toLowerCase().includes('sublimation')
                );
            } catch {}
        }

        // COLORS SECTION LOGIC
        let colorsSection = '';

        if (hasSublimation) {
            colorsSection = `
                <div class="fabric_section mt-2">
                    <p class="section_title">FABRIC COLORS</p>

                    <div class="palette-row">
                        <div class="sublimation_palette"></div>

                        <div class="shine-text">
                            This Product Can Be Sublimated In Any Color
                        </div>
                    </div>
                </div>
            `;
        } else {
            colorsSection = renderSection(
                renderFabricColors(fabric.colors),
                'FABRIC COLORS'
            );
        }

        const opacitySection = renderSection(parsed.opacityHtml);
        const weightSection = renderSection(parsed.weightHtml);
        const embellishmentSection = renderSection(
            renderEmbellishments(fabric.embellishments),
            'EMBELLISHMENT TYPES'
        );

        html += `
            <div class="col-lg-3 col-md-4 col-sm-6 mb-3 fabric-card">
                <div class="card" style="padding:10px; height:100%;">
                    <div class="fabric_image"
                        style="
                            background-image:url('${fabric.image_1}');
                            height:220px;
                            background-size:cover;
                            background-position:center;
                            border-radius:8px;
                            display:flex;
                            justify-content:center;
                        ">
                        <span class="fabric_name" style="color:#fff;font-weight:600;">
                            ${fabric.fabric_name}
                        </span>
                    </div>

                    <div class="fabric_details mt-3">
                        ${listSection}
                        ${colorsSection}
                        ${opacitySection}
                        ${weightSection}
                        ${embellishmentSection}
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
renderFabrics(fabricsWithImage);

/* ===============================
   LIVE SEARCH
=============================== */
const searchWrapper = document.querySelector('.search-wrapper');
const searchInput = document.querySelector('.search-input');
let isTyping = false;

searchWrapper.addEventListener('mouseenter', () => {
    searchWrapper.classList.add('active');
    searchInput.focus();
});

searchInput.addEventListener('input', () => {
    const value = searchInput.value.trim().toLowerCase();
    isTyping = value.length > 0;

    const filtered = fabricsWithImage.filter(fabric =>
        fabric.fabric_name.toLowerCase().includes(value)
    );

    renderFabrics(filtered);
});

searchWrapper.addEventListener('mouseleave', () => {
    if (!isTyping) {
        searchWrapper.classList.remove('active');
        searchInput.value = '';
        renderFabrics(fabricsWithImage);
    }
});

searchInput.addEventListener('focus', () =>
    searchWrapper.classList.add('active')
);

searchInput.addEventListener('blur', () => {
    if (!isTyping) {
        searchWrapper.classList.remove('active');
        searchInput.value = '';
        renderFabrics(fabricsWithImage);
    }
});
</script>



<div class="" style=" z-index:99; padding: unset;">

    @include('pages.customer_product_catlog.layout.footer')

</div>


@endsection
