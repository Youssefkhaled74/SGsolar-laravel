<!doctype html>
<html lang="en" dir="ltr" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || !localStorage.getItem('theme'),
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.darkMode);
    }
}" x-init="document.documentElement.classList.toggle('dark', darkMode)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ config('website.name','SgSolar') }} CRM - Login</title>

    <link rel="stylesheet" href="{{ asset('assets/css/crm.css') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Professional font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        [x-cloak]{display:none!important}
        :root{
            --crm-font: "Manrope";
            --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
            --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
            --brand-dark: {{ config('website.dark_green', '#0C2D1C') }};
            --brand-forest: {{ config('website.forest_green', '#115F45') }};
            --brand-light: {{ config('website.light_green', '#8CC63F') }};
        }

        .dark{
            --bg-0: #070B12;
            --bg-1: #0A1220;
            --card: rgba(16, 24, 40, .78);
            --card-2: rgba(16, 24, 40, .55);
            --border: rgba(255,255,255,.10);
            --text: rgba(255,255,255,.92);
            --muted: rgba(255,255,255,.65);
            --shadow: 0 30px 80px rgba(0,0,0,.55);
            --panel-bg: rgba(0,0,0,.14);
            --chip-bg: rgba(255,255,255,.05);
            --chip-text: rgba(255,255,255,.78);
            --input-bg: rgba(0,0,0,.18);
            --input-border: rgba(255,255,255,.14);
            --input-color: rgba(255,255,255,.92);
            --input-placeholder: rgba(255,255,255,.45);
            --foot-border: rgba(255,255,255,.12);
            --ghost-bg: rgba(255,255,255,.04);
            --ghost-border: rgba(255,255,255,.14);
            --ghost-text: rgba(255,255,255,.86);
        }

        html:not(.dark){
            --bg-0: #FFFFFF;
            --bg-1: #F8F9FA;
            --card: #FFFFFF;
            --card-2: #FFFFFF;
            --border: rgba(0,0,0,.12);
            --text: rgba(0,0,0,.92);
            --muted: rgba(0,0,0,.60);
            --shadow: 0 10px 30px rgba(0,0,0,.10);
            --panel-bg: rgba(0,0,0,.03);
            --chip-bg: rgba(0,0,0,.05);
            --chip-text: rgba(0,0,0,.80);
            --input-bg: rgba(0,0,0,.03);
            --input-border: rgba(0,0,0,.18);
            --input-color: rgba(0,0,0,.92);
            --input-placeholder: rgba(0,0,0,.45);
            --foot-border: rgba(0,0,0,.12);
            --ghost-bg: rgba(0,0,0,.05);
            --ghost-border: rgba(0,0,0,.16);
            --ghost-text: rgba(0,0,0,.85);
        }

        *{box-sizing:border-box}
        body{
            margin:0;
            min-height:100vh;
            font-family: var(--crm-font), system-ui, -apple-system, "Segoe UI", Roboto, Arial;
            color: var(--text);
            background: linear-gradient(180deg, var(--bg-0), var(--bg-1));
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden;
        }

        .dark body{
            background: radial-gradient(1200px 700px at 18% 8%, rgba(140,198,63,.10), transparent 55%),
                        radial-gradient(1100px 650px at 88% 12%, rgba(255,223,65,.10), transparent 55%),
                        linear-gradient(180deg, var(--bg-0), var(--bg-1));
        }

        /* Animated background (always running, subtle, professional) */
        .bg{
            position:fixed; inset:0; z-index:-2; overflow:hidden;
        }
        .bg::before{
            content:"";
            position:absolute; inset:-40%;
            background:
                radial-gradient(circle at 25% 25%, rgba(255,223,65,.18), transparent 38%),
                radial-gradient(circle at 70% 30%, rgba(140,198,63,.14), transparent 40%),
                radial-gradient(circle at 55% 75%, rgba(17,95,69,.14), transparent 40%),
                radial-gradient(circle at 20% 80%, rgba(227,160,0,.12), transparent 40%);
            filter: blur(18px);
            animation: drift 18s ease-in-out infinite alternate;
        }
        .bg::after{
            content:"";
            position:absolute; inset:0;
            background-image:
                linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 44px 44px;
            opacity:.10;
            mask-image: radial-gradient(closest-side at 50% 40%, black 0%, transparent 70%);
            pointer-events:none;
        }
        @keyframes drift{
            0%   { transform: translate3d(-2%, -1%, 0) scale(1.02) rotate(-1deg); }
            50%  { transform: translate3d( 2%,  2%, 0) scale(1.06) rotate( 1deg); }
            100% { transform: translate3d( 1%, -2%, 0) scale(1.03) rotate( 0deg); }
        }

        /* Floating particles (subtle) */
        .particles{
            position:fixed; inset:0; z-index:-1; pointer-events:none; opacity:.55;
        }
        html:not(.dark) .bg,
        html:not(.dark) .particles{display:none}
        .dot{
            position:absolute;
            width:6px; height:6px; border-radius:999px;
            background: rgba(255,255,255,.18);
            box-shadow: 0 0 18px rgba(255,255,255,.08);
            animation: float 10s linear infinite;
        }
        .dot.y{ background: rgba(255,223,65,.22); }
        .dot.g{ background: rgba(140,198,63,.18); }
        .dot.o{ background: rgba(227,160,0,.18); }
        @keyframes float{
            from { transform: translateY(120vh); }
            to   { transform: translateY(-20vh); }
        }

        /* Layout */
        .wrap{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:32px 14px;
        }

        /* Card shell */
        .shell{
            width:100%;
            max-width:1040px;
            display:grid;
            grid-template-columns: 420px 1fr;
            border-radius:24px;
            overflow:hidden;
            background: var(--card);
            border:1px solid var(--border);
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }
        @media(max-width:980px){
            .shell{grid-template-columns:1fr; max-width:560px}
        }

        /* Left panel */
        .left{
            padding:30px 28px;
            background:
                radial-gradient(700px 420px at 30% 20%, rgba(255,223,65,.12), transparent 50%),
                radial-gradient(700px 420px at 80% 60%, rgba(140,198,63,.10), transparent 52%),
                linear-gradient(180deg, var(--card-2), var(--card));
            border-right:1px solid var(--border);
        }
        @media(max-width:980px){
            .left{border-right:none;border-bottom:1px solid var(--border)}
        }

        .brand{display:flex;align-items:center;gap:12px}
        .logo{
            width:54px;height:54px;border-radius:16px;
            background: var(--chip-bg);
            border:1px solid var(--border);
            display:flex;align-items:center;justify-content:center;
            overflow:hidden;
        }
        .logo img{width:100%;height:100%;object-fit:contain;padding:8px; filter: drop-shadow(0 8px 12px rgba(0,0,0,.35));}
        .brand-name{font-weight:900;font-size:18px;letter-spacing:-0.2px;line-height:1.1}
        .brand-sub{margin-top:4px;font-size:12px;color:var(--muted);font-weight:800}

        .hero{
            margin-top:18px;
            padding:14px 14px;
            border-radius:16px;
            border:1px solid var(--border);
            background: var(--panel-bg);
        }
        .hero h3{margin:0;font-size:14px;font-weight:900}
        .hero p{margin:6px 0 0 0;font-size:13px;color:var(--muted);line-height:1.55;font-weight:700}

        .chips{margin-top:14px;display:flex;gap:10px;flex-wrap:wrap}
        .chip{
            display:inline-flex;align-items:center;gap:8px;
            padding:8px 10px;border-radius:999px;
            border:1px solid var(--border);
            background: var(--chip-bg);
            font-size:12px;font-weight:900;color: var(--chip-text);
        }
        .chip b{color: var(--text)}
        .chip .k{width:8px;height:8px;border-radius:999px;background: var(--muted)}
        .chip .k.y{background: rgba(255,223,65,.35)}
        .chip .k.g{background: rgba(140,198,63,.30)}

        /* Right panel */
        .right{padding:30px 30px}
        .title{margin:0;font-size:22px;font-weight:900;letter-spacing:-0.2px}
        .subtitle{margin:8px 0 0 0;font-size:13px;color:var(--muted);font-weight:800;line-height:1.55}

        .error{
            margin-top:14px;
            background: rgba(127,29,29,.22);
            border:1px solid rgba(254,202,202,.45);
            color: var(--text);
            border-radius:16px;
            padding:12px 14px;
            font-weight:800;
        }
        .error ul{margin:8px 0 0 18px}

        .field{margin-top:14px}
        .label{
            font-size:12px;color:var(--muted);
            font-weight:900;margin-bottom:7px;
            display:flex;align-items:center;justify-content:space-between;gap:10px;
        }
        .input{
            width:100%;
            padding:12px 12px;
            border-radius:14px;
            border:1px solid var(--input-border);
            background: var(--input-bg);
            color: var(--input-color);
            outline:none;
            transition: box-shadow .15s ease, border-color .15s ease, background .15s ease;
            font-weight:800;
        }
        .input::placeholder{color: var(--input-placeholder); font-weight:700}
        .input:focus{
            border-color: rgba(255,223,65,.55);
            box-shadow: 0 0 0 3px rgba(255,223,65,0.18);
            background: var(--input-bg);
        }

        .row{
            margin-top:16px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
        }
        .remember{
            display:flex;align-items:center;gap:10px;
            font-size:13px;color: var(--muted);
            font-weight:800;
        }
        .remember input{width:18px;height:18px;accent-color: var(--brand-yellow)}

        .btn{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:10px;
            padding:12px 14px;
            border-radius:14px;
            border:1px solid transparent;
            cursor:pointer;
            font-weight:900;
            min-width:170px;
            transition: transform .05s ease, filter .15s ease, opacity .15s ease, box-shadow .15s ease;
            text-decoration:none;
            white-space:nowrap;
        }
        .btn:active{transform:translateY(1px)}
        .btn-primary{
            background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%);
            color: #0b122a;
            box-shadow: 0 18px 34px rgba(227,160,0,0.22);
        }
        .btn-primary:hover{
            filter:brightness(0.98);
            box-shadow: 0 22px 44px rgba(227,160,0,0.26);
        }
        .btn-ghost{
            background: var(--ghost-bg);
            border-color: var(--ghost-border);
            color: var(--ghost-text);
        }
        .btn-ghost:hover{background: var(--ghost-bg)}
        .btn[disabled]{opacity:0.65;cursor:not-allowed;transform:none}

        .foot{
            margin-top:18px;
            padding-top:14px;
            border-top:1px solid var(--foot-border);
            font-size:12px;
            color: var(--muted);
            font-weight:800;
            display:flex;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
        }
        .foot a{color: var(--text); text-decoration:none; font-weight:900}
        .foot a:hover{text-decoration:underline}

        /* Small inline icon style */
        .lock{
            width:34px;height:34px;border-radius:14px;
            display:flex;align-items:center;justify-content:center;
            background: var(--chip-bg);
            border:1px solid var(--border);
            margin-bottom:12px;
        }
        .lock svg{width:18px;height:18px;opacity:.9}

        .theme-toggle{
            position:fixed;
            top:16px;
            right:16px;
            width:40px;
            height:40px;
            border-radius:14px;
            border:1px solid var(--border);
            background: var(--ghost-bg);
            color: var(--text);
            cursor:pointer;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:18px;
            transition: all 0.3s ease;
            z-index:5;
        }
        .theme-toggle:hover{transform: rotate(20deg)}
    </style>
