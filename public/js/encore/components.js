(() => {
    'use strict';

    function initialize(root = document) {
        const $ = window.jQuery;
        if (!$ || !$.fn.select2) return;

        root.querySelectorAll('select[data-encore-select]').forEach(element => {
            const field = $(element);
            if (field.data('select2')) return;
            const modal = field.closest('.modal');
            const options = { width: '100%' };
            if (modal.length) options.dropdownParent = modal;
            field.select2(options);
        });
    }

    document.addEventListener('click', event => {
        const button = event.target.closest('[data-encore-confirm]');
        if (!button || button.disabled) return;
        if (!window.confirm(button.dataset.encoreConfirm)) {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    }, true);

    window.EncoreComponents = { initialize };
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => initialize());
    } else {
        initialize();
    }
})();
