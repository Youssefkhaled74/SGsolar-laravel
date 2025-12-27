<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ config('website.name') }} - Company Catalog</title>

    <style>
        /* =========================
           PRO CATALOG (RTL) - A4
           Single file: CSS + JS
        ========================== */

        :root{
            --primary:#FFDF41;
            --primary2:#E3A000;
            --green:#0C2D1C;
            --green2:#115F45;
            --ink:#111827;
            --muted:#6B7280;
            --border:rgba(17,24,39,.10);
            --shadow: 0 18px 45px rgba(0,0,0,.08);
            --soft: rgba(17,24,39,.04);
        }

        *{box-sizing:border-box;margin:0;padding:0}
        body{
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
            color:var(--ink);
            background:#f3f4f6;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ====== Layout wrappers ====== */
        .book{
            max-width:1100px;
            margin:24px auto;
            padding:0 14px 30px;
        }
        .page{
            width: 210mm;
            min-height: 297mm;
            background:#fff;
            border-radius:18px;
            box-shadow: var(--shadow);
            overflow:hidden;
            position:relative;
            margin: 0 auto 18px;
        }

        .page-inner{
            padding: 18mm 16mm 18mm;
        }

        /* ====== Top header (for inner pages) ====== */
        .page-head{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            padding: 4mm 16mm 2mm;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, rgba(12,45,28,.04), rgba(255,223,65,.06));
            /* make header less heavy in print */
            box-shadow: none;
        }
        .brand{
            display:flex;
            align-items:center;
            gap:10px;
            min-width:0;
        }
        .brand .logo{
            width:44px;height:44px;
            border-radius:14px;
            display:grid;place-items:center;
            background: linear-gradient(135deg, var(--green), var(--green2));
            color:#fff;
            font-weight:1000;
            letter-spacing:.4px;
            flex:0 0 auto;
            overflow:hidden;
        }
        .brand .logo img{width:100%;height:100%;object-fit:cover}
        .brand .txt{min-width:0}
        .brand .txt .name{
            font-weight:1000;
            font-size:14px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .brand .txt .tag{
            font-size:12px;
            color:var(--muted);
            font-weight:700;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .head-meta{
            display:flex;
            align-items:center;
            gap:8px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }
        .pill{
            background:#fff;
            border:1px solid rgba(17,24,39,.06);
            border-radius:999px;
            padding:6px 10px;
            font-size:11px;
            font-weight:800;
            color:var(--green);
            box-shadow: none;
        }
        .pill b{color:var(--ink)}

        /* ====== Footer for page numbers (injected by JS) ====== */
        .page-footer{
            position:absolute;
            left:0; right:0;
            bottom:0;
            padding: 6mm 14mm 6mm;
            border-top:1px solid rgba(17,24,39,.04);
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
            background: transparent;
            /* keep footers light and non-obtrusive */
            box-shadow: none;
        }
        .page-footer .foot-left{
            font-size:11px;
            color:var(--muted);
            font-weight:700;
        }
        .page-footer .foot-right{
            font-size:11px;
            color:var(--muted);
            font-weight:700;
        }
        .page-footer .pageno{
            font-size:11px;
            color:var(--ink);
            font-weight:900;
            background: rgba(255,223,65,.12);
            border: 1px solid rgba(227,160,0,.16);
            padding:5px 9px;
            border-radius:999px;
        }

        /* ====== Cover ====== */
        .cover{
            background: radial-gradient(1200px 600px at 10% 10%, rgba(255,223,65,.22), transparent 55%),
                        radial-gradient(900px 600px at 90% 20%, rgba(17,95,69,.18), transparent 55%),
                        linear-gradient(135deg, var(--green) 0%, var(--green2) 100%);
            color:#fff;
        }
        .cover .page-inner{
            padding: 24mm 18mm;
            display:flex;
            flex-direction:column;
            justify-content:space-between;
            min-height:297mm;
        }
        .cover-top{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:16px;
        }
        .cover-logo{
            display:flex;
            align-items:center;
            gap:12px;
        }
        .cover-logo .mark{
            width:64px;height:64px;border-radius:18px;
            background: rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.18);
            display:grid;place-items:center;
            overflow:hidden;
        }
        .cover-logo .mark img{width:100%;height:100%;object-fit:contain;filter: brightness(0) invert(1);}
        .cover-logo .text .co{
            font-size:18px;
            font-weight:1000;
            letter-spacing:.3px;
        }
        .cover-logo .text .sl{
            font-size:12px;
            opacity:.85;
            margin-top:2px;
            font-weight:700;
        }

        .cover-year{
            background: rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.18);
            padding:10px 14px;
            border-radius:999px;
            font-weight:1000;
            font-size:12px;
            white-space:nowrap;
        }

        .cover-mid{
            text-align:center;
            margin-top:6mm;
        }
        .cover-title{
            font-size:44px;
            font-weight:1100;
            color:var(--primary);
            letter-spacing:.4px;
            line-height:1.15;
        }
        .cover-sub{
            margin-top:10px;
            font-size:18px;
            opacity:.92;
            font-weight:600;
        }
        .cover-divider{
            width:220px;height:3px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
            margin:18px auto 16px;
            border-radius:999px;
        }
        .cover-note{
            font-size:14px;
            opacity:.85;
            font-weight:700;
        }

        .cover-bottom{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:16px;
            align-items:end;
        }
        .cover-card{
            background: rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.18);
            border-radius:18px;
            padding:14px 16px;
        }
        .cover-card h4{
            font-size:12px;
            opacity:.9;
            font-weight:1000;
            color: #fff;
            margin-bottom:8px;
            letter-spacing:.4px;
        }
        .cover-card p{
            font-size:12px;
            opacity:.9;
            line-height:1.7;
            font-weight:650;
        }

        /* ====== Section header ====== */
        .section-header{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:14px;
            margin-bottom:12px;
            padding-bottom:6px;
            border-bottom: 1px dashed rgba(17,24,39,.03);
        }
        .sec-left{
            min-width:0;
            flex:1;
        }
        .sec-kicker{
            display:flex;
            align-items:center;
            gap:12px;
        }
        .sec-no{
            width:44px;height:44px;border-radius:14px;
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            display:grid;place-items:center;
            font-weight:1100;
            color:#1f2937;
            border: 1px solid rgba(0,0,0,.08);
            flex:0 0 auto;
        }
        .sec-title{
            font-size:24px;
            font-weight:1100;
            color:var(--green);
            line-height:1.1;
        }
        .sec-title-en{
            font-size:12px;
            color:var(--muted);
            font-weight:900;
            margin-top:2px;
            letter-spacing:.3px;
        }
        .sec-line{
            height:2px;
            background: linear-gradient(90deg, var(--primary), transparent);
            margin-top:10px;
            border-radius:999px;
            width:100%;
        }

        /* ====== Cards / grids ====== */
        .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .card{
            border:1px solid var(--border);
            background: #fff;
            border-radius:18px;
            overflow:hidden;
        }
        .card.pad{padding:14px}
        .card.soft{
            background: linear-gradient(180deg, rgba(17,24,39,.02), #fff);
        }
        .muted{color:var(--muted)}
        .small{font-size:12px}
        .bold{font-weight:1000}

        /* ====== About ====== */
        .about-hero{
            display:grid;
            grid-template-columns: 1.2fr .8fr;
            gap:14px;
        }
        .about-hero .img{
            border-radius:18px;
            overflow:hidden;
            border:1px solid var(--border);
            background:#f3f4f6;
            min-height:240px;
        }
        .about-hero .img img{width:100%;height:100%;object-fit:cover}
        .about-hero h3{
            font-size:16px;font-weight:1100;color:var(--green);
            margin-bottom:8px;
        }
        .about-hero p{
            font-size:13px;
            color:var(--ink);
            line-height:1.9;
            font-weight:650;
        }

        .stats{
            display:grid;
            grid-template-columns: repeat(4, 1fr);
            gap:10px;
            margin-top:14px;
        }
        .stat{
            border-radius:18px;
            background: linear-gradient(135deg, var(--green), var(--green2));
            color:#fff;
            padding:12px;
            border:1px solid rgba(255,255,255,.12);
        }
        .stat .n{
            font-size:26px;
            font-weight:1200;
            color: var(--primary);
        }
        .stat .l{
            font-size:11px;
            opacity:.9;
            font-weight:900;
            margin-top:6px;
        }

        /* ====== Products ====== */
        .cat-block{
            border:1px solid var(--border);
            border-radius:18px;
            background: linear-gradient(180deg, rgba(17,24,39,.02), #fff);
            padding:12px;
            overflow:hidden;
        }
        .cat-title{
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:10px;
            margin-bottom:8px;
        }
        .cat-title h3{
            font-size:14px;
            font-weight:1200;
            color:var(--green);
            line-height:1.25;
        }
        .cat-title .en{
            font-size:11px;
            color:var(--muted);
            font-weight:900;
            margin-top:2px;
            letter-spacing:.3px;
        }

        .product{
            border:1px solid var(--border);
            border-radius:16px;
            padding:10px;
            background:#fff;
            display:flex;
            gap:10px;
            align-items:flex-start;
        }
        .product + .product{margin-top:10px}
        .product .icon{
            width:38px;height:38px;
            border-radius:14px;
            display:grid;place-items:center;
            background: rgba(17,95,69,.10);
            border:1px solid rgba(17,95,69,.18);
            font-weight:1000;
            flex:0 0 auto;
        }
        .product .name{
            font-size:13px;
            font-weight:1100;
            line-height:1.4;
        }
        .product .desc{
            font-size:11.5px;
            color:var(--muted);
            margin-top:4px;
            line-height:1.7;
            font-weight:650;
        }

        /* ====== Projects ====== */
        .proj-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .proj{
            border:1px solid var(--border);
            border-radius:18px;
            overflow:hidden;
            background:#fff;
        }
        .proj .img{
            height:160px;
            background:#f3f4f6;
        }
        .proj .img img{width:100%;height:100%;object-fit:cover}
        .proj .body{padding:12px}
        .proj .title{font-size:13px;font-weight:1100;color:var(--green)}
        .proj .meta{font-size:11px;color:var(--muted);font-weight:800;margin-top:6px}

        /* ====== Contact ====== */
        .contact{
            background: linear-gradient(135deg, var(--green) 0%, var(--green2) 100%);
            color:#fff;
            border-radius:18px;
            padding:14px;
            border:1px solid rgba(255,255,255,.10);
        }
        .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px}
        .citem{
            background: rgba(255,255,255,.10);
            border:1px solid rgba(255,255,255,.18);
            border-radius:16px;
            padding:10px;
            display:flex;
            gap:10px;
            align-items:flex-start;
        }
        .cicon{
            width:34px;height:34px;border-radius:14px;
            background: rgba(255,223,65,.22);
            border:1px solid rgba(255,223,65,.22);
            display:grid;place-items:center;
            font-weight:1000;
            flex:0 0 auto;
        }
        .ctxt h4{font-size:12px;font-weight:1100;color:var(--primary)}
        .ctxt p{font-size:11.5px;opacity:.95;margin-top:3px;line-height:1.7;font-weight:650}

        /* ====== Avoid breaking cards in print ====== */
        .avoid-break{break-inside: avoid; page-break-inside: avoid;}
        .page-break{page-break-before: always; break-before: page;}

        /* ====== Print ====== */
        @media print{
            body{background:#fff}
            .book{max-width:none;margin:0;padding:0}
            .page{
                margin:0;
                box-shadow:none;
                border-radius:0;
                width:210mm;
                min-height:297mm;
            }
            @page{size:A4;margin:0}
        }

        /* Responsive screen only */
        @media (max-width: 980px){
            .page{width:100%;min-height:auto}
            .page-inner{padding:18px}
            .page-head{padding:16px}
            .page-footer{padding:12px 16px}
        }
        @media (max-width: 780px){
            .grid-2,.proj-grid,.about-hero{grid-template-columns:1fr}
            .stats{grid-template-columns:1fr 1fr}
            .contact-grid{grid-template-columns:1fr}
        }
    </style>
</head>

<body>
@php
    use Illuminate\Support\Facades\Lang;

    // Force Arabic visual content, but still use website config values
    $companyName = config('website.name');
    $slogan      = config('website.slogan');
    $mission     = config('website.mission');

    $logoPath    = config('website.logo');

    // Products from your translation structure
    $panels = Lang::get('website.products.solar_panels.items');
    $lights = Lang::get('website.products.solar_lights.items');
    $swh    = Lang::get('website.products.swh.items');

    $panels = is_array($panels) ? $panels : [];
    $lights = is_array($lights) ? $lights : [];
    $swh    = is_array($swh)    ? $swh    : [];

    // Combine language product lists into one ordered array (Arabic data source)
    $langProductsCombined = array_values(array_merge($swh, $lights, $panels));

    // About stats
    $stats  = Lang::get('website.about.stats');
    $stats  = is_array($stats) ? $stats : [];

    // Projects (folders)
    $projectsPath = public_path('our porfolio');
    $folders = [];
    if (is_dir($projectsPath)) {
        $folders = array_filter(scandir($projectsPath), function($item) use ($projectsPath) {
            return $item !== '.' && $item !== '..' && is_dir($projectsPath . '/' . $item);
        });
        // show more if you want
        $folders = array_values($folders);
    }

    $safe = function($v){ return e((string)($v ?? '')); };

    $sections = [
        ['id'=>'about','no'=>'01','ar'=>'من نحن','en'=>'About Us'],
        ['id'=>'products','no'=>'02','ar'=>'المنتجات','en'=>'Products'],
        ['id'=>'projects','no'=>'03','ar'=>'المشاريع','en'=>'Projects'],
        ['id'=>'contact','no'=>'04','ar'=>'تواصل معنا','en'=>'Contact'],
    ];
@endphp

<div class="book" id="catalogBook">

    {{-- ================= COVER PAGE ================= --}}
    <div class="page cover" data-nofooter="1">
        <div class="page-inner">
            <div class="cover-top">
                <div class="cover-logo">
                    <div class="mark">
                        @if($logoPath)
                            <img src="{{ asset($logoPath) }}" alt="{{ $safe($companyName) }}" style="width:100%;height:100%;object-fit:contain;">
                        @endif
                    </div>
                    <div class="text">
                        <div class="co">{{ $companyName }}</div>
                        <div class="sl">{{ $slogan }}</div>
                    </div>
                </div>
                <div class="cover-year">Company Catalog — {{ date('Y') }}</div>
            </div>

            <div class="cover-mid">
                <div class="cover-title">{{ $companyName }}</div>
                <div class="cover-sub">{{ $slogan }}</div>
                <div class="cover-divider"></div>
                <div class="cover-note">كتالوج الشركة — عرض المنتجات والمشاريع والخدمات</div>
            </div>

            <!-- cover-bottom removed as requested -->
        </div>
    </div>

    {{-- ================= ABOUT (01) ================= --}}
    <div class="page" data-section="about">
        <div class="page-head">
            <div class="brand">
                <div class="logo">
                    @if($logoPath)
                        <img src="{{ asset($logoPath) }}" alt="{{ $safe($companyName) }}">
                    @else
                        {{ mb_substr((string)$companyName,0,1) }}
                    @endif
                </div>
                <div class="txt">
                    <div class="name">{{ $companyName }}</div>
                    <div class="tag">{{ $slogan }}</div>
                </div>
            </div>

            <div class="head-meta">
                <div class="pill"><b>01</b> — من نحن</div>
                <div class="pill">{{ date('Y') }}</div>
            </div>
        </div>

        <div class="page-inner">
            <div class="section-header">
                <div class="sec-left">
                    <div class="sec-kicker">
                        <div class="sec-no">01</div>
                        <div>
                            <div class="sec-title">{{ __('website.about.title') }}</div>
                            <div class="sec-title-en">About Us</div>
                        </div>
                    </div>
                    <div class="sec-line"></div>
                </div>
                <div class="pill"><b>{{ __('website.about.subtitle') }}</b></div>
            </div>


            <div class="about-hero">
                <div class="card pad soft avoid-break" style="background: linear-gradient(135deg, #f9fbe7 60%, #e0f2f1 100%); border: 2px solid #e0e0e0;">
                    <h3 style="color: var(--primary); font-size: 20px; font-weight: 900; margin-bottom: 10px;">من نحن</h3>
                    <p class="muted" style="margin-top:6px; font-size: 15px; color: #222; font-weight: 700; line-height: 2.1;">
                        نحن في <span style="color: var(--green); font-weight: 900;">SG Solar</span> نؤمن بأن الطاقة الشمسية هي مستقبل الاستدامة. نلتزم بتقديم حلول تسخين مياه صديقة للبيئة وموفرة للطاقة، مع ضمان أعلى مستويات الجودة والكفاءة لعملائنا في المنازل والشركات.
                    </p>
                    <div style="margin-top:18px; background: #fffbe7; border-radius: 12px; padding: 12px 14px; border: 1px solid #ffe082;">
                        <div class="bold" style="color:var(--primary2);font-size:15px; margin-bottom: 6px;">لماذا تختارنا؟</div>
                        <ul style="font-size: 13px; color: #444; font-weight: 700; line-height: 2; margin: 0 0 0 18px; padding: 0; list-style: disc inside;">
                            <li>خبرة عميقة وفريق متخصص في الطاقة الشمسية.</li>
                            <li>حلول مخصصة تلبي احتياجاتك بدقة.</li>
                            <li>ضمان الجودة وخدمة ما بعد البيع المتميزة.</li>
                            <li>أسعار تنافسية وشفافية كاملة في التعامل.</li>
                            <li>دعم فني واستشارات مجانية لتحقيق أفضل النتائج.</li>
                        </ul>
                    </div>
                </div>
                <div class="about-hero img avoid-break">
                    <img src="{{ asset('images/aboutus.png') }}" alt="About {{ $safe($companyName) }}">
                </div>
            </div>

            @if(!empty($stats))
                <div class="stats">
                    @foreach($stats as $st)
                        <div class="stat avoid-break">
                            <div class="n">
                                {{ $st['number'] ?? '' }}{{ $st['suffix'] ?? '' }}
                            </div>
                            <div class="l">{{ $st['label'] ?? '' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ================= PRODUCTS (02) ================= --}}
    <div class="page" data-section="products">
        <div class="page-head">
            <div class="brand">
                <div class="logo">
                    @if($logoPath)
                        <img src="{{ asset($logoPath) }}" alt="{{ $safe($companyName) }}">
                    @else
                        {{ mb_substr((string)$companyName,0,1) }}
                    @endif
                </div>
                <div class="txt">
                    <div class="name">{{ $companyName }}</div>
                    <div class="tag">Company Catalog</div>
                </div>
            </div>

            <div class="head-meta">
                <div class="pill"><b>02</b> — المنتجات</div>
                <div class="pill">{{ __('website.products.subtitle') }}</div>
            </div>
        </div>

        <div class="page-inner">
            <div class="section-header">
                <div class="sec-left">
                    <div class="sec-kicker">
                        <div class="sec-no">02</div>
                        <div>
                            <div class="sec-title">{{ __('website.products.title') }}</div>
                            <div class="sec-title-en">Products</div>
                        </div>
                    </div>
                    <div class="sec-line"></div>
                </div>
                <div class="pill"><b>{{ __('website.products.subtitle') }}</b></div>
            </div>

            @php
                $sectionData = [
                    [
                        'icon' => '🧱',
                        'title_ar' => Lang::get('website.products.solar_panels.title'),
                        'title_en' => 'Solar Panels',
                        'desc' => Lang::get('website.products.solar_panels.description'),
                        'items' => $panels,
                        'meta_key' => 'power',
                        'meta_label' => 'القدرة / Power',
                    ],
                    [
                        'icon' => '💡',
                        'title_ar' => Lang::get('website.products.solar_lights.title'),
                        'title_en' => 'Solar Lights',
                        'desc' => Lang::get('website.products.solar_lights.description'),
                        'items' => $lights,
                        'meta_key' => 'power',
                        'meta_label' => 'القدرة / Power',
                    ],
                    [
                        'icon' => '🔥',
                        'title_ar' => Lang::get('website.products.swh.title'),
                        'title_en' => 'Solar Water Heaters',
                        'desc' => Lang::get('website.products.swh.description'),
                        'items' => $swh,
                        'meta_key' => 'capacity',
                        'meta_label' => 'السعة / Capacity',
                    ],
                ];
            @endphp

            <div class="grid-2">
                @foreach($sectionData as $sec)
                    <div class="cat-block avoid-break">
                        <div class="cat-title">
                            <div>
                                <h3>{{ $sec['title_ar'] }}</h3>
                                <div class="en">{{ $sec['title_en'] }}</div>
                            </div>
                            <div style="font-size:18px;font-weight:1200">{{ $sec['icon'] }}</div>
                        </div>

                        @if(!empty($sec['desc']))
                            <div class="small muted" style="font-weight:800;margin-bottom:10px;line-height:1.7;">
                                {{ $sec['desc'] }}
                            </div>
                        @endif

                        @forelse($sec['items'] as $it)
                            @php
                                $name  = $it['name'] ?? '';
                                $en    = $it['english_name'] ?? '';
                                $desc  = $it['description'] ?? ($it['full_content'] ?? '');
                                $img   = $it['image'] ?? null;
                                $badge = $it['badge'] ?? null;
                                $meta  = $sec['meta_key'] ? ($it[$sec['meta_key']] ?? '') : '';
                            @endphp

                            <div class="product avoid-break">
                                <div class="icon">{{ $sec['icon'] }}</div>

                                <div style="flex:1;min-width:0">
                                    <div style="display:flex;gap:10px;justify-content:space-between;align-items:flex-start;">
                                        <div style="min-width:0">
                                            <div class="name">{{ $name }}</div>
                                            @if($en)
                                                <div class="desc" style="font-weight:1000;letter-spacing:.2px">{{ $en }}</div>
                                            @endif
                                        </div>

                                        @if($badge)
                                            <div style="
                                                background: rgba(255,223,65,.22);
                                                border: 1px solid rgba(227,160,0,.28);
                                                color:#7a4b00;
                                                font-weight:1100;
                                                font-size:11px;
                                                padding:6px 10px;
                                                border-radius:999px;
                                                white-space:nowrap;
                                                flex:0 0 auto;
                                            ">{{ $badge }}</div>
                                        @endif
                                    </div>

                                    @if($meta)
                                        <div class="desc" style="margin-top:6px">
                                            <b style="color:var(--ink)">{{ $sec['meta_label'] }}:</b> {{ $meta }}
                                        </div>
                                    @endif

                                    @if($desc)
                                        <div class="desc" style="margin-top:6px">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($desc), 220) }}
                                        </div>
                                    @endif
                                </div>

                                @if($img)
                                    <div style="width:86px;flex:0 0 auto">
                                        <div style="border-radius:16px;overflow:hidden;border:1px solid var(--border);background:#f3f4f6;">
                                            <img src="{{ asset(ltrim($img,'/')) }}" alt="{{ $safe($name) }}" style="width:86px;height:86px;object-fit:cover;">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="small muted">لا توجد منتجات في هذا القسم حالياً.</div>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================= PRODUCT PAGES (individual) ================= --}}
    @php
        $langProducts = is_array($langProductsCombined) ? $langProductsCombined : [];
    @endphp
    @foreach($langProducts as $pIndex => $prod)
        @php
            // Normalize product fields from translation arrays
            $pName = $prod['name'] ?? ($prod['english_name'] ?? '');
            $pDesc = $prod['full_content'] ?? ($prod['description'] ?? '');
            $pImg  = $prod['image'] ?? ($prod['image_path'] ?? null);
            $pFeatures = is_array($prod['features'] ?? null) ? $prod['features'] : [];
            $pBadge = $prod['badge'] ?? null;
        @endphp

        <div class="page page-break" data-section="product-{{ $pIndex+1 }}">
            <div class="page-head">
                <div class="brand">
                    <div class="logo">
                        @if(!empty($pImg))
                            <img src="{{ asset(ltrim($pImg,'/')) }}" alt="{{ $safe($pName) }}" style="width:100%;height:100%;object-fit:cover">
                        @elseif($logoPath)
                            <img src="{{ asset($logoPath) }}" alt="{{ $safe($companyName) }}">
                        @else
                            {{ mb_substr((string)$companyName,0,1) }}
                        @endif
                    </div>
                    <div class="txt">
                        <div class="name">{{ $pName }}</div>
                        <div class="tag">المنتج {{ sprintf('%02d', $pIndex+1) }}</div>
                    </div>
                </div>

                <div class="head-meta">
                    <div class="pill"><b>{{ sprintf('%02d', $pIndex+1) }}</b> — المنتج</div>
                    <div class="pill">{{ $pBadge ?? '' }}</div>
                </div>
            </div>

            <div class="page-inner">
                <div class="section-header">
                    <div class="sec-left">
                        <div class="sec-kicker">
                            <div class="sec-no">{{ sprintf('%02d', $pIndex+1) }}</div>
                            <div>
                                <div class="sec-title">{{ $pName }}</div>
                                <div class="sec-title-en">Product Details</div>
                            </div>
                        </div>
                        <div class="sec-line"></div>
                    </div>
                    <div class="pill"><b>{{ $prod['price'] ?? '' }} {{ $prod['currency'] ?? '' }}</b></div>
                </div>

                <div style="display:grid;grid-template-columns: 1fr 1.1fr;gap:18px;align-items:start;">
                    <div class="card pad" style="min-height:220px; display:flex;align-items:center;justify-content:center;">
                        @if(!empty($pImg))
                            <img src="{{ asset(ltrim($pImg,'/')) }}" alt="{{ $safe($pName) }}" style="max-width:100%;max-height:260px;object-fit:contain;">
                        @else
                            <div style="width:100%;height:200px;background:#f3f4f6;border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--muted);">No Image</div>
                        @endif
                    </div>

                    <div>
                        <div class="card pad soft avoid-break" style="margin-bottom:12px;">
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;">
                                <div>
                                    <div style="font-size:18px;font-weight:1100;color:var(--green);">{{ $pName }}</div>
                                    @if(!empty($pDesc))
                                        <div class="muted" style="margin-top:8px;font-weight:700;line-height:1.8;">{!! nl2br(e(strip_tags($pDesc))) !!}</div>
                                    @endif
                                </div>
                                <div style="text-align:right;min-width:120px;">
                                    @if(!empty($prod['price']) || !empty($prod['currency']))
                                        <div style="background:var(--primary);color:#10221b;padding:8px 10px;border-radius:10px;font-weight:1100;">{{ $prod['price'] ?? '' }} {{ $prod['currency'] ?? '' }}</div>
                                    @endif
                                    @if(!empty($pFeatures))
                                        <div style="margin-top:10px;font-size:12px;color:var(--muted);">مزايا سريعة:</div>
                                        <ul style="margin-top:6px;">
                                            @foreach(array_slice($pFeatures,0,6) as $feat)
                                                <li style="font-size:13px;color:#333;font-weight:700;line-height:1.8;">{{ $feat }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!empty($pFeatures))
                            <div class="card pad avoid-break">
                                <div class="bold" style="color:var(--green);margin-bottom:8px;font-size:15px;">الخصائص التفصيلية</div>
                                <ul style="list-style:disc inside; margin-left:12px;">
                                    @foreach($pFeatures as $f)
                                        <li style="font-size:13px;color:var(--muted);font-weight:700;line-height:1.8;">{{ $f }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach



    {{-- ================= CONTACT (04) ================= --}}
    <div class="page" data-section="contact">
        <div class="page-head">
            <div class="brand">
                <div class="logo">
                    @if($logoPath)
                        <img src="{{ asset($logoPath) }}" alt="{{ $safe($companyName) }}">
                    @else
                        {{ mb_substr((string)$companyName,0,1) }}
                    @endif
                </div>
                <div class="txt">
                    <div class="name">{{ $companyName }}</div>
                    <div class="tag">Get in touch</div>
                </div>
            </div>

            <div class="head-meta">
                <div class="pill"><b>04</b> — تواصل معنا</div>
                <div class="pill">{{ config('website.contact.email') }}</div>
            </div>
        </div>

        <div class="page-inner">
            <div class="section-header">
                <div class="sec-left">
                    <div class="sec-kicker">
                        <div class="sec-no">04</div>
                        <div>
                            <div class="sec-title">{{ __('website.nav.contact') }}</div>
                            <div class="sec-title-en">Contact</div>
                        </div>
                    </div>
                    <div class="sec-line"></div>
                </div>
                <div class="pill"><b>We’re here to help</b></div>
            </div>

            <div class="contact avoid-break">
                <div class="bold" style="font-size:14px;color:#fff;">بيانات التواصل</div>
                <div class="contact-grid">
                    <div class="citem avoid-break">
                        <div class="cicon">📞</div>
                        <div class="ctxt">
                            <h4>Phone</h4>
                            <p>{{ config('website.contact.phone') }}<br>{{ config('website.contact.phone2') }}</p>
                        </div>
                    </div>

                    <div class="citem avoid-break">
                        <div class="cicon">✉️</div>
                        <div class="ctxt">
                            <h4>Email</h4>
                            <p>{{ config('website.contact.email') }}</p>
                        </div>
                    </div>

                    <div class="citem avoid-break">
                        <div class="cicon">📱</div>
                        <div class="ctxt">
                            <h4>WhatsApp</h4>
                            <p>{{ config('website.contact.whatsapp') }}</p>
                        </div>
                    </div>

                    <div class="citem avoid-break">
                        <div class="cicon">📍</div>
                        <div class="ctxt">
                            <h4>Address</h4>
                            <p>{{ config('website.contact.address') }}</p>
                        </div>
                    </div>
                </div>

                <div style="margin-top:12px;background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.18);border-radius:16px;padding:10px;">
                    <div style="font-size:12px;font-weight:1000;color:var(--primary);">ملاحظة للطباعة</div>
                    <div style="font-size:11.5px;opacity:.92;line-height:1.7;font-weight:650;margin-top:6px;">
                        للحصول على PDF نظيف مثل الصورة: من نافذة الطباعة <b>اقفل Headers and footers</b> + فعّل <b>Background graphics</b>.
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
/**
 * - Ctrl+P prints
 * - Inject footer with page numbers for each .page (except cover data-nofooter=1)
 * - This gives consistent page numbers in PDF output
 */
(function(){
    function injectFooters(){
        const pages = Array.from(document.querySelectorAll('.page'));
        const printablePages = pages.filter(p => !p.dataset.nofooter);
        const total = printablePages.length;

        // Remove old footers
        pages.forEach(p=>{
            const old = p.querySelector('.page-footer');
            if(old) old.remove();
        });

        let i = 0;
        printablePages.forEach(p=>{
            i++;
            const foot = document.createElement('div');
            foot.className = 'page-footer';
            foot.innerHTML = `
                <div class="foot-left">{{ addslashes(config('website.name')) }} — Company Catalog</div>
                <div class="pageno">${i} / ${total}</div>
                <div class="foot-right">{{ date('Y') }}</div>
            `;
            p.appendChild(foot);
        });
    }

    document.addEventListener('keydown', function(e){
        if ((e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 'P')) {
            e.preventDefault();
            injectFooters();
            window.print();
        }
    });

    window.addEventListener('beforeprint', injectFooters);
    window.addEventListener('load', injectFooters);
    window.addEventListener('resize', ()=>{ /* keep it light */ });

})();
</script>
</body>
</html>
