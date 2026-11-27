@props(['target'])

<button type="button" {{ $attributes->merge(['class' => 'encore-password-toggle']) }}
    data-encore-password-toggle="{{ $target }}"
    data-show-label="{{ __('Show password') }}"
    data-hide-label="{{ __('Hide password') }}"
    aria-controls="{{ $target }}"
    aria-label="{{ __('Show password') }}"
    aria-pressed="false">
    <i class="fas fa-eye-slash" aria-hidden="true"></i>
</button>
