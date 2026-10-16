@extends('layouts.login', ['class' => 'bg-default'])

@section('content')
<style>
    body {
        height: 100vh;
    }
    .main-content footer {
        display: none;
    }
    .bg-secondary {
        background-color: #f7fafca8 !important;
    }
    #togglePassword {
        cursor: pointer;

    }
    #login_container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
    }
    .copyright {
        text-align: center !important;
    }
    .wrap{ width:min(1040px, 100%); }

    .card{
      background: linear-gradient(180deg, rgb(255 255 255 / 67%), rgb(255 255 255));
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border: 1px solid rgba(255,255,255,.12);
      border-radius: var(--radius);
      padding: clamp(16px, 3vw, 40px);
      box-shadow: 0 10px 40px rgba(0,0,0,.25);
    }

    .logo{ display:inline-flex; align-items:center; gap:10px; text-decoration:none; color:var(--text); font-weight:700; letter-spacing:.2px; font-size:18px; }
    .logo img{ height:32px; width:auto; display:block; }
    .logo-mark{ width:36px; height:36px; border-radius:12px; display:grid; place-items:center; color:white; background: conic-gradient(from 30deg, var(--accent), var(--accent-2), var(--accent)); box-shadow: 0 8px 20px rgba(99,102,241,.45); }

    .headline{ font-size: clamp(26px, 5vw, 44px); line-height:1.15; margin:18px 0 12px; font-weight:800; }
    .sub{ font-size: clamp(15px, 2.4vw, 18px); color:var(--muted); margin: 0 0 22px; }

    .form{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
    .input{
      flex: 1 1 260px; min-width: 200px; height: 52px; border-radius: 14px; border:1px solid rgba(255,255,255,.18);
      padding: 0 14px; font-size:16px; color:var(--text); background: rgba(255,255,255,.06);
      outline: none; transition: box-shadow .2s, border-color .2s, background .2s;
    }
    .input::placeholder{ color: rgba(226,232,240,.7); }
    .input:focus{ box-shadow: 0 0 0 6px var(--ring); border-color: var(--accent); background: rgba(255,255,255,.1); }

    .btn{
      height:52px; padding:0 20px; border:none; border-radius:14px; cursor:pointer; font-weight:700;
      color:white; background: linear-gradient(90deg, var(--accent), var(--accent-2));
      box-shadow: 0 10px 20px rgba(2,6,23,.3);
      transition: transform .12s ease, box-shadow .12s ease, opacity .2s;
      flex: 0 0 auto;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 16px 26px rgba(2,6,23,.35); }
    .btn:active{ transform: translateY(0); box-shadow: 0 8px 16px rgba(2,6,23,.3); }

    .meta{ display:flex; gap:16px; align-items:center; flex-wrap:wrap; margin-top:18px; color: var(--muted); font-size:14px; }
    .socials{ margin-left:auto; display:flex; gap:10px; }
    .icon-btn{ width:40px; height:40px; display:grid; place-items:center; border-radius:12px; border:1px solid rgba(255,255,255,.15); background: rgba(255,255,255,.04); text-decoration:none; color:var(--text); }
    .icon-btn:hover{ border-color: rgba(255,255,255,.25); }

    footer{ text-align:center; opacity:.7; font-size:12px; margin-top:18px; }

    .stack{ display:flex; flex-direction:column; gap:18px; }
    .sr-only{ position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); white-space:nowrap; border:0; }

    /* ======= Responsiveness tweaks ======= */
    /* Tiny phones (<=360px) */
    @media (max-width: 360px){
      .headline{ font-size: 22px; }
      .sub{ font-size: 14px; }
      .card{ padding: 14px; border-radius: 18px; }
      .input, .btn{ height: 48px; }
    }

    /* Narrow devices: stack form vertically for comfort */
    @media (max-width: 420px){
      .form{ flex-direction: column; align-items: stretch; }
      .btn{ width: 100%; }
      .socials{ width: 100%; justify-content: center; margin-left: 0; }
      .meta{ justify-content: center; text-align: center; }
    }

    /* Tablets */
    @media (min-width: 768px){
      .wrap{ width:min(980px, 100%); }
      .headline{ font-size: clamp(34px, 4vw, 52px); }
      .sub{ font-size: clamp(16px, 1.8vw, 20px); }
    }

    /* Large desktops / ultrawide */
    @media (min-width: 1440px){
      body{ padding: 6vh calc(32px + env(safe-area-inset-left)) 6vh calc(32px + env(safe-area-inset-right)); }
      .wrap{ width:min(1200px, 100%); }
    }

    /* Short landscape screens (foldables/phones sideways) */
    @media (max-height: 540px) and (orientation: landscape){
      body{ padding: 12px; }
      .headline{ margin: 8px 0; }
      .meta{ margin-top: 10px; }
    }

    /* High-contrast / Windows forced-colors */
    @media (forced-colors: active){
      .card, .input, .icon-btn{ border: 1px solid ButtonText; }
      .btn{ forced-color-adjust: none; background: ButtonFace; color: ButtonText; }
    }

    /* Motion sensitivity */
    @media (prefers-reduced-motion: reduce){
      *{ transition: none !important; animation: none !important; }
    }
</style>

    {{-- @include('layouts.headers.guest') --}}

    <div class="container" id="login_container">
        <div class="row justify-content-center">
            <div class="col-lg-12 col-md-7">

                        <main class="wrap">
    <section class="card">
        <div class="text-center text-muted mb-4">
            <img src="{{ asset('argon') }}/img/encore/logo_dark.png" width="350px" />
        </div>

      <h1 class="headline text-center">We’re working on something awesome!</h1>
      <p class="sub text-center">Our site is under construction, but we’ll be live soon. Stay tuned!</p>

      {{-- <form class="form" action="https://formspree.io/f/your-id" method="POST">
        <input class="input" id="email" name="email" type="email" placeholder="Enter your email" required />
        <button class="btn" type="submit">Notify Me</button>
      </form> --}}

      <div class="meta d-flex justify-content-between align-items-center">
        <!-- Left Side -->
        <span>✨ Launching soon</span>

        <!-- Right Side -->
        <a href="https://wa.me/94778816299" target="_blank" style="color: #25D366; text-decoration: none;">
            <i class="fab fa-whatsapp"></i> Contact Admin
        </a>
    </div>

      {{-- <div class="socials">
        <a class="icon-btn" href="#" aria-label="Twitter">T</a>
        <a class="icon-btn" href="#" aria-label="Instagram">I</a>
        <a class="icon-btn" href="#" aria-label="LinkedIn">in</a>
      </div> --}}

    </section>
  </main>

            </div>
        </div>
    </div>


@endsection
