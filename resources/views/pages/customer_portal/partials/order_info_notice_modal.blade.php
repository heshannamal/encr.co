@if (!empty($showPortalNotice))
<style>
    .ec-notice-modal {
        z-index: 10050;
    }

    .ec-notice-modal .modal-dialog {
        max-width: 700px;
    }

    .ec-notice-modal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.14);
    }

    .ec-notice-modal .modal-header {
        background: #39AB92;
        border: none;
        padding: 16px 20px;
        position: relative;
    }

    .ec-notice-modal .ec-notice-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .ec-notice-modal .ec-notice-icon .material-icons-outlined {
        font-size: 18px;
        color: #fff;
    }

    .ec-notice-modal .modal-title {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
    }

    .ec-notice-modal .modal-subtitle {
        color: rgba(255, 255, 255, 0.82);
        font-size: 1rem;
        margin: 2px 0 0;
    }

    .ec-notice-modal .btn-close-notice {
        position: absolute;
        top: 12px;
        right: 14px;
        background: rgba(255, 255, 255, 0.18);
        border: none;
        border-radius: 7px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.15s ease;
        padding: 0;
        line-height: 1;
    }

    .ec-notice-modal .btn-close-notice:hover {
        background: rgba(255, 255, 255, 0.32);
    }

    .ec-notice-modal .btn-close-notice .material-icons-outlined {
        font-size: 16px;
        color: #fff;
    }

    .ec-notice-modal .modal-body {
        padding: 12px 14px;
        background: #f4f6f8;
        display: flex;
        flex-direction: column;
        gap: 8px;
        max-height: 55vh;
        overflow-y: auto;
    }

    .ec-notice-item {
        display: flex;
        gap: 10px;
        padding: 11px 13px;
        background: #fff;
        border-radius: 11px;
        border: 1px solid #eef1f4;
        transition: border-color 0.2s ease;
    }

    .ec-notice-item:hover {
        border-color: #c8e8e0;
    }

    .ec-notice-item-icon {
        width: 30px;
        height: 30px;
        border-radius: 7px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .ec-notice-item-icon .material-icons-outlined {
        font-size: 15px;
    }

    .ec-notice-item-icon--changes {
        background: #E9F7F4;
        color: #39AB92;
    }

    .ec-notice-item-icon--production {
        background: #FFF6CC;
        color: #c99200;
    }

    .ec-notice-item-icon--custom {
        background: #FFEDEE;
        color: #BB0000;
    }

    .ec-notice-item-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 2px;
    }

    .ec-notice-item-text {
        font-size: 1rem;
        color: #5a6270;
        line-height: 1.5;
        margin: 0;
    }

    .ec-notice-item-text strong {
        color: #1a1a2e;
        font-weight: 600;
    }
</style>

<div class="modal fade ec-notice-modal" id="orderInfoNoticeModal" tabindex="-1"
     aria-labelledby="orderInfoNoticeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <div class="d-flex align-items-center gap-2">
                    <div class="ec-notice-icon">
                        <span class="material-icons-outlined">info</span>
                    </div>
                    <div>
                        <h5 class="modal-title" id="orderInfoNoticeModalLabel">Important Order Information</h5>
                        <p class="modal-subtitle">Please review before continuing to your portal</p>
                    </div>
                </div>
                <button type="button" class="btn-close-notice" data-bs-dismiss="modal" aria-label="Close">
                    <span class="material-icons-outlined">close</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="ec-notice-item">
                    <div class="ec-notice-item-icon ec-notice-item-icon--changes">
                        <span class="material-icons-outlined">edit_note</span>
                    </div>
                    <div>
                        <div class="ec-notice-item-title">Order Changes</div>
                        <p class="ec-notice-item-text">
                            Once payment is submitted, your order is considered final and is released to production. No changes or additions can be made after this point. If you have any questions or need additional items, please contact your sales representative.
                        </p>
                    </div>
                </div>

                {{-- <div class="ec-notice-item">
                    <div class="ec-notice-item-icon ec-notice-item-icon--production">
                        <span class="material-icons-outlined">schedule</span>
                    </div>
                    <div>
                        <div class="ec-notice-item-title">Production Changes</div>
                        <p class="ec-notice-item-text">
                            Changes must be requested within <strong>48 hours</strong> of entering production. After that, changes may not be possible.
                        </p>
                    </div>
                </div> --}}

                <div class="ec-notice-item">
                    <div class="ec-notice-item-icon ec-notice-item-icon--custom">
                        <span class="material-icons-outlined">verified_user</span>
                    </div>
                    <div>
                        <div class="ec-notice-item-title">Custom-Made Items</div>
                        <p class="ec-notice-item-text">
                            
                            All products are custom made to order. Once an order enters production, <strong>All sales are final</strong> No refunds, cancellations, or changes are permitted.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var noticeModalEl = document.getElementById('orderInfoNoticeModal');
    if (!noticeModalEl) return;

    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    csrfToken = csrfToken ? csrfToken.getAttribute('content') : '{{ csrf_token() }}';
    var noticeModal = null;

    function showNoticeModal() {
        // No static backdrop — backdrop click will dismiss naturally
        noticeModal = new bootstrap.Modal(noticeModalEl, {
            backdrop: true,
            keyboard: true
        });
        noticeModal.show();
    }

    function waitForLoaderThenShow() {
        if (document.body.classList.contains('pace-running')) {
            setTimeout(waitForLoaderThenShow, 150);
            return;
        }
        showNoticeModal();
    }

    if (document.readyState === 'complete') {
        waitForLoaderThenShow();
    } else {
        window.addEventListener('load', waitForLoaderThenShow);
    }

    noticeModalEl.addEventListener('hidden.bs.modal', function () {
        fetch('{{ route("customer_portal.acknowledge_order_notice") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({})
        }).catch(error => console.error('Error acknowledging notice:', error));
    });
});
</script>
@endif
