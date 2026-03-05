<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Admin') — AIS DTS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html{scroll-behavior:smooth;}body{height:100%;}
        :root{--r9:#7f1d1d;--r8:#991b1b;--r7:#b91c1c;--r6:#dc2626;--rl:#fee2e2;--rll:#fff5f5;}
        *{font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;}
        body{background:#f4f4f6;}
        /* SIDEBAR */
        #adminSidebar{
            width:260px;background:linear-gradient(135deg,#450a0a,var(--r9));
            position:fixed;inset-y:0;left:0;z-index:30;display:flex;flex-direction:column;
            box-shadow:4px 0 24px rgba(0,0,0,0.35);transition:transform 0.3s cubic-bezier(.4,0,.2,1);
            height:100vh;
        }
        .sb-brand{padding:1.5rem 1.25rem;border-bottom:1px solid rgba(255,255,255,0.08);}
        .sb-logo{width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--r8),var(--r6));display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;box-shadow:0 4px 12px rgba(185,28,28,0.5);}
        nav{flex:1;padding:1rem 0.875rem;overflow-y:auto;}
        .nav-section{font-size:0.6rem;font-weight:700;color:rgba(255,255,255,0.25);letter-spacing:0.1em;text-transform:uppercase;padding:0 0.5rem;margin-bottom:0.375rem;}
        .nav-gap{margin-top:1.25rem;}
        .ni{display:flex;align-items:center;gap:0.875rem;padding:0.75rem 1rem;border-radius:0.5rem;font-size:0.875rem;font-weight:600;transition:all 0.2s;text-decoration:none;margin-bottom:0.25rem; border: 1px solid transparent;}
        .ni.on{background:linear-gradient(90deg, var(--r6), var(--r7));color:#fff;box-shadow:0 4px 15px -3px rgba(220,38,38,0.5); font-weight:700;}
        .ni:not(.on){color:rgba(255,255,255,0.6);}
        .ni:not(.on):hover{background:rgba(255,255,255,0.1);color:#fff;transform:translateX(4px);}
        .ni svg{width:1.25rem;height:1.25rem;flex-shrink:0; opacity: 0.7;}
        .ni.on svg, .ni:hover svg {opacity: 1;}

        .badge-pill{margin-left:auto;background:#ef4444;color:#fff;font-size:0.6rem;font-weight:700;padding:0.1rem 0.45rem;border-radius:9999px;}
        .sb-footer{padding:0.875rem;border-top:1px solid rgba(255,255,255,0.07);
        margin-top:auto;
        }
        .user-chip{display:flex;align-items:center;gap:0.625rem;background:rgba(255,255,255,0.06);border-radius:0.625rem;padding:0.625rem 0.75rem;}
        .avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--r8),var(--r6));display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:800;flex-shrink:0;}
        /* HEADER */
        #adminHeader{background:rgba(255,255,255,0.9);backdrop-filter:blur(12px);border-bottom:1px solid rgba(0,0,0,0.05);position:sticky;top:0;z-index:20;}
        .hdr-inner{display:flex;align-items:center;justify-content:space-between;padding:0.6875rem 1.5rem;}
        .hdr-logo-sm{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--r8),var(--r6));display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;}
        
        .sb-logout-btn{width:100%;display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.75rem;background:rgba(0,0,0,0.2);border:1px solid rgba(255,255,255,0.05);color:rgba(255,255,255,0.6);border-radius:0.75rem;font-size:0.75rem;font-weight:600;cursor:pointer;transition:all 0.2s;font-family:inherit;margin-top:1rem;}
        .sb-logout-btn:hover{background:rgba(220,38,38,0.2);color:#fff;border-color:rgba(220,38,38,0.4);box-shadow:0 4px 12px rgba(0,0,0,0.2);}
        
        /* MAIN */
        .ml-sidebar{margin-left:260px;}
        /* STATUS BADGES */
        .sb-pending{background:#fef9c3;color:#854d0e;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-routed{background:#dbeafe;color:#1e40af;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-deferred{background:#fee2e2;color:#991b1b;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-approved{background:#dcfce7;color:#166534;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-received{background:#f1f5f9;color:#475569;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        /* ALERT */
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #22c55e;border-radius:0.75rem;padding:0.875rem 1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.625rem;}
        .alert-error{background:var(--rll);border:1px solid #fecaca;border-left:4px solid var(--r6);border-radius:0.75rem;padding:0.875rem 1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.625rem;}
        /* RESPONSIVE */
        #sbOverlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:25;}
        @media(max-width:1023px){
            #adminSidebar{transform:translateX(-100%);}
            #adminSidebar.open{transform:translateX(0);}
            #sbOverlay.show{display:block;}
            .ml-sidebar{margin-left:0;}
            #menuBtn{display:flex !important;}
            #hdrName{display:none !important;}
        }
        #menuBtn{display:none;background:none;border:none;cursor:pointer;padding:0.375rem;border-radius:0.5rem;color:#64748b;align-items:center;}
        #menuBtn:hover{background:#f1f5f9;}
        .table-wrap{overflow-x:auto;background:#fff;border:1px solid #e2e8f0;border-top:3px solid var(--r6);border-radius:0.75rem;box-shadow:0 4px 6px -1px rgba(0,0,0,0.05);margin-bottom:1.5rem;}
        table{width:100%;border-collapse:collapse;}
        th{background:#f8fafc;padding:0.75rem 1.25rem;text-align:left;font-size:0.7rem;font-weight:700;color:#64748b;letter-spacing:0.05em;text-transform:uppercase;border-bottom:1px solid #e2e8f0;}
        td{padding:0.875rem 1.25rem;font-size:0.875rem;color:#334155;border-bottom:1px solid #f1f5f9;}
        tr:last-child td{border-bottom:none;}
        tr:hover td{background:#f8fafc;}
        /* MODAL */
        .modal-bg{position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:50;display:none;align-items:center;justify-content:center;padding:1rem;}
        .modal-bg.open{display:flex;}
        .modal-card{background:#fff;border-radius:1.25rem;box-shadow:0 24px 60px rgba(0,0,0,0.35);width:100%;max-width:520px;max-height:90vh;overflow-y:auto;}
        .modal-header{padding:1.25rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;}
        .modal-body{padding:1.5rem;}
        .detail-row{display:grid;grid-template-columns:140px 1fr;gap:0.5rem;padding:0.625rem 0;border-bottom:1px solid #f8fafc;}
        .detail-row:last-child{border-bottom:none;}
        .detail-label{font-size:0.75rem;font-weight:700;color:#94a3b8;letter-spacing:0.04em;text-transform:uppercase;padding-top:1px;}
        .detail-value{font-size:0.875rem;color:#1e293b;font-weight:500;}
    </style>
</head>
<body>

<div id="sbOverlay" onclick="closeSB()"></div>

<!-- SIDEBAR -->
<aside id="adminSidebar">
    <div class="sb-brand">
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <div class="sb-logo">
        <img src="{{ asset('images/ais-logo.png') }}" alt="AIS" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div>
                <p style="font-size:0.8rem;font-weight:800;color:#fff;line-height:1.2;">DocTrack-AIS</p>
                <p style="font-size:0.68rem;color:rgba(255,255,255,0.35);font-weight:500;">Admin Panel</p>
            </div>
        </div>
    </div>

    <nav>
        <p class="nav-section">Main</p>
        <a href="{{ route('admin.dashboard') }}" class="ni {{ request()->routeIs('admin.dashboard') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 13a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.users') }}" class="ni {{ request()->routeIs('admin.users') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Manage Users
        </a>

        <p class="nav-section nav-gap">Documents</p>
        <a href="{{ route('admin.documents') }}" class="ni {{ request()->routeIs('admin.documents') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            All Documents
        </a>
        <a href="{{ route('admin.pending') }}" class="ni {{ request()->routeIs('admin.pending') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pending
            @php $pc = \App\Models\Document::where('status','pending')->count(); @endphp
            @if($pc > 0)<span class="badge-pill">{{ $pc }}</span>@endif
        </a>
        <a href="{{ route('admin.deferred') }}" class="ni {{ request()->routeIs('admin.deferred') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            Deferred
            @php $dc = \App\Models\Document::where('status','deferred')->count(); @endphp
            @if($dc > 0)<span class="badge-pill">{{ $dc }}</span>@endif
        </a>
        <a href="{{ route('admin.audit-logs') }}" class="ni {{ request()->routeIs('admin.audit-logs') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            Audit Logs
        </a>
    </nav>

    <div class="sb-footer">
        <div class="user-chip">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div style="overflow:hidden;flex:1;">
                <p style="color:#fff;font-size:0.75rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</p>
                <p style="color:rgba(255,255,255,0.35);font-size:0.65rem;">Administrator</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout-btn">
                <svg style="width:0.875rem;height:0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Logout
            </button>
        </form>
    </div>
</aside>

<!-- MAIN -->
<div class="ml-sidebar flex flex-col min-h-screen">

    <!-- HEADER -->
    <header id="adminHeader">
        <div class="hdr-inner">
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <button id="menuBtn" onclick="openSB()">
                    <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="hdr-logo-sm">
                    {{-- <img src="{{ asset('images/ais-logo.png') }}" alt="AIS" style="width:100%;height:100%;object-fit:cover;"> --}}
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                </div>
                <div>
                    <p style="font-size:0.875rem;font-weight:700;color:#0f172a;">@yield('page-title','Dashboard')</p>
                    <p style="font-size:0.7rem;color:#94a3b8;line-height:1.2;">Ambalayat Integrated School</p>
                </div>
            </div>
            <div class="hidden sm:flex items-center gap-3 text-right">
                <div id="time-container">
                    <p id="timeDisplay" class="font-semibold text-gray-800 text-sm leading-tight"></p>
                    <p id="dateDisplay" class="text-xs text-gray-500"></p>
                </div>
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="flex-1 p-6 overflow-y-auto">
        @if(session('success'))
        <div class="alert-success">
            <svg style="width:1.125rem;height:1.125rem;color:#16a34a;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p style="font-size:0.875rem;color:#15803d;font-weight:500;">{{ session('success') }}</p>
        </div>
        @endif
        @if(session('error'))
        <div class="alert-error">
            <svg style="width:1.125rem;height:1.125rem;color:#dc2626;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p style="font-size:0.875rem;color:#dc2626;font-weight:500;">{{ session('error') }}</p>
        </div>
        @endif
        @yield('content')
    </main>
</div>

<script>
    const sb=document.getElementById('adminSidebar'),ov=document.getElementById('sbOverlay');
    function openSB(){sb.classList.add('open');ov.classList.add('show');}
    function closeSB(){sb.classList.remove('open');ov.classList.remove('show');}
    window.addEventListener('resize',()=>{ if(window.innerWidth>=1024){sb.classList.remove('open');ov.classList.remove('show');} });

    function updateTime() {
        const now = new Date();
        const timeOptions = { hour: 'numeric', minute: '2-digit', second: '2-digit', hour12: true, timeZone: 'Asia/Manila' };
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', timeZone: 'Asia/Manila' };
        
        const timeEl = document.getElementById('timeDisplay');
        const dateEl = document.getElementById('dateDisplay');

        if (timeEl) timeEl.textContent = now.toLocaleTimeString('en-US', timeOptions);
        if (dateEl) dateEl.textContent = now.toLocaleDateString('en-US', dateOptions);
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
@stack('scripts')
</body>
</html>