<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Dashboard') — AIS DTS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html{scroll-behavior:smooth;}body{height:100%;}
        :root{--r9:#7f1d1d;--r8:#991b1b;--r7:#b91c1c;--r6:#dc2626;--rl:#fee2e2;--rll:#fff5f5;}
        *{font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box;}
        body{background:#f4f4f6;}
        #userSidebar{width:260px;background:linear-gradient(135deg,#450a0a,var(--r9));position:fixed;inset-y:0;left:0;z-index:30;display:flex;flex-direction:column;box-shadow:4px 0 24px rgba(0,0,0,0.35);transition:transform 0.3s cubic-bezier(.4,0,.2,1); height:100vh;}
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
        .ni-submit{background:rgba(252, 165, 165, 0.1); color: #fca5a5; border: 1px solid rgba(220,38,38,0.3);}
        .ni-submit:hover{background:rgba(220,38,38,0.7);color:#fff; border-color: transparent;}
        .ni-submit.on { background: var(--r6); color: #fff; }
        .sb-footer{padding:0.875rem;border-top:1px solid rgba(255,255,255,0.07);
        margin-top:auto;
        }
        .user-chip{display:flex;align-items:center;gap:0.625rem;background:rgba(255,255,255,0.06);border-radius:0.625rem;padding:0.625rem 0.75rem;}
        .edit-profile-btn{color:rgba(255,255,255,0.5);padding:0.25rem;border-radius:0.375rem;transition:all 0.2s;}
        .edit-profile-btn:hover{color:#fff;background:rgba(255,255,255,0.1);}
        .avatar{width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,var(--r8),var(--r6));display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.7rem;font-weight:800;flex-shrink:0;}
        #adminHeader{background:rgba(255,255,255,0.9);backdrop-filter:blur(12px);border-bottom:1px solid rgba(0,0,0,0.05);position:sticky;top:0;z-index:20;}
        .hdr-inner{display:flex;align-items:center;justify-content:space-between;padding:0.6875rem 1.5rem;}
        .hdr-logo-sm{width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,var(--r8),var(--r6));display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;}
        
        .sb-logout-btn{width:100%;display:flex;align-items:center;justify-content:center;gap:0.5rem;padding:0.75rem;background:rgba(0,0,0,0.2);border:1px solid rgba(255,255,255,0.05);color:rgba(255,255,255,0.6);border-radius:0.75rem;font-size:0.75rem;font-weight:600;cursor:pointer;transition:all 0.2s;font-family:inherit;margin-top:1rem;}
        .sb-logout-btn:hover{background:rgba(220,38,38,0.2);color:#fff;border-color:rgba(220,38,38,0.4);box-shadow:0 4px 12px rgba(0,0,0,0.2);}
        .logout-icon{background:none;border:none;color:rgba(255,255,255,0.5);cursor:pointer;padding:0;transition:all 0.2s;display:flex;align-items:center;justify-content:center;}
        .logout-icon:hover{color:#fff;transform:translateX(2px);}
        
        .ml-sidebar{margin-left:260px;}
        .sb-pending{background:#fef9c3;color:#854d0e;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-routed{background:#dbeafe;color:#1e40af;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-deferred{background:#fee2e2;color:#991b1b;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-approved{background:#dcfce7;color:#166534;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .sb-received{background:#f1f5f9;color:#475569;padding:0.2rem 0.625rem;border-radius:9999px;font-size:0.7rem;font-weight:600;}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #22c55e;border-radius:0.75rem;padding:0.875rem 1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.625rem;}
        .alert-error{background:var(--rll);border:1px solid #fecaca;border-left:4px solid var(--r6);border-radius:0.75rem;padding:0.875rem 1rem;margin-bottom:1.25rem;display:flex;align-items:center;gap:0.625rem;}
        #sbOverlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,0.55);z-index:25;}
        @media(max-width:1023px){
            #userSidebar{transform:translateX(-100%);}
            #userSidebar.open{transform:translateX(0);}
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
        /* LOGOUT MODAL */
        #logoutModal{position:fixed;inset:0;background:rgba(0,0,0,0.55);backdrop-filter:blur(4px);z-index:100;display:none;align-items:center;justify-content:center;padding:1rem;}
        #logoutModal.open{display:flex;}
        .logout-modal-card{background:#fff;border-radius:1.25rem;box-shadow:0 24px 60px rgba(0,0,0,0.3);width:100%;max-width:380px;overflow:hidden;animation:modalIn 0.2s ease;}
        @keyframes modalIn{from{opacity:0;transform:scale(0.95) translateY(8px);}to{opacity:1;transform:scale(1) translateY(0);}}
        .logout-modal-icon{width:56px;height:56px;border-radius:50%;background:#fee2e2;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;}
        .logout-btn-cancel{flex:1;padding:0.7rem;border:1px solid #e2e8f0;border-radius:0.625rem;background:#fff;color:#475569;font-size:0.875rem;font-weight:600;cursor:pointer;transition:all 0.2s;font-family:inherit;}
        .logout-btn-cancel:hover{background:#f8fafc;border-color:#cbd5e1;}
        .logout-btn-confirm{flex:1;padding:0.7rem;border:none;border-radius:0.625rem;background:linear-gradient(135deg,#dc2626,#b91c1c);color:#fff;font-size:0.875rem;font-weight:600;cursor:pointer;transition:all 0.2s;font-family:inherit;box-shadow:0 4px 12px rgba(220,38,38,0.3);}
        .logout-btn-confirm:hover{background:linear-gradient(135deg,#b91c1c,#991b1b);box-shadow:0 6px 16px rgba(220,38,38,0.4);}
    </style>
</head>
<body>
<div id="sbOverlay" onclick="closeSB()"></div>

<!-- LOGOUT CONFIRMATION MODAL -->
<div id="logoutModal" onclick="if(event.target===this)closeLogoutModal()">
    <div class="logout-modal-card">
        <div style="padding:2rem 1.75rem 1.5rem;text-align:center;">
            <div class="logout-modal-icon">
                <svg fill="none" stroke="#dc2626" viewBox="0 0 24 24" style="width:28px;height:28px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </div>
            <p style="font-size:1.125rem;font-weight:700;color:#0f172a;margin-bottom:0.5rem;">Confirm Logout</p>
            <p style="font-size:0.875rem;color:#64748b;line-height:1.6;">Are you sure you want to log out? Any unsaved changes will be lost.</p>
        </div>
        <div style="display:flex;gap:0.75rem;padding:0 1.75rem 1.75rem;">
            <button class="logout-btn-cancel" onclick="closeLogoutModal()">Cancel</button>
            <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                @csrf
                <button type="submit" class="logout-btn-confirm" style="width:100%;">Yes, Logout</button>
            </form>
        </div>
    </div>
</div>

<!-- SIDEBAR -->
<aside id="userSidebar">
    <div class="sb-brand">
        <div style="display:flex;align-items:center;gap:0.75rem;">
            <div class="sb-logo">
                <img src="{{ asset('images/ais-logo.png') }}" alt="AIS" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div>
                <p style="font-size:0.8rem;font-weight:800;color:#fff;line-height:1.2;">DocTrack-AIS</p>
                <p style="font-size:0.68rem;color:rgba(255,255,255,0.35);font-weight:500;">Staff Portal</p>
            </div>
        </div>
    </div>

    <nav>
        <p class="nav-section">Main</p>
        <a href="{{ route('user.dashboard') }}" class="ni {{ request()->routeIs('user.dashboard') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Home
        </a>
        <a href="{{ route('user.documents') }}" class="ni {{ request()->routeIs('user.documents') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            My Documents
        </a>

        <p class="nav-section nav-gap">Track Status</p>
        <a href="{{ route('user.routed') }}" class="ni {{ request()->routeIs('user.routed') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            Routed / Incoming
            @php $urc = \App\Models\Document::where('submitted_by', auth()->id())->where('status','routed')->count(); @endphp
            @if($urc > 0)<span class="badge-pill">{{ $urc }}</span>@endif
        </a>
        <a href="{{ route('user.pending') }}" class="ni {{ request()->routeIs('user.pending') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Pending
            @php $upc = \App\Models\Document::where('submitted_by', auth()->id())->where('status','pending')->count(); @endphp
            @if($upc > 0)<span class="badge-pill">{{ $upc }}</span>@endif
        </a>
        <a href="{{ route('user.deferred') }}" class="ni {{ request()->routeIs('user.deferred') ? 'on' : '' }}">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
            Deferred
            @php $udc = \App\Models\Document::where('submitted_by', auth()->id())->where('status','deferred')->count(); @endphp
            @if($udc > 0)<span class="badge-pill">{{ $udc }}</span>@endif
        </a>
        <div style="margin-top:1.25rem;">
            <a href="{{ route('user.submit') }}" class="ni ni-submit {{ request()->routeIs('user.submit') ? 'on' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Submit New Document
            </a>
        </div>
    </nav>

    <div class="sb-footer">
        <div class="user-chip">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
            <div style="overflow:hidden;flex:1;">
                <p style="color:#fff;font-size:0.75rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</p>
                <p style="color:rgba(255,255,255,0.35);font-size:0.65rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->position ?? 'Staff' }}</p>
            </div>
            <button onclick="openProfileModal()" class="edit-profile-btn" title="Edit Profile" style="background:transparent;border:none;cursor:pointer;">
                <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('logout') }}" id="userLogoutForm" style="display:none;">
            @csrf
        </form>
        <button type="button" class="sb-logout-btn" onclick="openLogoutModal()">
            <svg style="width:0.875rem;height:0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Logout
        </button>
    </div>
</aside>

<!-- MAIN -->
<div class="ml-sidebar flex flex-col min-h-screen">
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

<!-- View Document Modal -->
<div id="docModal" class="modal-bg" onclick="if(event.target===this)closeModal()">
    <div class="modal-card">
        <div class="modal-header">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Document Details</p>
                <p class="text-lg font-bold text-slate-800" id="mTracking"></p>
            </div>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <div id="mStatus" class="mb-4 inline-block"></div>
            <div class="space-y-3">
                <div class="detail-row"><div class="detail-label">Type</div><div class="detail-value" id="mType"></div></div>
                <div class="detail-row"><div class="detail-label">Date</div><div class="detail-value" id="mDate"></div></div>
                <div class="detail-row"><div class="detail-label">Purpose</div><div class="detail-value" id="mPurpose"></div></div>
                <div class="detail-row"><div class="detail-label">Details</div><div class="detail-value" id="mDetails"></div></div>
                <div class="detail-row"><div class="detail-label">To Dept</div><div class="detail-value" id="mTo"></div></div>
                <div class="detail-row"><div class="detail-label">Remarks</div><div class="detail-value" id="mRemarks"></div></div>
            </div>
            <div id="mFile" class="mt-6 pt-4 border-t border-slate-100"></div>
        </div>
    </div>
</div>

<!-- Profile Modal -->
<div id="profileModal" class="modal-bg" onclick="if(event.target===this)closeProfileModal()">
    <div class="modal-card">
        <div class="modal-header">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">My Account</p>
                <p class="text-lg font-bold text-slate-800">Edit Profile</p>
            </div>
            <button onclick="closeProfileModal()" class="text-slate-400 hover:text-slate-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('user.profile.update') }}" method="POST" class="mb-6">
                @csrf
                <h4 class="font-bold text-slate-700 mb-3 text-sm uppercase">Personal Information</h4>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full p-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-red-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full p-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-red-500" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="bg-red-700 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-red-800 transition">Save Info</button>
                    </div>
                </div>
            </form>
            <hr class="border-slate-100 my-4">
            <form action="{{ route('user.password.update') }}" method="POST">
                @csrf
                <h4 class="font-bold text-slate-700 mb-3 text-sm uppercase">Change Password</h4>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Current Password</label>
                        <input type="password" name="current_password" class="w-full p-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-red-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">New Password</label>
                        <input type="password" name="password" class="w-full p-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-red-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="w-full p-2 border border-slate-200 rounded-lg text-sm focus:outline-none focus:border-red-500" required>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="bg-slate-700 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-slate-800 transition">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const sb=document.getElementById('userSidebar'),ov=document.getElementById('sbOverlay');
    function openSB(){sb.classList.add('open');ov.classList.add('show');}
    function closeSB(){sb.classList.remove('open');ov.classList.remove('show');}
    window.addEventListener('resize',()=>{ if(window.innerWidth>=1024){sb.classList.remove('open');ov.classList.remove('show');} });

    function openLogoutModal(){document.getElementById('logoutModal').classList.add('open');}
    function closeLogoutModal(){document.getElementById('logoutModal').classList.remove('open');}
    document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeLogoutModal(); });
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

    // Modal Logic
    const modal = document.getElementById('docModal');
    function closeModal(){ modal.classList.remove('open'); }
    function viewDoc(id){
        fetch(`/user/documents/${id}/detail`)
            .then(r=>r.json())
            .then(d=>{
                document.getElementById('mTracking').textContent = d.tracking_number;
                document.getElementById('mType').textContent = d.document_type;
                document.getElementById('mDate').textContent = d.created_at_formatted;
                document.getElementById('mPurpose').textContent = d.purpose;
                document.getElementById('mDetails').textContent = d.details;
                document.getElementById('mTo').textContent = d.to_department;
                document.getElementById('mRemarks').textContent = d.remarks || '-';
                
                const st = document.getElementById('mStatus');
                st.className = `sb-${d.status}`;
                st.textContent = d.status.toUpperCase();

                const fDiv = document.getElementById('mFile');
                if(d.file_path){
                    fDiv.innerHTML = `<a href="/storage/${d.file_path}" target="_blank" class="flex items-center gap-2 text-blue-600 font-medium hover:underline"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>View Attached File</a>`;
                } else {
                    fDiv.innerHTML = '<span class="text-slate-400 text-sm italic">No file attached</span>';
                }
                modal.classList.add('open');
            });
    }

    function openProfileModal(){ document.getElementById('profileModal').classList.add('open'); }
    function closeProfileModal(){ document.getElementById('profileModal').classList.remove('open'); }
</script>
@stack('scripts')
</body>
</html>