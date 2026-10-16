<!DOCTYPE html>
<html>

<body style="font-family: Arial; background:#f5f7fa; padding:20px;">
    <table width="600" align="center" style="background:#ffffff; padding:20px; border-radius:8px;">
        <tr>
            <td>
                <p>Hello <strong>{{ $creatorName }}</strong>,</p>

                <p>
                    The sub-discussion you assigned has passed its due date.
                </p>

                <table width="100%" cellpadding="8" style="background:#f9fafb; margin-top:15px;">
                    <tr>
                        <td width="140"><strong>Sub Discussion</strong></td>
                        <td>{{ $subDiscussionName }}</td>
                    </tr>
                    <tr>
                        <td><strong>Assigned To</strong></td>
                        <td>{{ $assigneeName }}</td>
                    </tr>
                    <tr>
                        <td><strong>Due Date</strong></td>
                        <td>{{ $dueDate }}</td>
                    </tr>
                </table>

                <p style="margin-top:15px;">
                    You may want to follow up with the assignee or update the due date.
                </p>

                <p style="margin-top:25px;">
                    Regards,<br>
                    <strong>Encore Cloud Team</strong>
                </p>
            </td>
        </tr>
    </table>
</body>

</html>
