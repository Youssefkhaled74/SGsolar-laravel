<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>SgSolar CRM - Please sign in</title>

    <!-- CRM stylesheet (optional but keeps buttons consistent if exists) -->
    <link rel="stylesheet" href="{{ asset('crm/crm.css') }}">

    <!-- Professional font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root{
            --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
            --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
            --brand-dark: {{ config('website.dark_green', '#0C2D1C') }};
            --brand-forest: {{ config('website.forest_green', '#115F45') }};
            --bg-0: #070B12;
            --bg-1: #0A1220;
            --border: rgba(255,255,255,.12);
            --text: rgba(255,255,255,.92);
            --muted: rgba(255,255,255,.68);
            --shadow: 0 30px 80px rgba(0,0,0,.55);
            --font: "Manrope";
        }
        *{box-sizing:border-box}
        body{
            margin:0; min-height:100vh;
            font-family: var(--font), system-ui, -apple-system, "Segoe UI", Roboto, Arial;
            color: var(--text);
            background:
                radial-gradient(1100px 650px at 18% 10%, rgba(140,198,63,.10), transparent 55%),
                radial-gradient(1000px 600px at 86% 12%, rgba(255,223,65,.10), transparent 55%),
                linear-gradient(180deg, var(--bg-0), var(--bg-1));
            -webkit-font-smoothing:antialiased;
            overflow-x:hidden;
        }

        /* Animated background */
        .bg{position:fixed; inset:0; z-index:-2; overflow:hidden}
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

        /* Floating particles */
        .particles{position:fixed; inset:0; z-index:-1; pointer-events:none; opacity:.55}
        .dot{
            position:absolute; width:6px; height:6px; border-radius:999px;
            background: rgba(255,255,255,.18);
            box-shadow: 0 0 18px rgba(255,255,255,.08);
            animation: float 10s linear infinite;
        }
        .dot.y{ background: rgba(255,223,65,.22); }
        .dot.g{ background: rgba(140,198,63,.18); }
        .dot.o{ background: rgba(227,160,0,.18); }
        @keyframes float{ from{transform:translateY(120vh)} to{transform:translateY(-20vh)} }

        /* Center card */
        .wrap{min-height:100vh; display:flex; align-items:center; justify-content:center; padding:30px 14px;}
        .card{
            width:100%; max-width:560px;
            border-radius:24px;
            border:1px solid var(--border);
            background: linear-gradient(180deg, rgba(255,255,255,.06), rgba(255,255,255,.03));
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
            overflow:hidden;
        }
        .card-body{padding:26px 24px; text-align:center;}
        .logo{
            width:62px;height:62px;border-radius:18px;
            border:1px solid var(--border);
            background: rgba(255,255,255,.06);
            display:flex;align-items:center;justify-content:center;
            margin:0 auto 14px auto;
            overflow:hidden;
        }
        .logo img{width:100%;height:100%;object-fit:contain;padding:10px; filter: drop-shadow(0 10px 16px rgba(0,0,0,.35));}
        .icon{
            width:54px;height:54px;border-radius:18px;
            border:1px solid var(--border);
            background: rgba(0,0,0,.18);
            display:flex;align-items:center;justify-content:center;
            margin:0 auto 12px auto;
        }
        .title{margin:0;font-size:20px;font-weight:900;letter-spacing:-0.2px}
        .sub{margin:10px 0 0 0;font-size:13px;color:var(--muted);font-weight:800;line-height:1.6}

        .actions{
            margin-top:18px;
            display:flex; gap:10px; justify-content:center; flex-wrap:wrap;
        }
        .btn{
            display:inline-flex; align-items:center; justify-content:center; gap:10px;
            padding:12px 14px;
            border-radius:14px;
            border:1px solid transparent;
            cursor:pointer;
            font-weight:900;
            min-width:180px;
            text-decoration:none;
            transition: transform .05s ease, filter .15s ease, box-shadow .15s ease, opacity .15s ease;
            white-space:nowrap;
        }
        .btn:active{transform:translateY(1px)}
        .btn-primary{
            background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%);
            color:#0b122a;
            box-shadow: 0 18px 34px rgba(227,160,0,0.22);
        }
        .btn-primary:hover{filter:brightness(.98); box-shadow: 0 22px 44px rgba(227,160,0,0.26)}
        .btn-ghost{
            background: rgba(255,255,255,.04);
            border-color: rgba(255,255,255,.14);
            color: rgba(255,255,255,.86);
        }
        .btn-ghost:hover{background: rgba(255,255,255,.07)}

        .foot{
            padding:14px 18px;
            border-top:1px solid rgba(255,255,255,.12);
            display:flex; justify-content:space-between; gap:12px; flex-wrap:wrap;
            font-size:12px; color: rgba(255,255,255,.62); font-weight:800;
        }
        .foot a{color: rgba(255,255,255,.78); text-decoration:none; font-weight:900}
        .foot a:hover{text-decoration:underline}
    </style>
</head>
<body>
    <div class="bg" aria-hidden="true"></div>

    <div class="particles" aria-hidden="true">
        <span class="dot y" style="left:12%; animation-duration: 12s; animation-delay: -3s;"></span>
        <span class="dot g" style="left:24%; animation-duration: 15s; animation-delay: -7s; width:7px; height:7px;"></span>
        <span class="dot"   style="left:36%; animation-duration: 13s; animation-delay: -5s;"></span>
        <span class="dot o" style="left:50%; animation-duration: 17s; animation-delay: -11s; width:8px; height:8px;"></span>
        <span class="dot"   style="left:62%; animation-duration: 14s; animation-delay: -8s;"></span>
        <span class="dot g" style="left:74%; animation-duration: 16s; animation-delay: -10s; width:7px; height:7px;"></span>
        <span class="dot y" style="left:86%; animation-duration: 13s; animation-delay: -6s;"></span>
        <span class="dot"   style="left:93%; animation-duration: 18s; animation-delay: -13s; width:9px; height:9px;"></span>
    </div>

    <div class="wrap">
        <div class="card">
            <div class="card-body">
                <div class="logo">
                    <img src="{{ asset('png/SG-013.png') }}" alt="SgSolar CRM Logo">
                </div>

                <div class="icon" aria-hidden="true">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none">
                        <path d="M7.5 10V8.2c0-2.9 2.1-5.2 4.5-5.2s4.5 2.3 4.5 5.2V10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        <path d="M6.8 10h10.4c.9 0 1.6.7 1.6 1.6v7c0 .9-.7 1.6-1.6 1.6H6.8c-.9 0-1.6-.7-1.6-1.6v-7c0-.9.7-1.6 1.6-1.6Z" stroke="currentColor" stroke-width="1.8" />
                        <path d="M12 14.2v2.8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                </div>

                <h1 class="title">Please sign in</h1>
                <p class="sub">
                    Your session has expired or you are not signed in to SgSolar CRM.
                    Please login to continue.
                </p>

                <div class="actions">
                    <a href="{{ route('crm.login') }}" class="btn btn-primary">Go to CRM Login</a>
                    <a href="{{ url('/') }}" class="btn btn-ghost">Back to Website</a>
                </div>
            </div>

            <div class="foot">
                <div>© {{ date('Y') }} {{ config('website.name','SgSolar') }}</div>
                <div>
                    <a href="mailto:{{ data_get(config('website.contact'), 'email', 'info@sgsolar.com') }}">
                        {{ data_get(config('website.contact'), 'email', 'info@sgsolar.com') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
