<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $userId         = auth()->id();
        $totalSubmitted = Document::where('submitted_by', $userId)->count();
        $pending        = Document::where('submitted_by', $userId)->where('status', 'pending')->count();
        $routed         = Document::where('submitted_by', $userId)->where('status', 'routed')->count();
        $deferred       = Document::where('submitted_by', $userId)->where('status', 'deferred')->count();
        $recentDocs     = Document::where('submitted_by', $userId)->latest()->take(5)->get();

        return view('user.dashboard', compact('totalSubmitted', 'pending', 'routed', 'deferred', 'recentDocs'));
    }

    /**
     * All documents submitted by this user (new page).
     */
    public function myDocuments()
    {
        $documents = Document::where('submitted_by', auth()->id())
            ->latest()
            ->paginate(10);
        return view('user.my-documents', compact('documents'));
    }

    public function routed()
    {
        $documents = Document::where('submitted_by', auth()->id())
            ->where('status', 'routed')
            ->latest()->paginate(10);
        return view('user.routed', compact('documents'));
    }

    public function pending()
    {
        $documents = Document::where('submitted_by', auth()->id())
            ->where('status', 'pending')
            ->latest()->paginate(10);
        return view('user.pending', compact('documents'));
    }

    public function deferred()
    {
        $documents = Document::where('submitted_by', auth()->id())
            ->where('status', 'deferred')
            ->latest()->paginate(10);
        return view('user.deferred', compact('documents'));
    }

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

    public function submitNew()
    {
        return view('user.submit-new');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'details'       => 'required|string',
            'purpose'       => 'required|string',
            'file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,bmp,svg,webp|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
        }

        $document = Document::create([
            'tracking_number' => Document::generateTrackingNumber(),
            'submitted_by'    => auth()->id(),
            'document_type'   => $request->document_type,
            'details'         => $request->details,
            'purpose'         => $request->purpose,
            'to_department'   => 'Administration',
            'file_path'       => $filePath,
            'status'          => 'pending',
        ]);

        AuditLog::create([
            'user_id'     => auth()->id(),
            'document_id' => $document->id,
            'action'      => 'SUBMIT',
            'description' => auth()->user()->name.' submitted document '.$document->tracking_number,
            'ip_address'  => $request->ip(),
        ]);

        return redirect()->route('user.documents')
            ->with('success', '✅ Document submitted! Tracking #: '.$document->tracking_number);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update($request->only('name', 'email'));
        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        auth()->user()->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password updated successfully.');
    }
}