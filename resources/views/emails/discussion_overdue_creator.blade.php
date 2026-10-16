<!DOCTYPE html>
<html>

<body style="font-family: Arial; background:#f5f7fa; padding:20px;">
    <table width="600" align="center" style="background:#fff; padding:20px; border-radius:8px;">
        <tr>
            <td>
                <p>Hello <strong>{{ $creatorName }}</strong>,</p>

                <p>Important Notice: Your assigned task is now past its due date – kindly review and take immediate action.</p>

                <table width="100%" cellpadding="8" style="background:#f9fafb;">
                    <tr>
                        <td><strong>Task</strong></td>
                        <td>{{ $discussionName }}</td>
                    </tr>
                    <tr>
                        <td><strong>Assigned By</strong></td>
                        <td>{{ $assigneeName }}</td>
                    </tr>
                    <tr>
                        <td><strong>Due Date</strong></td>
                        <td>{{ $dueDate }}</td>
                    </tr>
                </table>

                <p style="margin-top:15px;">
                    Please contact the assignee and make any necessary adjustments to the due date to avoid any inconvenience.
                </p>

                <p>Regards,<br><strong>Encore Cloud Team</strong></p>
            </td>
        </tr>
    </table>
</body>

</html>
