<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            .b,
            .strong {
                font-weight: bold;
            }
            .p {
                margin-bottom: 0rem;
            }
        </style>
    </head>
    <body>
        <div class="container text-left;max-width: 600px;">
            <img style="max-width: 600px;" src="https://encr.co/public/images/Shipment_Tracking_header_OP_06.jpg" />

            <div style="text-align: left; max-width: 600px; margin: 0rem;border: 2px solid #b1b1b1;border-top: none;">
                @php
                    echo $notifyBody;
                @endphp
            </div>
        </div>
    </body>
</html>
