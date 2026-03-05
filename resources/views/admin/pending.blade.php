@extends('layouts.admin')
@section('title', 'Pending Documents')
@section('page-title', 'Pending Documents')

@section('content')
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-100 flex items-center gap-3 bg-white">
        <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
        <h3 class="font-bold text-lg text-gray-800">Pending Documents ({{ $documents->total() }})</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="py-4 px-6 text-left">Tracking #</th>
                    <th class="py-4 px-6 text-left">Submitted By</th>
                    <th class="py-4 px-6 text-left">Type</th>
                    <th class="py-4 px-6 text-left">Purpose</th>
                    <th class="py-4 px-6 text-center">Submitted</th>
                    <th class="py-4 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($documents as $doc)
                <tr class="border-b border-gray-50 hover:bg-gray-50/80 transition-colors">
                    <td class="py-4 px-6 font-mono font-bold text-blue-700">{{ $doc->tracking_number }}</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">{{ $doc->submitter->name }}</td>
                    <td class="py-4 px-6">{{ $doc->document_type }}</td>
                    <td class="py-4 px-6 max-w-xs truncate" title="{{ $doc->purpose }}">{{ $doc->purpose }}</td>
                    <td class="py-4 px-6 text-center text-gray-500">{{ $doc->created_at->format('M d, Y') }}</td>
                    <td class="py-4 px-6 text-center">
                        <div class="flex gap-2 justify-center">
                            <form method="POST" action="{{ route('admin.documents.status', $doc) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="routed">
                                <button class="bg-blue-50 text-blue-600 text-xs px-4 py-1.5 rounded-lg hover:bg-blue-100 font-semibold transition">Route</button>
                            </form>
                            <form method="POST" action="{{ route('admin.documents.status', $doc) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="deferred">
                                <button class="bg-red-50 text-red-600 text-xs px-4 py-1.5 rounded-lg hover:bg-red-100 font-semibold transition">Defer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-20 text-center text-gray-400">No pending documents. 🎉</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-5 border-t border-gray-100">{{ $documents->links() }}</div>
</div>
@endsection