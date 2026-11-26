@props(['message' => 'Are you sure?', 'type' => 'submit'])

<button type="{{ $type }}" data-encore-confirm="{{ __($message) }}" {{ $attributes->merge(['class' => 'btn btn-danger']) }}>
    {{ $slot }}
</button>
