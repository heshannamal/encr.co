@props(['message' => 'Loading…', 'visible' => false])

<span {{ $attributes->merge(['class' => 'encore-loading']) }} role="status" aria-live="polite" @unless ($visible) hidden @endunless>
    <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
    <span>{{ __($message) }}</span>
</span>
