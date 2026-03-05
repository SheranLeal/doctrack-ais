@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

<!-- Stat Cards (Fixed Size) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-5 mb-6">
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-gray-800">{{ $totalUsers }}</p>
            <p class="text-xs text-gray-500">Total Users</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-gray-800">{{ $totalDocuments }}</p>
            <p class="text-xs text-gray-500">Total Documents</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-9 h-9 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-yellow-600">{{ $pendingDocs }}</p>
            <p class="text-xs text-gray-500">Pending</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-blue-600">{{ $routedDocs }}</p>
            <p class="text-xs text-gray-500">Routed</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center text-green-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-green-600">{{ $approvedDocs }}</p>
            <p class="text-xs text-gray-500">Approved</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-red-600">{{ $deferredDocs }}</p>
            <p class="text-xs text-gray-500">Deferred</p>
        </div>
    </div>
</div>

<!-- Charts and Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
    <div class="lg:col-span-3">
        <!-- Document Status Bar Chart -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 h-full">
            <h3 class="font-bold text-gray-800 mb-4">Documents Overview</h3>
            <div style="height: 320px;">
                <canvas id="adminDocumentChart"></canvas>
            </div>
        </div>
    </div>
    <div class="lg:col-span-2">
        <!-- Recent Activity -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 h-full">
            <div class="px-4 py-3 border-b border-gray-100">
                <h3 class="font-bold text-sm text-gray-800">Recent Logs</h3>
            </div>
            <div id="recentLogsContainer" class="divide-y divide-gray-100">
                @forelse($recentLogs as $log)
                <div class="p-3 text-xs">
                    <span class="font-semibold text-gray-600">{{ optional($log->user)->name ?? 'System' }}</span>
                    <span class="text-gray-500">{{ $log->description }}</span>
                    <span class="text-gray-400 float-right">{{ $log->created_at->diffForHumans(null, true) }}</span>
                </div>
                @empty
                <p class="p-4 text-xs text-gray-500">No recent logs.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Recent Documents Table -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 mt-6">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-gray-800">Recent Document Submissions</h3>
        <a href="{{ route('admin.documents') }}" class="text-sm font-semibold text-red-700 hover:underline">View All Documents</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="py-3 px-6 text-left">Tracking #</th>
                    <th class="py-3 px-6 text-left">Submitted By</th>
                    <th class="py-3 px-6 text-left">Document Type</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-right">Submitted On</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm">
                @forelse($recentDocuments as $doc)
                <tr class="border-b border-gray-50 hover:bg-gray-50/80 transition-colors">
                    <td class="py-3 px-6 font-mono font-bold text-red-700">{{ $doc->tracking_number }}</td>
                    <td class="py-3 px-6 font-semibold text-gray-800">{{ optional($doc->submitter)->name ?? 'Unknown' }}</td>
                    <td class="py-3 px-6">{{ $doc->document_type }}</td>
                    <td class="py-3 px-6 text-center">
                        @if($doc->status==='pending')  <span class="sb-pending">Pending</span>
                        @elseif($doc->status==='routed')   <span class="sb-routed">Routed</span>
                        @elseif($doc->status==='deferred') <span class="sb-deferred">Deferred</span>
                        @elseif($doc->status==='approved') <span class="sb-approved">Approved</span>
                        @else <span class="sb-received">Received</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-right text-gray-500">{{ $doc->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-500"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg></div>
                        No documents have been submitted yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Bar Chart
    const adminCtx = document.getElementById('adminDocumentChart');
    if (adminCtx) {
        new Chart(adminCtx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Routed', 'Approved', 'Deferred'],
                datasets: [{
                    label: 'Number of Documents',
                    data: [{{ $pendingDocs }}, {{ $routedDocs }}, {{ $approvedDocs }}, {{ $deferredDocs }}],
                    backgroundColor: ['rgba(245, 158, 11, 0.6)', 'rgba(59, 130, 246, 0.6)', 'rgba(34, 197, 94, 0.6)', 'rgba(239, 68, 68, 0.6)'],
                    borderColor: ['rgb(255, 162, 0)', 'rgb(0, 98, 255)', 'rgb(24, 151, 71)', 'rgb(226, 18, 18)'],
                    borderWidth: 1.5,
                    borderRadius: 4,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }, plugins: { legend: { display: false } } }
        });
    }

    // Real-time recent logs
    const logsContainer = document.getElementById('recentLogsContainer');
    function fetchRecentLogs() {
        fetch("{{ route('admin.recent-logs') }}", {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(logs => {
            logsContainer.innerHTML = ''; // Clear current logs
            if (logs.length > 0) {
                logs.forEach(log => {
                    const logEl = document.createElement('div');
                    logEl.className = 'p-3 text-xs';
                    logEl.innerHTML = `
                        <span class="font-semibold text-gray-600">${log.user_name}</span>
                        <span class="text-gray-500">${log.description}</span>
                        <span class="text-gray-400 float-right">${log.time_ago}</span>
                    `;
                    logsContainer.appendChild(logEl);
                });
            } else {
                logsContainer.innerHTML = '<p class="p-4 text-xs text-gray-500">No recent logs.</p>';
            }
        })
        .catch(error => console.error('Error fetching recent logs:', error));
    }

    // Fetch logs on load and then every 5 seconds
    fetchRecentLogs();
    setInterval(fetchRecentLogs, 5000);
});
</script>
@endpush