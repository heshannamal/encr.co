<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <p>Sub: purchase order has been successfully submitted for order&nbsp;<strong>#{{ $orderNo }}</strong>.</p>
        <p>Dear Sir/Madam, </p>
        <p>This is to acknowledge that we have received the purchase order for invoice&nbsp;<strong>#{{ $orderNo }}</strong>&nbsp;on<strong>&nbsp;{{ $paidDate }}</strong> by <strong>{{ $organizationname }}</strong>.</p>
        <br>
        <br>

            <a href="{{ route('customer_payment_download.po', ['sourceId'=>$sourceId]) }}" target="_blank" rel="noopener noreferrer" class="mt-1">
                <button type="button" class="btn" style="padding: 10px;
                background: #e0ac43;
                border: none;
                border-radius: 9px;
                color: white;
                font-weight: bold;
                margin-top: 10px;
                cursor: pointer;"><i class="fas fa-file-download">Download</i></button>
            </a>


        <br>
        <p class="has-text-align-center">Thanking you!</p>
        <p>
            <img style="max-width: 250px;" src="https://encr.co/public/images/signature.png" /><br>
        </p>
    </body>
</html>
