<div class="modal fade" id="userrole_detail_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;" role="document">
        <div class="modal-content rounded-0" style="border-radius: 8px; border: none;">

            <div class="modal-header" style="padding: 1.25rem 1.5rem 0.5rem; border-bottom: none; flex-direction: column; align-items: stretch;">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="modal-title font-weight-bold" id="detail_user_role_name" style="font-size: 1.1rem;"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 1rem;">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <hr style="width: 100%; margin: 0.75rem 0 0; border-top: 1px solid #dee2e6;">
            </div>

            <div class="modal-body" style="padding: 0.5rem 1.5rem 1.5rem;">

                <!-- Narration -->
                <div class="mb-3 p-2">
                    <p class="font-weight-bold mb-0" style="font-size: 0.85rem;">Narration</p>
                    <p class="mb-0" id="detail_narration" style="font-size: 0.82rem; color: #6b7280;"></p>
                </div>

                <!-- Users in Group -->
                <div class="p-2">
                    <p class="font-weight-bold mb-0" style="font-size: 0.85rem;">Users in this Group</p>
                    <p class="mb-2" id="detail_user_count" style="font-size: 0.78rem; color: #6b7280;"></p>

                    <div class="table-responsive">
                        <table class="table mb-0" style="border: 1px solid #dee2e6; border-radius: 4px; overflow: hidden;">
                            <thead>
                                <tr>
                                    <th style="background-color: #707070; color: white; font-size: 0.72rem; text-transform: uppercase; padding: 0.6rem 1rem; font-weight: 600; border: none;">USER</th>
                                    <th style="background-color: #707070; color: white; font-size: 0.72rem; text-transform: uppercase; padding: 0.6rem 1rem; font-weight: 600; border: none;">EMAIL</th>
                                </tr>
                            </thead>
                            <tbody id="detail_users_tbody" style="font-size: 0.82rem;">
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    #userrole_detail_modal .table tbody tr td {
        padding: 0.55rem 1rem;
        vertical-align: middle;
        border-top: 1px solid #f0f0f0;
        color: #374151;
    }

    #userrole_detail_modal .table tbody tr:hover {
        background-color: #f9fafb;
    }
</style>