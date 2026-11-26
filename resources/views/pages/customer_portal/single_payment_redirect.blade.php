<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>
<body style="font-family:Arial, Helvetica, sans-serif;text-align:center;padding:60px 20px;color:#111827;">

    <h3 style="margin:0 0 8px 0;">Payment successful</h3>
    <p style="margin:0 0 6px 0;color:#6b7280;">
        Your receipt <strong>{{ $fileName }}</strong> is downloading...
    </p>
    <p style="margin:0;color:#6b7280;font-size:13px;">
        If you are not redirected, <a href="{{ $redirectUrl }}">click here</a>.
    </p>

    <script>
        (function () {
            var base64      = @json($pdfBase64);
            var fileName    = @json($fileName);
            var redirectUrl = @json($redirectUrl);

            // base64 → PDF file
            var bytes = atob(base64);
            var arr   = new Uint8Array(bytes.length);
            for (var i = 0; i < bytes.length; i++) {
                arr[i] = bytes.charCodeAt(i);
            }
            var blob = new Blob([arr], { type: 'application/pdf' });

            // Download with the correct file name
            var link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = fileName;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Redirect after the download starts
            setTimeout(function () {
                window.location.href = redirectUrl;
            }, 1500);
        })();
    </script>

</body>
</html>