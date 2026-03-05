@extends('layouts.admin')
@section('title','All Documents')
@section('page-title','All Documents')

@section('content')

{{-- Search / Filter --}}
<div class="bg-white rounded-2xl shadow-sm p-6 mb-6 border border-gray-100">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <div class="relative flex-1 min-w-[250px]">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}" placeholder="Search tracking #, type, or name..."
                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 focus:bg-white transition-all"
            >
        </div>
        <select name="status" id="statusSelect"
            class="bg-gray-50 border border-gray-200 rounded-xl text-sm px-5 py-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 cursor-pointer"
        >
            <option value="">All Status</option>
            <option value="pending"  {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="routed"   {{ request('status')=='routed'?'selected':'' }}>Routed</option>
            <option value="deferred" {{ request('status')=='deferred'?'selected':'' }}>Deferred</option>
            <option value="approved" {{ request('status')=='approved'?'selected':'' }}>Approved</option>
            <option value="received" {{ request('status')=='received'?'selected':'' }}>Received</option>
        </select>
    </form>
</div>

{{-- Table Card --}}
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-100 flex items-center justify-between bg-white">
        <div>
            <h3 class="font-bold text-lg text-gray-800">All Documents</h3>
            <p class="text-sm text-gray-500 mt-1">{{ $documents->total() }} total record(s)</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="py-4 px-6 text-left">Tracking #</th>
                    <th class="py-4 px-6 text-left">Submitted By</th>
                    <th class="py-4 px-6 text-left">Document Type</th>
                    <th class="py-4 px-6 text-left">Destination</th>
                    <th class="py-4 px-6 text-center">Status</th>
                    <th class="py-4 px-6 text-center">Date</th>
                    <th class="py-4 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="documentsTableBody">
                @forelse($documents as $doc)
                <tr class="border-b border-gray-50 hover:bg-gray-50/80 text-sm text-gray-700 transition-colors">
                    <td class="py-4 px-6 font-mono font-bold text-red-700">{{ $doc->tracking_number }}</td>
                    <td class="py-4 px-6">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 font-bold text-xs">{{ strtoupper(substr(optional($doc->submitter)->name ?? 'U',0,1)) }}</div>
                            <span class="font-semibold text-gray-800">{{ optional($doc->submitter)->name ?? 'Unknown User' }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6">{{ $doc->document_type }}</td>
                    <td class="py-4 px-6">{{ $doc->to_department }}</td>
                    <td class="py-4 px-6 text-center">
                        @if($doc->status==='pending')  <span class="sb-pending">Pending</span>
                        @elseif($doc->status==='routed')   <span class="sb-routed">Routed</span>
                        @elseif($doc->status==='deferred') <span class="sb-deferred">Deferred</span>
                        @elseif($doc->status==='approved') <span class="sb-approved">Approved</span>
                        @else <span class="sb-received">Received</span>
                        @endif
                    </td>
                    <td class="py-4 px-6 text-center text-gray-500">{{ $doc->created_at->format('M d, Y') }}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex item-center justify-center gap-2">
                            {{-- VIEW DETAILS --}}
                            <button onclick="viewDoc({{ $doc->id }})"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            {{-- UPDATE STATUS --}}
                            <button onclick="openStatus({{ $doc->id }},'{{ $doc->tracking_number }}','{{ $doc->status }}')"
                                class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition-colors" title="Update Status">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-16 text-gray-400">No documents found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div id="paginationLinks" class="px-8 py-5 border-t border-gray-100">{{ $documents->links() }}</div>
</div>

{{-- ============ VIEW DETAILS MODAL ============ --}}
<div id="viewModal" class="modal-bg" onclick="if(event.target===this)closeView()">
    <div class="modal-card">
        <div class="modal-header" style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);">
            <div>
                <p class="text-xs font-bold text-white/60 uppercase tracking-wider">Document Details</p>
                <p id="vModalTracking" class="text-lg font-bold text-white font-mono mt-1"></p>
            </div>
            <button onclick="closeView()" class="bg-white/20 rounded-full p-2 hover:bg-white/30 transition-colors">
                <svg style="width:1.125rem;height:1.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            {{-- Status badge --}}
            <div style="margin-bottom:1.25rem;display:flex;align-items:center;gap:0.75rem;">
                <span id="vStatusBadge"></span>
                <span id="vDate" class="text-xs text-gray-500"></span>
            </div>

            {{-- Submitter info --}}
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-5 flex items-center gap-4">
                <div id="vAvatar" class="w-12 h-12 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-white text-xl font-bold flex-shrink-0"></div>
                <div>
                    <p id="vName" class="font-bold text-red-800"></p>
                    <p id="vPosition" class="text-sm text-red-600"></p>
                </div>
            </div>

            {{-- Detail rows --}}
            <div style="border:1px solid #f1f5f9;border-radius:0.875rem;overflow:hidden;">
                <div class="detail-row" style="padding:0.75rem 1rem;">
                    <p class="detail-label">Document Type</p>
                    <p class="detail-value" id="vType"></p>
                </div>
                <div class="detail-row" style="padding:0.75rem 1rem;background:#fafafa;">
                    <p class="detail-label">Description</p>
                    <p class="detail-value" id="vDetails" style="white-space:pre-wrap;"></p>
                </div>
                <div class="detail-row" style="padding:0.75rem 1rem;">
                    <p class="detail-label">Purpose</p>
                    <p class="detail-value" id="vPurpose" style="white-space:pre-wrap;"></p>
                </div>
                <div class="detail-row" style="padding:0.75rem 1rem;background:#fafafa;">
                    <p class="detail-label">Destination</p>
                    <p class="detail-value" id="vDest"></p>
                </div>
                <div class="detail-row" style="padding:0.75rem 1rem;">
                    <p class="detail-label">Remarks</p>
                    <p class="detail-value" id="vRemarks" style="color:#64748b;font-style:italic;"></p>
                </div>
                <div class="detail-row" style="padding:0.75rem 1rem;background:#fafafa;">
                    <p class="detail-label">Attachment</p>
                    <p class="detail-value" id="vFile"></p>
                </div>
            </div>

            <div style="margin-top:1.25rem;display:flex;justify-content:flex-end;">
                <button onclick="closeView()" class="px-5 py-2 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-sm">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ============ STATUS UPDATE MODAL ============ --}}
