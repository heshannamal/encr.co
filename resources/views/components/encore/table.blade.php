@props(['caption' => null])

<div class="table-responsive" tabindex="0" role="region" aria-label="{{ $caption ?? __('Data table') }}">
    <table {{ $attributes->merge(['class' => 'table align-items-center']) }}>
        @if ($caption)
            <caption class="sr-only">{{ $caption }}</caption>
        @endif
        {{ $slot }}
    </table>
</div>