</head>
<body>
    <button @click="toggleTheme()" class="theme-toggle" aria-label="Toggle theme" title="Toggle dark/light mode">
        <span x-show="darkMode">&#9790;</span>
        <span x-show="!darkMode" x-cloak>&#9728;</span>
    </button>
    <div class="bg" aria-hidden="true"></div>

    <!-- Subtle animated particles -->
    <div class="particles" aria-hidden="true">
        <span class="dot y" style="left:10%; animation-duration: 11s; animation-delay: -2s;"></span>
        <span class="dot g" style="left:22%; animation-duration: 14s; animation-delay: -6s; width:7px; height:7px;"></span>
        <span class="dot"   style="left:34%; animation-duration: 12s; animation-delay: -4s;"></span>
        <span class="dot o" style="left:48%; animation-duration: 16s; animation-delay: -10s; width:8px; height:8px;"></span>
        <span class="dot"   style="left:61%; animation-duration: 13s; animation-delay: -7s;"></span>
        <span class="dot g" style="left:72%; animation-duration: 15s; animation-delay: -9s; width:7px; height:7px;"></span>
        <span class="dot y" style="left:84%; animation-duration: 12s; animation-delay: -5s;"></span>
        <span class="dot"   style="left:92%; animation-duration: 17s; animation-delay: -12s; width:9px; height:9px;"></span>
    </div>

    <div class="wrap">
        <div class="shell">
            <!-- Left -->
            <div class="left">
                <div class="brand">
                    <div class="logo">