<div id="statusModal" class="modal-bg" onclick="if(event.target===this)closeStatus()">
    <div class="modal-card" style="max-width:420px;">
        <div class="modal-header">
            <div>
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Update Status</p>
                <p id="sModalTracking" class="text-base font-bold text-gray-800 font-mono mt-1"></p>
            </div>
            <button onclick="closeStatus()" class="bg-gray-100 rounded-full p-2 hover:bg-gray-200 transition-colors">
                <svg style="width:1rem;height:1rem;color:#64748b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="statusForm" method="POST">
                @csrf @method('PATCH')
                <div style="margin-bottom:1rem;">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">New Status</label>
                    <select name="status" id="sModalStatus"
                        class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                    >
                        <option value="pending">⏳ Pending</option>
                        <option value="routed">↗️ Routed</option>
                        <option value="deferred">❌ Deferred</option>
                        <option value="approved">✅ Approved</option>
                    </select>
                </div>
                <div style="margin-bottom:1.25rem;">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Remarks / Notes <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea name="remarks" rows="3"
                        class="w-full p-2.5 bg-gray-50 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Add notes for the submitter..."></textarea>
                </div>
                <div style="display:flex;gap:0.625rem;">
                    <button type="submit" class="flex-1 py-2.5 bg-gradient-to-br from-red-600 to-red-700 text-white font-bold text-sm rounded-lg hover:opacity-90 transition-opacity">Update Status</button>
                    <button type="button" onclick="closeStatus()" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-sm">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Pass document data as JSON --}}
<script>
const docs = @json($documents->items());
const docsMap = {};
docs.forEach(d => docsMap[d.id] = d);

