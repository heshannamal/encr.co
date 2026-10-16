<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <p>Sub: Payment of<strong>&nbsp;$ {{ $paidAmount }}&nbsp;</strong>received on invoice&nbsp;<strong>#{{ $orderId }}</strong>.</p>
        <p>Dear Sir/Madam, </p>
        <p>This is to acknowledge that we have received the payment of<strong> $ {{ $paidAmount }}</strong>&nbsp;for invoice&nbsp;<strong>#{{ $orderId }}</strong>&nbsp;on<strong>&nbsp;{{ $paidDate }}</strong> by <strong>{{ $organizationname }}</strong>.</p>

        <p class="has-text-align-center">Thanking you.</p>
        <p>
            <img style="max-width: 250px;" src="https://encr.co/public/images/signature.png" /><br>
        </p>
    </body>
</html>
