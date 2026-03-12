@extends('layouts.user')
@section('page-title', 'Deferred Documents')
@section('title', 'Deferred')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Deferred Documents</h2>
            <p class="text-sm text-slate-500 mt-1">Documents returned for revision or currently on hold.</p>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        @if($documents->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500 font-bold tracking-wider">
                        <th class="px-6 py-4">Tracking #</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Date Submitted</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($documents as $doc)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-semibold text-slate-700">{{ $doc->tracking_number }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ $doc->document_type }}</td>
                        <td class="px-6 py-4 text-slate-500 text-sm">{{ $doc->created_at->format('M d, Y h:i A') }}</td>
                        <td class="px-6 py-4"><span class="sb-deferred">Deferred</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="openModal({{ json_encode([
                                'tracking' => $doc->tracking_number,
                                'type' => $doc->document_type,
                                'date' => $doc->created_at->format('M d, Y h:i A'),
                                'status' => $doc->status,
                                'details' => $doc->details,
                                'purpose' => $doc->purpose,
                                'remarks' => $doc->remarks,
                                'to' => $doc->to_department
                            ]) }})" class="text-sm font-medium text-blue-600 hover:text-blue-800">View</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">{{ $documents->links() }}</div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg></div>
            <h3 class="text-lg font-medium text-slate-900">No deferred documents</h3>
            <p class="text-slate-500 mt-1">You don't have any deferred documents.</p>
        </div>
        @endif
    </div>
</div>

{{-- Modal --}}
<div id="docModal" style="position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:50;display:none;align-items:center;justify-content:center;padding:1rem;" onclick="if(event.target===this)closeModal()">
    <div style="background:#fff;border-radius:1.25rem;box-shadow:0 24px 60px rgba(0,0,0,0.35);width:100%;max-width:500px;max-height:90vh;overflow-y:auto;">
        <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;background:linear-gradient(135deg,#991b1b,#ef4444);">
            <div>
                <p style="font-size:0.7rem;font-weight:700;color:rgba(255,255,255,0.6);letter-spacing:0.06em;text-transform:uppercase;">Document Details</p>
                <p id="mdTracking" style="font-size:1rem;font-weight:800;color:#fff;font-family:monospace;margin-top:0.125rem;"></p>
            </div>
            <button onclick="closeModal()" style="background:rgba(255,255,255,0.15);border:none;border-radius:0.5rem;padding:0.5rem;cursor:pointer;color:#fff;display:flex;align-items:center;"><svg style="width:1.125rem;height:1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div style="padding:1.5rem;">
            <div style="margin-bottom:1rem;display:flex;align-items:center;gap:0.75rem;"><span id="mdBadge"></span><span id="mdDate" style="font-size:0.75rem;color:#94a3b8;"></span></div>
            <div style="border:1px solid #f1f5f9;border-radius:0.875rem;overflow:hidden;margin-bottom:1.25rem;">
                <div style="padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;"><p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;">Document Type</p><p id="mdType" style="font-size:0.875rem;color:#1e293b;font-weight:600;"></p></div>
                <div style="padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;background:#fafafa;"><p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;">Description</p><p id="mdDetails" style="font-size:0.875rem;color:#374151;white-space:pre-wrap;"></p></div>
                <div style="padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;"><p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;">Purpose</p><p id="mdPurpose" style="font-size:0.875rem;color:#374151;white-space:pre-wrap;"></p></div>
                <div style="padding:0.75rem 1rem;border-bottom:1px solid #f8fafb;background:#fafafa;"><p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;">Sent To</p><p id="mdDest" style="font-size:0.875rem;color:#374151;font-weight:600;"></p></div>
                <div style="padding:0.75rem 1rem;"><p style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;">Admin Remarks</p><p id="mdRemarks" style="font-size:0.875rem;"></p></div>
            </div>
            <button onclick="closeModal()" style="width:100%;padding:0.75rem;border:1.5px solid #e2e8f0;background:#fff;color:#64748b;font-weight:600;font-size:0.875rem;border-radius:0.75rem;cursor:pointer;">Close</button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openModal(d){
    document.getElementById('mdTracking').textContent = d.tracking;
    document.getElementById('mdBadge').innerHTML = `<span class="sb-${d.status}">${d.status.charAt(0).toUpperCase() + d.status.slice(1)}</span>`;
    document.getElementById('mdDate').textContent = d.date;
    document.getElementById('mdType').textContent = d.type;
    document.getElementById('mdDetails').textContent = d.details;
    document.getElementById('mdPurpose').textContent = d.purpose;
    document.getElementById('mdDest').textContent = d.to;
    document.getElementById('mdRemarks').innerHTML = d.remarks ? `<span style="color:#374151;">${d.remarks}</span>` : '<span style="color:#cbd5e1;font-style:italic;">No remarks</span>';
    document.getElementById('docModal').style.display='flex';
}
function closeModal(){ document.getElementById('docModal').style.display='none'; }
document.addEventListener('keydown',e=>{ if(e.key==='Escape') closeModal(); });
</script>
@endpush
@endsection