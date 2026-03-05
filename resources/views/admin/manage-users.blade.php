@extends('layouts.admin')
@section('title', 'Manage Users')
@section('page-title', 'Manage Users')

@section('content')
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-100 bg-white">
        <h3 class="font-bold text-lg text-gray-800">All Staff Accounts</h3>
        <p class="text-sm text-gray-500 mt-1">View and manage registered users</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs font-semibold tracking-wider">
                <tr>
                    <th class="py-4 px-6 text-left">#</th>
                    <th class="py-4 px-6 text-left">Name</th>
                    <th class="py-4 px-6 text-left">Email</th>
                    <th class="py-4 px-6 text-left">Position</th>
                    <th class="py-4 px-6 text-center">Registered</th>
                    <th class="py-4 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @forelse($users as $user)
                <tr class="border-b border-gray-50 hover:bg-gray-50/80 transition-colors">
                    <td class="py-4 px-6 text-left whitespace-nowrap font-semibold text-gray-400">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6 text-left">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="font-semibold text-gray-800">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="py-4 px-6 text-left">{{ $user->email }}</td>
                    <td class="py-4 px-6 text-left">{{ $user->position ?? 'N/A' }}</td>
                    <td class="py-4 px-6 text-center text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="py-4 px-6 text-center">
                        <form method="POST" action="{{ route('admin.users.delete', $user) }}"
                            onsubmit="return confirm('Delete this user? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded-lg text-xs font-semibold transition">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-20 text-center text-gray-400">No users registered yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
