(() => {
    'use strict';

    document.addEventListener('click', event => {
        const button = event.target.closest('[data-encore-password-toggle]');
        if (!button) return;

        const field = document.getElementById(button.dataset.encorePasswordToggle);
        if (!(field instanceof HTMLInputElement)) return;
        if (!['password', 'text'].includes(field.type)) return;

        const visible = field.type === 'password';
        field.type = visible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(visible));
        button.setAttribute('aria-label', visible ? button.dataset.hideLabel : button.dataset.showLabel);
        const icon = button.querySelector('i');
        if (icon) {
            icon.classList.toggle('fa-eye', visible);
            icon.classList.toggle('fa-eye-slash', !visible);
        }
    });
})();
