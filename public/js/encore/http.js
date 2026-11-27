(() => {
    'use strict';

    class HttpError extends Error {
        constructor(response, data) {
            super(typeof data?.message === 'string' ? data.message : 'Request failed (' + response.status + ').');
            this.name = 'HttpError';
            this.status = response.status;
            this.errors = data?.errors ?? {};
            this.data = data;
        }
    }

    async function request(url, { method = 'GET', body, headers = {}, signal } = {}) {
        const target = new URL(url, document.baseURI);
        if (target.origin !== window.location.origin) {
            throw new TypeError('Encore requests must use the same origin.');
        }

        const verb = method.toUpperCase();
        const requestHeaders = new Headers(headers);
        requestHeaders.set('Accept', 'application/json');
        requestHeaders.set('X-Requested-With', 'XMLHttpRequest');
        if (!['GET', 'HEAD', 'OPTIONS'].includes(verb)) {
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!token) throw new Error('CSRF token is missing.');
            requestHeaders.set('X-CSRF-TOKEN', token);
        }
        let payload = body;
        if (body != null && !(body instanceof FormData) && !(body instanceof URLSearchParams) && typeof body !== 'string') {
            requestHeaders.set('Content-Type', 'application/json');
            payload = JSON.stringify(body);
        }

        const response = await fetch(target.href, {
            method: verb,
            credentials: 'same-origin',
            redirect: 'error',
            headers: requestHeaders,
            body: payload,
            signal,
        });
        const data = response.status === 204 || verb === 'HEAD' ? null
            : (response.headers.get('content-type') || '').includes('json')
                ? await response.json() : await response.text();
        if (!response.ok) throw new HttpError(response, data);
        return data;
    }

    async function withBusy(element, callback) {
        if (!element || element.getAttribute('aria-busy') === 'true') return;
        const wasDisabled = element.disabled;
        element.setAttribute('aria-busy', 'true');
        if ('disabled' in element) element.disabled = true;
        try {
            return await callback();
        } finally {
            element.removeAttribute('aria-busy');
            if ('disabled' in element) element.disabled = wasDisabled;
        }
    }

    window.EncoreHttp = { request, withBusy, HttpError };
})();
