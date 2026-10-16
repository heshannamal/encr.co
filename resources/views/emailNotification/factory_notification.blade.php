<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>
            p {
                margin-bottom: 0rem;
            }
        </style>
    </head>
    <body>
        <div class="container">
            @php
                echo $body;
            @endphp
            <p>
                Thank you!<br><br>
                <img style="max-width: 250px;" src="https://encr.co/public/images/signature.png" /><br>
            </p>
        </div>
    </body>
</html>
