@extends('layouts.admin')
@section('title', 'Audit Logs')
@section('page-title', 'Audit Logs')

@section('content')
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-100 bg-white">
        <h3 class="font-bold text-lg text-gray-800">System Audit Trail</h3>
        <p class="text-sm text-gray-500 mt-1">All user and document activity logs</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="py-4 px-6 text-left">User</th>
                    <th class="py-4 px-6 text-left">Action</th>
                    <th class="py-4 px-6 text-left">Description</th>
                    <th class="py-4 px-6 text-left">IP Address</th>
                    <th class="py-4 px-6 text-left">Date & Time</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($logs as $log)
                <tr class="border-b border-gray-50 hover:bg-gray-50/80 transition-colors">
                    <td class="py-4 px-6 font-semibold text-gray-800">{{ optional($log->user)->name ?? 'System' }}</td>
                    <td class="py-4 px-6">
                        <span class="px-2 py-1 text-xs rounded-full font-medium
                            {{ $log->action === 'LOGIN'    ? 'bg-green-100 text-green-800' : '' }}
                            {{ $log->action === 'LOGOUT'   ? 'bg-gray-100 text-gray-800' : '' }}
                            {{ $log->action === 'SUBMIT'   ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $log->action === 'REGISTER' ? 'bg-purple-100 text-purple-800' : '' }}
                            {{ $log->action === 'STATUS_UPDATE' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="py-4 px-6 text-gray-700">{{ $log->description }}</td>
                    <td class="py-4 px-6 text-gray-500 font-mono text-xs">{{ $log->ip_address }}</td>
                    <td class="py-4 px-6 text-gray-500">{{ $log->created_at->format('M d, Y h:i A') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-20 text-center text-gray-400">No logs yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-8 py-5 border-t border-gray-100">{{ $logs->links() }}</div>
</div>
@endsection