@extends('crm.layouts.sales')

@section('title','Followups')

@section('content')
@include('crm.sales.partials.theme')

@php
    // controller ممكن يبعت followups كـ collection واحدة
    // أو يبعت todayFollowups / overdueFollowups
    $todayFollowups = $todayFollowups ?? collect();
    $overdueFollowups = $overdueFollowups ?? collect();

    // لو عندك متغير واحد $followups (زي ملفك القديم) هنقسمه بشكل آمن:
    if(isset($followups) && $followups instanceof \Illuminate\Support\Collection){
        $todayFollowups = $todayFollowups->count() ? $todayFollowups : $followups->filter(function($f){
            $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null;
            return $when && !$f->completed && $when->isToday();
        })->values();

        $overdueFollowups = $overdueFollowups->count() ? $overdueFollowups : $followups->filter(function($f){
            $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null;
            return $when && !$f->completed && $when->isPast() && !$when->isToday();
        })->values();
    }
@endphp

<div class="s-shell" x-data="{tab:'today'}">
    <div class="s-bg" aria-hidden="true"></div>

    <div class="s-wrap">
        <div class="s-head">
            <div style="min-width:260px;flex:1">
                <h3>Followups</h3>
                <p>Focus on overdue first, then handle today’s schedule.</p>

                <div style="margin-top:10px;display:flex;gap:10px;flex-wrap:wrap">
                    <span class="s-pill y"><span class="dot"></span>Today: {{ $todayFollowups->count() }}</span>
                    <span class="s-pill r"><span class="dot"></span>Overdue: {{ $overdueFollowups->count() }}</span>
                </div>
            </div>

            <div class="s-actions">
                <a href="{{ route('crm.sales.leads.index') }}" class="crm-btn crm-btn-ghost">My Leads</a>
                <a href="{{ route('crm.sales.dashboard') }}" class="crm-btn crm-btn-primary">Dashboard</a>
            </div>
        </div>

        <div class="s-card">
            <div class="s-card-head">
                <div>
                    <h4 class="s-card-title">Today & Overdue</h4>
                    <div class="s-card-sub">Mark followups done as you complete them.</div>
                </div>

                <div class="s-tabs">
                    <button type="button" class="s-tab" :class="tab==='today' ? 's-tab active' : 's-tab'" @click="tab='today'">
                        Today ({{ $todayFollowups->count() }})
                    </button>
                    <button type="button" class="s-tab" :class="tab==='overdue' ? 's-tab active' : 's-tab'" @click="tab='overdue'">
                        Overdue ({{ $overdueFollowups->count() }})
                    </button>
                </div>
            </div>

            {{-- TODAY --}}
            <div x-show="tab==='today'" x-cloak>
                @if($todayFollowups->count())
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach($todayFollowups as $f)
                            @php $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null; @endphp
                            <div class="s-panel">
                                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                    <div>
                                        <div class="s-strong">{{ optional($f->lead)->name ?? 'Lead' }}</div>
                                        <div class="s-muted" style="font-size:12px;font-weight:800;margin-top:4px">
                                            {{ $when ? $when->toDayDateTimeString() : '—' }}
                                        </div>
                                    </div>
                                    <span class="s-pill y"><span class="dot"></span>Today</span>
                                </div>

                                <div class="s-panel-body">
                                    {{ $f->note ?? '—' }}
                                </div>

                                <div style="margin-top:10px;display:flex;justify-content:flex-end">
                                    @if(!($f->completed ?? false))
                                        <form method="POST" action="{{ route('crm.sales.followups.done', $f->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                        </form>
                                    @else
                                        <div class="s-muted" style="font-size:12px;font-weight:800">Done</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="s-empty">No followups for today.</div>
                @endif
            </div>

            {{-- OVERDUE --}}
            <div x-show="tab==='overdue'" x-cloak>
                @if($overdueFollowups->count())
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach($overdueFollowups as $f)
                            @php $when = $f->scheduled_at ? \Carbon\Carbon::parse($f->scheduled_at) : null; @endphp
                            <div class="s-panel">
                                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;align-items:center">
                                    <div>
                                        <div class="s-strong">{{ optional($f->lead)->name ?? 'Lead' }}</div>
                                        <div class="s-muted" style="font-size:12px;font-weight:800;margin-top:4px">
                                            {{ $when ? $when->toDayDateTimeString() : '—' }}
                                        </div>
                                    </div>
                                    <span class="s-pill r"><span class="dot"></span>Overdue</span>
                                </div>

                                <div class="s-panel-body">
                                    {{ $f->note ?? '—' }}
                                </div>

                                <div style="margin-top:10px;display:flex;justify-content:flex-end">
                                    @if(!($f->completed ?? false))
                                        <form method="POST" action="{{ route('crm.sales.followups.done', $f->id) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                        </form>
                                    @else
                                        <div class="s-muted" style="font-size:12px;font-weight:800">Done</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="s-empty">No overdue followups 🎉</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

