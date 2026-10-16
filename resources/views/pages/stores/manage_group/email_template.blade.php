<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Your Group</title>
</head>
<body style="font-family: Helvetica, Arial, sans-serif; font-size:14px; margin:0; padding:0; background-color:#f6f6f6;">

<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#f6f6f6" style="padding:20px 0;">
    <tr>
        <td></td>
        <td width="600" bgcolor="#ffffff" style="margin:0 auto; border:1px solid #e0e0e0; padding:20px;">

            <h1 style="font-size:24px; font-weight:600; margin:20px 0; color:#000;">
                Group Access to Online Store
            </h1>

            <p style="margin:0 0 15px 0; line-height:1.5; color:#333;">
                <strong>{{$store_name}}</strong> has given you group manager access to your store,<br>
                You can market the store, check on orders and keep up with your fundraising goal!
            </p>

            <p style="margin:20px 0;">
                <a href="{{ route('store.manage_your_group', ['token' => $token]) }}#orders" target="_blank"
                   style="background-color:#348eda; border-radius:25px; color:#ffffff;
                          font-weight:bold; text-decoration:none; padding:10px 20px;
                          display:inline-block;">
                    Manage your store
                </a>
            </p>

            <hr style="border:none; border-top:1px solid #ddd; margin:30px 0;">

            {{-- <p style="font-size:12px; color:#999; text-align:center; margin:0;">
                <a href=""
                   style="color:#999; text-decoration:none;">Unsubscribe</a>
            </p> --}}

        </td>
        <td></td>
    </tr>
</table>

</body>
</html>
