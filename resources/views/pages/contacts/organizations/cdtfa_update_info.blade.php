@if ($organization->usesCaliforniaSalesTax() && $organization->cdtfa_updated_at)
    <span class="cdtfa-update-info">
        <button type="button" class="cdtfa-update-icon" aria-label="Automatic sales tax update details" aria-describedby="cdtfa-update-details">
            <i class="fas fa-info-circle" aria-hidden="true"></i>
        </button>
        <span class="cdtfa-update-popover" id="cdtfa-update-details" role="tooltip">
            <strong>Automatic sales tax update</strong>
            <span class="cdtfa-update-body">
                This organization's sales tax was automatically updated from CDTFA.<br>
                Previous rate {{ $organization->cdtfa_previous_rate === null ? 'Not set' : rtrim(rtrim(number_format($organization->cdtfa_previous_rate, 5, '.', ''), '0'), '.').'%' }}<br>
                Updated rate {{ rtrim(rtrim(number_format($organization->cdtfa_updated_rate, 5, '.', ''), '0'), '.') }}%<br>
                Updated {{ \Carbon\Carbon::parse($organization->cdtfa_updated_at)->timezone($user_timezone ?? config('app.timezone'))->format('m/d/Y h:i A') }}
            </span>
        </span>
    </span>
    <style>
        .cdtfa-update-info { position: relative; display: inline-block; margin-left: 6px; }
        .cdtfa-update-icon { padding: 0 2px; border: 0; background: transparent; color: #9b9200; cursor: pointer; }
        .cdtfa-update-icon:focus-visible { outline: 2px solid #454372; outline-offset: 2px; }
        .cdtfa-update-popover { display: none; position: absolute; bottom: calc(100% + 10px); left: 50%; transform: translateX(-50%); width: 276px; max-width: 80vw; white-space: normal; background: white; color: #657199; border-radius: 8px; box-shadow: 0 8px 30px #0003; z-index: 1060; font-size: 14px; line-height: 1.5; font-weight: normal; text-align: left; }
        .cdtfa-update-popover::after { content: ''; position: absolute; top: 100%; left: calc(50% - 10px); border: 10px solid transparent; border-top-color: white; }
        .cdtfa-update-popover strong { display: block; padding: 9px 15px; border-bottom: 1px solid #eee; color: #454372; font-size: 16px; font-weight: 600; }
        .cdtfa-update-body { display: block; padding: 10px 15px; }
        .cdtfa-update-info:hover .cdtfa-update-popover, .cdtfa-update-info:focus-within .cdtfa-update-popover { display: block; }
    </style>
@endif
