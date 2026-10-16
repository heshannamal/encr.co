<style>
    .ncm-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1050;
        align-items: center;
        justify-content: center;
    }

    .ncm-backdrop.show {
        display: flex;
    }

    .ncm-modal {
        background: #fff;
        border-radius: 12px;
        width: 100%;
        max-width: 760px;
        max-height: 88vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, .18), 0 4px 16px rgba(0, 0, 0, .10);
        font-family: 'Inter', 'Segoe UI', sans-serif;
        font-size: 13.5px;
        color: #1a1a2e;
        margin: 16px;
    }

    /* ── Header ── */
    .ncm-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        padding: 22px 28px 18px;
        border-bottom: 1px solid #f0f0f0;
        flex: 0 0 auto;
    }

    .ncm-title {
        font-size: 17px;
        font-weight: 700;
        color: #111827;
        line-height: 1.4;
        margin: 0;
        padding-right: 20px;
    }

    .ncm-close {
        background: none;
        border: none;
        color: #9ca3af;
        font-size: 18px;
        cursor: pointer;
        padding: 2px 4px;
        border-radius: 4px;
        flex-shrink: 0;
        line-height: 1;
        transition: color .12s;
    }

    .ncm-close:hover {
        color: #374151;
    }

    /* ── Body — empty on purpose ── */
    .ncm-body {
        padding: 20px 28px;
        flex: 1 1 auto;
        overflow-y: auto;
        min-height: 0;
    }

    /* ── Footer ── */
    .ncm-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 28px 22px;
        border-top: 1px solid #f0f0f0;
        flex-wrap: wrap;
        flex: 0 0 auto;
    }

    .ncm-footer-left {
        margin-right: auto;
        display: flex;
        gap: 10px;
    }

    .ncm-btn-cancel {
        background: #e5e7eb;
        border: none;
        border-radius: 7px;
        color: #374151;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .5px;
        padding: 10px 24px;
        cursor: pointer;
        transition: background .12s;
    }

    .ncm-btn-cancel:hover {
        background: #d1d5db;
    }

    .ncm-btn-unread {
        background: none;
        border: 1.5px solid #d1d5db;
        border-radius: 7px;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .5px;
        padding: 9px 18px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background .12s, color .12s;
    }

    .ncm-btn-unread:hover {
        background: #f3f4f6;
        color: #374151;
    }

    .ncm-btn-reject {
        background: #dc2626;
        border: none;
        border-radius: 7px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .5px;
        padding: 10px 22px;
        cursor: pointer;
        transition: background .12s;
    }

    .ncm-btn-reject:hover {
        background: #b91c1c;
    }

    .ncm-btn-confirm {
        background: #0d9488;
        border: none;
        border-radius: 7px;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .5px;
        padding: 10px 22px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background .12s;
    }

    .ncm-btn-confirm:hover {
        background: #0f766e;
    }

    .omm-backdrop.omm-sub {
        z-index: 1060;
        background: rgba(0, 0, 0, 0.35);
    }

    .omm-backdrop.show {
        display: flex !important;
    }

    /* ── Items list scroll region (the actual fix) ── */
    .ncm-items-scroll {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        overflow-y: auto;
        flex: 1 1 auto;
        min-height: 80px;
        max-height: 220px;
        /* hard cap: guarantees independent scroll */
        box-sizing: border-box;
    }
</style>

{{-- ══════════ COMMON MODAL SHELL ══════════ --}}


