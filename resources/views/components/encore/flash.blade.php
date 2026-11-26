@props(['type' => 'success'])

<div {{ $attributes->merge(['class' => 'alert alert-'.($type === 'error' ? 'danger' : $type).' alert-dismissible fade show']) }} role="alert">
    <span class="alert-inner--text">{{ $slot }}</span>
    <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('Close') }}">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
