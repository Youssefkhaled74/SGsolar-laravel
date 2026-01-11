@extends('crm.layouts.sales')

@section('title','Followups Today')

@section('content')
    <h2>Followups Today / Overdue</h2>

    <div class="crm-section" style="margin-top:12px">
        @if($followups->count())
            <div style="display:flex;flex-direction:column;gap:10px">
                @foreach($followups as $f)
                    <div class="crm-timeline-item">
                        <div class="crm-timeline-meta"><strong>{{ optional($f->lead)->name ?? 'Lead' }}</strong> <span class="text-sm muted">· {{ optional($f->scheduled_at) ? \Carbon\Carbon::parse($f->scheduled_at)->toDayDateTimeString() : '' }}</span></div>
                        <div class="crm-timeline-content">{{ $f->note }}</div>
                        <div style="margin-top:6px">
                            @if(!$f->completed)
                                <form method="POST" action="{{ route('crm.sales.followups.done', $f->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button class="crm-btn crm-btn-ghost">Mark Done</button>
                                </form>
                            @else
                                <div class="text-sm muted">Completed at {{ optional($f->completed_at) ? \Carbon\Carbon::parse($f->completed_at)->toDayDateTimeString() : '' }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="crm-empty-state">No followups for today.</div>
        @endif
    </div>
@endsection