{{-- ══ MAIN MODAL ══ --}}
<div id="ncmBackdrop"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:1050; align-items:center; justify-content:center;">
    <div
        style="background:#fff; border-radius:12px; width:100%; max-width:760px; max-height:88vh; display:flex; flex-direction:column; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,.18),0 4px 16px rgba(0,0,0,.10); font-family:'Inter','Segoe UI',sans-serif; font-size:13.5px; color:#1a1a2e; margin:16px;">

        {{-- Header --}}
        <div
            style="display:flex; align-items:flex-start; justify-content:space-between; padding:22px 28px 18px; border-bottom:1px solid #f0f0f0; flex:0 0 auto;">
            <h2 id="title"
                style="font-size:17px; font-weight:700; color:#111827; line-height:1.4; margin:0; padding-right:20px;">
            </h2>
            <button id="ncmClose" onclick="closeNcm()"
                style="background:none; border:none; color:#9ca3af; font-size:18px; cursor:pointer; padding:2px 4px; border-radius:4px; flex-shrink:0; line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Body --}}
        <div id="body" style="padding:0px 28px; flex:1 1 auto; overflow-y:auto; min-height:0;">

        </div>


        {{-- /body --}}


        {{-- Footer --}}
        <div id="modal-footer">

        </div>
        {{-- <div id="footer-order"
            style="display:flex; align-items:center; padding:16px 28px 22px; border-top:1px solid #f0f0f0; flex:0 0 auto; gap:10px; flex-wrap:wrap;">
            <div style="display:flex; gap:10px; margin-right:auto;">
                <button onclick="closeNcm()"
                    style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer;">CANCEL</button>
                <button id="unread-btn-order" onclick="markAsUnread()"
                    style="background:none; border:1.5px solid #d1d5db; border-radius:7px; color:#6b7280; font-size:12px; font-weight:700; letter-spacing:.5px; padding:9px 18px; cursor:pointer; display:flex; align-items:center; gap:8px;">
                    <i class="far fa-bell"></i> MARK AS UNREAD
                </button>
            </div>
            <button id="reject-btn" onclick="openNcmRejectDialog()"
                style="background:#dc2626; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 22px; cursor:pointer;">REJECT</button>
            <button id="conform-btn" onclick="openNcmConfirmDialog()"
                style="background:#0d9488; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 22px; cursor:pointer; display:flex; align-items:center; gap:8px;">
                <i class="far fa-check-square"></i> CONFIRM
            </button>
        </div>

        <div id="footer-task"
            style="display:none; align-items:center; justify-content:flex-end; gap:10px; padding:16px 28px 22px; border-top:1px solid #f0f0f0; flex:0 0 auto;">
            <button onclick="closeNcm()"
                style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer;">
                CANCEL
            </button>
            <button id="unread-btn-task" onclick="markAsUnread()"
                style="background:#0d9488; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 20px; cursor:pointer; display:flex; align-items:center; gap:8px;">
                <i class="far fa-bell"></i> MARK AS UNREAD
            </button>
        </div>

        <div id="footer-template"
            style="display:none; align-items:center; padding:16px 28px 22px; border-top:1px solid #f0f0f0; flex:0 0 auto; gap:10px; flex-wrap:wrap;">
            <div style="display:flex; gap:10px; margin-right:auto;">
                <button onclick="closeNcm()"
                    style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer;">
                    CANCEL
                </button>
                <button id="unread-btn-template" onclick="markAsUnread()"
                    style="background:none; border:1.5px solid #d1d5db; border-radius:7px; color:#6b7280; font-size:12px; font-weight:700; letter-spacing:.5px; padding:9px 18px; cursor:pointer; display:flex; align-items:center; gap:8px;">
                    <i class="far fa-bell"></i> MARK AS UNREAD
                </button>
            </div>
            <button id="add-to-list-btn" onclick="submitNcmAddToList()"
                style="background:#0d9488; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 22px; cursor:pointer; display:flex; align-items:center; gap:8px;">
                <i class="far fa-check-circle"></i> ADD TO MY LIST
            </button>
        </div> --}}

    </div>
</div>


{{-- ══ CONFIRM DIALOG ══ --}}
<div id="ncmConfirmDialog"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:1060; align-items:center; justify-content:center;">
    <div
        style="background:#fff; border-radius:12px; width:100%; max-width:560px; box-shadow:0 16px 48px rgba(0,0,0,.18); font-family:'Inter','Segoe UI',sans-serif; margin:16px; overflow:hidden;">

        {{-- Header --}}
        <div
            style="display:flex; align-items:flex-start; justify-content:space-between; padding:22px 28px 18px; border-bottom:1px solid #f0f0f0;">
            <h3 style="font-size:16px; font-weight:700; color:#111827; margin:0;">Ex-Factory Date Confirmation</h3>
            <button onclick="closeNcmConfirmDialog()"
                style="background:none; border:none; color:#9ca3af; font-size:17px; cursor:pointer; padding:2px 4px; border-radius:4px; line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Body --}}
        <div style="padding:22px 28px 18px;">
            <label style="display:block; font-size:13px; color:#374151; margin-bottom:10px;">
                Please type "CONFIRM" for confirm this order.
            </label>
            <input type="text" id="ncmConfirmInput" autocomplete="off"
                style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:10px 14px; font-family:'Inter',sans-serif; font-size:13px; color:#1a1a2e; box-sizing:border-box; outline:none;"
                oninput="document.getElementById('ncmConfirmSubmit').disabled = this.value.trim().toUpperCase() !== 'CONFIRM';"
                placeholder='Type "CONFIRM" here'>
        </div>

        {{-- Footer --}}
        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:12px 28px 22px;">
            <button onclick="closeNcmConfirmDialog()"
                style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">CANCEL</button>
            <button id="ncmConfirmSubmit" disabled onclick="submitNcmConfirm()"
                style="background:#0d9488; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 20px; cursor:pointer; display:flex; align-items:center; gap:8px; text-transform:uppercase; opacity:0.5;">
                <i class="far fa-check-square"></i> CONFIRM
            </button>
        </div>

    </div>
</div>


