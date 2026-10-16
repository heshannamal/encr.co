<!DOCTYPE html>
<html>

<body style="font-family: Arial, sans-serif; background:#f5f7fa; padding:30px; margin:0;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:8px;">

                    <tr>
                        <td style="padding:35px;">

                            <h2 style="margin-top:0; margin-bottom:25px; color:#111827;">
                                New Task Assigned
                            </h2>

                            <p style="margin-top:0; margin-bottom:18px; line-height:24px;">
                                Hello <strong>{{ $assigneeName }}</strong>,
                            </p>

                            <p style="margin-top:0; margin-bottom:25px; line-height:24px;">
                                A new discussion/task has been assigned to you.
                                Please review the details below.
                            </p>

                            <table width="100%" cellpadding="12" cellspacing="0"
                                style="background:#f9fafb; border-radius:6px;">

                                <tr>
                                    <td width="180" style="vertical-align:top;">
                                        <strong>Task</strong>
                                    </td>

                                    <td>
                                        {{ $discussionName }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:top;">
                                        <strong>Assigned By</strong>
                                    </td>

                                    <td>
                                        {{ $AssignedBy }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:top;">
                                        <strong>Description</strong>
                                    </td>

                                    <td>
                                        {{ $description ?: 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:top;">
                                        <strong>Due Date</strong>
                                    </td>

                                    <td>
                                        {{ $dueDate ?: 'N/A' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="vertical-align:top;">
                                        <strong>Project Link</strong>
                                    </td>

                                    <td>
                                        <a href="https://encr.co/projects/view-temp/{{ $projectId }}"
                                            style="color:#2563eb; text-decoration:none;">
                                            View Project
                                        </a>
                                    </td>
                                </tr>

                            </table>

                            <p style="margin-top:30px; margin-bottom:20px; line-height:24px;">
                                Please make sure to review and complete the assigned task before the due date.
                            </p>

                            <p style="margin:0; line-height:26px;">
                                Regards,<br>
                                <strong>Encore Cloud Team</strong>
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>