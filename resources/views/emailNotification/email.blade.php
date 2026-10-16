<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div align="center" class="container text-center">
            <img style="max-width: 600px;" src="https://encr.co/public/images/Shipment_Tracking_header_OP_06.jpg" />

            <br><br>
            <p style="text-align: left;max-width: 600px;">
                Hi {{$clubName}}, <br><br>

                We are pleased to announce that your order for <b>{{$clubName}}</b> is on its way to you from our factory.<br><br>


                Tracking #: <br>
                Items in this shipment:<br><br>
                @foreach ($shippedItems as $shippedItem)
                    {{$shippedItem['orderItemName'] . " - " . $shippedItem['order_item_tracking_no']}}<br>
                @endforeach
                <br>
                Please let me know how your items are once you receive them. <br><br>

                Thank you for your order!<br><br>

                Alissha<br><br>

                Alissha Davis<br>
                Production Coordinator<br>
                <a href="www.encorelacrosse.com">www.encorelacrosse.com</a><br>
            </p>
        </div>
    </body>
</html>