{{-- ══ REJECT DIALOG ══ --}}
<div id="ncmRejectDialog"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:1060; align-items:center; justify-content:center;">
    <div
        style="background:#fff; border-radius:12px; width:100%; max-width:580px; box-shadow:0 16px 48px rgba(0,0,0,.18); font-family:'Inter','Segoe UI',sans-serif; margin:16px; overflow:hidden;">

        {{-- Header --}}
        <div
            style="display:flex; align-items:flex-start; justify-content:space-between; padding:22px 28px 18px; border-bottom:1px solid #f0f0f0;">
            <h3 style="font-size:16px; font-weight:700; color:#111827; margin:0;">Ex-Factory Date Rejection</h3>
            <button onclick="closeNcmRejectDialog()"
                style="background:none; border:none; color:#9ca3af; font-size:17px; cursor:pointer; padding:2px 4px; border-radius:4px; line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        {{-- Body --}}
        <div style="padding:22px 28px 10px;">
            <label style="display:block; font-size:13px; color:#374151; margin-bottom:8px;">
                Please enter the reason for order rejection
            </label>
            <textarea id="ncmRejectReason" placeholder="Type the rejection reason here..."
                style="width:100%; min-height:160px; border:1px solid #d1d5db; border-radius:8px; padding:12px 14px; font-family:'Inter',sans-serif; font-size:13px; color:#1a1a2e; resize:vertical; margin-bottom:18px; box-sizing:border-box; outline:none;"></textarea>

            <label style="display:block; font-size:13px; color:#374151; margin-bottom:8px;">
                Suggested Ex-Factory Date
            </label>
            <div style="position:relative; margin-bottom:8px;">
                <i class="far fa-calendar-alt"
                    style="position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:13px; pointer-events:none;"></i>
                <input type="date" id="ncmRejectDate"
                    style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:10px 14px 10px 38px; font-family:'Inter',sans-serif; font-size:13px; color:#1a1a2e; box-sizing:border-box; outline:none;">
            </div>
        </div>

        {{-- Footer --}}
        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 28px 22px;">
            <button onclick="closeNcmRejectDialog()"
                style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">CANCEL</button>
            <button onclick="submitNcmReject()"
                style="background:#dc2626; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">REJECT</button>
        </div>

    </div>
</div>


{{-- ══ PAYMENT APPROVE DIALOG ══ --}}
<div id="ncmPaymentApproveDialog"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:1060; align-items:center; justify-content:center;">
    <div
        style="background:#fff; border-radius:12px; width:100%; max-width:480px; box-shadow:0 16px 48px rgba(0,0,0,.18); font-family:'Inter','Segoe UI',sans-serif; margin:16px; overflow:hidden;">

        <div
            style="display:flex; align-items:flex-start; justify-content:space-between; padding:22px 28px 18px; border-bottom:1px solid #f0f0f0;">
            <h3 style="font-size:16px; font-weight:700; color:#111827; margin:0;">Approve Payment</h3>
            <button onclick="closeNcmPaymentApproveDialog()"
                style="background:none; border:none; color:#9ca3af; font-size:17px; cursor:pointer; padding:2px 4px; border-radius:4px; line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="padding:22px 28px 18px;">
            <label style="display:block; font-size:13px; color:#374151; margin-bottom:10px;">
                Confirm the verified payment amount
            </label>
            <div style="position:relative;">
                <span style="position:absolute; left:14px; top:48%; transform:translateY(-50%); color:#6b7280; font-size:13px;">$</span>
                <input type="number" step="0.01" min="0" id="ncmPaymentApproveAmount" autocomplete="off"
                    style="width:100%; border:1px solid #d1d5db; border-radius:8px; padding:10px 14px 10px 26px; font-family:'Inter',sans-serif; font-size:13px; color:#1a1a2e; box-sizing:border-box; outline:none;"
                    placeholder="0.00">
            </div>
        </div>

        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:12px 28px 22px;">
            <button onclick="closeNcmPaymentApproveDialog()"
                style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">CANCEL</button>
            <button id="ncmPaymentApproveSubmit" onclick="submitNcmPaymentApprove()"
                style="background:#0d9488; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 22px; cursor:pointer; display:flex; align-items:center; gap:8px; text-transform:uppercase;">
                <i class="far fa-check-square"></i> APPROVE
            </button>
        </div>
    </div>
</div>

