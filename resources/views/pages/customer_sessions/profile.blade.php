@extends('pages.customer_sessions.layout')
@section('title','My Profile | Encore Fitness')
@section('content')
<div class="ec-page-head"><div><h1 class="ec-page-title">My Profile</h1><p class="ec-page-subtitle">Manage profile information and view saved child.</p></div></div>
<ul class="nav ec-tabs" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profileInformation" type="button">Parent Profile</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#myPlayers" type="button">My Child</button></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade show active" id="profileInformation">
        <div class="ec-card"><div class="ec-card-body">
            <form method="POST" action="{{ route('em.customer.profile.update') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-lg-3 text-center">
                        @php
                            $photo = $customer->profile_photo;
                            $photoUrl = $photo ? (\Illuminate\Support\Str::startsWith($photo,['http://','https://']) ? $photo : asset('storage/' . ltrim($photo,'/'))) : null;
                        @endphp
                        <div class="ec-avatar mx-auto mb-3" style="width:110px;height:110px;font-size:36px">
                            @if($photoUrl)<img src="{{ $photoUrl }}" alt="{{ $customer->name }}">@else{{ strtoupper(substr($customer->name,0,1)) }}@endif
                        </div>
                        <label class="ec-btn ec-btn-outline"><i class="fa-regular fa-image"></i>Change Photo<input type="file" name="profile_photo" accept="image/*" hidden></label>
                    </div>
                    <div class="col-lg-9">
                        <div class="row g-3">
                            <div class="col-md-6"><label class="ec-label">First Name</label><input class="ec-form-control" name="first_name" value="{{ old('first_name',$customer->first_name) }}"></div>
                            <div class="col-md-6"><label class="ec-label">Last Name</label><input class="ec-form-control" name="last_name" value="{{ old('last_name',$customer->last_name) }}"></div>
                            <div class="col-md-6"><label class="ec-label">Email Address</label><input type="email" class="ec-form-control" name="email" value="{{ old('email',$customer->email) }}"></div>
                            <div class="col-md-6"><label class="ec-label">Phone</label><input class="ec-form-control" name="phone" value="{{ old('phone',$customer->phone) }}"></div>
                        </div>
                        <button type="submit" class="ec-btn ec-btn-primary mt-4">Update Profile</button>
                    </div>
                </div>
            </form>
        </div></div>
    </div>
    <div class="tab-pane fade" id="myPlayers">
        <div class="row g-3">
            @forelse($children as $child)
                <div class="col-lg-6">
                    <div class="ec-card"><div class="ec-card-body d-flex align-items-center gap-3">
                        <div class="ec-avatar" style="width:54px;height:54px"><i class="fa-solid fa-user"></i></div>
                        <div class="flex-grow-1"><strong class="d-block text-dark">{{ $child->player_first }} {{ $child->player_last }}</strong><div class="small text-muted">Grad Year: {{ $child->grad_year ?: '-' }}</div><div class="small text-muted">Position: {{ is_array($child->positions) ? implode(', ',$child->positions) : '-' }}</div></div>
                    </div></div>
                </div>
            @empty
                <div class="col-12"><div class="ec-empty"><i class="fa-solid fa-users"></i><h5>No saved players</h5><p>Players are saved automatically when you complete a session booking.</p></div></div>
            @endforelse
        </div>
    </div>
</div>
@endsection
