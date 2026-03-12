<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — AIS Document Tracking System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family:'Plus Jakarta Sans',sans-serif;box-sizing:border-box; }
        body { background:linear-gradient(145deg,#1a0000 0%,#3b0000 45%,#7f1d1d 100%);min-height:100vh; }
        .noise { position:fixed;inset:0;pointer-events:none;z-index:0;opacity:0.4;
            background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E"); }
        .orb1 { position:fixed;width:480px;height:480px;border-radius:50%;background:radial-gradient(circle,rgba(220,38,38,0.2),transparent 70%);top:-120px;right:-80px;pointer-events:none;z-index:0; }
        .orb2 { position:fixed;width:360px;height:360px;border-radius:50%;background:radial-gradient(circle,rgba(127,29,29,0.3),transparent 70%);bottom:-80px;left:-60px;pointer-events:none;z-index:0; }
        .logo-ring { width:120px;height:120px;border-radius:50%;background:linear-gradient(135deg,#7f1d1d,#dc2626);display:flex;align-items:center;justify-content:center;margin:0 auto 1.125rem;box-shadow:0 8px 32px rgba(185,28,28,0.6),0 0 0 5px rgba(185,28,28,0.15);overflow:hidden; }
        .card { background:rgba(255,255,255,0.98);border-radius:1.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.5);overflow:hidden;border:1px solid rgba(255,255,255,0.1);backdrop-filter:blur(10px); }
        .accent-bar { height:5px;background:linear-gradient(90deg,#7f1d1d,#dc2626,#f59e0b); }
        
        /* New Input Group Styles */
        .input-group { display:flex;align-items:center;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:0.75rem;transition:all 0.2s;overflow:hidden; }
        .input-group:focus-within { border-color:#991b1b;background:#fff;box-shadow:0 0 0 4px rgba(153,27,27,0.1); }
        .input-group input { flex:1;background:transparent;border:none;outline:none;padding:0.875rem 0;font-size:0.875rem;color:#0f172a;width:100%;min-width:0; }
        .ig-icon { padding:0 0.75rem 0 1rem;color:#94a3b8;display:flex;align-items:center;pointer-events:none;flex-shrink:0; }
        .ig-icon svg { width:1.125rem;height:1.125rem; }
        .ig-action { padding:0 1rem 0 0.75rem;background:none;border:none;cursor:pointer;color:#94a3b8;display:flex;align-items:center;transition:color 0.2s;flex-shrink:0; }
        .ig-action:hover { color:#991b1b; }
        
        .btn-main { width:100%;padding:0.95rem;background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:#fff;font-weight:700;font-size:0.9rem;letter-spacing:0.03em;border-radius:0.75rem;border:none;cursor:pointer;box-shadow:0 4px 18px rgba(153,27,27,0.45);transition:all 0.22s;font-family:inherit; }
        .btn-main:hover { transform:translateY(-2px);box-shadow:0 10px 30px rgba(153,27,27,0.55); }
        .btn-sec { width:100%;padding:0.875rem;border:1.5px solid #fecaca;background:transparent;color:#991b1b;font-weight:600;font-size:0.875rem;border-radius:0.75rem;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:0.5rem;text-decoration:none;font-family:inherit; }
        .btn-sec:hover { background:#fee2e2;border-color:#991b1b; }
        .div-line { display:flex;align-items:center;gap:0.75rem; }
        .div-line::before,.div-line::after { content:'';flex:1;height:1px;background:#e2e8f0; }
        .div-line span { font-size:0.7rem;color:#94a3b8;font-weight:600;letter-spacing:0.05em;text-transform:uppercase; }
        @keyframes fu { from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)} }
        .fu  { animation:fu 0.5s cubic-bezier(.22,.68,0,1.2) forwards; }
        .fu2 { animation:fu 0.5s cubic-bezier(.22,.68,0,1.2) 0.13s forwards;opacity:0; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
<div class="noise"></div><div class="orb1"></div><div class="orb2"></div>

<div class="w-full max-w-md relative z-10">
    <!-- Logo -->
    <div class="text-center mb-7 fu">
        <div class="logo-ring">
        <img src="{{ asset('images/ais-logo.png') }}" alt="AIS" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <h1 style="font-family:'Playfair Display',serif;font-size:1.625rem;font-weight:800;color:#fff;letter-spacing:-0.01em;">Ambalayat Integrated School</h1>
        <p style="color:rgba(252,165,165,0.75);font-size:0.78rem;font-weight:500;margin-top:0.3rem;letter-spacing:0.07em;text-transform:uppercase;">Document Tracking System</p>
    </div>

    <!-- Card -->
    <div class="card fu2">
        <div class="accent-bar"></div>
        <div style="padding:2.25rem 2rem 2rem;">
            <h2 style="font-size:1.5rem;font-weight:800;color:#0f172a;margin-bottom:0.25rem;">Welcome Back</h2>
            <p style="color:#64748b;font-size:0.875rem;margin-bottom:1.75rem;">Sign in to access the tracking system</p>

            @if($errors->any())
            <div style="background:#fef2f2;border-left:4px solid #dc2626;border-radius:0.625rem;padding:0.875rem 1rem;margin-bottom:1.25rem;display:flex;gap:0.5rem;align-items:flex-start;">
                <svg style="width:1rem;height:1rem;color:#dc2626;flex-shrink:0;margin-top:2px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                <p style="color:#991b1b;font-size:0.8125rem;font-weight:500;">{{ $errors->first() }}</p>
            </div>
            @endif
            @if(session('success'))
            <div style="background:#f0fdf4;border-left:4px solid #22c55e;border-radius:0.625rem;padding:0.875rem 1rem;margin-bottom:1.25rem;">
                <p style="color:#15803d;font-size:0.8125rem;font-weight:500;">{{ session('success') }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="display:flex;flex-direction:column;gap:1.125rem;">
                @csrf
                <div>
                    <label style="display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Email Address</label>
                    <div class="input-group">
                        <div class="ig-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                    </div>
                </div>
                <div>
                    <label style="display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.4rem;">Password</label>
                    <div class="input-group">
                        <div class="ig-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                        <input type="password" name="password" id="pw" required placeholder="Enter your password">
                        <button type="button" class="ig-action" onclick="togglePw('pw','ea','eb')">
                            <svg id="ea" style="width:1.125rem;height:1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg id="eb" style="width:1.125rem;height:1.125rem;display:none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:0.625rem;">
                    <input type="checkbox" name="remember" id="rem" style="width:1rem;height:1rem;accent-color:#991b1b;cursor:pointer;">
                    <label for="rem" style="margin:0;font-weight:500;color:#64748b;cursor:pointer;font-size:0.8125rem;">Keep me signed in</label>
                </div>
                <button type="submit" class="btn-main">Sign In to AIS-DTS</button>
                <div class="div-line"><span>or</span></div>
                <a href="{{ route('register') }}" class="btn-sec">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Create New Account
                </a>
            </form>
        </div>
    </div>
    <p style="text-align:center;color:rgba(252,165,165,0.35);font-size:0.7rem;margin-top:1.5rem;">© {{ date('Y') }} Ambalayat Integrated School · All rights reserved</p>
</div>
<script>
function togglePw(id,sa,sb){
    const i=document.getElementById(id),a=document.getElementById(sa),b=document.getElementById(sb);
    if(i.type==='password'){i.type='text';a.style.display='none';b.style.display='block';}
    else{i.type='password';a.style.display='block';b.style.display='none';}
}
</script>
</body>
</html>