{{-- ══ PAYMENT REJECT DIALOG ══ --}}
<div id="ncmPaymentRejectDialog"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:1060; align-items:center; justify-content:center;">
    <div
        style="background:#fff; border-radius:12px; width:100%; max-width:560px; box-shadow:0 16px 48px rgba(0,0,0,.18); font-family:'Inter','Segoe UI',sans-serif; margin:16px; overflow:hidden;">

        <div
            style="display:flex; align-items:flex-start; justify-content:space-between; padding:22px 28px 18px; border-bottom:1px solid #f0f0f0;">
            <h3 style="font-size:16px; font-weight:700; color:#111827; margin:0;">Reject Payment</h3>
            <button onclick="closeNcmPaymentRejectDialog()"
                style="background:none; border:none; color:#9ca3af; font-size:17px; cursor:pointer; padding:2px 4px; border-radius:4px; line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="padding:22px 28px 10px;">
            <label style="display:block; font-size:13px; color:#374151; margin-bottom:8px;">
                Please enter the reason for rejecting this payment
            </label>
            <textarea id="ncmPaymentRejectReason" placeholder="Type the rejection reason here..."
                style="width:100%; min-height:140px; border:1px solid #d1d5db; border-radius:8px; padding:12px 14px; font-family:'Inter',sans-serif; font-size:13px; color:#1a1a2e; resize:vertical; margin-bottom:8px; box-sizing:border-box; outline:none;"></textarea>
        </div>

        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 28px 22px;">
            <button onclick="closeNcmPaymentRejectDialog()"
                style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">CANCEL</button>
            <button id="ncmPaymentRejectSubmit" onclick="submitNcmPaymentReject()"
                style="background:#dc2626; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">REJECT</button>
        </div>
    </div>
</div>

{{-- ══ PO REJECT DIALOG ══ --}}
<div id="ncmPoRejectDialog"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:1060; align-items:center; justify-content:center;">
    <div
        style="background:#fff; border-radius:12px; width:100%; max-width:560px; box-shadow:0 16px 48px rgba(0,0,0,.18); font-family:'Inter','Segoe UI',sans-serif; margin:16px; overflow:hidden;">

        <div style="display:flex; align-items:flex-start; justify-content:space-between; padding:22px 28px 18px; border-bottom:1px solid #f0f0f0;">
            <h3 style="font-size:16px; font-weight:700; color:#111827; margin:0;">Reject Purchase Order</h3>
            <button onclick="closeNcmPoRejectDialog()"
                style="background:none; border:none; color:#9ca3af; font-size:17px; cursor:pointer; padding:2px 4px; border-radius:4px; line-height:1;">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div style="padding:22px 28px 10px;">
            <label style="display:block; font-size:13px; color:#374151; margin-bottom:8px;">
                Please enter the reason for rejecting this purchase order
            </label>
            <textarea id="ncmPoRejectReason" placeholder="Type the rejection reason here..."
                style="width:100%; min-height:140px; border:1px solid #d1d5db; border-radius:8px; padding:12px 14px; font-family:'Inter',sans-serif; font-size:13px; color:#1a1a2e; resize:vertical; margin-bottom:8px; box-sizing:border-box; outline:none;"></textarea>
        </div>

        <div style="display:flex; align-items:center; justify-content:flex-end; gap:10px; padding:16px 28px 22px;">
            <button onclick="closeNcmPoRejectDialog()"
                style="background:#e5e7eb; border:none; border-radius:7px; color:#374151; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">CANCEL</button>
            <button id="ncmPoRejectSubmit" onclick="submitNcmPoReject()"
                style="background:#dc2626; border:none; border-radius:7px; color:#fff; font-size:12px; font-weight:700; letter-spacing:.5px; padding:10px 24px; cursor:pointer; text-transform:uppercase;">REJECT</button>
        </div>
    </div>
</div>


