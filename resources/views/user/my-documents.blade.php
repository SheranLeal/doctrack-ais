@extends('layouts.user')
@section('title','My Documents')
@section('page-title','My Documents')

@section('content')

{{-- Stats strip --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:1rem;margin-bottom:1.25rem;">
    @php
        $total    = $documents->total();
        $pending  = \App\Models\Document::where('submitted_by',auth()->id())->where('status','pending')->count();
        $routed   = \App\Models\Document::where('submitted_by',auth()->id())->where('status','routed')->count();
        $deferred = \App\Models\Document::where('submitted_by',auth()->id())->where('status','deferred')->count();
    @endphp
    <div style="background:#fff;border-radius:1rem;border:1px solid #f1f5f9;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <p style="font-size:1.75rem;font-weight:800;color:#0f172a;">{{ $total }}</p>
        <p style="font-size:0.75rem;color:#64748b;margin-top:0.25rem;font-weight:500;">Total Submitted</p>
    </div>
    <div style="background:#fff;border-radius:1rem;border:1px solid #f1f5f9;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <p style="font-size:1.75rem;font-weight:800;color:#d97706;">{{ $pending }}</p>
        <p style="font-size:0.75rem;color:#64748b;margin-top:0.25rem;font-weight:500;">Pending</p>
    </div>
    <div style="background:#fff;border-radius:1rem;border:1px solid #f1f5f9;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <p style="font-size:1.75rem;font-weight:800;color:#1d4ed8;">{{ $routed }}</p>
        <p style="font-size:0.75rem;color:#64748b;margin-top:0.25rem;font-weight:500;">Routed</p>
    </div>
    <div style="background:#fff;border-radius:1rem;border:1px solid #f1f5f9;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <p style="font-size:1.75rem;font-weight:800;color:#991b1b;">{{ $deferred }}</p>
        <p style="font-size:0.75rem;color:#64748b;margin-top:0.25rem;font-weight:500;">Deferred</p>
    </div>
</div>

{{-- Table --}}
<div style="background:#fff;border-radius:1.25rem;border:1px solid #f1f5f9;box-shadow:0 2px 8px rgba(0,0,0,0.04);overflow:hidden;">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #f8fafb;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;">
        <div>
            <h3 style="font-size:0.9375rem;font-weight:700;color:#0f172a;">All My Submitted Documents</h3>
            <p style="font-size:0.75rem;color:#94a3b8;margin-top:0.125rem;">Track all your submissions and their current status</p>
        </div>
        <a href="{{ route('user.submit') }}"
            style="display:inline-flex;align-items:center;gap:0.375rem;padding:0.5625rem 1rem;background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:#fff;font-size:0.8125rem;font-weight:600;border-radius:0.625rem;text-decoration:none;transition:all 0.2s;box-shadow:0 2px 8px rgba(153,27,27,0.3);"
            onmouseover="this.style.opacity='0.88'" onmouseout="this.style.opacity='1'">
            <svg style="width:0.875rem;height:0.875rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Submit New
        </a>
    </div>

    <div style="overflow-x:auto;">
        <table>
            <thead>
                <tr>
                    <th>Tracking #</th>
                    <th>Document Type</th>
                    <th>Purpose</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Submitted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr>
                    <td><span style="font-family:monospace;font-weight:700;color:#991b1b;font-size:0.8125rem;">{{ $doc->tracking_number }}</span></td>
                    <td style="font-size:0.8125rem;font-weight:500;color:#1e293b;">{{ $doc->document_type }}</td>
                    <td style="font-size:0.8125rem;color:#64748b;max-width:180px;">
                        <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $doc->purpose }}</span>
                    </td>
                    <td>
                        @if($doc->status==='pending')  <span class="sb-pending">Pending</span>
                        @elseif($doc->status==='routed')   <span class="sb-routed">Routed</span>
                        @elseif($doc->status==='deferred') <span class="sb-deferred">Deferred</span>
                        @elseif($doc->status==='approved') <span class="sb-approved">Approved</span>
                        @else <span class="sb-received">Received</span>
                        @endif
                    </td>
                    <td style="font-size:0.8rem;color:#64748b;max-width:160px;">
                        @if($doc->remarks)
                            <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="{{ $doc->remarks }}">{{ $doc->remarks }}</span>
                        @else
                            <span style="color:#cbd5e1;font-style:italic;">—</span>
                        @endif
                    </td>
                    <td style="font-size:0.8rem;color:#94a3b8;">{{ $doc->created_at->format('M d, Y') }}</td>
                    <td>
                        <button onclick="viewMyDoc({{ json_encode([
                            'tracking'=>$doc->tracking_number,
                            'type'=>$doc->document_type,
                            'details'=>$doc->details,
                            'purpose'=>$doc->purpose,
                            'to'=>$doc->to_department,
                            'status'=>$doc->status,
                            'remarks'=>$doc->remarks,
                            'file'=>$doc->file_path,
                            'date'=>$doc->created_at->format('F d, Y h:i A'),
                        ]) }})"
                            style="display:inline-flex;align-items:center;gap:0.25rem;padding:0.375rem 0.75rem;background:#fff5f5;border:1px solid #fecaca;color:#991b1b;font-size:0.75rem;font-weight:600;border-radius:0.5rem;cursor:pointer;transition:all 0.15s;font-family:inherit;"
                            onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#fff5f5'">
                            <svg style="width:0.8rem;height:0.8rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:3rem;">
                        <div style="display:flex;flex-direction:column;align-items:center;gap:0.75rem;">
                            <div style="width:56px;height:56px;background:#f8fafc;border-radius:1rem;display:flex;align-items:center;justify-content:center;">
                                <svg style="width:1.75rem;height:1.75rem;color:#cbd5e1;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p style="color:#94a3b8;font-size:0.875rem;">You haven't submitted any documents yet.</p>
                            <a href="{{ route('user.submit') }}" style="color:#991b1b;font-weight:600;font-size:0.875rem;text-decoration:none;">Submit your first document →</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding:1rem 1.25rem;">{{ $documents->links() }}</div>
