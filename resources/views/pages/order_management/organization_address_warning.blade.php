@php
    $addressOrganization = session('order_address_organization', $addressOrganization ?? null);
@endphp
<div class="alert alert-danger mt-2" id="order-organization-address-warning" role="alert" @if (!$addressOrganization) hidden @endif>
    This organization's shipping address is incomplete. Please update it to calculate sales tax.
    <a class="alert-link" data-organization-url="{{ route('organizations.info', ['id' => '__organization__']) }}"
        href="{{ $addressOrganization ? route('organizations.info', ['id' => $addressOrganization]) : '#' }}"
        target="_blank" rel="noopener">Update organization address</a>
</div>
<script>
    function showOrderOrganizationAddressWarning(organizationId, hasShippingAddress) {
        const warning = document.getElementById('order-organization-address-warning');
        const link = warning.querySelector('a');
        warning.hidden = !organizationId || hasShippingAddress;
        if (!warning.hidden) {
            link.href = link.dataset.organizationUrl.replace('__organization__', encodeURIComponent(organizationId));
        }
    }
</script>
