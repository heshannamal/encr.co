<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You were mentioned in a comment</title>
</head>

<body style="margin:0;padding:0;background:#eef1f5;font-family:Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;background:#eef1f5;padding:24px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellpadding="0" cellspacing="0" border="0"
                    style="border-collapse:collapse;background:#ffffff;border:1px solid #1f2937;border-radius:10px;overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:#111827;padding:22px 20px;text-align:center;" bgcolor="#111827">
                            <img src="https://encr.co/argon/img/encore/logo.png" alt="Encore Custom" width="220"
                                style="display:block;margin:0 auto;max-width:220px;height:auto;border:0;outline:none;text-decoration:none;">
                        </td>
                    </tr>

                    <!-- Title -->
                    <tr>
                        <td style="padding:22px 20px 4px 20px;">
                            <h2 style="margin:0;font-size:19px;color:#111827;">{{$mentionedByName}} mention you in a comment</h2>
                        </td>
                    </tr>

                    <!-- Task -->
                    <tr>
                        <td style="padding:16px 20px 0 20px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;background:#f9fafb;border-radius:8px;" bgcolor="#f9fafb">
                                <tr>
                                    <td style="padding:14px 16px;background:#f9fafb;" bgcolor="#f9fafb">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                                            <tr>
                                                <td valign="top">
                                                    <div style="font-size:9px;letter-spacing:1px;color:#9ca3af;font-weight:700;">{{ $taskType === 'sub_discussion' ? 'SUB TASK' : 'TASK' }}</div>
                                                    <div style="font-size:15px;font-weight:700;color:#111827;margin-top:4px;">{{$discussionName}}</div>
                                                    @if(!empty($priority))
                                                    @php
                                                        $priorityColors = [
                                                            'Critical' => '#dc2626',
                                                            'High'     => '#ea580c',
                                                            'Medium'   => '#d97706',
                                                            'Low'      => '#16a34a',
                                                        ];
                                                        $priorityColor = $priorityColors[$priority] ?? '#6b7280';
                                                    @endphp
                                                    <div style="font-size:12px;color:#6b7280;margin-top:6px;">
                                                        <span style="color:{{$priorityColor}};">&#9679;</span> {{$priority}} priority
                                                    </div>
                                                    @endif
                                                </td>
                                                <td valign="top" align="right" width="24">
                                                    @if($taskType === 'sub_discussion')
                                                        <a href="https://encr.co/projects/my_tasks?open_chat=true&type=%22sub_discussion%22&discussion_id={{$discussionId}}" style="color:#9ca3af;text-decoration:none;font-size:14px;">&#8599;</a>
                                                    @else
                                                        <a href="https://encr.co/projects/my_tasks?open_chat=true&type=discussion&discussion_id={{$discussionId}}" style="color:#9ca3af;text-decoration:none;font-size:14px;">&#8599;</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Task details -->
                    <tr>
                        <td style="padding:18px 20px 0 20px;">
                            <div style="font-size:10px;letter-spacing:1px;color:#9ca3af;font-weight:700;">TASK DETAILS</div>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:4px;">
                                <tr>
                                    <td style="font-size:13px;color:#374151;padding-bottom:6px;">Project</td>
                                    <td align="right" style="font-size:13px;color:#111827;font-weight:700;padding-bottom:6px;">{{$projectName}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px;color:#374151;">Due Date</td>
                                    <td align="right" style="font-size:13px;color:#111827;font-weight:700;">{{ $dueDate ? \Carbon\Carbon::parse($dueDate)->format('M j, Y') : 'No due date' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Comments -->
                    @if(!empty($comments))
                    <tr>
                        <td style="padding:18px 20px 24px 20px;">
                            <div style="font-size:10px;letter-spacing:1px;color:#9ca3af;font-weight:700;margin-bottom:8px;">COMMENTS</div>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;">
                                @foreach($comments as $comment)
                                <tr>
                                    <td style="padding:6px 0;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                            style="border-collapse:collapse;{{ $comment['is_mention'] ? 'background:#f9fafb;border-radius:8px;' : '' }}">
                                            <tr>
                                                <td style="padding:{{ $comment['is_mention'] ? '12px 14px' : '4px 0' }};" valign="top" width="36">
                                                    @if(!empty($comment['profile_pic']))
                                                        <img src="{{ $comment['profile_pic'] }}" width="28" height="28" alt="{{ $comment['user_name'] }}"
                                                            style="display:block;width:28px;height:28px;border-radius:50%;object-fit:cover;">
                                                    @else
                                                        <span style="display:inline-block;width:28px;height:28px;line-height:28px;border-radius:50%;background:#0d9488;color:#ffffff;font-size:12px;font-weight:700;text-align:center;">{{ strtoupper(substr($comment['user_name'], 0, 1)) }}</span>
                                                    @endif
                                                </td>
                                                <td style="padding:{{ $comment['is_mention'] ? '12px 14px 12px 0' : '4px 0 4px 10px' }};" valign="top">
                                                    <div style="font-size:12px;font-weight:700;color:#111827;">{{$comment['user_name']}} <span style="font-weight:400;color:#9ca3af;">&middot; {{$comment['created_at']}}</span></div>
                                                    <div style="font-size:13px;color:#374151;margin-top:4px;line-height:1.5;">{!! $comment['comment'] !!}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>
                    @endif

                    <!-- CTA -->
                    <tr>
                        <td style="padding:0 20px 24px 20px;" align="center">
                            <a href="https://encr.co/projects/view-temp/{{$projectId}}" target="_blank"
                                style="display:inline-block;background:#0d9488;color:#ffffff;font-size:12px;font-weight:700;padding:10px 22px;border-radius:8px;text-decoration:none;">GO TO PROJECT</a>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding:0;background:#f9fafb;" bgcolor="#f9fafb">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="border-collapse:collapse;background:#f9fafb;" bgcolor="#f9fafb">
                                <tr>
                                    <td style="padding:24px 20px 20px 20px;background:#f9fafb;" bgcolor="#f9fafb">
                                        <div style="text-align:center;">
                                            <img src="https://encr.co/argon/img/encore/logo_dark.png" alt="Encore Custom" width="180"
                                                style="display:block;margin:0 auto 10px auto;max-width:180px;height:auto;border:0;outline:none;text-decoration:none;">
                                            <p style="font-size:11px;color:#6b7280;font-style:italic;margin:0 0 14px 0;">The quality of your apparel reflects the quality of your brand.</p>
                                            <div style="font-size:11px;color:#374151;">
                                                Web: www.EncoreCustom.com Facebook: @ENCRSTM Instagram: @ENCRSTM
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>