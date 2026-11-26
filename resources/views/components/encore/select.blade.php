@props(['name', 'label', 'options' => [], 'value' => null, 'multiple' => false, 'searchable' => true, 'id' => null, 'placeholder' => 'Select an option'])

@php
    $fieldId = $id ?? $name;
    $selected = array_map('strval', (array) old($name, $value));
@endphp

<div class="form-group">
    <label for="{{ $fieldId }}">{{ $label }}</label>
    <select id="{{ $fieldId }}" name="{{ $name }}{{ $multiple ? '[]' : '' }}"
        @if ($multiple) multiple @endif
        @if ($searchable) data-encore-select @endif
        @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $name }}-error" @endif
        {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>
        @unless ($multiple)
            <option value="">{{ __($placeholder) }}</option>
        @endunless
        @foreach ($options as $key => $option)
            <option value="{{ $key }}" @if (in_array((string) $key, $selected, true)) selected @endif>{{ $option }}</option>
        @endforeach
    </select>
    <x-encore.field-error :name="$name" />
</div>
