@extends('layouts.admin')
@section('title', 'Deferred Documents')
@section('page-title', 'Deferred Documents')

@section('content')
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-100 flex items-center gap-3 bg-white">
        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
        <h3 class="font-bold text-lg text-gray-800">Deferred Documents ({{ $documents->total() }})</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="py-4 px-6 text-left">Tracking #</th>
                    <th class="py-4 px-6 text-left">Submitted By</th>
                    <th class="py-4 px-6 text-left">Type</th>
                    <th class="py-4 px-6 text-left">Remarks</th>
                    <th class="py-4 px-6 text-center">Deferred On</th>
                    <th class="py-4 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($documents as $doc)
                <tr class="border-b border-gray-50 hover:bg-gray-50/80 transition-colors">
                    <td class="py-4 px-6 font-mono font-bold text-blue-700">{{ $doc->tracking_number }}</td>
                    <td class="py-4 px-6 font-semibold text-gray-800">{{ optional($doc->submitter)->name ?? 'Unknown' }}</td>
                    <td class="py-4 px-6">{{ $doc->document_type }}</td>
                    <td class="py-4 px-6 italic text-gray-500">{{ $doc->remarks ?? 'No remarks' }}</td>
                    <td class="py-4 px-6 text-center text-gray-500">{{ $doc->deferred_at ? $doc->deferred_at->format('M d, Y') : 'N/A' }}</td>
                    <td class="py-4 px-6 text-center">
                        <form method="POST" action="{{ route('admin.documents.status', $doc) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status" value="pending">
                            <button class="bg-yellow-50 text-yellow-700 text-xs px-4 py-1.5 rounded-lg hover:bg-yellow-100 font-semibold transition">Revert to Pending</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-20 text-center text-gray-400">No deferred documents.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-5 border-t border-gray-100">{{ $documents->links() }}</div>
</div>
@endsection