@extends('crm.layouts.sales')

@section('title','Lead')

@section('content')
    <nav class="crm-breadcrumb">
        <a href="{{ route('crm.sales.leads.index') }}">My Leads</a>
        <span>›</span>
        <span>{{ $lead->name }}</span>
    </nav>

    <div style="display:flex;gap:12px;flex-wrap:wrap">
        <div style="flex:1;min-width:280px;max-width:360px">
            <div class="crm-section">
                <h3>{{ $lead->name }}</h3>
                <div><strong>Phone:</strong> {{ $lead->phone ?? '—' }}</div>
                <div><strong>Email:</strong> {{ $lead->email ?? '—' }}</div>
                <div><strong>Source:</strong> <span class="crm-badge crm-badge--source">{{ optional($lead->source)->name }}</span></div>
                <div><strong>Status:</strong> <span class="crm-badge crm-badge--status">{{ optional($lead->status)->name }}</span></div>
            </div>

            <div class="crm-section" style="margin-top:12px">
                <h4>Add Comment</h4>
                <form method="POST" action="{{ route('crm.sales.leads.comments.store', $lead->id) }}">
                    @csrf
                    <div class="crm-form-row">
                        <textarea name="comment" class="crm-input">{{ old('comment') }}</textarea>
                    </div>
                    <div style="margin-top:8px;text-align:right"><button class="crm-btn">Add Comment</button></div>
                </form>
            </div>

            <div class="crm-section" style="margin-top:12px">
                <h4>Log Action</h4>
                <form method="POST" action="{{ route('crm.sales.leads.actions.store', $lead->id) }}">
                    @csrf
                    <div class="crm-form-row">
                        <select name="action_type_id" class="crm-input">
                            <option value="">Action Type</option>
                            @foreach($actionTypes as $at)
                                <option value="{{ $at->id }}">{{ $at->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="crm-form-row"><input type="datetime-local" name="scheduled_at" class="crm-input" /></div>
                    <div style="text-align:right;margin-top:8px"><button class="crm-btn">Log</button></div>
                </form>
            </div>
        </div>

        <div style="flex:2;min-width:320px">
            <div class="crm-section">
                <h4>Comments</h4>
                @if($comments->count())
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach($comments as $c)
                            <div class="crm-timeline-item">
                                <div class="crm-timeline-meta"><strong>{{ optional($c->author)->name ?? 'You' }}</strong> <span class="text-sm muted">· {{ optional($c->created_at) ? \Carbon\Carbon::parse($c->created_at)->diffForHumans() : '' }}</span></div>
                                <div class="crm-timeline-content">{{ $c->comment }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="crm-empty-state">No comments yet.</div>
                @endif
            </div>

            <div class="crm-section" style="margin-top:12px">
                <h4>Actions</h4>
                @if($actions->count())
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach($actions as $a)
                            <div class="crm-timeline-item">
                                <div class="crm-timeline-meta"><strong>{{ optional($a->type)->name }}</strong> <span class="text-sm muted">· {{ optional($a->scheduled_at) ? \Carbon\Carbon::parse($a->scheduled_at)->toDayDateTimeString() : '' }}</span></div>
                                <div class="crm-timeline-content">{{ $a->notes }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="crm-empty-state">No actions logged.</div>
                @endif
            </div>

            <div class="crm-section" style="margin-top:12px">
                <h4>Followups</h4>
                @if($followups->count())
                    <div style="display:flex;flex-direction:column;gap:10px">
                        @foreach($followups as $f)
                            <div class="crm-timeline-item">
                                <div class="crm-timeline-meta"><strong>Followup</strong> <span class="text-sm muted">· {{ optional($f->scheduled_at) ? \Carbon\Carbon::parse($f->scheduled_at)->toDayDateTimeString() : '' }}</span></div>
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
                    <div class="crm-empty-state">No followups scheduled.</div>
                @endif
            </div>

            <div class="crm-section" style="margin-top:12px">
                <h4>Schedule Followup</h4>
                <form method="POST" action="{{ route('crm.sales.leads.followups.store', $lead->id) }}">
                    @csrf
                    <div class="crm-form-row"><label>When</label><input type="datetime-local" name="scheduled_at" class="crm-input" /></div>
                    <div class="crm-form-row"><label>Note</label><input name="note" class="crm-input" /></div>
                    <div style="margin-top:8px;text-align:right"><button class="crm-btn">Schedule</button></div>
                </form>
            </div>

        </div>
    </div>
@endsection