// Auto Search Logic
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusSelect = document.getElementById('statusSelect');
    const tableBody = document.getElementById('documentsTableBody');
    const paginationLinks = document.getElementById('paginationLinks');
    let timeout = null;

    function fetchResults() {
        const search = searchInput.value;
        const status = statusSelect.value;
        const url = new URL(window.location.href);
        url.searchParams.set('search', search);
        url.searchParams.set('status', status);
        url.searchParams.delete('page');
        window.history.pushState({}, '', url);

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                if(doc.getElementById('documentsTableBody')) tableBody.innerHTML = doc.getElementById('documentsTableBody').innerHTML;
                if(doc.getElementById('paginationLinks')) paginationLinks.innerHTML = doc.getElementById('paginationLinks').innerHTML;
            });
    }

    searchInput.addEventListener('input', () => { clearTimeout(timeout); timeout = setTimeout(fetchResults, 400); });
    statusSelect.addEventListener('change', fetchResults);
});

function statusBadge(s){
    const map = {
        pending:  '<span class="sb-pending">Pending</span>',
        routed:   '<span class="sb-routed">Routed</span>',
        deferred: '<span class="sb-deferred">Deferred</span>',
        approved: '<span class="sb-approved">Approved</span>',
        received: '<span class="sb-received">Received</span>',
    };
    return map[s] || s;
}

function viewDoc(id){
    // Reset modal to loading state
    document.getElementById('vModalTracking').textContent = 'Loading...';
    document.getElementById('vStatusBadge').innerHTML = '';
    document.getElementById('vDate').textContent = '';
    document.getElementById('vAvatar').textContent = '';
    document.getElementById('vName').textContent = '';
    document.getElementById('vPosition').textContent = '';
    document.getElementById('vType').textContent = '';
    document.getElementById('vDetails').textContent = '';
    document.getElementById('vPurpose').textContent = '';
    document.getElementById('vDest').textContent = '';
    document.getElementById('viewModal').classList.add('open');

    // Fetch full details via AJAX for accuracy
    fetch(`/admin/documents/${id}/detail`, {headers:{'Accept':'application/json','X-Requested-With':'XMLHttpRequest'}})
    .then(r=>r.json())
    .then(d=>{
        document.getElementById('vModalTracking').textContent = d.tracking_number;
        document.getElementById('vStatusBadge').innerHTML = statusBadge(d.status);
        document.getElementById('vDate').textContent = 'Submitted: ' + d.created_at_formatted;
        document.getElementById('vAvatar').textContent = d.submitter_initial;
        document.getElementById('vName').textContent = d.submitter_name;
        document.getElementById('vPosition').textContent = d.submitter_position;
        document.getElementById('vType').textContent = d.document_type;
        document.getElementById('vDetails').textContent = d.details;
        document.getElementById('vPurpose').textContent = d.purpose;
        document.getElementById('vDest').textContent = d.to_department;
        document.getElementById('vRemarks').textContent = d.remarks || 'No remarks yet.';
        document.getElementById('vFile').innerHTML = d.file_path
            ? `<a href="/storage/${d.file_path}" target="_blank" style="color:#1d4ed8;font-weight:600;text-decoration:none;">📎 View Attachment</a>`
            : '<span style="color:#94a3b8;font-style:italic;">No file attached</span>';
    })
    .catch(()=>{
        document.getElementById('vModalTracking').textContent = 'Error loading details.';
        console.error('Failed to load document details');
    });
}
function closeView(){ document.getElementById('viewModal').classList.remove('open'); }

function openStatus(id, tracking, status){
    document.getElementById('sModalTracking').textContent = tracking;
    document.getElementById('sModalStatus').value = status;
    document.getElementById('statusForm').action = `/admin/documents/${id}/status`;
    document.getElementById('statusModal').classList.add('open');
}
function closeStatus(){ document.getElementById('statusModal').classList.remove('open'); }

// Close modals with Escape
document.addEventListener('keydown', e => {
    if(e.key === 'Escape'){ closeView(); closeStatus(); }
});
</script>
@endsection