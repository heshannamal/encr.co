@extends('layouts.app', ['activePage' => 'pdt_tool', 'titlePage' => __('PDT')])

@section('content')

<style>
    .pdt-table-wrap {
        width: 100%;
    }

    .se-pre-con {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        background: url("{{ asset('argon') }}/img/loader/Spinner-1s-200px.gif") center no-repeat #ffffff99;
    }

    #pdtTable {
        width: 100% !important;
    }

    #pdtTable th,
    #pdtTable td {
        white-space: nowrap;
        vertical-align: middle;
    }

    .pdt-path {
        max-width: 160px;
        display: inline-block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: middle;
    }

    .dataTables_wrapper {
        width: 100%;
    }

    .select2-container {
        width: 100% !important;
    }

    .parts-table th,
    .parts-table td {
        vertical-align: middle;
        white-space: nowrap;
    }

    .parts-table .form-control {
        min-width: 130px;
    }

    .parts-table .mesh-input {
        min-width: 260px;
    }


    .case-sensitive-option {
        font-family: Consolas, Monaco, monospace;
        font-size: 12px;
        white-space: pre;
    }

    .parts-case-note {
        color: #b45309;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 10px;
        }

        .pdt-add-btn {
            width: 100%;
        }
    }

    .product-used-option {
        color: #28a745 !important;
        font-weight: 700;
    }

    .product-used-option::after {
        content: "  ✓ Already added";
        font-size: 11px;
    }

    .file-scan-status {
        border-radius: 8px;
        font-size: 13px;
    }

    .parts-select {
        min-width: 180px;
    }

    .mesh-select {
        min-width: 280px;
    }

    .parts-table .select2-container {
        min-width: 180px;
    }

    .parts-table .mesh-select + .select2-container {
        min-width: 280px;
    }

    #addRelevantPartsSection {
        display: none;
    }

    #addRelevantPartsSection.is-ready {
        display: block;
    }

    /* Keep the header/footer fixed and scroll only the modal body. */
    #addPdtModal .modal-dialog,
    #editPdtModal .modal-dialog {
        height: calc(100vh - 30px);
        margin: 15px auto;
    }

    #addPdtModal .modal-content,
    #editPdtModal .modal-content {
        max-height: 100%;
        overflow: hidden;
    }

    #addPdtModal .modal-body,
    #editPdtModal .modal-body {
        min-height: 0;
        overflow-y: auto !important;
        overflow-x: hidden;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
    }
     .pdt-action-btn {
        background: #ffffff;
        border: 1px solid #cfd6df;
        border-radius: 5px;
        color: #5f6975;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.4px;
        padding: 9px 14px;
        text-transform: uppercase;
        line-height: 1.2;
        box-shadow: none;
        transition: all 0.2s ease;
    }

    .pdt-action-btn i {
        margin-right: 6px;
        font-size: 12px;
        color: #68727d;
    }

    .pdt-action-btn:hover,
    .pdt-action-btn:focus {
        background: #f7f8fa;
        border-color: #aeb7c2;
        color: #3f4852;
        text-decoration: none;
        box-shadow: none;
    }

</style>

@if ($errors->any())
    <div class="alert alert-danger">{{ $errors->first() }}</div>
