<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{
    --ec-black:#1f2327;
    --ec-black-2:#292e33;
    --ec-red:#e21b23;
    --ec-red-dark:#bd1118;
    --ec-green:#00bd6f;
    --ec-blue:#1769ff;
    --ec-bg:#f7f7f8;
    --ec-card:#ffffff;
    --ec-border:#e3e6e9;
    --ec-text:#252d34;
    --ec-muted:#78818a;
    --ec-shadow:0 6px 18px rgba(24,31,38,.08);
    --ec-sidebar:205px;
}
*{box-sizing:border-box}
html,body{min-height:100%}
body{margin:0;background:var(--ec-bg);color:var(--ec-text);font-family:'Open Sans',Arial,sans-serif;font-size:14px}
a{color:var(--ec-blue)}
.ec-app{min-height:100vh}
.ec-sidebar{position:fixed;inset:0 auto 0 0;width:var(--ec-sidebar);background:linear-gradient(180deg,#1d2226,#20262b);z-index:1035;color:#fff;display:flex;flex-direction:column;border-right:1px solid #31373d}
.ec-sidebar-brand{height:64px;display:flex;align-items:center;padding:10px 18px;border-bottom:1px solid rgba(255,255,255,.08)}
.ec-sidebar-brand img{display:block;max-width:150px;max-height:42px;filter:brightness(0) invert(1)}
.ec-sidebar-nav{padding:12px 9px;flex:1;overflow:auto}
.ec-nav-label{padding:18px 12px 7px;color:#8f9aa3;font-size:10px;text-transform:uppercase;letter-spacing:.12em;font-weight:800}
.ec-nav-link{display:flex;align-items:center;gap:12px;padding:10px 12px;margin:3px 0;border-radius:4px;color:#d3d9de;text-decoration:none;font-weight:600;font-size:13px;transition:.16s}
.ec-nav-link i{width:17px;text-align:center;color:#b9c3cb}
.ec-nav-link:hover{background:#2b3238;color:#fff}
.ec-nav-link.active{background:linear-gradient(90deg,var(--ec-red),#c9141b);color:#fff;box-shadow:0 5px 15px rgba(226,27,35,.28)}
.ec-nav-link.active i{color:#fff}
.ec-sidebar-help{padding:17px;border-top:1px solid rgba(255,255,255,.08);font-size:11px;color:#aeb8c0}
.ec-sidebar-help strong{color:#fff;display:block;margin-bottom:3px}
.ec-main{min-height:100vh;margin-left:var(--ec-sidebar);display:flex;flex-direction:column}
.ec-topbar{height:64px;background:#fff;border-bottom:1px solid var(--ec-border);display:flex;align-items:center;justify-content:space-between;padding:0 20px;position:sticky;top:0;z-index:1020}
.ec-topbar-left{display:flex;align-items:center;gap:14px}
.ec-menu-btn{border:0;background:transparent;width:36px;height:36px;color:#333;font-size:17px}
.ec-portal-title{font-size:17px;font-weight:600;color:#222;letter-spacing:.01em}
.ec-topbar-actions{display:flex;align-items:center;gap:13px}
.ec-cart-link{position:relative;width:38px;height:38px;display:flex;align-items:center;justify-content:center;color:#111;text-decoration:none;font-size:18px}
.ec-cart-count{position:absolute;right:-1px;top:-3px;min-width:17px;height:17px;border-radius:999px;background:var(--ec-red);color:#fff;font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 4px}
.ec-user-menu{display:flex;align-items:center;gap:9px;text-decoration:none;color:#222;font-weight:700;font-size:12px}
.ec-avatar{width:34px;height:34px;border-radius:50%;background:#e9edf1;display:flex;align-items:center;justify-content:center;overflow:hidden;border:2px solid #fff;box-shadow:0 0 0 1px #dfe3e6;color:#555;font-weight:800}
.ec-avatar img{width:100%;height:100%;object-fit:cover}
.ec-page{flex:1;padding:20px 18px 32px}
.ec-page-head{display:flex;justify-content:space-between;align-items:flex-end;gap:14px;margin-bottom:18px}
.ec-page-title{margin:0;font-size:26px;font-weight:800;color:#111;letter-spacing:-.03em}
.ec-page-subtitle{color:var(--ec-muted);margin-top:4px;margin-bottom:0;font-size:12px}
.ec-card{background:var(--ec-card);border:1px solid var(--ec-border);box-shadow:var(--ec-shadow);border-radius:12px}
.ec-card-body{padding:18px}
.ec-card-title{font-size:16px;font-weight:700;margin:0;color:#20262b}
.ec-stat{position:relative;background:#fff;border:1px solid var(--ec-border);border-radius:10px;padding:18px 18px 14px;box-shadow:var(--ec-shadow);overflow:hidden}
.ec-stat:after{content:"";position:absolute;right:-26px;top:-36px;width:90px;height:90px;border-radius:50%;background:rgba(226,27,35,.055)}
.ec-stat-label{font-size:12px;color:#69747d;font-weight:600;margin-bottom:7px}
.ec-stat-value{font-size:30px;line-height:1;font-weight:800;color:#111}
.ec-stat-icon{position:absolute;right:18px;top:18px;color:#707981;font-size:20px}
.ec-stat-more{position:absolute;right:16px;bottom:13px;border:1px solid #cfd5d9;background:#fff;color:#333;border-radius:4px;padding:4px 12px;text-decoration:none;font-weight:700;font-size:11px;z-index:2}
.ec-stat-more:hover{background:var(--ec-red);border-color:var(--ec-red);color:#fff}
.ec-btn{border:0;border-radius:4px;padding:10px 18px;font-size:12px;font-weight:700;display:inline-flex;align-items:center;justify-content:center;gap:7px;text-decoration:none;cursor:pointer;transition:.15s}
.ec-btn:hover{transform:translateY(-1px)}
.ec-btn-primary{background:linear-gradient(90deg,var(--ec-red),#c9151b);color:#fff;box-shadow:0 5px 12px rgba(226,27,35,.22)}
.ec-btn-primary:hover{color:#fff;background:var(--ec-red-dark)}
.ec-btn-dark{background:#303a42;color:#fff}.ec-btn-dark:hover{color:#fff;background:#1d252b}
.ec-btn-outline{background:#fff;color:#303940;border:1px solid #cdd4d9}.ec-btn-outline:hover{background:#f4f5f6;color:#111}
.ec-btn-danger{background:#fff;color:var(--ec-red);border:1px solid #f1a8ab}.ec-btn-danger:hover{background:var(--ec-red);color:#fff}
.ec-btn-success{background:var(--ec-green);color:#fff}.ec-btn-success:hover{color:#fff;background:#009b5b}
.ec-session-card{height:100%;background:#fff;border:1px solid var(--ec-border);border-radius:9px;box-shadow:0 4px 14px rgba(25,31,37,.06);padding:16px;display:flex;flex-direction:column;transition:.18s}
.ec-session-card:hover{transform:translateY(-3px);box-shadow:0 12px 25px rgba(25,31,37,.11);border-color:#cfd4d9}
.ec-session-top{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:11px}
.ec-session-date{display:flex;gap:8px;color:#4e5860;font-size:11px;font-weight:600}
.ec-session-date i{color:var(--ec-red);margin-top:2px}
.ec-session-title{font-size:15px;font-weight:800;color:#111;margin:4px 0 2px}
.ec-session-type{display:inline-block;background:#edf0f2;color:#46515a;border-radius:3px;padding:3px 7px;font-size:9px;font-weight:800;margin:6px 0 10px;text-transform:uppercase;letter-spacing:.04em}
.ec-session-meta{display:flex;align-items:flex-start;gap:7px;color:#68727a;font-size:11px;margin:5px 0;line-height:1.45}
.ec-session-meta i{width:13px;color:#4f5961;margin-top:2px;text-align:center}
.ec-session-actions{margin-top:auto;padding-top:14px;display:flex;align-items:center;justify-content:space-between;gap:10px}
.ec-spots{font-size:10px;font-weight:800;color:var(--ec-green)}
.ec-spots.full{color:var(--ec-red)}
.ec-badge{display:inline-flex;align-items:center;border-radius:3px;padding:4px 7px;font-size:9px;font-weight:800;text-transform:uppercase;letter-spacing:.035em}
.ec-badge-success{color:#07804d;background:#d8f6e9;border:1px solid #b7ebd5}
.ec-badge-warning{color:#9a6500;background:#fff5d7;border:1px solid #f1db8a}
.ec-badge-danger{color:#a51117;background:#ffe2e4;border:1px solid #f2b7ba}
.ec-badge-info{color:#1256ba;background:#dcecff;border:1px solid #b6d3f7}
.ec-badge-dark{color:#fff;background:#313a41}
.ec-empty{padding:45px 22px;text-align:center;color:#7a838b;border:1px dashed #cfd6da;border-radius:8px;background:#fbfbfc}
.ec-empty i{font-size:30px;color:#b3bbc1;margin-bottom:10px}
.ec-table-wrap{background:#fff;border:1px solid var(--ec-border);box-shadow:var(--ec-shadow);border-radius:10px;overflow:hidden}
.ec-table{width:100%;border-collapse:collapse;margin:0}
.ec-table th{padding:13px 14px;color:#59636b;font-size:10px;text-transform:uppercase;letter-spacing:.055em;border-bottom:1px solid #d8dde0;text-align:left}
.ec-table td{padding:14px;border-bottom:1px solid #e2e6e9;color:#555f67;font-size:12px;vertical-align:middle}
.ec-table tr:last-child td{border-bottom:0}
.ec-table a{text-decoration:none}
.ec-form-control,.ec-form-select{display:block;width:100%;height:42px;border:1px solid #ccd3d8;border-radius:5px;background:#fff;padding:9px 12px;font-size:12px;color:#2d353b;outline:0}
textarea.ec-form-control{height:auto;min-height:110px}
.ec-form-control:focus,.ec-form-select:focus{border-color:#65727c;box-shadow:0 0 0 3px rgba(65,77,86,.08)}
.ec-label{display:block;font-size:11px;font-weight:700;color:#3d464d;margin-bottom:7px}
.ec-footer{border-top:1px solid var(--ec-border);background:#fff;padding:18px 20px;text-align:center;color:#6f7980;font-size:11px}
.ec-package-card{height:100%;background:#fff;border:1px solid var(--ec-border);box-shadow:var(--ec-shadow);border-radius:10px;overflow:hidden;display:flex;flex-direction:column;transition:.18s}
.ec-package-card:hover{transform:translateY(-3px);box-shadow:0 12px 25px rgba(25,31,37,.12)}
.ec-package-visual{height:180px;background:radial-gradient(circle at 65% 30%,rgba(226,27,35,.28),transparent 30%),linear-gradient(135deg,#11161a,#292f34 60%,#970c13);position:relative;color:#fff;display:flex;align-items:center;justify-content:center;overflow:hidden}
.ec-package-visual:before,.ec-package-visual:after{content:"";position:absolute;background:rgba(255,255,255,.045);transform:rotate(-25deg)}
.ec-package-visual:before{width:70px;height:260px;left:10%}.ec-package-visual:after{width:35px;height:220px;right:15%}
.ec-package-number{font-size:70px;font-weight:800;line-height:.9;position:relative;z-index:2;text-align:center;text-shadow:0 6px 20px rgba(0,0,0,.3)}
.ec-package-number small{display:block;font-size:12px;letter-spacing:.22em;margin-top:10px}
.ec-package-body{padding:17px;display:flex;flex-direction:column;flex:1}
.ec-package-name{font-size:16px;font-weight:800;color:#111;margin-bottom:5px}
.ec-package-price{font-size:22px;font-weight:800;color:#111;margin:8px 0}
.ec-package-features{padding:0;margin:10px 0 16px;list-style:none;color:#626c74;font-size:11px}
.ec-package-features li{margin:7px 0;display:flex;gap:7px}.ec-package-features i{color:var(--ec-green);margin-top:2px}
.ec-auth{min-height:100vh;background:#f3f4f5;display:grid;grid-template-columns:minmax(340px,42%) 1fr}
.ec-auth-brand{position:relative;overflow:hidden;background:linear-gradient(145deg,#f6f6f6,#dedede);display:flex;align-items:center;justify-content:center;padding:50px}
.ec-auth-brand:before{content:"";position:absolute;width:420px;height:720px;background:linear-gradient(180deg,rgba(226,27,35,.15),rgba(0,0,0,.02));transform:rotate(25deg);right:-130px;top:-100px}
.ec-auth-brand-content{position:relative;z-index:2;width:100%;max-width:410px}
.ec-auth-logo{max-width:270px;height:auto;margin-bottom:50px}
.ec-auth-tagline{font-size:29px;line-height:1.2;font-weight:800;color:#111}.ec-auth-tagline span{color:var(--ec-red)}
.ec-auth-sport{height:260px;margin-top:35px;position:relative;border-bottom:4px solid #222;background:radial-gradient(ellipse at bottom,#c8c8c8,transparent 67%)}
.ec-auth-sport:after{content:"";position:absolute;width:120px;height:205px;right:20%;bottom:0;background:linear-gradient(155deg,#202429,#626970);clip-path:polygon(39% 0,60% 3%,68% 22%,84% 37%,70% 52%,79% 100%,54% 100%,49% 60%,29% 100%,5% 100%,29% 49%,16% 27%)}
.ec-auth-panel{display:flex;align-items:center;justify-content:center;padding:45px 25px;background:#fff}
.ec-auth-card{width:100%;max-width:440px}
.ec-auth-title{font-size:24px;font-weight:800;color:#111;margin-bottom:4px}
.ec-auth-subtitle{font-size:12px;color:#7b858d;margin-bottom:27px}
.ec-google-btn{width:100%;height:42px;border:1px solid #cbd2d7;border-radius:5px;background:#fff;color:#303940;font-weight:700;font-size:12px;display:flex;align-items:center;justify-content:center;gap:9px;text-decoration:none}
.ec-google-btn:hover{background:#f6f7f8;color:#111}
.ec-divider{display:flex;align-items:center;gap:12px;color:#949ba1;font-size:10px;margin:18px 0}.ec-divider:before,.ec-divider:after{content:"";height:1px;background:#e0e4e6;flex:1}
.ec-modal .modal-content{border:0;border-radius:7px;box-shadow:0 22px 60px rgba(0,0,0,.24)}
.ec-modal .modal-header{border-bottom:1px solid #e3e6e8;padding:16px 18px}.ec-modal .modal-title{font-size:15px;font-weight:800}
.ec-modal .modal-body{padding:18px}.ec-modal .modal-footer{padding:13px 18px;border-top:1px solid #e3e6e8}
.ec-stepper{display:flex;align-items:center;margin-bottom:20px}.ec-step{display:flex;align-items:center;gap:7px;color:#828b92;font-size:10px;font-weight:700}.ec-step span{width:22px;height:22px;border-radius:50%;border:1px solid #cbd1d5;display:flex;align-items:center;justify-content:center}.ec-step.active{color:#111}.ec-step.active span{background:var(--ec-red);border-color:var(--ec-red);color:#fff}.ec-step-line{height:1px;background:#d9dddf;flex:1;margin:0 10px}
.ec-position{display:inline-flex;margin:0 6px 7px 0}.ec-position input{display:none}.ec-position label{border:1px solid #cbd2d7;border-radius:4px;padding:7px 11px;font-size:10px;font-weight:700;color:#4b555d;cursor:pointer}.ec-position input:checked+label{background:var(--ec-red);border-color:var(--ec-red);color:#fff}
.ec-credit-bar{height:7px;background:#eceff1;border-radius:10px;overflow:hidden}.ec-credit-bar span{display:block;height:100%;background:linear-gradient(90deg,var(--ec-red),#ff5f64)}
.ec-tabs{border-bottom:1px solid #dce0e3;margin-bottom:18px;display:flex;gap:24px}.ec-tabs .nav-link{border:0;border-bottom:2px solid transparent;color:#5e6870;padding:10px 0;font-size:11px;font-weight:700;background:transparent}.ec-tabs .nav-link.active{color:var(--ec-red);border-bottom-color:var(--ec-red)}
@media(max-width:991px){
    .ec-sidebar{transform:translateX(-100%);transition:.2s}.ec-sidebar.open{transform:translateX(0)}
    .ec-main{margin-left:0}.ec-portal-title{font-size:14px}.ec-page{padding:15px 12px}.ec-auth{grid-template-columns:1fr}.ec-auth-brand{display:none}
}
@media(max-width:575px){.ec-user-name{display:none}.ec-topbar{padding:0 10px}.ec-page-title{font-size:22px}.ec-card-body{padding:14px}.ec-auth-panel{padding:25px 16px}}
</style>
