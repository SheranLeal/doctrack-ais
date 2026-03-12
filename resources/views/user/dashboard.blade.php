@extends('layouts.user')
@section('title', 'Dashboard')
@section('page-title', 'My Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-br from-red-900 via-red-800 to-red-900 rounded-2xl p-5 mb-6 text-white shadow-lg relative overflow-hidden">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center text-lg font-bold flex-shrink-0 border-2 border-white/30">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
            <div>
                <h2 class="text-lg font-bold">Welcome, {{ auth()->user()->name }}!</h2>
                <p class="text-red-200 text-xs mt-1">Here's your document tracking summary.</p>
            </div>
        </div>
        <a href="{{ route('user.submit') }}" class="bg-white/90 hover:bg-white text-red-800 font-bold py-2 px-3 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center gap-2 w-full md:w-auto justify-center text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            <span>Submit a Document</span>
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <a href="{{ route('user.documents') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
        <div class="w-9 h-9 bg-slate-100 rounded-xl flex items-center justify-center text-slate-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-gray-800">{{ $totalSubmitted }}</p>
            <p class="text-xs text-gray-500">Total Submitted</p>
        </div>
    </a>
    <a href="{{ route('user.pending') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
        <div class="w-9 h-9 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-yellow-600">{{ $pending }}</p>
            <p class="text-xs text-gray-500">Pending</p>
        </div>
    </a>
    <a href="{{ route('user.routed') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
        <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-blue-600">{{ $routed }}</p>
            <p class="text-xs text-gray-500">Routed</p>
        </div>
    </a>
    <a href="{{ route('user.deferred') }}" class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 flex items-center gap-4 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
        <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
        </div>
        <div>
            <p class="text-lg font-bold text-red-600">{{ $deferred }}</p>
            <p class="text-xs text-gray-500">Deferred</p>
        </div>
    </a>
</div>

<!-- Chart and Recent Documents -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Documents -->
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-sm text-gray-800">Recent Activity</h3>
            <a href="{{ route('user.documents') }}" class="text-red-700 text-xs font-semibold hover:underline">View All</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentDocs as $doc)
            <div class="p-3 flex items-start gap-3 hover:bg-slate-50/50 transition-colors">
                <div class="w-7 h-7 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0 mt-1 text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-sm text-slate-800">
                        You submitted a document: <span class="font-bold text-red-800 font-mono">{{ $doc->tracking_number }}</span>
                    </p>
                    <p class="text-xs text-slate-500">{{ $doc->document_type }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-[10px] text-slate-400">{{ $doc->created_at->diffForHumans() }}</span>
                        <span class="w-0.5 h-0.5 bg-slate-300 rounded-full"></span>
                        @if($doc->status==='pending')  <span class="sb-pending text-[10px] px-1.5 py-0.5">Pending</span>
                        @elseif($doc->status==='routed')   <span class="sb-routed text-[10px] px-1.5 py-0.5">Routed</span>
                        @elseif($doc->status==='deferred') <span class="sb-deferred text-[10px] px-1.5 py-0.5">Deferred</span>
                        @elseif($doc->status==='approved') <span class="sb-approved text-[10px] px-1.5 py-0.5">Approved</span>
                        @else <span class="sb-received text-[10px] px-1.5 py-0.5">Received</span>
                        @endif
                    </div>
                </div>
                <button onclick="viewDoc({{ $doc->id }})" class="text-xs font-medium text-blue-600 hover:text-blue-800 self-center">View</button>
            </div>
            @empty
            <div class="p-6 text-center">
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg></div>
                <h3 class="text-base font-medium text-slate-900">No recent activity</h3>
                <p class="text-slate-500 text-xs mt-1">Your recent document submissions will appear here.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Document Status Chart -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex flex-col">
        <h3 class="font-bold text-sm text-gray-800 mb-3 px-2">Documents Summary</h3>
        <div class="flex-grow flex items-center justify-center">
            <canvas id="documentStatusChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const data = {
        labels: ['Pending', 'Routed', 'Deferred', 'Approved'],
        datasets: [{
            label: 'Documents',
            data: [
                {{ $pending }},
                {{ $routed }},
                {{ $deferred }},
                {{ $totalSubmitted - ($pending + $routed + $deferred) }}
            ],
            backgroundColor: [
                '#f59e0b', // amber-500 for Pending
                '#3b82f6', // blue-500 for Routed
                '#ef4444', // red-500 for Deferred
                '#27ea51'  // slate-500 for Other
            ],
            borderColor: '#fff',
            borderWidth: 2,
            hoverOffset: 8
        }]
    };

    const config = {
        type: 'doughnut',
        data: data,
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        boxWidth: 12,
                        font: {
                            size: 11
                        }
                    }
                },
                title: {
                    display: false,
                }
            }
        }
    };

    const documentStatusChart = new Chart(
        document.getElementById('documentStatusChart'),
        config
    );
</script>
@endpush