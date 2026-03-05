<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Root
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});

// ── Auth (guests only) ──
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ── Admin Routes ──
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard',                      [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users',                          [AdminController::class, 'manageUsers'])->name('users');
        Route::delete('/users/{user}',                [AdminController::class, 'deleteUser'])->name('users.delete');
        Route::get('/documents',                      [AdminController::class, 'allDocuments'])->name('documents');
        Route::get('/documents/{document}/detail',    [AdminController::class, 'documentDetail'])->name('documents.detail');
        Route::get('/pending',                        [AdminController::class, 'pendingDocuments'])->name('pending');
        Route::get('/deferred',                       [AdminController::class, 'deferredDocuments'])->name('deferred');
        Route::patch('/documents/{document}/status',  [AdminController::class, 'updateDocumentStatus'])->name('documents.status');
        Route::get('/audit-logs',                     [AdminController::class, 'auditLogs'])->name('audit-logs');
        Route::get('/recent-logs',                    [AdminController::class, 'getRecentLogs'])->name('recent-logs');
    });

// ── User Routes ──
Route::middleware(['auth', 'user.only'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard',  [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/documents',  [UserController::class, 'myDocuments'])->name('documents');
        Route::get('/documents/{document}/detail', [UserController::class, 'documentDetail'])->name('documents.detail');
        Route::get('/routed',     [UserController::class, 'routed'])->name('routed');
        Route::get('/pending',    [UserController::class, 'pending'])->name('pending');
        Route::get('/deferred',   [UserController::class, 'deferred'])->name('deferred');
        Route::get('/submit',     [UserController::class, 'submitNew'])->name('submit');
        Route::post('/submit',    [UserController::class, 'store'])->name('submit.store');
        Route::post('/profile',   [UserController::class, 'updateProfile'])->name('profile.update');
        Route::post('/password',  [UserController::class, 'updatePassword'])->name('password.update');
    });