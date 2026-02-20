<style>
    [x-cloak]{display:none!important}

    :root{
        --brand-yellow: {{ config('website.primary_color', '#FFDF41') }};
        --brand-orange: {{ config('website.secondary_color', '#E3A000') }};
        --brand-light: {{ config('website.light_green', '#8CC63F') }};
    }

    .dark{
        --s-border:rgba(255,255,255,.10);
        --s-text:rgba(255,255,255,.92);
        --s-muted:rgba(255,255,255,.62);
        --s-card:rgba(0,0,0,.14);
        --s-card2:rgba(0,0,0,.10);
        --s-shadow: 0 22px 60px rgba(0,0,0,.35);
        --s-shadow2: 0 12px 26px rgba(0,0,0,.22);
        --s-head-bg: rgba(0,0,0,.14);
        --s-pill-bg: rgba(255,255,255,.05);
        --s-pill-border: rgba(255,255,255,.12);
        --s-pill-text: rgba(255,255,255,.78);
        --s-input-bg: rgba(255,255,255,.04);
        --s-input-border: rgba(255,255,255,.14);
        --s-input-color: rgba(255,255,255,.90);
        --s-input-placeholder: rgba(255,255,255,.55);
        --s-table-head-bg: rgba(255,255,255,.04);
        --s-table-row-bg: rgba(0,0,0,.06);
        --s-table-row-hover: rgba(255,255,255,.03);
        --s-table-border: rgba(255,255,255,.06);
        --s-empty-bg: rgba(0,0,0,.14);
        --s-empty-border: rgba(255,255,255,.14);
        --s-panel-bg: rgba(0,0,0,.10);
        --s-panel-border: rgba(255,255,255,.10);
        --s-panel-text: rgba(255,255,255,.86);
        --s-panel-muted: rgba(255,255,255,.62);
        --s-danger: #ffd0d0;
        --s-danger-border: rgba(239,68,68,.28);
        --s-danger-bg: rgba(239,68,68,.12);
    }

    html:not(.dark){
        --s-border:rgba(0,0,0,.12);
        --s-text:rgba(0,0,0,.95);
        --s-muted:rgba(0,0,0,.70);
        --s-card:#FFFFFF;
        --s-card2:#FFFFFF;
        --s-shadow: 0 4px 12px rgba(0,0,0,.08);
        --s-shadow2: 0 2px 8px rgba(0,0,0,.06);
        --s-head-bg: rgba(248,249,250,.8);
        --s-pill-bg: rgba(0,0,0,.05);
        --s-pill-border: rgba(0,0,0,.15);
        --s-pill-text: rgba(0,0,0,.85);
        --s-input-bg: rgba(0,0,0,.03);
        --s-input-border: rgba(0,0,0,.18);
        --s-input-color: rgba(0,0,0,.95);
        --s-input-placeholder: rgba(0,0,0,.50);
        --s-table-head-bg: rgba(0,0,0,.05);
        --s-table-row-bg: #FFFFFF;
        --s-table-row-hover: rgba(0,0,0,.03);
        --s-table-border: rgba(0,0,0,.10);
        --s-empty-bg: rgba(0,0,0,.03);
        --s-empty-border: rgba(0,0,0,.18);
        --s-panel-bg: rgba(0,0,0,.03);
        --s-panel-border: rgba(0,0,0,.10);
        --s-panel-text: rgba(0,0,0,.88);
        --s-panel-muted: rgba(0,0,0,.60);
        --s-danger: #b91c1c;
        --s-danger-border: rgba(239,68,68,.35);
        --s-danger-bg: rgba(239,68,68,.10);
    }

    /* Shell */
    .s-shell{
        position:relative;
        border-radius:20px;
        overflow:hidden;
        border:1px solid var(--s-border);
        background: var(--s-card2);
        box-shadow: var(--s-shadow);
    }
    .s-bg{
        position:absolute; inset:0; z-index:0; pointer-events:none;
        background:
            radial-gradient(900px 520px at 16% 10%, rgba(140,198,63,.14), transparent 55%),
            radial-gradient(900px 520px at 86% 18%, rgba(255,223,65,.14), transparent 55%),
            radial-gradient(800px 520px at 72% 90%, rgba(227,160,0,.10), transparent 55%),
            linear-gradient(180deg, rgba(7,11,18,.45), rgba(10,18,32,.25));
        filter: blur(14px);
        opacity:.78;
    }
    .s-wrap{position:relative; z-index:1; padding:16px}

    /* Head */
    .s-head{
        display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;
        padding:14px;
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-head-bg);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        margin-bottom:14px;
    }
    .s-head h3{margin:0;font-size:16px;font-weight:900;color:var(--s-text)}
    .s-head p{margin:6px 0 0;font-size:12px;font-weight:800;color:var(--s-muted);line-height:1.55}
    .s-actions{display:flex;gap:10px;flex-wrap:wrap;align-items:center}

    /* Pills */
    .s-pill{
        display:inline-flex;align-items:center;gap:8px;
        padding:7px 10px;border-radius:999px;
        border:1px solid var(--s-pill-border);
        background: var(--s-pill-bg);
        color: var(--s-pill-text);
        font-size:12px;font-weight:900;
        white-space:nowrap;
    }
    .s-pill .dot{width:8px;height:8px;border-radius:999px;background: var(--s-muted)}
    .s-pill.y .dot{background: rgba(255,223,65,.35)}
    .s-pill.g .dot{background: rgba(140,198,63,.30)}
    .s-pill.r .dot{background: rgba(239,68,68,.45)}

    /* Cards */
    .s-card{
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        padding:14px;
    }
    .s-card-title{margin:0;font-size:14px;font-weight:900;color:var(--s-text)}
    .s-card-sub{margin-top:4px;font-size:12px;font-weight:800;color:var(--s-muted)}
    .s-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:10px}

    /* KPI */
    .s-kpi-grid{display:grid;grid-template-columns:1fr;gap:14px}
    @media(min-width:640px){ .s-kpi-grid{grid-template-columns:repeat(2,1fr)} }
    @media(min-width:1024px){ .s-kpi-grid{grid-template-columns:repeat(3,1fr)} }

    .s-kpi{
        border-radius:16px;
        border:1px solid var(--s-border);
        background: var(--s-card);
        padding:16px;
        box-shadow: var(--s-shadow2);
        backdrop-filter: blur(10px);
        transition:transform .12s ease, box-shadow .12s ease, border-color .12s ease;
    }
    .s-kpi:hover{transform: translateY(-1px); border-color: rgba(255,255,255,.14); box-shadow: 0 16px 34px rgba(0,0,0,.28)}
    .s-kpi .t{font-size:12px;font-weight:900;color:rgba(255,255,255,.68)}
    .s-kpi .v{margin-top:10px;font-size:30px;font-weight:900;color:var(--s-text);letter-spacing:-.2px}
    .s-kpi .m{margin-top:8px;font-size:12px;font-weight:800;color:var(--s-muted)}

    /* Inputs */
    .s-input{
        width:100%;
        padding:10px 12px;
        border-radius:14px;
        border:1px solid var(--s-input-border);
        background: var(--s-input-bg);
        color: var(--s-input-color);
        font-weight:800;
        outline:none;
    }
    .s-input::placeholder{color: var(--s-input-placeholder)}
    .s-input:focus{
        border-color: rgba(255,223,65,.28);
        box-shadow: 0 0 0 4px rgba(255,223,65,.10);
    }

    /* Tabs */
    .s-tabs{display:flex;gap:8px;flex-wrap:wrap}
    .s-tab{
        background: var(--s-pill-bg);
        border:1px solid var(--s-pill-border);
        color: var(--s-pill-text);
        padding:9px 12px;border-radius:12px;font-weight:900;cursor:pointer;
    }
    .s-tab:hover{background: var(--s-table-row-hover)}
    .s-tab.active{border-color: rgba(255,223,65,.26); box-shadow: 0 0 0 4px rgba(255,223,65,.10)}

    /* Table */
    .s-table-card{
        border-radius:14px; overflow:hidden;
        border:1px solid var(--s-border);
        background: var(--s-card2);
    }
    .s-table{width:100%;border-collapse:collapse}
    .s-table thead th{
        text-align:left;font-size:12px;font-weight:900;color:var(--s-muted);
        padding:12px;background: var(--s-table-head-bg);border-bottom:1px solid var(--s-table-border);
        white-space:nowrap;
    }
    .s-table td{
        padding:12px;color:var(--s-text);font-weight:800;
        border-bottom:1px solid var(--s-table-border);background: var(--s-table-row-bg);
        vertical-align:middle;
    }
    .s-table tbody tr:hover td{background: var(--s-table-row-hover)}
    .s-muted{color: var(--s-muted)!important}
    .s-strong{font-weight:900;color:var(--s-text)}

    .s-empty{
        padding:14px;border-radius:14px;border:1px dashed var(--s-empty-border);
        background: var(--s-empty-bg);color:var(--s-muted);font-weight:800;line-height:1.55;
        text-align:center;
    }

    .s-panel{
        border-radius:14px;
        border:1px solid var(--s-panel-border);
        background: var(--s-panel-bg);
        padding:12px;
        color: var(--s-panel-text);
    }
    .s-panel-body{
        margin-top:8px;
        color: var(--s-panel-text);
        font-weight:800;
        line-height:1.55;
    }
    .s-panel-muted{
        color: var(--s-panel-muted);
        font-size:12px;
        font-weight:800;
    }

    /* Buttons (match theme without touching global css) */
    .crm-btn.crm-btn-primary{
        background: linear-gradient(135deg, var(--brand-yellow) 0%, var(--brand-orange) 100%) !important;
        color:#0b122a !important;
        border: 1px solid rgba(255,255,255,.08) !important;
        box-shadow: 0 18px 34px rgba(227,160,0,0.18);
        font-weight:900;
    }
    .crm-btn.crm-btn-ghost{
        background: rgba(255,255,255,.04) !important;
        border:1px solid rgba(255,255,255,.14) !important;
        color: rgba(255,255,255,.86) !important;
        font-weight:900;
    }
    .crm-btn.crm-btn-ghost:hover{background: rgba(255,255,255,.07) !important}
</style>
