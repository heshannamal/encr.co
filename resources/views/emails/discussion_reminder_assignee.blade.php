<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task Comment Notification</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f9;font-family:Arial,Helvetica,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f6f9;padding:30px 0;">
        <tr>
            <td align="center">

                <table width="650" cellpadding="0" cellspacing="0" border="0"
                    style="background:#ffffff;border-radius:8px;overflow:hidden;">

                    <!-- Logo -->
                    <tr>
                        <td style="padding:30px 40px 20px;">
                            <img src="https://encr.co/argon/img/encore/logo_dark.png" alt="Encore Logo"
                                style="height:55px;">
                        </td>
                    </tr>

                    <!-- User Header -->
                    <tr>
                        <td style="padding:0 40px 25px;">

                            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                <tr>

                                    <td width="70" valign="top">

                                        @if (!empty($commented_user_profile))
                                            <img src="https://encr.co/{{ $commented_user_profile }}" width="60"
                                                height="60"
                                                style="border-radius:50%;display:block;border:1px solid #ddd;">
                                        @else
                                            <div
                                                style="width:60px; height:60px; background:#7c3aed; border-radius:50%; color:#ffffff; font-weight:700; font-size:20px; text-align:center; line-height:60px; display:block;">
                                                {{ strtoupper(substr($commented_user, 0, 2)) }}
                                            </div>
                                        @endif

                                    </td>

                                    <td valign="middle">

                                        <div
                                            style="
                                            font-size:22px;
                                            font-weight:600;
                                            color:#1f2937;
                                            line-height:1.4;">
                                            {{ $commented_user }} added a comment
                                        </div>

                                        <div
                                            style="
                                            margin-top:5px;
                                            font-size:14px;
                                            color:#6b7280;">
                                            encr.co
                                        </div>

                                    </td>

                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- View Project Button -->
                    <tr>
                        <td style="padding:0 40px 25px;">

                            <a href="https://encr.co/projects/view-temp/{{ $project_id }}"
                                style="
                                    background:#3b82f6;
                                    color:#ffffff;
                                    text-decoration:none;
                                    padding:8px 14px;
                                    border-radius:6px;
                                    display:inline-block;
                                    font-size:14px;
                                    font-weight:bold;">
                                View Project
                            </a>

                        </td>
                    </tr>

                    <!-- Mention Users -->
                    @if (!empty($mention_users))
                        <tr>
                            <td style="padding:0 40px 25px;">
                                <div
                                    style="
                                color:#2563eb;
                                font-size:15px;
                                font-weight:500;">
                                    {{ $mention_users }}
                                </div>
                            </td>
                        </tr>
                    @endif

                    <!-- Main Card -->
                    <tr>
                        <td style="padding:0 40px 40px;">

                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="
                                    border:1px solid #e5e7eb;
                                    border-radius:8px;
                                    background:#ffffff;">

                                <tr>
                                    <td style="padding:25px;">

                                        <!-- Project Name -->
                                        <div
                                            style="
                                            font-size:28px;
                                            font-weight:700;
                                            color:#111827;
                                            margin-bottom:20px;">
                                            {{ $project_name }}
                                        </div>

                                        <!-- Meta Information -->
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr>

                                                <td
                                                    style="
                                                    font-size:14px;
                                                    color:#6b7280;
                                                    padding-right:25px;">
                                                    👤 {{ $user }}
                                                </td>

                                                <td
                                                    style="
                                                    font-size:14px;
                                                    color:#6b7280;">
                                                    📅 {{ $task_due_date }}
                                                </td>

                                            </tr>
                                        </table>

                                        <!-- Section -->
                                        @if (!empty($section_name))
                                            <div
                                                style="
                                            margin-top:15px;
                                            font-size:14px;
                                            color:#4b5563;">
                                                📁
                                                {{ $section_name }}
                                            </div>
                                        @endif

                                        <!-- Task -->
                                        @if (!empty($task_name))
                                            <div
                                                style="
                                            margin-top:10px;
                                            font-size:14px;
                                            color:#4b5563;">
                                                ✅
                                                {{ $task_name }}
                                            </div>
                                        @endif

                                        <!-- Mention Users -->
                                        @if (!empty($mention_users))
                                            <div
                                                style="
                                            margin-top:10px;
                                            font-size:14px;
                                            color:#4b5563;">
                                                👥 {{ $mention_users }}
                                            </div>
                                        @endif

                                        <div
                                            style="background:#f9fafb; border-left:4px solid #3b82f6; padding:12px 15px; margin-top:15px;">

                                            <div style="font-size:13px; color:#6b7280; margin-bottom:8px;">

                                                <strong style="color:#111827;">
                                                    {{ $commented_user }}
                                                </strong>
                                                •
                                                {{ \Carbon\Carbon::parse($created_at)->format('M d, Y g:i A') }}

                                            </div>

                                            <div style="font-size:15px; line-height:1.8; color:#374151;">
                                                {!! $comment !!}
                                            </div>

                                        </div>

                                        <!-- View Task -->
                                        <div style="margin-top:25px;">

                                            <a href="https://encr.co/projects/my_tasks?open_chat=true&type={{ $task_type }}&discussion_id={{ $task_id }}"
                                                style="
                                                    color:#2563eb;
                                                    text-decoration:none;
                                                    font-size:15px;
                                                    font-weight:600;">
                                                View Full Task Details →
                                            </a>

                                        </div>

                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                    @if (isset($recent_comments) && $recent_comments->count() > 1)

                        <tr>
                            <td style="padding:0 40px 30px;">

                                <table width="100%" cellpadding="0" cellspacing="0"
                                    style="border:1px solid #e5e7eb; border-radius:8px; background:#fafafa;">

                                    <tr>
                                        <td style="padding:15px 20px; font-size:16px; font-weight:600; color:#374151;">
                                            Recent Comments
                                        </td>
                                    </tr>

                                    @foreach ($recent_comments->take($recent_comments->count() - 1) as $recent)
                                        <tr>
                                            <td style="padding:12px 20px; border-top:1px solid #e5e7eb;">

                                                <div style="font-size:14px; font-weight:600; color:#111827;">

                                                    {{ $recent->userInfo->name ?? 'User' }}

                                                    <span style="color:#6b7280; font-weight:400;">

                                                        • {{ $recent->created_at->format('M d, Y g:i A') }}

                                                    </span>

                                                </div>

                                                <div
                                                    style="margin-top:6px; color:#374151; font-size:14px;line-height:1.6;">

                                                    {!! $recent->comment !!}

                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach

                                </table>

                            </td>
                        </tr>

                    @endif

                    <!-- Footer -->
                    <tr>
                        <td
                            style="
                            background:#f9fafb;
                            padding:20px 40px;
                            text-align:center;
                            font-size:13px;
                            color:#6b7280;">

                            This email was sent by Encore Cloud Team.

                            <br><br>

                            © {{ date('Y') }} Encore Cloud Team. All rights reserved.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