<script>
    /* ── Main modal ─────────────────────────────────────────── */
    window.openNotificationModal = function() {
        var el = document.getElementById('ncmBackdrop');
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    };

    window.closeNcm = function() {
        document.getElementById('ncmBackdrop').style.display = 'none';
        document.body.style.overflow = '';
        isBulkPaymentMode = false;
    };

    /* Click outside main modal */
    document.getElementById('ncmBackdrop').addEventListener('click', function(e) {
        if (e.target === this) closeNcm();
    });

    /* ── Confirm dialog ─────────────────────────────────────── */
    window.openNcmConfirmDialog = function() {
        document.getElementById('ncmConfirmInput').value = '';
        document.getElementById('ncmConfirmSubmit').disabled = true;
        document.getElementById('ncmConfirmSubmit').style.opacity = '0.5';
        document.getElementById('ncmConfirmDialog').style.display = 'flex';
    };

    window.closeNcmConfirmDialog = function() {
        document.getElementById('ncmConfirmDialog').style.display = 'none';
    };

    /* Enable confirm button only when "CONFIRM" is typed */
    document.getElementById('ncmConfirmInput').addEventListener('input', function() {
        var btn = document.getElementById('ncmConfirmSubmit');
        var isMatch = this.value.trim().toUpperCase() === 'CONFIRM';
        btn.disabled = !isMatch;
        btn.style.opacity = isMatch ? '1' : '0.5';
        btn.style.cursor = isMatch ? 'pointer' : 'not-allowed';
    });

    window.submitNcmConfirm = function() {
        /* Add your AJAX confirm call here */
        closeNcmConfirmDialog();
        closeNcm();
    };

    document.getElementById('ncmConfirmDialog').addEventListener('click', function(e) {
        if (e.target === this) closeNcmConfirmDialog();
    });

    /* ── Reject dialog ──────────────────────────────────────── */
    window.openNcmRejectDialog = function() {
        document.getElementById('ncmRejectReason').value = '';
        document.getElementById('ncmRejectDate').value = '';
        document.getElementById('ncmRejectDialog').style.display = 'flex';
    };

    window.closeNcmRejectDialog = function() {
        document.getElementById('ncmRejectDialog').style.display = 'none';
    };

    window.submitNcmReject = function() {
        var reason = document.getElementById('ncmRejectReason').value.trim();
        if (!reason) {
            document.getElementById('ncmRejectReason').focus();
            return;
        }
        /* Add your AJAX reject call here */
        closeNcmRejectDialog();
        closeNcm();
    };

    document.getElementById('ncmRejectDialog').addEventListener('click', function(e) {
        if (e.target === this) closeNcmRejectDialog();
    });

    /* ── ESC key ────────────────────────────────────────────── */
    document.addEventListener('keydown', function(e) {
        if (e.key !== 'Escape') return;
        if (document.getElementById('ncmConfirmDialog').style.display === 'flex') {
            closeNcmConfirmDialog();
            return;
        }
        if (document.getElementById('ncmRejectDialog').style.display === 'flex') {
            closeNcmRejectDialog();
            return;
        }
        if (document.getElementById('ncmPaymentApproveDialog').style.display === 'flex') {
            closeNcmPaymentApproveDialog();
            return;
        }
        if (document.getElementById('ncmPaymentRejectDialog').style.display === 'flex') {
            closeNcmPaymentRejectDialog();
            return;
        }
        if (document.getElementById('ncmBackdrop').style.display === 'flex') {
            closeNcm();
        }
    });
</script>

