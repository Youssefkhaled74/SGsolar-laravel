<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('website.name') }} - Company Catalog</title>

    <style>
        /* ==============================
           Modern Print-Ready Catalog
           ============================== */

        :root{
            --primary:#FFDF41;
            --secondary:#E3A000;
            --dark:#0C2D1C;
            --dark2:#115F45;
            --ink:#0f172a;
            --muted:#64748b;
            --paper:#ffffff;
            --soft:#f8fafc;
            --border: rgba(15, 23, 42, 0.10);
            --shadow: 0 18px 40px rgba(2, 6, 23, 0.10);
            --radius: 18px;
        }

        *{ box-sizing:border-box; }
        html,body{ height:100%; }
        body{
            margin:0;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial, "Noto Sans", "Helvetica Neue", sans-serif;
            color: var(--ink);
            background: var(--soft);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ========== Toolbar (screen only) ========== */
        .toolbar{
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255,255,255,.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }
        .toolbar-inner{
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px 20px;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
        }
        .toolbar .brand{
            display:flex;
            align-items:center;
            gap:10px;
            min-width:0;
        }
        .toolbar .brand strong{
            font-size: 14px;
            letter-spacing:.2px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .toolbar .hint{
            font-size: 12px;
            color: var(--muted);
        }
        .btn{
            border: 1px solid var(--border);
            background: linear-gradient(180deg,#fff,#f8fafc);
            border-radius: 12px;
            padding: 10px 14px;
            cursor: pointer;
            font-weight: 700;
            font-size: 13px;
            display:inline-flex;
            align-items:center;
            gap: 8px;
            box-shadow: 0 8px 18px rgba(2,6,23,.06);
        }
        .btn-primary{
            border-color: rgba(227,160,0,0.45);
            background: linear-gradient(180deg, var(--primary), #ffe979);
        }
        .btn:active{ transform: translateY(1px); }

        /* ========== Page Wrapper ========== */
        .page{
            max-width: 1200px;
            margin: 18px auto 40px;
            padding: 0 18px;
        }

        /* Print header/footer “running” feel */
        .print-header, .print-footer{
            display:none;
        }

        /* ========== Card / Sections ========== */
        .sheet{
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
        }
        .section{
            padding: 46px 46px;
        }
        @media (max-width: 900px){
            .section{ padding: 28px 18px; }
        }

        .section-head{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap: 20px;
            padding-bottom: 18px;
            border-bottom: 2px solid rgba(255,223,65,.55);
            margin-bottom: 26px;
        }
        .section-head h2{
            margin:0;
            font-size: 34px;
            letter-spacing:-.6px;
            color: var(--dark);
        }
        .section-head p{
            margin: 6px 0 0;
            color: var(--muted);
            max-width: 62ch;
        }
        .chip{
            display:inline-flex;
            align-items:center;
            gap:8px;
            border: 1px solid var(--border);
            border-radius: 999px;
            padding: 8px 12px;
            font-weight: 800;
            font-size: 12px;
            background: #fff;
            color: #0b1220;
            white-space:nowrap;
        }

        /* ========== Cover ========== */
        .cover{
            min-height: 100vh;
            background: radial-gradient(1200px 700px at 10% 0%, rgba(255,223,65,.18), transparent 60%),
                        radial-gradient(900px 600px at 90% 30%, rgba(227,160,0,.16), transparent 55%),
                        linear-gradient(135deg, var(--dark) 0%, var(--dark2) 100%);
            color: #fff;
            display:flex;
            align-items:center;
            justify-content:center;
            text-align:center;
            padding: 70px 40px;
            page-break-after: always;
        }
        .cover-inner{
            max-width: 880px;
        }
        .cover-logo{
            width: 240px;
            max-width: 70vw;
            height:auto;
            margin: 0 auto 26px;
            filter: brightness(0) invert(1);
            display:block;
        }
        .cover-title{
            margin:0;
            font-size: 54px;
            letter-spacing:-1px;
            color: var(--primary);
        }
        .cover-subtitle{
            margin: 10px 0 0;
            font-size: 20px;
            opacity: .92;
            font-weight: 500;
        }
        .cover-divider{
            width: 260px;
            height: 4px;
            margin: 26px auto 22px;
            border-radius: 99px;
            background: linear-gradient(90deg, var(--primary), rgba(255,223,65,.20));
        }
        .cover-badge-row{
            display:flex;
            gap: 10px;
            justify-content:center;
            flex-wrap:wrap;
            margin-top: 18px;
        }
        .cover-badge{
            background: rgba(255,255,255,.10);
            border: 1px solid rgba(255,255,255,.18);
            border-radius: 999px;
            padding: 10px 14px;
            font-size: 12px;
            font-weight: 700;
        }
        .cover-year{
            margin-top: 26px;
            opacity:.85;
            font-weight: 700;
        }

        /* ========== TOC ========== */
        .toc{
            display:grid;
            grid-template-columns: 1.1fr .9fr;
            gap: 22px;
            align-items:start;
        }
        .toc-card{
            border: 1px solid var(--border);
            border-radius: 18px;
            padding: 18px;
            background: linear-gradient(180deg, #fff, #fbfdff);
        }
        .toc h3{
            margin: 0 0 10px;
            color: #0b1220;
            font-size: 18px;
            letter-spacing: -.2px;
        }
        .toc a{
            display:flex;
            justify-content:space-between;
            gap: 10px;
            padding: 10px 10px;
            border-radius: 12px;
            text-decoration:none;
            color: var(--ink);
            border: 1px solid transparent;
        }
        .toc a:hover{
            border-color: var(--border);
            background: #fff;
        }
        .toc small{ color: var(--muted); font-weight: 700; }

        /* ========== About ========== */
        .grid-2{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap: 26px;
            align-items:center;
        }
        @media (max-width: 900px){
            .grid-2{ grid-template-columns: 1fr; }
        }
        .about-box h3{
            margin: 0 0 10px;
            color: var(--dark);
            font-size: 20px;
        }
        .about-box p{
            margin: 0 0 14px;
            color: #111827;
        }
        .about-image{
            border-radius: 18px;
            overflow:hidden;
            border: 1px solid var(--border);
            box-shadow: 0 14px 30px rgba(2,6,23,.10);
            background: #fff;
        }
        .about-image img{
            width: 100%;
            height: 100%;
            max-height: 360px;
            object-fit: cover;
            display:block;
        }

        .stats{
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-top: 22px;
        }
        @media (max-width: 900px){
            .stats{ grid-template-columns: repeat(2, 1fr); }
        }
        .stat{
            border-radius: 18px;
            padding: 18px 16px;
            background: linear-gradient(135deg, rgba(12,45,28,1), rgba(17,95,69,1));
            color:#fff;
            border: 1px solid rgba(255,255,255,.16);
        }
        .stat strong{
            display:block;
            font-size: 34px;
            color: var(--primary);
            letter-spacing:-.6px;
        }
        .stat span{
            font-size: 12px;
            opacity:.92;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        /* ========== Products ========== */
        .category{
            margin-top: 26px;
        }
        .category-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap: 12px;
            margin-bottom: 12px;
        }
        .category-head h3{
            margin: 0;
            font-size: 20px;
            color: #0b1220;
        }
        .category-head p{
            margin: 0;
            color: var(--muted);
            font-size: 13px;
        }
        .products{
            display:grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
        }
        @media (max-width: 1050px){
            .products{ grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 650px){
            .products{ grid-template-columns: 1fr; }
        }
        .product{
            border: 1px solid var(--border);
            border-radius: 18px;
            background: #fff;
            padding: 16px;
            page-break-inside: avoid;
            position:relative;
            overflow:hidden;
        }
        .product:before{
            content:"";
            position:absolute;
            inset:0;
            background: radial-gradient(600px 220px at 0% 0%, rgba(255,223,65,.20), transparent 55%);
            pointer-events:none;
        }
        .product-top{
            display:flex;
            align-items:center;
            gap: 12px;
            margin-bottom: 10px;
            position:relative;
        }
        .picon{
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--dark), var(--dark2));
            display:flex;
            align-items:center;
            justify-content:center;
            color: var(--primary);
            font-weight: 900;
            flex: 0 0 auto;
            border: 1px solid rgba(255,255,255,.18);
            overflow:hidden;
        }
        .picon img{
            width: 34px;
            height: 34px;
            object-fit: contain;
        }
        .product h4{
            margin: 0;
            font-size: 15px;
            color: #0b1220;
            letter-spacing: -.2px;
        }
        .product p{
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
            position:relative;
        }
        .tag-row{
            display:flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 10px;
            position:relative;
        }
        .tag{
            font-size: 11px;
            font-weight: 800;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(248,250,252,.9);
            color: #0b1220;
        }

        /* ========== Projects ========== */
        .projects{
            display:grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        @media (max-width: 900px){
            .projects{ grid-template-columns: 1fr; }
        }
        .project{
            border: 1px solid var(--border);
            border-radius: 18px;
            overflow:hidden;
            background:#fff;
            page-break-inside: avoid;
        }
        .project .img{
            height: 240px;
            background: #f1f5f9;
            overflow:hidden;
        }
        .project .img img{
            width:100%;
            height:100%;
            object-fit:cover;
            display:block;
        }
        .project .body{
            padding: 14px 16px;
        }
        .project h4{
            margin: 0 0 6px;
            font-size: 16px;
            color: #0b1220;
        }
        .project p{
            margin: 0;
            font-size: 13px;
            color: var(--muted);
        }

        /* ========== Contact ========== */
        .contact{
            border-radius: 18px;
            background: linear-gradient(135deg, var(--dark), var(--dark2));
            color:#fff;
            padding: 22px;
            border: 1px solid rgba(255,255,255,.14);
        }
        .contact-grid{
            display:grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        @media (max-width: 900px){
            .contact-grid{ grid-template-columns: 1fr; }
        }
        .citem{
            display:flex;
            gap: 12px;
            align-items:flex-start;
            padding: 12px;
            border-radius: 16px;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.12);
        }
        .cicon{
            width: 40px;
            height: 40px;
            border-radius: 14px;
            background: linear-gradient(180deg, var(--primary), #ffe979);
            color: #0b1220;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight: 900;
            flex: 0 0 auto;
        }
        .citem h4{
            margin: 0 0 4px;
            font-size: 13px;
            letter-spacing:.2px;
            color: rgba(255,255,255,.95);
        }
        .citem p{
            margin: 0;
            font-size: 13px;
            color: rgba(255,255,255,.85);
        }

        /* ========== Print Rules ========== */
        @media print{
            /* IMPORTANT: allow backgrounds in print */
            *{ -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }

            .toolbar{ display:none !important; }
            body{ background:#fff; }
            .page{ max-width: 100%; margin: 0; padding: 0; }
            .sheet{ box-shadow:none; border: none; border-radius: 0; }

            /* Fixed header/footer in print */
            .print-header, .print-footer{
                display:block;
                position: fixed;
                left: 0;
                right: 0;
                padding: 10mm 14mm;
                color: #0b1220;
                font-size: 11px;
            }
            .print-header{
                top: 0;
                border-bottom: 1px solid rgba(15,23,42,.10);
                background: rgba(255,255,255,.92);
            }
            .print-footer{
                bottom: 0;
                border-top: 1px solid rgba(15,23,42,.10);
                background: rgba(255,255,255,.92);
            }
            .print-footer .page-num:after{
                content: counter(page);
            }

            /* page margins (space for fixed header/footer) */
            @page{
                size: A4;
                margin: 18mm 14mm;
            }

            /* Avoid awkward breaks */
            .section, .product, .project, .contact{ break-inside: avoid; page-break-inside: avoid; }
            .cover{ page-break-after: always; }
        }
    </style>
</head>

<body>

    {{-- Screen-only toolbar --}}
    <div class="toolbar no-print">
        <div class="toolbar-inner">
            <div class="brand">
                <strong>{{ config('website.name') }} — Catalog</strong>
                <span class="hint">Ctrl + P to print / Save as PDF</span>
            </div>
            <div style="display:flex; gap:10px; align-items:center;">
                <button class="btn" type="button" id="scrollTopBtn">↑ Top</button>
                <button class="btn btn-primary" type="button" id="printBtn">🖨️ Print / Save PDF</button>
            </div>
        </div>
    </div>

    {{-- Print header/footer --}}
    <div class="print-header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div style="font-weight:800;">{{ config('website.name') }}</div>
            <div style="color:#64748b; font-weight:700;">Company Catalog — {{ date('Y') }}</div>
        </div>
    </div>

    <div class="print-footer">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div style="color:#64748b;">
                {{ config('website.contact.email') }} • {{ config('website.contact.phone') }}
            </div>
            <div style="font-weight:800;">
                Page <span class="page-num"></span>
            </div>
        </div>
    </div>

    <div class="page">
        <div class="sheet">

            {{-- Cover --}}
            <div class="cover" id="cover">
                <div class="cover-inner">
                    <img src="{{ asset(config('website.logo')) }}" alt="{{ config('website.name') }} Logo" class="cover-logo">
                    <h1 class="cover-title">{{ config('website.name') }}</h1>
                    <p class="cover-subtitle">{{ config('website.slogan') }}</p>
                    <div class="cover-divider"></div>
                    <div style="font-size: 22px; font-weight: 900; letter-spacing:.2px;">Company Catalog</div>

                    <div class="cover-badge-row">
                        <div class="cover-badge">Solar Solutions</div>
                        <div class="cover-badge">Engineering & Installation</div>
                        <div class="cover-badge">After-Sales Support</div>
                    </div>

                    <div class="cover-year">{{ date('Y') }}</div>
                </div>
            </div>

            {{-- TOC --}}
            <div class="section" id="toc">
                <div class="section-head">
                    <div>
                        <h2>Table of Contents</h2>
                        <p>Quick navigation for the catalog sections.</p>
                    </div>
                    <span class="chip">PDF Ready</span>
                </div>

                <div class="toc">
                    <div class="toc-card">
                        <h3>Sections</h3>
                        <a href="#about"><span>About Us</span><small>01</small></a>
                        <a href="#products"><span>Products</span><small>02</small></a>
                        <a href="#projects"><span>Projects</span><small>03</small></a>
                        <a href="#contact"><span>Contact</span><small>04</small></a>
                    </div>

                    <div class="toc-card">
                        <h3>Catalog Notes</h3>
                        <div style="color:var(--muted); font-size:13px;">
                            <div class="chip" style="margin-bottom:10px;">Tip</div>
                            Use <strong>Ctrl + P</strong> then choose <strong>Save as PDF</strong>.
                            For best results, enable <strong>Background graphics</strong> in print settings.
                            <div style="margin-top:12px;">
                                <span class="chip">A4</span>
                                <span class="chip">Clean Layout</span>
                                <span class="chip">Page Numbers</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- About --}}
            <div class="section" id="about">
                <div class="section-head">
                    <div>
                        <h2>{{ __('website.about.title') }}</h2>
                        <p>{{ __('website.about.subtitle') }}</p>
                    </div>
                    <span class="chip">{{ __('website.nav.mission') }}</span>
                </div>

                <div class="grid-2">
                    <div class="about-box">
                        <h3>{{ __('website.nav.mission') }}</h3>
                        <p>{{ config('website.mission') }}</p>

                        <h3 style="margin-top:16px;">Why Choose Us</h3>
                        <p>{{ __('website.why_us.subtitle') }}</p>

                        <div style="margin-top:16px;">
                            <span class="chip">Quality</span>
                            <span class="chip">Safety</span>
                            <span class="chip">Warranty</span>
                            <span class="chip">Support</span>
                        </div>
                    </div>

                    <div class="about-image">
                        <img src="{{ asset('images/aboutus.png') }}" alt="About {{ config('website.name') }}">
                    </div>
                </div>

                <div class="stats">
                    @foreach(__('website.about.stats') as $stat)
                        <div class="stat">
                            <strong>{{ $stat['number'] ?? '' }}{{ $stat['suffix'] ?? '' }}</strong>
                            <span>{{ $stat['label'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Products --}}
            <div class="section" id="products" style="page-break-before: always;">
                <div class="section-head">
                    <div>
                        <h2>{{ __('website.products.title') }}</h2>
                        <p>{{ __('website.products.subtitle') }}</p>
                    </div>
                    <span class="chip">Solutions</span>
                </div>

                @php
                    // Add/edit freely. Each category has items. Icons are optional.
                    // If you have icons under public/icons/icons/, keep icon value like "on-grid.svg".
                    $productsByCategory = [
                        [
                            'title' => 'Solar Systems',
                            'subtitle' => 'Complete solutions for homes, businesses and farms.',
                            'items' => [
                                ['name'=>'On-Grid Solar System','icon'=>'on-grid.svg','desc'=>'Connect to the grid and reduce bills while exporting surplus energy.','tags'=>['Residential','Commercial']],
                                ['name'=>'Off-Grid Solar System','icon'=>'off-grid.svg','desc'=>'Energy independence with battery storage for remote areas.','tags'=>['Remote','Backup']],
                                ['name'=>'Hybrid Solar System','icon'=>'hybrid.svg','desc'=>'Grid + battery backup for uninterrupted power and savings.','tags'=>['Backup','Smart']],
                            ],
                        ],
                        [
                            'title' => 'Water & Heating',
                            'subtitle' => 'Efficient solar solutions for water pumping and hot water.',
                            'items' => [
                                ['name'=>'Solar Water Pumping','icon'=>'pump.svg','desc'=>'High-efficiency pumping for agriculture and remote use.','tags'=>['Agriculture','Industry']],
                                ['name'=>'Solar Water Heaters','icon'=>'solar-heater.svg','desc'=>'Eco-friendly hot water, reduces energy costs year-round.','tags'=>['Home','Hotel']],
                            ],
                        ],
                        [
                            'title' => 'Lighting & Accessories',
                            'subtitle' => 'Solar lighting + components that complete your system.',
                            'items' => [
                                ['name'=>'Solar Lighting Systems','icon'=>'solar-light.svg','desc'=>'Outdoor and indoor solar lighting solutions.','tags'=>['Street','Garden']],
                                ['name'=>'Inverters','icon'=>null,'desc'=>'Pure sine wave / hybrid inverters with smart monitoring options.','tags'=>['Inverter','Smart']],
                                ['name'=>'Batteries','icon'=>null,'desc'=>'Lithium & deep-cycle battery solutions for backup and off-grid.','tags'=>['LiFePO4','AGM']],
                                ['name'=>'Mounting Structures','icon'=>null,'desc'=>'Roof & ground mounting systems engineered for durability.','tags'=>['Roof','Ground']],
                            ],
                        ],
                    ];
                @endphp

                @foreach($productsByCategory as $cat)
                    <div class="category">
                        <div class="category-head">
                            <div>
                                <h3>{{ $cat['title'] }}</h3>
                                <p>{{ $cat['subtitle'] }}</p>
                            </div>
                            <span class="chip">{{ count($cat['items']) }} items</span>
                        </div>

                        <div class="products">
                            @foreach($cat['items'] as $product)
                                <div class="product">
                                    <div class="product-top">
                                        <div class="picon">
                                            @if(!empty($product['icon']) && file_exists(public_path('icons/icons/' . $product['icon'])))
                                                <img src="{{ asset('icons/icons/' . $product['icon']) }}" alt="{{ $product['name'] }}">
                                            @else
                                                ⚡
                                            @endif
                                        </div>
                                        <div style="min-width:0;">
                                            <h4>{{ $product['name'] }}</h4>
                                            <p>{{ $product['desc'] }}</p>
                                        </div>
                                    </div>

                                    @if(!empty($product['tags']))
                                        <div class="tag-row">
                                            @foreach($product['tags'] as $t)
                                                <span class="tag">{{ $t }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Projects --}}
            <div class="section" id="projects" style="page-break-before: always;">
                <div class="section-head">
                    <div>
                        <h2>{{ __('website.projects.title') }}</h2>
                        <p>{{ __('website.projects.subtitle') }}</p>
                    </div>
                    <span class="chip">Portfolio</span>
                </div>

                <div class="projects">
                    @php
                        $projectsPath = public_path('our porfolio');
                        $folders = [];
                        if (is_dir($projectsPath)) {
                            $folders = array_filter(scandir($projectsPath), function($item) use ($projectsPath) {
                                return $item !== '.' && $item !== '..' && is_dir($projectsPath . '/' . $item);
                            });
                            $folders = array_slice($folders, 0, 8);
                        }
                    @endphp

                    @foreach($folders as $folder)
                        @php
                            $folderPath = $projectsPath . '/' . $folder;
                            $images = glob($folderPath . '/*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);
                            $firstImage = !empty($images) ? basename($images[0]) : null;
                        @endphp

                        @if($firstImage)
                            <div class="project">
                                <div class="img">
                                    <img src="{{ asset('our porfolio/' . $folder . '/' . $firstImage) }}" alt="{{ $folder }}">
                                </div>
                                <div class="body">
                                    <h4>{{ $folder }}</h4>
                                    <p>{{ count($images) }} {{ __('website.projects.photos') }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Contact --}}
            <div class="section" id="contact">
                <div class="section-head">
                    <div>
                        <h2>{{ __('website.nav.contact') }}</h2>
                        <p>Get in touch with us</p>
                    </div>
                    <span class="chip">Support</span>
                </div>

                <div class="contact">
                    <div class="contact-grid">
                        <div class="citem">
                            <div class="cicon">📞</div>
                            <div>
                                <h4>Phone</h4>
                                <p>{{ config('website.contact.phone') }}<br>{{ config('website.contact.phone2') }}</p>
                            </div>
                        </div>

                        <div class="citem">
                            <div class="cicon">✉️</div>
                            <div>
                                <h4>Email</h4>
                                <p>{{ config('website.contact.email') }}</p>
                            </div>
                        </div>

                        <div class="citem">
                            <div class="cicon">📱</div>
                            <div>
                                <h4>WhatsApp</h4>
                                <p>{{ config('website.contact.whatsapp') }}</p>
                            </div>
                        </div>

                        <div class="citem">
                            <div class="cicon">📍</div>
                            <div>
                                <h4>Address</h4>
                                <p>{{ config('website.contact.address') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 18px; color: var(--muted); font-size: 12px; font-weight: 700;">
                    © {{ date('Y') }} {{ config('website.name') }} — All rights reserved.
                </div>
            </div>

        </div>
    </div>

    <script>
        // Ctrl+P and print button
        (function(){
            const printNow = () => window.print();

            document.getElementById('printBtn')?.addEventListener('click', printNow);

            document.addEventListener('keydown', function(e){
                const isPrint = (e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 'P');
                if(isPrint){
                    e.preventDefault();
                    printNow();
                }
            });

            document.getElementById('scrollTopBtn')?.addEventListener('click', function(){
                window.scrollTo({top:0, behavior:'smooth'});
            });
        })();
    </script>
</body>
</html>
