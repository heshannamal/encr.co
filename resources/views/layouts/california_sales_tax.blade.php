<script>
    (function () {
        const countyLookups = new WeakMap();
        const addressFields = ['shipping_street', 'shipping_city', 'shipping_state', 'shipping_postal_code', 'shipping_country'];

        function queueCountyLookup(form, addressChanged) {
            @if (!Gate::any(['edit organizations', 'add organizations']))
                return;
            @endif
            const county = form.querySelector('[name="shipping_county"]');
            if (!county || !form.querySelector('[name="sales_tax"]') || !form.querySelector('select[name="sales_tax_active"]')) return;

            const pending = countyLookups.get(form);
            if (pending) {
                clearTimeout(pending.timer);
                if (pending.controller) pending.controller.abort();
            }
            const lookup = {};
            countyLookups.set(form, lookup);
            const address = {};
            addressFields.forEach(function (name) {
                const input = form.querySelector('[name="' + name + '"]');
                address[name] = input ? input.value.trim() : '';
            });
            lookup.addressKey = JSON.stringify(address);
            if (pending && pending.addressKey === lookup.addressKey) addressChanged = false;
            let message = form.querySelector('[data-county-lookup-message]');
            if (message) message.textContent = '';
            const isCalifornia = ['CA', 'CALIFORNIA'].includes(address.shipping_state.toUpperCase())
                && ['', 'US', 'USA', 'UNITED STATES', 'UNITED STATES OF AMERICA'].includes(address.shipping_country.toUpperCase());
            if (!isCalifornia || (!addressChanged && county.value.trim())) return;
            if (addressChanged) county.value = '';
            if (!address.shipping_street || !address.shipping_city || !address.shipping_postal_code) return;

            const originalCounty = county.value;
            lookup.timer = setTimeout(async function () {
                if (!message) {
                    message = document.createElement('small');
                    message.className = 'd-block text-muted';
                    message.dataset.countyLookupMessage = '';
                    county.after(message);
                }
                message.textContent = 'Looking up county…';
                lookup.controller = new AbortController();
                try {
                    const token = form.querySelector('[name="_token"]');
                    const response = await fetch(@json(route('organizations.california_tax_details')), {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token ? token.value : '',
                        },
                        body: JSON.stringify(address),
                        signal: lookup.controller.signal,
                    });
                    const data = await response.json();
                    if (countyLookups.get(form) !== lookup) return;
                    if (!response.ok) {
                        const errors = data.errors ? Object.values(data.errors).flat() : [];
                        throw new Error(errors[0] || 'County lookup failed. Please try again.');
                    }
                    if (county.value === originalCounty) county.value = data.county || '';
                    message.textContent = data.county ? '' : 'County could not be found. Please verify the address.';
                } catch (error) {
                    if (error.name !== 'AbortError' && countyLookups.get(form) === lookup) {
                        message.textContent = error.message || 'County lookup failed. Please try again.';
                    }
                }
            }, 500);
        }

        function updateCaliforniaTaxControls(form) {
            const state = form.querySelector('[name="shipping_state"]');
            const country = form.querySelector('[name="shipping_country"]');
            const rate = form.querySelector('[name="sales_tax"]');
            const status = form.querySelector('select[name="sales_tax_active"]');
            if (!state || !rate || !status) return;

            const isCalifornia = ['CA', 'CALIFORNIA'].includes(state.value.trim().toUpperCase())
                && ['', 'US', 'USA', 'UNITED STATES', 'UNITED STATES OF AMERICA']
                    .includes(country ? country.value.trim().toUpperCase() : '');
            rate.readOnly = isCalifornia;
            status.disabled = isCalifornia;

            let automaticStatus = form.querySelector('[data-california-tax-status]');
            if (isCalifornia) {
                status.value = '1';
                if (!automaticStatus) {
                    automaticStatus = document.createElement('input');
                    automaticStatus.type = 'hidden';
                    automaticStatus.name = 'sales_tax_active';
                    automaticStatus.value = '1';
                    automaticStatus.dataset.californiaTaxStatus = '';
                    status.after(automaticStatus);
                }
            } else {
                if (automaticStatus) automaticStatus.remove();
            }
        }

        function refreshForms() {
            document.querySelectorAll('form').forEach(function (form) {
                updateCaliforniaTaxControls(form);
                queueCountyLookup(form, false);
            });
        }
        document.addEventListener('DOMContentLoaded', refreshForms);
        document.addEventListener('change', function (event) {
            if (event.target.form && ['shipping_state', 'shipping_country'].includes(event.target.name)) {
                updateCaliforniaTaxControls(event.target.form);
            }
            if (event.target.form && addressFields.includes(event.target.name)) {
                queueCountyLookup(event.target.form, true);
            }
        });
        if (window.jQuery) {
            jQuery(document).on('shown.bs.modal', refreshForms);
            jQuery(document).on('change', 'select[name="shipping_country"]', function () {
                if (this.form) {
                    updateCaliforniaTaxControls(this.form);
                    queueCountyLookup(this.form, true);
                }
            });
        }
    })();
</script>
