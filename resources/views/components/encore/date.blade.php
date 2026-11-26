@props(['name', 'label', 'value' => null])

<x-encore.input :name="$name" :label="$label" :value="$value" type="date" {{ $attributes }} />