<img src="{{ asset('png/SG-013.png') }}" alt="SgSolar CRM Logo">
                    </div>
                    <div>
                        <div class="brand-name">SgSolar CRM</div>
                        <div class="brand-sub">{{ config('website.slogan','مستشارك الأفضل، الحل الأمثل.') }}</div>
                    </div>
                </div>

                <div class="hero">
                    <h3>Secure CRM access</h3>
                    <p>Admin & Sales teams can manage leads, followups, and activity with a consistent professional workflow.</p>
                </div>

                <div class="chips">
                    <span class="chip"><span class="k y"></span><b>Leads</b></span>
                    <span class="chip"><span class="k g"></span><b>Followups</b></span>
                    <span class="chip"><span class="k"></span><b>Timeline</b></span>
                </div>
            </div>

            <!-- Right -->
            <div class="right">
                <div class="lock" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M7.5 10V8.2c0-2.9 2.1-5.2 4.5-5.2s4.5 2.3 4.5 5.2V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M6.8 10h10.4c.9 0 1.6.7 1.6 1.6v7c0 .9-.7 1.6-1.6 1.6H6.8c-.9 0-1.6-.7-1.6-1.6v-7c0-.9.7-1.6 1.6-1.6Z" stroke="currentColor" stroke-width="1.8" />
                        <path d="M12 14.2v2.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>

                <h1 class="title">Sign in</h1>
                <p class="subtitle">Use your CRM account credentials to continue.</p>

                @if($errors->any())
                    <div class="error">
                        <div><strong>Unable to sign in</strong></div>
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('crm.login.submit') }}">
                    @csrf

                    <div class="field">
                        <div class="label"><span>Email</span></div>
                        <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required autofocus placeholder="name@sgsolar.com">
                    </div>

                    <div class="field">
                        <div class="label"><span>Password</span></div>
                        <input id="password" name="password" type="password" class="input" required placeholder="Enter your password">
                    </div>

                    <div class="row">
                        <label class="remember">
                            <input type="checkbox" name="remember">
                            Remember me
                        </label>

                        <button type="submit" class="btn btn-primary">
                            Sign in
                        </button>

                        <a href="{{ url('/') }}" class="btn btn-ghost">
                            Back to website
                        </a>
                    </div>

                    <div class="foot">
                        <div>© {{ date('Y') }} {{ config('website.name','SgSolar') }}</div>
                        <div>
                            <a href="mailto:{{ data_get(config('website.contact'), 'email', 'info@sgsolar.com') }}">
                                {{ data_get(config('website.contact'), 'email', 'info@sgsolar.com') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>