<script>
    let currentNotifId = null;
    let currentOrderId = null;
    let currentOrderItemId = null;
    let currentTargetField = null;
    let currentIsUrgent = null;
    let isSubmittingAction = false;
    let currentPaymentId = null;
    let currentActionId = null;
    let confirmRoute = null;
    let rejectRoute = null;
    let isBulkPaymentMode = false;


    window.openNewNotificationModal = function(id) {
        currentNotifId = id;

        const el = document.getElementById('ncmBackdrop');
        el.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        document.getElementById('title').textContent = 'Loading...';
        document.getElementById('body').innerHTML = '';
        document.getElementById('modal-footer').innerHTML = '';

        $.ajax({
            url: "{{ url('get-notification-data') }}/" + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (!response.status) return;
                const data = response.data;
                isBulkPaymentMode = false;

                document.getElementById('title').innerHTML = data.notification.modal_title ?? data.notification.notification_title;
                document.getElementById('body').innerHTML = data.notification.notification_message;

                const footerContainer = document.getElementById('modal-footer');
                const footerData = data.notification_footer || {};
                footerContainer.innerHTML = footerData.modal_footer || '';

                const footerEl = footerContainer.firstElementChild;
                if (footerEl) {
                    footerEl.style.display = 'flex';
                }

                // ── Restore the state the submit functions depend on ──
                currentTargetField = data.notification.target_notification_field;
                currentOrderId = data.notification.order_id;
                currentOrderItemId = data.notification.order_item_id;
                currentIsUrgent = data.notification.is_urgent;
                confirmRoute = footerData.confirm_route || '';
                rejectRoute = footerData.reject_route || '';
                currentPaymentId = data.notification.check_payment_id
                    || data.notification.venmo_payment_id
                    || data.notification.paypal_payment_id
                    || data.notification.purchase_order_id
                    || null;
                currentActionId = data.notification.email_template_id || null;

                if (data.notification.is_read == 0) {
                    markNotificationRead(id);
                }

                if (data.notification.order_reject_or_confirm !== null && data.notification.order_reject_or_confirm !== undefined && data.notification.order_reject_or_confirm !== '') {
                    if (document.getElementById('reject-btn')) {
                        document.getElementById('reject-btn').style.display =  'none';
                    }
                    if (document.getElementById('conform-btn')) {
                        document.getElementById('conform-btn').style.display = 'none';
                    }
                    if (document.getElementById('add-to-list-btn')) {
                        document.getElementById('add-to-list-btn').style.display = 'none';
                    }
                }

  
                const paymentRecord = data.check_payment || data.venmo_payment || data.paypal_payment || data.purchase_order;
                if (paymentRecord && paymentRecord.is_approved !== 0) {
                    document.getElementById('reject-btn').style.display = 'none';
                    document.getElementById('conform-btn').style.display = 'none';
                }

               

                
            },
            error: function() {
                document.getElementById('title').textContent = 'Failed to load notification';
            }
        });
    };

    

  

    window.markAsUnread = function() {
        if (!currentNotifId) return;

        $.ajax({
            url: "{{ route('notifications.mark.unread') }}",
            type: 'POST',
            data: {
                ids: [currentNotifId],
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                closeNcm();
                refreshNotificationTables();
            },
            error: function() {
                alert('Failed to mark as unread. Please try again.');
            }
        });
    };

    window.markNotificationRead = function(id) {
        $.ajax({
            url: "{{ route('notifications.mark.read') }}",
            type: 'POST',
            data: {
                ids: [id],
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                refreshNotificationTables();
            }
        });
    };

    // Reuses your existing loadTab()/tabLoaded from the notifications page
    function refreshNotificationTables() {
        if (typeof tabLoaded === 'undefined' || typeof loadTab !== 'function') {
            // Fallback: this modal isn't on the notifications page, or those aren't defined yet
            return;
        }
        Object.keys(tabLoaded).forEach(function(tab) {
            if (tabLoaded[tab]) {
                loadTab(tab);
            }
        });
    }


    window.submitNcmConfirm = function() {
        if (isSubmittingAction) return;
        isSubmittingAction = true;

        const btn = document.getElementById('ncmConfirmSubmit');
        btn.disabled = true;

        showNcmLoadingOverlay('Confirming order...', '#ncmConfirmDialog > div');

        if (!confirmRoute) {
            isSubmittingAction = false;
            hideNcmLoadingOverlay();
            btn.disabled = false;
            alert('Unable to process this notification. Please contact support.');
            return;
        }

        $.ajax({
            url: confirmRoute,
            type: 'POST',
            data: {
                order_id: currentOrderId,
                notificationId: currentNotifId,
                notification_id: currentNotifId,  
                order_item_id: currentOrderItemId,
                confirm_text: 'CONFIRM',
                target_field: currentTargetField,          
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                closeNcmConfirmDialog();
                closeNcm();
                refreshNotificationTables();
            },
            error: function(xhr) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                btn.disabled = false;
                alert(xhr.responseJSON?.message || 'Failed to confirm. Please try again.');
            }
        });
    };

    window.submitNcmReject = function() {
        if (isSubmittingAction) return;

        const reason = document.getElementById('ncmRejectReason').value.trim();
        const suggestedDate = document.getElementById('ncmRejectDate').value;

        if (!reason) {
            document.getElementById('ncmRejectReason').focus();
            return;
        }
        if (!suggestedDate) {
            document.getElementById('ncmRejectDate').focus();
            return;
        }

        isSubmittingAction = true;

        const rejectSubmitBtn = document.querySelector('#ncmRejectDialog button[onclick="submitNcmReject()"]');
        if (rejectSubmitBtn) rejectSubmitBtn.disabled = true;

        showNcmLoadingOverlay('Submitting rejection...', '#ncmRejectDialog > div');

        if (!rejectRoute) {
            isSubmittingAction = false;
            hideNcmLoadingOverlay();
            if (rejectSubmitBtn) rejectSubmitBtn.disabled = false;
            alert('Unable to process this notification. Please contact support.');
            return;
        }

        $.ajax({
            url: rejectRoute,
            type: 'POST',
            data: {
                order_id: currentOrderId,
                notificationId: currentNotifId,
                notification_id: currentNotifId, 
                order_item_id: currentOrderItemId,
                reject_reason: reason,
                suggested_date: suggestedDate,
                ex_fac_date: suggestedDate,
                target_field: currentTargetField,      
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(response) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                closeNcmRejectDialog();
                closeNcm();
                refreshNotificationTables();
            },
            error: function(xhr) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                if (rejectSubmitBtn) rejectSubmitBtn.disabled = false;
                alert(xhr.responseJSON?.message || 'Failed to reject. Please try again.');
            }
        });
    };

   

    function showNcmLoadingOverlay(message, targetDialogSelector) {
        // Remove any existing overlay first
        hideNcmLoadingOverlay();

        const targetBox = document.querySelector(targetDialogSelector);
        if (!targetBox) return;

        targetBox.style.position = 'relative';

        const overlay = document.createElement('div');
        overlay.id = 'ncmLoadingOverlay';
        overlay.style.cssText = `
            position:absolute; inset:0; z-index:2000;
            background:rgba(255,255,255,0.7);
            backdrop-filter:blur(3px); -webkit-backdrop-filter:blur(3px);
            display:flex; align-items:center; justify-content:center;
            flex-direction:column; gap:12px;
            border-radius:12px;
        `;
        overlay.innerHTML = `
            <div style="width:34px; height:34px; border:3px solid #e5e7eb; border-top-color:#0d9488; border-radius:50%; animation:ncmSpin 0.7s linear infinite;"></div>
            <div style="font-size:12.5px; font-weight:600; color:#374151;">${message || 'Please wait...'}</div>
        `;
        targetBox.appendChild(overlay);

        if (!document.getElementById('ncmSpinKeyframes')) {
            const style = document.createElement('style');
            style.id = 'ncmSpinKeyframes';
            style.textContent = `@keyframes ncmSpin { to { transform: rotate(360deg); } }`;
            document.head.appendChild(style);
        }
    }

    function hideNcmLoadingOverlay() {
        const overlay = document.getElementById('ncmLoadingOverlay');
        if (overlay) overlay.remove();
    }


    /* ── Payment approve dialog ─────────────────────────────── */
    window.openNcmPaymentApproveDialog = function() {
        document.getElementById('ncmPaymentApproveAmount').value = '';
        document.getElementById('ncmPaymentApproveDialog').style.display = 'flex';
    };

    window.closeNcmPaymentApproveDialog = function() {
        document.getElementById('ncmPaymentApproveDialog').style.display = 'none';
    };

    window.submitNcmPaymentApprove = function() {
        if (isSubmittingAction) return;

        const amountInput = document.getElementById('ncmPaymentApproveAmount');
        const amount = amountInput.value.trim();
        if (!amount) {
            amountInput.focus();
            return;
        }

        if (!confirmRoute) {
            alert('Unable to process this notification. Please contact support.');
            return;
        }

        isSubmittingAction = true;
        const submitBtn = document.getElementById('ncmPaymentApproveSubmit');
        submitBtn.disabled = true;
        showNcmLoadingOverlay('Approving payment...', '#ncmPaymentApproveDialog > div');

        $.ajax({
            url: confirmRoute,
            type: 'POST',
            dataType: 'json',
            data: {
                check_payment_id: currentPaymentId,
                venmo_payment_id: currentPaymentId,
                paypal_payment_id: currentPaymentId,
                approve_amount: amount,
                is_approved: 1,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                submitBtn.disabled = false;
                closeNcmPaymentApproveDialog();

                // // ← hide both action buttons now that this payment is resolved
                // const rejectBtn = document.getElementById('reject-btn');
                // const confirmBtn = document.getElementById('conform-btn');
                // if (rejectBtn) rejectBtn.style.display = 'none';
                // if (confirmBtn) confirmBtn.style.display = 'none';

                const rejectBtn = document.querySelector('.reject-btn[data-payment-id="' + currentPaymentId + '"]');
                const confirmBtn = document.querySelector('.conform-btn[data-payment-id="' + currentPaymentId + '"]');
                if (rejectBtn) rejectBtn.style.display = 'none';
                if (confirmBtn) confirmBtn.style.display = 'none';

                if (isBulkPaymentMode) {
                    refreshNotificationTables();
                } else {
                    closeNcm();
                    refreshNotificationTables();
                }
            },
            error: function(xhr) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                submitBtn.disabled = false;
                alert(xhr.responseJSON?.message || 'Failed to approve. Please try again.');
            }
        });
    };

    const _ncmPayApproveEl = document.getElementById('ncmPaymentApproveDialog');
    if (_ncmPayApproveEl) {
        _ncmPayApproveEl.addEventListener('click', function(e) {
            if (e.target === this) closeNcmPaymentApproveDialog();
        });
    }

    /* ── Payment reject dialog ──────────────────────────────── */
    window.openNcmPaymentRejectDialog = function() {
        document.getElementById('ncmPaymentRejectReason').value = '';
        document.getElementById('ncmPaymentRejectDialog').style.display = 'flex';
    };

    window.closeNcmPaymentRejectDialog = function() {
        document.getElementById('ncmPaymentRejectDialog').style.display = 'none';
    };

    

    const _ncmPayRejectEl = document.getElementById('ncmPaymentRejectDialog');
    if (_ncmPayRejectEl) {
        _ncmPayRejectEl.addEventListener('click', function(e) {
            if (e.target === this) closeNcmPaymentRejectDialog();
        });
    }

    window.submitNcmPaymentReject = function() {
        if (isSubmittingAction) return;

        const reason = document.getElementById('ncmPaymentRejectReason').value.trim();
        if (!reason) {
            document.getElementById('ncmPaymentRejectReason').focus();
            return;
        }

        if (!rejectRoute) {
            alert('Unable to process this notification. Please contact support.');
            return;
        }

        isSubmittingAction = true;
        const submitBtn = document.getElementById('ncmPaymentRejectSubmit');
        submitBtn.disabled = true;
        showNcmLoadingOverlay('Submitting rejection...', '#ncmPaymentRejectDialog > div');

        $.ajax({
            url: rejectRoute,
            type: 'POST',
            dataType: 'json',
            data: {
                check_payment_id: currentPaymentId,
                venmo_payment_id: currentPaymentId,
                paypal_payment_id: currentPaymentId,
                is_approved: 3,
                reject_reason: reason,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                submitBtn.disabled = false;
                closeNcmPaymentRejectDialog();

                // const rejectBtn = document.getElementById('reject-btn');
                // const confirmBtn = document.getElementById('conform-btn');
                // if (rejectBtn) rejectBtn.style.display = 'none';
                // if (confirmBtn) confirmBtn.style.display = 'none';

                const rejectBtn = document.querySelector('.reject-btn[data-payment-id="' + currentPaymentId + '"]');
                const confirmBtn = document.querySelector('.conform-btn[data-payment-id="' + currentPaymentId + '"]');
                if (rejectBtn) rejectBtn.style.display = 'none';
                if (confirmBtn) confirmBtn.style.display = 'none';

                if (isBulkPaymentMode) {
                    refreshNotificationTables();
                } else {
                    closeNcm();
                    refreshNotificationTables();
                }
            },
            error: function(xhr) {
                isSubmittingAction = false;
                hideNcmLoadingOverlay();
                submitBtn.disabled = false;
                alert(xhr.responseJSON?.message || 'Failed to reject. Please try again.');
            }
        });
    };


    window.openNcmPoRejectDialog = function() {
        document.getElementById('ncmPoRejectReason').value = '';
        document.getElementById('ncmPoRejectDialog').style.display = 'flex';
    };

    window.closeNcmPoRejectDialog = function() {
        document.getElementById('ncmPoRejectDialog').style.display = 'none';
    };

    document.getElementById('ncmPoRejectDialog').addEventListener('click', function(e) {
        if (e.target === this) closeNcmPoRejectDialog();
    });

    window.submitNcmPoApprove = function() {
        if (isSubmittingAction) return;

        if (!confirmRoute) {
            alert('Unable to process this notification. Please contact support.');
            return;
        }

        isSubmittingAction = true;
        const btn = document.getElementById('conform-btn');
        if (btn) btn.disabled = true;

        $.ajax({
            url: confirmRoute,
            type: 'POST',
            dataType: 'json',
            data: {
                purchase_order_id: currentPaymentId,
                is_approved: 1,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                isSubmittingAction = false;
                if (btn) btn.disabled = false;

                const rejectBtn = document.getElementById('reject-btn');
                const confirmBtn = document.getElementById('conform-btn');
                if (rejectBtn) rejectBtn.style.display = 'none';
                if (confirmBtn) confirmBtn.style.display = 'none';

                closeNcm();
                refreshNotificationTables();
            },
            error: function(xhr) {
                isSubmittingAction = false;
                if (btn) btn.disabled = false;
                alert('Failed to approve. Please try again.');
            }
        });
    };

    window.submitNcmPoReject = function() {
        if (isSubmittingAction) return;

        const reason = document.getElementById('ncmPoRejectReason').value.trim();
        if (!reason) {
            document.getElementById('ncmPoRejectReason').focus();
            return;
        }

        if (!rejectRoute) {
            alert('Unable to process this notification. Please contact support.');
            return;
        }

        isSubmittingAction = true;
        const submitBtn = document.getElementById('ncmPoRejectSubmit');
        submitBtn.disabled = true;

        $.ajax({
            url: rejectRoute,
            type: 'POST',
            dataType: 'json',
            data: {
                purchase_order_id: currentPaymentId,
                is_approved: 3,
                reject_reason: reason,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                isSubmittingAction = false;
                submitBtn.disabled = false;
                closeNcmPoRejectDialog();

                const rejectBtn = document.getElementById('reject-btn');
                const confirmBtn = document.getElementById('conform-btn');
                if (rejectBtn) rejectBtn.style.display = 'none';
                if (confirmBtn) confirmBtn.style.display = 'none';

                closeNcm();
                refreshNotificationTables();
            },
            error: function(xhr) {
                isSubmittingAction = false;
                submitBtn.disabled = false;
                alert('Failed to reject. Please try again.');
            }
        });
    };

    

    window.submitNcmAddToList = function() {
        if (isSubmittingAction) return;

        if (!confirmRoute) {
            alert('Unable to process this notification. Please contact support.');
            return;
        }

        isSubmittingAction = true;
        const btn = document.getElementById('add-to-list-btn');
        if (btn) btn.disabled = true;

        $.ajax({
            url: confirmRoute,
            type: 'POST',
            dataType: 'json',
            data: {
                template_id: currentActionId,
                notification_id: currentNotifId,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                isSubmittingAction = false;
                if (btn) {
                    btn.style.display = 'none';
                }
                closeNcm();
                refreshNotificationTables();
            },
            error: function() {
                isSubmittingAction = false;
                if (btn) btn.disabled = false;
                alert('Failed to add. Please try again.');
            }
        });
    };
</script>
