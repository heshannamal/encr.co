<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <p>Sub: <span style="text-transform: capitalize;">{{ $type }}</span> payment received for orders;&nbsp;<strong>{{ $orderNo }}</strong>.</p>
        <p>Dear Sir/Madam, </p>
        <p>This is to acknowledge that we have received the {{ $type }} payment of&nbsp;<strong>${{ $paidAmount }}</strong>&nbsp;for orders&nbsp;<strong>#{{ $orderNo }}</strong>&nbsp;on<strong>&nbsp;{{ $paidDate }}</strong> by <strong>{{ $organizationname }}</strong>.</p>
        <br>
        <p>Payment reference:</p>
        <div class="mb-2">{{ $reference }}</div>
        @if(!empty($front_url) || !empty($back_url))
            <p>Assets:</p>
            <div>
                @if(!empty($front_url))
                    <img src="{{ $front_url }}"
                        style="width: 600px; height:auto; margin: 5px; cursor: pointer;"
                        alt="Front Image"
                        onclick="downloadImage('{{ $front_url }}', 'front_image.jpg')">
                @endif

                @if(!empty($back_url))
                    <img src="{{ $back_url }}"
                        style="width: 600px; height:auto; margin: 5px; cursor: pointer;"
                        alt="Back Image"
                        onclick="downloadImage('{{ $back_url }}', 'back_image.jpg')">
                @endif
            </div>

            <script>
                function downloadImage(url, filename) {
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = filename;
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }
            </script>
        @endif
        <br>
        <p class="has-text-align-center">Thanking you!</p>
        <p>
            <img style="max-width: 250px;" src="https://encr.co/public/images/signature.png" /><br>
        </p>
    </body>
</html>
