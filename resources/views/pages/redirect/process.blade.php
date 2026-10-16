<!DOCTYPE html>
<html>
<head>
    <title>Please wait...</title>
</head>
<body>

<p>Processing... opening product</p>

<script>

var productUrl = "";

@if($level == 1)
    productUrl = "{{ route('edit_product', $newId) }}";
@else
    productUrl = "{{ route('sub_products.edit', $newId) }}";
@endif

// open in the pre-opened tab
window.open(productUrl, "productTab");

// return current tab
window.location.href = "{{ route('projects.view.temp', $currentId) }}";

</script>

</body>
</html>