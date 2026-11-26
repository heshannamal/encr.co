@props(['name', 'label', 'type' => 'text', 'value' => null, 'id' => null])

@php($fieldId = $id ?? $name)

<div class="form-group">
    <label for="{{ $fieldId }}">{{ $label }}</label>
    <input
        id="{{ $fieldId }}"
        name="{{ $name }}"
        type="{{ $type }}"
        @if (! in_array($type, ['password', 'file'], true)) value="{{ old($name, $value) }}" @endif
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
    >
    <x-encore.field-error :name="$name" />
</div>
