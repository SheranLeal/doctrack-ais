@extends('layouts.user')
@section('page-title', 'Routed Documents')
@section('title', 'Routed')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Routed / Incoming</h2>
            <p class="text-sm text-slate-500 mt-1">Documents currently in circulation or being processed.</p>
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
                        <td class="px-6 py-4"><span class="sb-routed">Routed</span></td>
                        <td class="px-6 py-4 text-right">
                            <button onclick="viewDoc({{ $doc->id }})" class="text-sm font-medium text-blue-600 hover:text-blue-800">View</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">{{ $documents->links() }}</div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400"><svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg></div>
            <h3 class="text-lg font-medium text-slate-900">No routed documents</h3>
            <p class="text-slate-500 mt-1">You don't have any documents currently in routing.</p>
        </div>
        @endif
    </div>
</div>
@endsection