</div>

{{-- VIEW MODAL --}}
<div id="myDocModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:50;display:none;align-items:center;justify-content:center;padding:1rem;" onclick="if(event.target===this)closeMyDoc()">
    <div style="background:#fff;border-radius:1.25rem;box-shadow:0 24px 60px rgba(0,0,0,0.35);width:100%;max-width:500px;max-height:90vh;overflow-y:auto;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:linear-gradient(135deg,#7f1d1d,#b91c1c);">
            <div>
                <p style="font-size:0.7rem;font-weight:700;color:rgba(255,255,255,0.6);letter-spacing:0.06em;text-transform:uppercase;">Your Document</p>
                <p id="mdTracking" style="font-size:1rem;font-weight:800;color:#fff;font-family:monospace;margin-top:0.125rem;"></p>
            </div>
            <button onclick="closeMyDoc()" style="background:rgba(255,255,255,0.15);border:none;border-radius:0.5rem;padding:0.5rem;cursor:pointer;color:#fff;display:flex;align-items:center;">
                <svg style="width:1.125rem;height:1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div style="padding:1.5rem;">
            <div style="margin-bottom:1rem;display:flex;align-items:center;gap:0.75rem;">
                <span id="mdBadge"></span>
                <span id="mdDate" style="font-size:0.75rem;color:#94a3b8;"></span>
            </div>
            <div style="border:1px solid #f1f5f9;border-radius:0.875rem;overflow:hidden;margin-bottom:1.25rem;">
                <div style="display:grid;grid-template-columns:130px 1fr;gap:0.5rem;padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;">
                    <p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.04em;">Document Type</p>
                    <p id="mdType" style="font-size:0.875rem;color:#1e293b;font-weight:600;"></p>
                </div>
                <div style="display:grid;grid-template-columns:130px 1fr;gap:0.5rem;padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;background:#fafafa;">
                    <p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.04em;">Description</p>
                    <p id="mdDetails" style="font-size:0.875rem;color:#374151;white-space:pre-wrap;"></p>
                </div>
                <div style="display:grid;grid-template-columns:130px 1fr;gap:0.5rem;padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;">
                    <p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.04em;">Purpose</p>
                    <p id="mdPurpose" style="font-size:0.875rem;color:#374151;white-space:pre-wrap;"></p>
                </div>
                <div style="display:grid;grid-template-columns:130px 1fr;gap:0.5rem;padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;background:#fafafa;">
                    <p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.04em;">Sent To</p>
                    <p id="mdDest" style="font-size:0.875rem;color:#374151;font-weight:600;"></p>
                </div>
                <div style="display:grid;grid-template-columns:130px 1fr;gap:0.5rem;padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;">
                    <p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.04em;">Admin Remarks</p>
                    <p id="mdRemarks" style="font-size:0.875rem;"></p>
                </div>
                <div style="display:grid;grid-template-columns:130px 1fr;gap:0.5rem;padding:0.75rem 1rem;background:#fafafa;">
                    <p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.04em;">Attachment</p>
                    <p id="mdFile" style="font-size:0.875rem;"></p>
                </div>
            </div>
            <button onclick="closeMyDoc()" style="width:100%;padding:0.75rem;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-weight:600;font-size:0.875rem;border-radius:0.75rem;cursor:pointer;font-family:inherit;transition:all 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='#fff'">Close</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function statusBadgeUser(s){
    const map={
        pending:'<span class="sb-pending">Pending</span>',
        routed:'<span class="sb-routed">Routed</span>',
        deferred:'<span class="sb-deferred">Deferred</span>',
        approved:'<span class="sb-approved">Approved</span>',
        received:'<span class="sb-received">Received</span>',
    };
    return map[s]||s;
}
function viewMyDoc(d){
    document.getElementById('mdTracking').textContent = d.tracking;
    document.getElementById('mdBadge').innerHTML = statusBadgeUser(d.status);
    document.getElementById('mdDate').textContent = 'Submitted: ' + d.date;
    document.getElementById('mdType').textContent = d.type;
    document.getElementById('mdDetails').textContent = d.details;
    document.getElementById('mdPurpose').textContent = d.purpose;
    document.getElementById('mdDest').textContent = d.to;
    document.getElementById('mdRemarks').innerHTML = d.remarks
        ? `<span style="color:#374151;">${d.remarks}</span>`
        : '<span style="color:#cbd5e1;font-style:italic;">No remarks yet</span>';
    document.getElementById('mdFile').innerHTML = d.file
        ? `<a href="/storage/${d.file}" target="_blank" style="color:#1d4ed8;font-weight:600;">📎 View Attachment</a>`
        : '<span style="color:#cbd5e1;font-style:italic;">No file attached</span>';
    document.getElementById('myDocModal').style.display='flex';
}
function closeMyDoc(){ document.getElementById('myDocModal').style.display='none'; }
document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeMyDoc(); });
</script>
@endpush
@endsection