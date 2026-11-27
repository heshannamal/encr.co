@props(['caption' => null, 'interactive' => false])

<div class="table-responsive encore-table-region" tabindex="0" role="region" aria-label="{{ $caption ?? __('Data table') }}">
    <table @if ($interactive) data-encore-table @endif {{ $attributes->merge(['class' => 'table align-items-center']) }}>
        @if ($caption)
            <caption class="sr-only">{{ $caption }}</caption>
        @endif
        {{ $slot }}
    </table>
</div>
