@props(['name'])

@error($name)
    <span {{ $attributes->merge(['class' => 'invalid-feedback d-block', 'id' => $name.'-error']) }} role="alert">
        <strong>{{ $message }}</strong>
    </span>
@enderror
