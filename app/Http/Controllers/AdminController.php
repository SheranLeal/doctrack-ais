<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Document;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers      = User::where('role', 'user')->count();
        $totalDocuments  = Document::count();
        $pendingDocs     = Document::where('status', 'pending')->count();
        $deferredDocs    = Document::where('status', 'deferred')->count();
        $routedDocs      = Document::where('status', 'routed')->count();
        $approvedDocs    = Document::where('status', 'approved')->count();
        $recentDocuments = Document::with('submitter')->latest()->take(10)->get();
        $recentLogs      = AuditLog::with('user')->latest()->take(5)->get();

        // Adjust timezone for display
        $recentLogs->each(fn($log) => $log->created_at = $log->created_at->timezone('Asia/Manila'));

        return view('admin.dashboard', compact(
            'totalUsers', 'totalDocuments', 'pendingDocs',
            'deferredDocs', 'routedDocs', 'approvedDocs',
            'recentDocuments', 'recentLogs'
        ));
    }

    public function manageUsers()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.manage-users', compact('users'));
    }

    public function deleteUser(User $user)
    {
        if ($user->isAdmin()) abort(403);
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function allDocuments(Request $request)
    {
        $query = Document::with('submitter');
        if ($request->status) $query->where('status', $request->status);
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('tracking_number', 'like', '%'.$request->search.'%')
                  ->orWhere('document_type', 'like', '%'.$request->search.'%')
                  ->orWhereHas('submitter', fn($q2) =>
                      $q2->where('name', 'like', '%'.$request->search.'%')
                  );
            });
        }
        $documents = $query->latest()->paginate(10);
        return view('admin.all-documents', compact('documents'));
    }

    /**
     * Returns full document details as JSON for the View modal.
     */
    public function documentDetail(Document $document)
    {
        $document->load('submitter');
        return response()->json([
            'tracking_number'    => $document->tracking_number,
            'status'             => $document->status,
            'created_at_formatted' => $document->created_at->timezone('Asia/Manila')->format('F d, Y h:i A'),
            'submitter_name'     => optional($document->submitter)->name ?? 'Unknown User',
            'submitter_position' => optional($document->submitter)->position ?? 'Staff',
            'submitter_initial'  => strtoupper(substr(optional($document->submitter)->name ?? 'U', 0, 1)),
            'document_type'      => $document->document_type,
            'details'            => $document->details,
            'purpose'            => $document->purpose,
            'to_department'      => $document->to_department,
            'remarks'            => $document->remarks,
            'file_path'          => $document->file_path,
        ]);
    }

    public function pendingDocuments()
    {
        $documents = Document::with('submitter')->where('status', 'pending')->latest()->paginate(10);
        return view('admin.pending', compact('documents'));
    }

    public function deferredDocuments()
    {
        $documents = Document::with('submitter')->where('status', 'deferred')->latest()->paginate(10);
        return view('admin.deferred', compact('documents'));
    }

    public function updateDocumentStatus(Request $request, Document $document)
    {
        $request->validate([
            'status'  => 'required|in:pending,routed,deferred,approved',
            'remarks' => 'nullable|string',
        ]);

        $oldStatus = $document->status;
        $document->update([
            'status'      => $request->status,
            'remarks'     => $request->remarks,
            'handled_by'  => auth()->id(),
            'routed_at'   => $request->status === 'routed'   ? now() : $document->routed_at,
            'deferred_at' => $request->status === 'deferred' ? now() : $document->deferred_at,
        ]);

        AuditLog::create([
            'user_id'     => auth()->id(),
            'document_id' => $document->id,
            'action'      => 'STATUS_UPDATE',
            'description' => 'updated document '.$document->tracking_number.' status from '.$oldStatus.' to '.$request->status.'.',
            'ip_address'  => $request->ip(),
        ]);

        return back()->with('success', 'Document status updated successfully.');
    }

    public function auditLogs()
    {
        $logs = AuditLog::with(['user', 'document'])->latest()->paginate(20);

        // Adjust timezone for display
        $logs->getCollection()->transform(function ($log) {
            $log->created_at = $log->created_at->timezone('Asia/Manila');
            return $log;
        });

        return view('admin.audit-logs', compact('logs'));
    }

    public function getRecentLogs()
    {
        $recentLogs = AuditLog::with('user')->latest()->take(5)->get();

        $logsData = $recentLogs->map(function ($log) {
            return [
                'user_name' => optional($log->user)->name ?? 'System',
                'description' => $log->description,
                'time_ago' => $log->created_at->diffForHumans(null, true),
            ];
        });

        return response()->json($logsData);
    }
}