@endif

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="mb-5 content-position">

    <div class="se-pre-con"></div>

    @section('order-header')
        <span>PDT Dashboard</span>
    @endsection

    @section('back-btn')
        <a href="{{ route('home') }}" class="home-btn-color" title="Back to home">BACK TO HOME</a>
    @endsection

    <div class="card" style="border: unset;">
        <div class="card-body">

            <div class="d-flex justify-content-end mb-3" style="gap: 10px;">

                <a href="https://dev.encr.co/admin/login"
                target="_blank"
                class="btn pdt-action-btn">
                    <i class="fa fa-sign-in"></i>
                    LOGIN TO PDT
                </a>

                <button type="button"
                        class="btn pdt-action-btn"
                        data-toggle="modal"
                        data-target="#addPdtModal">
                    <i class="fa fa-plus"></i>
                    ADD PRODUCT
                </button>

            </div>

            <div class="pdt-table-wrap">
                <table id="pdtTable" class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>DXF Path</th>
                            <th>Model Path</th>
                            <th>Parts</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pdtProducts as $item)
                            @php
                                $layoutParts = is_array($item->layout_parts)
                                    ? $item->layout_parts
                                    : (json_decode($item->layout_parts ?? '[]', true) ?: []);

                                $partLabels = collect($layoutParts)
                                    ->sortBy(function ($part) {
                                        return $part['order'] ?? 999;
                                    })
                                    ->map(function ($part) {
                                        return $part['label'] ?? $part['key'] ?? '';
                                    })
                                    ->filter()
                                    ->values();
                            @endphp

                            <tr>
                                <td>
                                    @if($item->active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>{{ $item->product_id }}</td>

                                <td>{{ $item->product->product_name ?? '-' }}</td>

                                <td>
                                    <span class="pdt-path" title="{{ $item->dxf_path }}">
                                        {{ $item->dxf_path ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="pdt-path" title="{{ $item->modal_path }}">
                                        {{ $item->modal_path ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <span class="pdt-path" title="{{ $partLabels->implode(', ') }}">
                                        {{ $partLabels->count() ? $partLabels->implode(', ') : '-' }}
                                    </span>
                                </td>

                                <td>{{ $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-' }}</td>

                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-primary editBtn"
                                        data-toggle="modal"
                                        data-target="#editPdtModal"
                                        data-id="{{ $item->id }}"
                                        data-product="{{ $item->product_id }}"
                                        data-model="{{ $item->modal_path }}"
                                        data-dxf="{{ $item->dxf_path }}"
                                        data-active="{{ $item->active }}"
                                        data-layout-parts='@json($layoutParts)'
                                    >
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- Edit PDT Modal --}}
<div class="modal fade" id="editPdtModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <form action="{{ route('pdt.update') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="editproductForm">
            @csrf

            <input type="hidden" name="id" id="edit_id">

            <div class="modal-header">
                <h5 class="modal-title">Edit PDT Product</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Product</label>
                    <select name="product_id" id="edit_product_id" class="form-control select2-edit" required>
                        @foreach($products as $product)
                            @php
                                $isUsed = in_array((int) $product->id, $usedProductIds ?? [], true);
                                $productName = $product->product_name ?: $product->show_in_catalog_name;
                            @endphp
                            <option
                                value="{{ $product->id }}"
                                data-used="{{ $isUsed ? 1 : 0 }}"
                            >
                                {{ $productName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Replace 3D Model (Optional)</label>
                    <input type="file" name="modal_path" id="edit_modal_path" class="form-control" accept=".glb,.gltf">
                </div>

                <div class="form-group">
                    <label>Replace DXF (Optional)</label>
                    <input type="file" name="dxf_path" id="edit_dxf_path" class="form-control" accept=".dxf">
                </div>
                <div id="editFileScanStatus" class="alert alert-info file-scan-status d-none"></div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="active" id="edit_active" class="form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

                <div class="form-group mt-4">
                    <label class="form-control-label">Product Relevant Parts</label>

                    <input type="hidden" name="layout_parts" id="editLayoutPartsInput">

                    <div class="table-responsive">
                        <table class="table table-bordered parts-table" id="editLayoutPartsTable">
                            <thead>
                                <tr>
                                    <th style="width:80px;">Order</th>
                                    <th>Part Key</th>
                                    <th>Part Label</th>
                                    <th>3D Mesh Names</th>
                                    <th>Flip To</th>
                                    <th style="width:90px;">Mirror</th>
                                    <th style="width:70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-primary" id="editAddLayoutPartBtn">
                        <i class="fas fa-plus"></i> Add Part
                    </button>

                    <small class="text-muted d-block mt-2">
                        Choose one DXF Part Key, one GLB Mesh Name, and an optional DXF Flip To target for each row.
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Update
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

        </form>
    </div>
</div>

{{-- Add PDT Modal --}}
<div class="modal fade" id="addPdtModal" tabindex="-1" role="dialog" aria-labelledby="addPdtModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <form action="{{ route('pdt.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" id="addproductForm">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title" id="addPdtModalLabel">Add PDT Product</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label>Select Product</label>
                    <select name="product_id" id="product_id" class="form-control select2" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            @php
                                $isUsed = in_array((int) $product->id, $usedProductIds ?? [], true);
                                $productName = $product->product_name ?: $product->show_in_catalog_name;
                            @endphp
                            <option
                                value="{{ $product->id }}"
                                data-used="{{ $isUsed ? 1 : 0 }}"
                                {{ $isUsed ? 'disabled' : '' }}
                            >
                                {{ $productName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>3D Model File</label>
                    <input type="file" name="modal_path" id="add_modal_path" class="form-control" accept=".glb,.gltf" required>
                </div>

                <div class="form-group">
                    <label>DXF File</label>
                    <input type="file" name="dxf_path" id="add_dxf_path" class="form-control" accept=".dxf" required>
                </div>
                <div id="addFileScanStatus" class="alert alert-info file-scan-status d-none">
                    Select the GLB and DXF files. Exact case-sensitive keys and mesh names will be loaded as Select2 options; no mapping is selected automatically.
                </div>

                <div class="form-group mt-4" id="addRelevantPartsSection">
                    <label class="form-control-label">Product Relevant Parts</label>

                    <input type="hidden" name="layout_parts" id="layoutPartsInput">

                    <div class="table-responsive">
                        <table class="table table-bordered parts-table" id="layoutPartsTable">
                            <thead>
                                <tr>
                                    <th style="width:80px;">Order</th>
                                    <th>Part Key</th>
                                    <th>Part Label</th>
                                    <th>3D Mesh Names</th>
                                    <th>Flip To</th>
                                    <th style="width:90px;">Mirror</th>
                                    <th style="width:70px;">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-sm btn-primary" id="addLayoutPartBtn">
                        <i class="fas fa-plus"></i> Add Part
                    </button>

                    <small class="text-muted d-block mt-2">
                        Click Add Part, then manually select one DXF Part Key and one GLB Mesh Name for each row.
                    </small>
                </div>

            </div>

            <div class="modal-footer">
                <button id="addproductbtn" type="submit" class="btn btn-success">
                    <i class="fa fa-save"></i> Add
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>

        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/dxf-parser@1.1.2/dist/dxf-parser.js"></script>

<script type="importmap">
{
    "imports": {
        "three": "https://cdn.jsdelivr.net/npm/three@0.165.0/build/three.module.js",
        "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.165.0/examples/jsm/"
    }
}
</script>

<script type="module">
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

const $ = window.jQuery;
const gltfLoader = new GLTFLoader();
const DxfParserClass = window.DxfParser?.default || window.DxfParser;

$(function () {
    const inspectorState = {
        add: {
            dxfParts: [],
            meshNames: [],
        },
        edit: {
            dxfParts: [],
            meshNames: [],
        },
    };

    const modalFor = (prefix) => prefix === 'add' ? $('#addPdtModal') : $('#editPdtModal');
    const bodyFor = (prefix) => prefix === 'add' ? $('#layoutPartsTable tbody') : $('#editLayoutPartsTable tbody');
    const hiddenFor = (prefix) => prefix === 'add' ? $('#layoutPartsInput') : $('#editLayoutPartsInput');

    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    function unique(values) {
        return [...new Set(
            (values || [])
                .map(value => String(value || '').trim())
                .filter(Boolean)
        )];
    }

    function humanize(value) {
        return String(value || '')
            .replace(/[_-]+/g, ' ')
            .replace(/\s+/g, ' ')
            .trim()
            .replace(/\b\w/g, letter => letter.toUpperCase());
    }


    function assetUrl(path) {
        if (!path) {
            return '';
        }

        if (/^https?:\/\//i.test(path)) {
            return path;
        }

        return `${window.location.origin}/${String(path).replace(/^\/+/, '')}`;
    }

    function showScanStatus(prefix, message, type = 'info') {
        const $status = prefix === 'add'
            ? $('#addFileScanStatus')
            : $('#editFileScanStatus');

        $status
            .removeClass('d-none alert-info alert-success alert-warning alert-danger')
            .addClass(`alert-${type}`)
            .html(message);
    }

    function formatProductOption(option) {
        if (!option.id) {
            return option.text;
        }

        const isUsed = Number($(option.element).data('used')) === 1;

        return $('<span>')
            .toggleClass('product-used-option', isUsed)
            .text(option.text);
    }

    function initProductSelects() {
        $('.select2').select2({
            dropdownParent: $('#addPdtModal'),
            width: '100%',
            placeholder: 'Select Product',
            allowClear: true,
            templateResult: formatProductOption,
        });

        $('.select2-edit').select2({
            dropdownParent: $('#editPdtModal'),
            width: '100%',
            placeholder: 'Select Product',
            templateResult: formatProductOption,
        });
    }

    function collectDxfParts(dxf) {
        const parts = new Set();

        const addEntityLayers = (entities) => {
            (entities || []).forEach(entity => {
                const layer = String(entity?.layer || '').trim();

                if (
                    layer &&
                    layer !== '0' &&
                    layer.toLowerCase() !== 'defpoints'
                ) {
                    parts.add(layer);
                }
            });
        };

        addEntityLayers(dxf?.entities);

        Object.values(dxf?.blocks || {}).forEach(block => {
            addEntityLayers(block?.entities);
        });

        Object.keys(dxf?.tables?.layer?.layers || {}).forEach(layer => {
            const cleanLayer = String(layer || '').trim();

            if (
                cleanLayer &&
                cleanLayer !== '0' &&
                cleanLayer.toLowerCase() !== 'defpoints'
            ) {
                parts.add(cleanLayer);
            }
        });

        return [...parts].sort((a, b) => a.localeCompare(b, undefined, {
            numeric: true,
            sensitivity: 'base',
        }));
    }

    async function inspectDxf(source) {
        if (!DxfParserClass) {
            throw new Error('DXF parser did not load.');
        }

        let text;

        if (source instanceof File) {
            text = await source.text();
        } else {
            const response = await fetch(assetUrl(source));

            if (!response.ok) {
                throw new Error(`DXF request failed (${response.status}).`);
            }

            text = await response.text();
        }

        const parser = new DxfParserClass();
        const dxf = parser.parseSync(text);
        const parts = collectDxfParts(dxf);

        if (!parts.length) {
            throw new Error('No usable DXF layer names were found.');
        }

        return parts;
    }

    async function inspectGlb(source) {
        let payload;
        let basePath = '';
        let sourceName = '';

        if (source instanceof File) {
            sourceName = source.name;
            payload = source.name.toLowerCase().endsWith('.gltf')
                ? await source.text()
                : await source.arrayBuffer();
        } else {
            const url = assetUrl(source);
            sourceName = url;
            basePath = url.substring(0, url.lastIndexOf('/') + 1);

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error(`GLB request failed (${response.status}).`);
            }

            payload = url.toLowerCase().endsWith('.gltf')
                ? await response.text()
                : await response.arrayBuffer();
        }

        return await new Promise((resolve, reject) => {
            gltfLoader.parse(
                payload,
                basePath,
                gltf => {
                    const meshNames = new Set();
                    let unnamedIndex = 1;

                    gltf.scene.traverse(object => {
                        if (!object?.isMesh) {
                            return;
                        }

                        const meshName = String(object.name || '').trim()
                            || `Part_${unnamedIndex++}`;

                        meshNames.add(meshName);
                    });

                    if (!meshNames.size) {
                        reject(new Error(`No mesh names were found in ${sourceName || 'the model'}.`));
                        return;
                    }

                    resolve([...meshNames].sort((a, b) => a.localeCompare(b, undefined, {
                        numeric: true,
                        sensitivity: 'base',
                    })));
                },
                reject
            );
        });
    }


    function optionHtml(values, selectedValues = [], includeBlank = false) {
        const selected = new Set(
            (Array.isArray(selectedValues) ? selectedValues : [selectedValues])
                .map(value => String(value || ''))
        );

        let html = includeBlank ? '<option value=""></option>' : '';

        unique(values).forEach(value => {
            html += `<option value="${escapeHtml(value)}" ${selected.has(value) ? 'selected' : ''}>${escapeHtml(value)}</option>`;
        });

        return html;
    }

    function formatExactOption(option) {
        if (!option.id) {
            return option.text;
        }

        return $('<span>')
            .addClass('case-sensitive-option')
            .attr('title', 'Exact case-sensitive value')
            .text(option.id);
    }

    function initRowSelect2($row, prefix) {
        const $modal = modalFor(prefix);
        const exactSelect2 = {
            dropdownParent: $modal,
            width: '100%',
            allowClear: true,
            tags: false,
            templateResult: formatExactOption,
            templateSelection: formatExactOption,
        };

        $row.find(`.${prefix}-part-key`).select2({
            ...exactSelect2,
            placeholder: 'Select exact DXF key',
        });

        $row.find(`.${prefix}-part-meshes`).select2({
            ...exactSelect2,
            placeholder: 'Select exact GLB mesh name',
        });

        $row.find(`.${prefix}-part-flip-to`).select2({
            ...exactSelect2,
            placeholder: 'No flip target',
        });
    }

    function addPartRow(prefix, data = {}) {
        const state = inspectorState[prefix];
        const $tableBody = bodyFor(prefix);
        const rowCount = $tableBody.find('tr').length + 1;

        const order = Number(data.order || rowCount);
        const key = String(data.key || '');
        const label = String(data.label || '');
        const mesh = Array.isArray(data.meshes)
            ? String(data.meshes[0] || '')
            : String(data.meshes || '');
        const flipTo = String(data.flip_to || data.flipTo || '');
        const flipMirror = [true, 1, '1', 'true'].includes(data.flip_mirror);

        const dxfOptions = unique([
            ...state.dxfParts,
            key,
            flipTo,
        ]);

        const meshOptions = unique([
            ...state.meshNames,
            mesh,
        ]);

        const row = `
            <tr>
                <td>
                    <input
                        type="number"
                        class="form-control ${prefix}-part-order"
                        value="${escapeHtml(order)}"
                        min="1"
                    >
                </td>

                <td>
                    <select class="form-control parts-select ${prefix}-part-key">
                        ${optionHtml(dxfOptions, key, true)}
                    </select>
                </td>

                <td>
                    <input
                        type="text"
                        class="form-control ${prefix}-part-label"
                        placeholder="Part Label"
                        value="${escapeHtml(label || key)}"
                        data-auto-label="${label && label !== key ? '0' : '1'}"
                    >
                </td>

                <td>
                    <select class="form-control mesh-select ${prefix}-part-meshes">
                        ${optionHtml(meshOptions, mesh, true)}
                    </select>
                </td>

                <td>
                    <select class="form-control parts-select ${prefix}-part-flip-to">
                        ${optionHtml(dxfOptions.filter(item => item !== key), flipTo, true)}
                    </select>
                </td>

                <td class="text-center">
                    <label class="mb-0">
                        <input
                            type="checkbox"
                            class="${prefix}-part-flip-mirror"
                            ${flipMirror ? 'checked' : ''}
                        >
                        Mirror
                    </label>
                </td>

                <td>
                    <button
                        type="button"
                        class="btn btn-sm btn-danger remove-${prefix}-layout-part"
                    >
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        `;

        $tableBody.append(row);

        const $row = $tableBody.find('tr').last();
        initRowSelect2($row, prefix);

        $row.find(`.${prefix}-part-key`).on('change', function () {
            const selectedKey = String($(this).val() || '');
            const $label = $row.find(`.${prefix}-part-label`);

            if (!$label.val() || Number($label.data('auto-label')) === 1) {
                $label
                    .val(selectedKey)
                    .data('auto-label', 1);
            }

            // Do not auto-select a GLB mesh. The user must choose it manually.
            refreshFlipOptions(prefix);
        });

        $row.find(`.${prefix}-part-label`).on('input', function () {
            $(this).data('auto-label', 0);
        });
    }

    function destroySelect2($select) {
        if ($select.hasClass('select2-hidden-accessible')) {
            $select.select2('destroy');
        }
    }

    function refreshFlipOptions(prefix) {
        const state = inspectorState[prefix];
        const selectedKeys = unique(
            bodyFor(prefix)
                .find(`.${prefix}-part-key`)
                .map(function () {
                    return $(this).val();
                })
                .get()
        );

        const options = unique([...state.dxfParts, ...selectedKeys]);

        bodyFor(prefix).find('tr').each(function () {
            const $row = $(this);
            const key = String($row.find(`.${prefix}-part-key`).val() || '');
            const $flip = $row.find(`.${prefix}-part-flip-to`);
            const current = String($flip.val() || '');

            destroySelect2($flip);

            $flip.html(optionHtml(
                options.filter(option => option !== key),
                current,
                true
            ));

            $flip.select2({
                dropdownParent: modalFor(prefix),
                width: '100%',
                placeholder: 'No flip target',
                allowClear: true,
                tags: false,
                templateResult: formatExactOption,
                templateSelection: formatExactOption,
            });
        });
    }

    function reOrderRows(prefix) {
        bodyFor(prefix).find('tr').each(function (index) {
            $(this).find(`.${prefix}-part-order`).val(index + 1);
        });
    }

    function readRows(prefix) {
        const parts = [];

        bodyFor(prefix).find('tr').each(function (index) {
            const $row = $(this);

            const selectedMesh = String(
                $row.find(`.${prefix}-part-meshes`).val() || ''
            );

            parts.push({
                key: String($row.find(`.${prefix}-part-key`).val() || ''),
                label: String($row.find(`.${prefix}-part-label`).val() || ''),
                order: Number($row.find(`.${prefix}-part-order`).val() || index + 1),
                // Keep the database format compatible, but allow only one selected mesh.
                meshes: selectedMesh ? [selectedMesh] : [],
                flip_to: String($row.find(`.${prefix}-part-flip-to`).val() || ''),
                flip_mirror: $row.find(`.${prefix}-part-flip-mirror`).is(':checked'),
            });
        });

        return parts;
    }

    function renderRows(prefix, parts) {
        const $body = bodyFor(prefix);

        $body.find('select.select2-hidden-accessible').each(function () {
            destroySelect2($(this));
        });

        $body.empty();

        (parts || []).forEach(part => addPartRow(prefix, part));

        refreshFlipOptions(prefix);
    }


    function buildLayoutPartsJson(prefix) {
        const parts = readRows(prefix);
        const keys = new Set();
        const exactDxfKeys = new Set(inspectorState[prefix].dxfParts);
        const exactMeshNames = new Set(inspectorState[prefix].meshNames);

        if (!parts.length) {
            alert('Add at least one product part.');
            return false;
        }

        for (const part of parts) {
            if (!part.key) {
                alert('Select an exact DXF Part Key for every row.');
                return false;
            }

            if (!exactDxfKeys.has(part.key)) {
                alert(
                    `Part Key "${part.key}" does not exactly match a DXF key. ` +
                    'Part Keys are case-sensitive. Select the value from the DXF list.'
                );
                return false;
            }

            if (keys.has(part.key)) {
                alert(`Part Key "${part.key}" is selected more than once.`);
                return false;
            }

            const meshName = part.meshes[0] || '';

            if (!meshName) {
                alert(`Select one exact GLB mesh name for "${part.key}".`);
                return false;
            }

            if (!exactMeshNames.has(meshName)) {
                alert(
                    `Mesh Name "${meshName}" does not exactly match a GLB mesh. ` +
                    'Mesh Names are case-sensitive. Select the value from the GLB list.'
                );
                return false;
            }

            if (part.flip_to) {
                if (part.flip_to === part.key) {
                    alert(`"${part.key}" cannot flip to itself.`);
                    return false;
                }

                if (!exactDxfKeys.has(part.flip_to)) {
                    alert(
                        `Flip To "${part.flip_to}" does not exactly match a DXF key. ` +
                        'Flip targets are case-sensitive.'
                    );
                    return false;
                }
            }

            keys.add(part.key);
        }

        hiddenFor(prefix).val(JSON.stringify(parts));

        return true;
    }

    function updateAddReadyState() {
        const ready = (
            inspectorState.add.dxfParts.length > 0 &&
            inspectorState.add.meshNames.length > 0
        );

        $('#addproductbtn').prop('disabled', !ready);

        if (!ready) {
            return;
        }


        $('#addRelevantPartsSection')
            .addClass('is-ready');

        showScanStatus(
            'add',
            `<strong>Files detected successfully.</strong>
             ${inspectorState.add.dxfParts.length} DXF parts and
             ${inspectorState.add.meshNames.length} GLB meshes are ready.
             Click Add Part and choose the exact case-sensitive DXF key and GLB mesh name manually.`,
            'success'
        );

        window.setTimeout(() => {
            document.getElementById('addRelevantPartsSection')
                ?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 180);
    }

    $('#add_dxf_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            inspectorState.add.dxfParts = [];
            return;
        }

        showScanStatus('add', 'Reading DXF part layers…', 'info');

        try {
            inspectorState.add.dxfParts = await inspectDxf(file);
            updateAddReadyState();
        } catch (error) {
            inspectorState.add.dxfParts = [];
            $('#addproductbtn').prop('disabled', true);
            showScanStatus('add', escapeHtml(error.message), 'danger');
        }
    });

    $('#add_modal_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            inspectorState.add.meshNames = [];
            return;
        }

        showScanStatus('add', 'Reading GLB mesh names…', 'info');

        try {
            inspectorState.add.meshNames = await inspectGlb(file);
            updateAddReadyState();
        } catch (error) {
            inspectorState.add.meshNames = [];
            $('#addproductbtn').prop('disabled', true);
            showScanStatus('add', escapeHtml(error.message), 'danger');
        }
    });

    $('#edit_dxf_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            return;
        }

        const existingParts = readRows('edit');
        showScanStatus('edit', 'Reading replacement DXF…', 'info');

        try {
            inspectorState.edit.dxfParts = await inspectDxf(file);
            renderRows('edit', existingParts);
            showScanStatus(
                'edit',
                `${inspectorState.edit.dxfParts.length} DXF parts detected.`,
                'success'
            );
        } catch (error) {
            showScanStatus('edit', escapeHtml(error.message), 'danger');
        }
    });

    $('#edit_modal_path').on('change', async function () {
        const file = this.files?.[0];

        if (!file) {
            return;
        }

        const existingParts = readRows('edit');
        showScanStatus('edit', 'Reading replacement GLB…', 'info');

        try {
            inspectorState.edit.meshNames = await inspectGlb(file);
            renderRows('edit', existingParts);
            showScanStatus(
                'edit',
                `${inspectorState.edit.meshNames.length} GLB meshes detected.`,
                'success'
            );
        } catch (error) {
            showScanStatus('edit', escapeHtml(error.message), 'danger');
        }
    });

    $('#addLayoutPartBtn').on('click', function () {
        addPartRow('add');
        refreshFlipOptions('add');
    });

    $('#editAddLayoutPartBtn').on('click', function () {
        addPartRow('edit');
        refreshFlipOptions('edit');
    });

    $(document).on('click', '.remove-add-layout-part', function () {
        const $row = $(this).closest('tr');

        $row.find('select.select2-hidden-accessible').each(function () {
            destroySelect2($(this));
        });

        $row.remove();
        reOrderRows('add');
        refreshFlipOptions('add');
    });

    $(document).on('click', '.remove-edit-layout-part', function () {
        const $row = $(this).closest('tr');

        $row.find('select.select2-hidden-accessible').each(function () {
            destroySelect2($(this));
        });

        $row.remove();
        reOrderRows('edit');
        refreshFlipOptions('edit');
    });

    $('#addPdtModal').on('shown.bs.modal', function () {
        $('#addproductbtn').prop('disabled', true);
        showScanStatus(
            'add',
            'Select the GLB and DXF files. Exact case-sensitive keys and mesh names will be loaded as Select2 options; no mapping is selected automatically.',
            'info'
        );
    });

    $('#addPdtModal').on('hidden.bs.modal', function () {
        $('#addproductForm')[0].reset();
        $('#product_id').val('').trigger('change');
        $('#addRelevantPartsSection').removeClass('is-ready');
        bodyFor('add').empty();
        hiddenFor('add').val('');
        inspectorState.add.dxfParts = [];
        inspectorState.add.meshNames = [];
        $('#addproductbtn').prop('disabled', true);
    });

    $('#addproductForm').on('submit', function (event) {
        if (!buildLayoutPartsJson('add')) {
            event.preventDefault();
            return;
        }

        $('.se-pre-con').fadeIn('slow');
    });

    $('#editproductForm').on('submit', function (event) {
        if (!buildLayoutPartsJson('edit')) {
            event.preventDefault();
            return;
        }

        $('.se-pre-con').fadeIn('slow');
    });

    $(document).on('click', '.editBtn', async function () {
        const $button = $(this);
        const currentProductId = String($button.data('product'));
        let layoutParts = $button.attr('data-layout-parts') || '[]';

        $('#edit_id').val($button.data('id'));
        $('#edit_active').val($button.data('active'));

        $('#edit_product_id option').each(function () {
            const isUsed = Number($(this).data('used')) === 1;
            const isCurrent = String(this.value) === currentProductId;

            $(this).prop('disabled', isUsed && !isCurrent);
        });

        $('#edit_product_id')
            .val(currentProductId)
            .trigger('change.select2');

        try {
            layoutParts = JSON.parse(layoutParts);
        } catch (error) {
            console.error('Invalid layout parts JSON:', error);
            layoutParts = [];
        }

        if (!Array.isArray(layoutParts)) {
            layoutParts = [];
        }

        inspectorState.edit.dxfParts = unique([
            ...layoutParts.map(part => part.key),
            ...layoutParts.map(part => part.flip_to),
        ]);

        inspectorState.edit.meshNames = unique(
            layoutParts.flatMap(part => Array.isArray(part.meshes) ? part.meshes : [])
        );

        renderRows(
            'edit',
            layoutParts.sort((a, b) => Number(a.order || 0) - Number(b.order || 0))
        );

        showScanStatus('edit', 'Reading current DXF and GLB files…', 'info');

        const dxfPath = $button.data('dxf');
        const modelPath = $button.data('model');

        const results = await Promise.allSettled([
            dxfPath ? inspectDxf(dxfPath) : Promise.resolve([]),
            modelPath ? inspectGlb(modelPath) : Promise.resolve([]),
        ]);

        const currentParts = readRows('edit');

        if (results[0].status === 'fulfilled') {
            inspectorState.edit.dxfParts = unique([
                ...results[0].value,
                ...inspectorState.edit.dxfParts,
            ]);
        }

        if (results[1].status === 'fulfilled') {
            inspectorState.edit.meshNames = unique([
                ...results[1].value,
                ...inspectorState.edit.meshNames,
            ]);
        }

        renderRows('edit', currentParts);

        const dxfCount = inspectorState.edit.dxfParts.length;
        const meshCount = inspectorState.edit.meshNames.length;

        showScanStatus(
            'edit',
            `${dxfCount} exact DXF keys and ${meshCount} exact GLB mesh names are available.`,
            dxfCount && meshCount ? 'success' : 'warning'
        );
    });

    $('#pdtTable').DataTable({
        pageLength: 25,
        responsive: false,
        scrollX: true,
        autoWidth: false,
        order: [[6, 'desc']],
        columnDefs: [
            {
                targets: [7],
                orderable: false,
            },
        ],
    });

    initProductSelects();
});
</script>

@endsection
