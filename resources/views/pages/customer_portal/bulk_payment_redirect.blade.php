<!DOCTYPE html>
<html>
<head>
    <title>Downloading Bulk Payment PDF</title>
</head>
<body>
<script>
    // Create a blob from base64 PDF
    const pdfData = atob("{{ $pdfBase64 }}"); // decode base64
    const array = new Uint8Array(pdfData.length);
    for (let i = 0; i < pdfData.length; i++) {
        array[i] = pdfData.charCodeAt(i);
    }
    const blob = new Blob([array], { type: 'application/pdf' });

    // Create a temporary link
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = "Bulk_Payment_{{ now()->format('Ymd_His') }}.pdf";

    // Open PDF download in a new tab
    window.open(link.href, "_blank");

    // Optional: trigger automatic download (some browsers may block)
    link.click();

    // Redirect the main page immediately
    window.location.href = "{{ $redirectUrl }}";
</script>

<p>If the download doesn't start automatically, <a id="manualDownload" href="#">click here</a>.</p>

<script>
    document.getElementById('manualDownload').href = URL.createObjectURL(
        new Blob([atob("{{ $pdfBase64 }}")], { type: 'application/pdf' })
    );
    document.getElementById('manualDownload').target = "_blank";
</script>

</body>
</html>
