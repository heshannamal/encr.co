@php
    $bookingChildren = isset($children) ? $children : collect();
    $defaultBookAction = isset($sessions) && $sessions->count() ? route('em.customer.session.book', $sessions->first()->id) : '#';
@endphp
<div class="modal fade ec-modal" id="bookSessionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" id="bookSessionForm" action="{{ $defaultBookAction }}">
                @csrf
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title">Book Session</h5>
                        <div class="small text-muted" id="bookSessionName">Complete player information.</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="ec-stepper">
                        <div class="ec-step active"><span>1</span> Player Info</div>
                        <div class="ec-step-line"></div>
                        <div class="ec-step"><span>2</span> Confirm</div>
                    </div>
                    @if($bookingChildren->count())
                        <div class="mb-3">
                            <label class="ec-label">Select Saved Player <span class="text-muted fw-normal">(Optional)</span></label>
                            <select class="ec-form-select" id="existingChildSelect" name="child_id">
                                <option value="">Add a new player</option>
                                @foreach($bookingChildren as $child)
                                    <option value="{{ $child->id }}"
                                            data-first="{{ $child->player_first }}"
                                            data-last="{{ $child->player_last }}"
                                            data-grad="{{ $child->grad_year }}"
                                            data-positions='@json(is_array($child->positions) ? $child->positions : [])'>
                                        {{ $child->player_first }} {{ $child->player_last }}{{ $child->grad_year ? ' · ' . $child->grad_year : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="child_id" value="">
                    @endif
                    <div class="row g-3" id="newPlayerFields">
                        <div class="col-md-6">
                            <label class="ec-label">Player First <span class="text-danger">*</span></label>
                            <input class="ec-form-control" id="playerFirstInput" name="player_first" value="{{ old('player_first') }}" placeholder="Enter first name">
                        </div>
                        <div class="col-md-6">
                            <label class="ec-label">Player Last <span class="text-danger">*</span></label>
                            <input class="ec-form-control" id="playerLastInput" name="player_last" value="{{ old('player_last') }}" placeholder="Enter last name">
                        </div>
                        <div class="col-md-6">
                            <label class="ec-label">Grad Year <span class="text-danger">*</span></label>
                            <select class="ec-form-select" id="gradYearInput" name="grad_year">
                                <option value="">Select graduation year</option>
                                @for($year = (int)date('Y'); $year <= (int)date('Y') + 15; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="ec-label">Position <span class="text-danger">*</span> <span class="text-muted fw-normal">(select all that apply)</span></label>
                            <div>
                                @foreach(['Attack','Middie','Defense','Goalie'] as $position)
                                    <span class="ec-position">
                                        <input type="checkbox" name="positions[]" value="{{ $position }}" id="position_{{ strtolower($position) }}">
                                        <label for="position_{{ strtolower($position) }}">{{ $position }}</label>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="bookingFormErrors" class="alert alert-danger mt-3 mb-0 d-none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="ec-btn ec-btn-outline" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="ec-btn ec-btn-primary" id="confirmBookButton">Book Session</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade ec-modal" id="noCreditsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body py-5 px-4">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle" style="width:58px;height:58px;background:#ffe4e5;color:#d8171f;font-size:24px">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <h4 class="fw-bold">You don't have enough credits</h4>
                <p class="text-muted mb-4">Please buy a package before booking this session.</p>
                <a href="{{ route('em.customer.packages') }}" class="ec-btn ec-btn-primary">Go to Packages</a>
            </div>
        </div>
    </div>
</div>
