<!-- LEAVE BALANCE MODAL — include once via include layout -->
<div class="modal fade" id="leaveBalanceModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header" style="background-color:#f8f8f8;">
                <div>
                    <h5 class="modal-title" style="margin-bottom:2px;">
                        <i class="fa fa-calendar-check-o mr-2" style="color:#2dce89;"></i>
                        Leave Balance
                    </h5>
                    <small class="text-muted">
                        <span id="lbm_userName" style="font-weight:600;"></span>
                        &nbsp;—&nbsp;
                        <span id="lbm_groupName" style="color:#47D6B6;"></span>
                    </small>
                </div>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body p-0">

                {{-- Loading state --}}
                <div id="lbm_loading" class="text-center py-4">
                    <i class="fa fa-spinner fa-spin fa-2x" style="color:#2dce89;"></i>
                    <p class="mt-2 text-muted" style="font-size:12px;">Loading leave balance...</p>
                </div>

                {{-- Error state --}}
                <div id="lbm_error" class="alert alert-warning m-3" style="display:none;font-size:13px;">
                    <i class="fa fa-exclamation-triangle mr-1"></i>
                    <span id="lbm_errorText"></span>
                </div>

                {{-- Content --}}
                <div id="lbm_content" style="display:none;">
                    <table class="table table-sm mb-0" style="font-size:13px;">
                        <thead style="background-color:#717070;">
                            <tr>
                                <th class="table_header_text pl-3">Leave Type</th>
                                <th class="table_header_text text-center">Allocated</th>
                                <th class="table_header_text text-center">Used</th>
                                <th class="table_header_text text-center">Remaining</th>
                            </tr>
                        </thead>
                        <tbody id="lbm_tableBody"></tbody>
                        <tfoot id="lbm_tableFoot" style="background-color:#f8f8f8;font-weight:600;font-size:13px;">
                        </tfoot>
                    </table>
                </div>

            </div>

            <div class="modal-footer" style="background-color:#f8f8f8;padding:8px 15px;">
                <small class="text-muted mr-auto" style="font-size:12px;">
                    <i class="fa fa-info-circle"></i>
                    Counts approved leaves only. Short leaves do not deduct days.
                </small>
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    /**
     * loadLeaveBalanceBadge(userId, targetSelector)
     *
     * Fetches leave balance and renders it inline inside the badge.
     * targetSelector: jQuery selector for the .lbm-inline-text span inside the badge.
     *
     * Auto-called on page load for all .leave-balance-badge elements.
     */
    function loadLeaveBalanceBadge(userId, targetSelector) {

        var $target = $(targetSelector);

        // Loading
        $target.html(
            '<div style="font-size:12px;color:#94a3b8;padding:5px 0;">' +
                '<i class="fa fa-spinner fa-spin" style="font-size:12px;"></i> Loading...' +
            '</div>'
        );

        $.ajax({

            url: '{{ url("/leave-Manage/getLeaveBalance") }}/' + userId,

            method: 'GET',

            success: function(res) {

                if (
                    !res.success ||
                    !res.balances ||
                    res.balances.length === 0
                ) {

                    $target.html(
                        '<div style="font-size:12px;color:#94a3b8;padding:5px 0;">' +
                            'No leave balance data' +
                        '</div>'
                    );

                    return;
                }


                /*
                * Format number
                * 14.00 => 14
                * 4.50  => 4.5
                */
                function formatNumber(value) {

                    var number = parseFloat(value);

                    if (isNaN(number)) {
                        return 0;
                    }

                    return Number.isInteger(number)
                        ? number
                        : parseFloat(number.toFixed(2));
                }


                /*
                * Escape leave name
                */
                function escapeHtml(value) {

                    return $('<div>')
                        .text(value == null ? '' : value)
                        .html();
                }


                /*
                * Leave type colours
                */
                function getCardStyle(leaveName, index) {

                    var name = String(
                        leaveName || ''
                    ).toLowerCase();


                    // Annual
                    if (
                        name.indexOf('annual') !== -1
                    ) {

                        return {
                            color: '#1677ff',
                            background: '#f5f9ff',
                            border: '#dbeafe'
                        };
                    }


                    // Casual
                    if (
                        name.indexOf('casual') !== -1
                    ) {

                        return {
                            color: '#0ca765',
                            background: '#f3fbf7',
                            border: '#d8f0e3'
                        };
                    }


                    // Sick
                    if (
                        name.indexOf('sick') !== -1
                    ) {

                        return {
                            color: '#ff8a00',
                            background: '#fff9f0',
                            border: '#fde7bf'
                        };
                    }


                    // Other leave types
                    var fallback = [

                        {
                            color: '#8b5cf6',
                            background: '#faf7ff',
                            border: '#ede9fe'
                        },

                        {
                            color: '#ec4899',
                            background: '#fff7fb',
                            border: '#fce7f3'
                        },

                        {
                            color: '#06b6d4',
                            background: '#f3fcfd',
                            border: '#cffafe'
                        },

                        {
                            color: '#f97316',
                            background: '#fff8f3',
                            border: '#ffedd5'
                        }

                    ];


                    return fallback[
                        index % fallback.length
                    ];
                }


                var html = '';


                /*
                * Heading - same style as Employee Details
                */
                html +=
                    '<div style="' +

                        'font-size:12px;' +
                        'font-weight:600;' +
                        'color:#94a3b8;' +
                        'letter-spacing:.06em;' +
                        'text-transform:uppercase;' +
                        'margin-bottom:8px;' +

                    '">' +

                        'Remaining Leave' +

                    '</div>';


                /*
                * Cards wrapper
                */
                html +=
                    '<div style="' +

                        'display:grid;' +
                        'grid-template-columns:repeat(3,minmax(0,1fr));' +
                        'gap:7px;' +
                        'width:100%;' +

                    '">';


                res.balances.forEach(
                    function(item, index) {

                        var leaveName =
                            item.leave_type_name || 'Leave';

                        var safeName =
                            escapeHtml(leaveName);

                        var style =
                            getCardStyle(
                                leaveName,
                                index
                            );

                        var remaining =
                            formatNumber(
                                item.remaining
                            );

                        var used =
                            formatNumber(
                                item.used
                            );

                        var allocated =
                            formatNumber(
                                item.allocated
                            );


                        /*
                        * Card
                        */
                        html +=
                            '<div style="' +

                                'display:flex;' +
                                'align-items:center;' +
                                'min-width:0;' +
                                'height:50px;' +
                                'padding:6px 8px;' +

                                'border:1px solid ' +
                                    style.border + ';' +

                                'border-radius:7px;' +

                                'background:' +
                                    style.background + ';' +

                                'box-sizing:border-box;' +

                            '">';


                        /*
                        * Left side
                        */
                        html +=
                            '<div style="' +

                                'flex:1 1 auto;' +
                                'min-width:0;' +
                                'padding-right:7px;' +

                            '">';


                        /*
                        * Leave name
                        */
                        html +=
                            '<div style="' +

                                'font-size:12px;' +
                                'font-weight:600;' +
                                'line-height:1.15;' +
                                'color:#172033;' +

                                'white-space:nowrap;' +
                                'overflow:hidden;' +
                                'text-overflow:ellipsis;' +

                            '">' +

                                safeName +

                            '</div>';


                        /*
                        * Remaining
                        */
                        html +=
                            '<div style="' +

                                'display:flex;' +
                                'align-items:baseline;' +
                                'gap:3px;' +
                                'margin-top:4px;' +
                                'white-space:nowrap;' +

                            '">';


                        html +=
                            '<span style="' +

                                'font-size:18px;' +
                                'font-weight:700;' +
                                'line-height:1;' +

                                'color:' +
                                    style.color + ';' +

                            '">' +

                                remaining +

                            '</span>';


                        html +=
                            '<span style="' +

                                'font-size:8px;' +
                                'font-weight:500;' +
                                'color:#64748b;' +

                            '">' +

                                'days left' +

                            '</span>';


                        html += '</div>';

                        html += '</div>';


                        /*
                        * Separator
                        */
                        html +=
                            '<div style="' +

                                'width:1px;' +
                                'height:29px;' +
                                'background:#d8dee8;' +
                                'margin-right:7px;' +
                                'flex-shrink:0;' +

                            '"></div>';


                        /*
                        * Used
                        */
                        html +=
                            '<div style="' +

                                'flex:0 0 auto;' +
                                'min-width:34px;' +
                                'white-space:nowrap;' +

                            '">';


                        html +=
                            '<div style="' +

                                'font-size:12px;' +
                                'font-weight:700;' +
                                'line-height:1.15;' +
                                'color:#172033;' +

                            '">' +

                                used +
                                ' / ' +
                                allocated +

                            '</div>';


                        html +=
                            '<div style="' +

                                'font-size:12px;' +
                                'font-weight:500;' +
                                'color:#64748b;' +
                                'margin-top:4px;' +

                            '">' +

                                'used' +

                            '</div>';


                        html += '</div>';

                        html += '</div>';

                    }
                );


                html += '</div>';


                $target.html(html);
            },


            error: function(xhr) {

                console.error(
                    'Leave balance error:',
                    xhr.status,
                    xhr.responseText
                );


                $target.html(
                    '<div style="' +

                        'font-size:12px;' +
                        'color:#dc2626;' +
                        'padding:5px 0;' +

                    '">' +

                        'Unable to load leave balance' +

                    '</div>'
                );

            }

        });
    }

    // Auto-init ONLY for badges that have data-userid on page load
    // (used on profile page, NOT in admin modal)
    $(document).ready(function() {
        $('.leave-balance-badge[data-userid]').each(function() {
            var userId = $(this).data('userid');
            var $textSpan = $(this).find('.lbm-inline-text');
            if (userId && $textSpan.length) {
                loadLeaveBalanceBadge(userId, $textSpan);
            }
        });
    });
    // Auto-init: on page load, find all badges and load their data
    $(document).ready(function() {
        $('.leave-balance-badge').each(function() {
            var userId = $(this).data('userid');
            var $textSpan = $(this).find('.lbm-inline-text');
            if (userId && $textSpan.length) {
                loadLeaveBalanceBadge(userId, $textSpan);
            }
        });
    });
    /**
     * showLeaveBalance(userId)
     * Opens the leave balance modal for any user.
     * Works from any page — just call with the user's ID.
     */
    function showLeaveBalance(userId) {
        // Reset to loading state
        $('#lbm_loading').show();
        $('#lbm_content').hide();
        $('#lbm_error').hide();
        $('#lbm_tableBody').empty();
        $('#lbm_tableFoot').empty();
        $('#lbm_userName').text('');
        $('#lbm_groupName').text('');

        $('#leaveBalanceModal').modal('show');

        $.ajax({
            // url: '/leave-Manage/getLeaveBalance/' + userId,
            url: '{{ url("/leave-Manage/getLeaveBalance") }}/' + userId,
            method: 'GET',
            success: function(res) {
                $('#lbm_loading').hide();

                if (!res.success) {
                    $('#lbm_errorText').text(res.message);
                    $('#lbm_error').show();
                    return;
                }

                $('#lbm_userName').text(res.user_name);
                $('#lbm_groupName').text(res.group_name);

                var totalAllocated = 0,
                    totalUsed = 0,
                    totalRemaining = 0;

                res.balances.forEach(function(item) {
                    totalAllocated += item.allocated;
                    totalUsed += item.used;
                    totalRemaining += item.remaining;

                    // Colour-code remaining: red=0, orange=low (≤20%), green=ok
                    var pct = item.allocated > 0 ? (item.remaining / item.allocated) : 0;
                    var remainClass = pct <= 0 ?
                        'text-danger' :
                        (pct <= 0.2 ? 'text-warning' : 'text-success');

                    // Progress bar width
                    var usedPct = item.allocated > 0 ?
                        Math.min(100, Math.round((item.used / item.allocated) * 100)) :
                        0;

                    $('#lbm_tableBody').append(
                        '<tr>' +
                        '  <td class="pl-3">' +
                        '    <strong>' + item.leave_type_name + '</strong>' +
                        '    <div style="height:4px;background:#e9ecef;border-radius:2px;margin-top:3px;">' +
                        '      <div style="height:4px;width:' + usedPct + '%;background:#2dce89;border-radius:2px;"></div>' +
                        '    </div>' +
                        '  </td>' +
                        '  <td class="text-center align-middle">' + item.allocated + '</td>' +
                        '  <td class="text-center align-middle text-muted">' + item.used + '</td>' +
                        '  <td class="text-center align-middle ' + remainClass + '">' +
                        '    <strong>' + item.remaining + '</strong>' +
                        '  </td>' +
                        '</tr>'
                    );
                });

                // Totals footer row
                $('#lbm_tableFoot').append(
                    '<tr>' +
                    '  <td class="pl-3">Total</td>' +
                    '  <td class="text-center">' + totalAllocated + '</td>' +
                    '  <td class="text-center text-muted">' + totalUsed + '</td>' +
                    '  <td class="text-center ' + (totalRemaining <= 0 ? 'text-danger' : 'text-success') + '">' +
                    '    <strong>' + totalRemaining + '</strong>' +
                    '  </td>' +
                    '</tr>'
                );

                $('#lbm_content').show();
            },
            error: function() {
                $('#lbm_loading').hide();
                $('#lbm_errorText').text('Failed to load leave balance. Please try again.');
                $('#lbm_error').show();
            }
        });
    }
</script>
