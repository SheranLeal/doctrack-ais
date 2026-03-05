@extends('layouts.user')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<style>
    .form-card {
        background-color: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        border: 1px solid #e2e8f0;
        margin-bottom: 1.5rem;
    }
    .form-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .form-body {
        padding: 1.5rem;
    }
    .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-input {
        width: 100%;
        padding: 0.625rem 1rem;
        border: 1px solid #cbd5e1;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--r7);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.2);
    }
    .form-submit-btn {
        background: var(--r7);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .form-submit-btn:hover {
        background: var(--r8);
    }
    .error-text {
        color: #dc2626;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }
</style>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        {{-- Update Profile Information --}}
        <div class="form-card">
            <div class="form-header">
                <h2 class="text-lg font-bold text-slate-800">Profile Information</h2>
                <p class="text-sm text-slate-500">Update your account's profile information and email address.</p>
            </div>
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                <div class="form-body">
                    <div>
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="position" class="form-label">Position / Role</label>
                        <input type="text" id="position" name="position" class="form-input" value="{{ old('position', auth()->user()->position) }}">
                        @error('position') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-6 text-right">
                        <button type="submit" class="form-submit-btn">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Update Password --}}
        <div class="form-card">
            <div class="form-header">
                <h2 class="text-lg font-bold text-slate-800">Update Password</h2>
                <p class="text-sm text-slate-500">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <form action="{{ route('user.password.update') }}" method="POST">
                @csrf
                <div class="form-body">
                    <div>
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-input" required>
                        @error('current_password', 'updatePassword') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" id="password" name="password" class="form-input" required>
                        @error('password', 'updatePassword') <p class="error-text">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                    </div>
                    <div class="mt-6 text-right">
                        <button type="submit" class="form-submit-btn">Update Password</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection