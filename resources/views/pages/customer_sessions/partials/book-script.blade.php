<script>
(function () {
    var bookingModalElement = document.getElementById('bookSessionModal');
    var noCreditsElement = document.getElementById('noCreditsModal');
    if (!bookingModalElement || !noCreditsElement) return;

    var bookingModal = new bootstrap.Modal(bookingModalElement);
    var noCreditsModal = new bootstrap.Modal(noCreditsElement);
    var form = document.getElementById('bookSessionForm');
    var childSelect = document.getElementById('existingChildSelect');
    var firstInput = document.getElementById('playerFirstInput');
    var lastInput = document.getElementById('playerLastInput');
    var gradInput = document.getElementById('gradYearInput');
    var errorBox = document.getElementById('bookingFormErrors');
    var submitButton = document.getElementById('confirmBookButton');

    function resetPlayerForm() {
        if (childSelect) childSelect.value = '';
        if (firstInput) { firstInput.value = ''; firstInput.readOnly = false; }
        if (lastInput) { lastInput.value = ''; lastInput.readOnly = false; }
        if (gradInput) { gradInput.value = ''; gradInput.disabled = false; }
        document.querySelectorAll('#bookSessionModal input[name="positions[]"]').forEach(function (input) {
            input.checked = false;
            input.disabled = false;
        });
        errorBox.classList.add('d-none');
        errorBox.innerHTML = '';
    }

    function fillFromChild() {
        if (!childSelect) return;
        var option = childSelect.options[childSelect.selectedIndex];
        var hasChild = !!childSelect.value;
        if (!hasChild) {
            if (firstInput) { firstInput.value = ''; firstInput.readOnly = false; }
            if (lastInput) { lastInput.value = ''; lastInput.readOnly = false; }
            if (gradInput) { gradInput.value = ''; gradInput.disabled = false; }
            document.querySelectorAll('#bookSessionModal input[name="positions[]"]').forEach(function (input) { input.checked = false; input.disabled = false; });
            return;
        }
        if (firstInput) { firstInput.value = option.getAttribute('data-first') || ''; firstInput.readOnly = true; }
        if (lastInput) { lastInput.value = option.getAttribute('data-last') || ''; lastInput.readOnly = true; }
        if (gradInput) { gradInput.value = option.getAttribute('data-grad') || ''; gradInput.disabled = true; }
        var positions = [];
        try { positions = JSON.parse(option.getAttribute('data-positions') || '[]'); } catch (e) { positions = []; }
        document.querySelectorAll('#bookSessionModal input[name="positions[]"]').forEach(function (input) {
            input.checked = positions.indexOf(input.value) !== -1;
            input.disabled = true;
        });
    }

    if (childSelect) childSelect.addEventListener('change', fillFromChild);

    document.addEventListener('click', function (event) {
        var button = event.target.closest('.js-book-session');
        if (!button) return;
        event.preventDefault();
        if (String(button.getAttribute('data-has-credits')) !== '1') {
            noCreditsModal.show();
            return;
        }
        resetPlayerForm();
        form.action = button.getAttribute('data-action');
        document.getElementById('bookSessionName').textContent = button.getAttribute('data-session') || 'Complete player information.';
        bookingModal.show();
    });

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        errorBox.classList.add('d-none');
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Booking...';

        var formData = new FormData(form);
        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: formData
        }).then(function (response) {
            return response.json().then(function (json) { return {ok: response.ok, json: json}; });
        }).then(function (result) {
            if (!result.ok || result.json.status === false) {
                if (result.json.needs_package) {
                    bookingModal.hide();
                    noCreditsModal.show();
                    return;
                }
                var messages = [];
                if (result.json.errors) {
                    Object.keys(result.json.errors).forEach(function (key) {
                        result.json.errors[key].forEach(function (message) { messages.push(message); });
                    });
                }
                if (!messages.length) messages.push(result.json.message || 'Unable to book this session.');
                errorBox.innerHTML = messages.join('<br>');
                errorBox.classList.remove('d-none');
                return;
            }
            window.location.href = result.json.redirect || '{{ route('em.customer.bookings') }}';
        }).catch(function () {
            errorBox.textContent = 'Unable to complete the booking. Please try again.';
            errorBox.classList.remove('d-none');
        }).finally(function () {
            submitButton.disabled = false;
            submitButton.innerHTML = 'Book Session';
        });
    });
})();
</script>
