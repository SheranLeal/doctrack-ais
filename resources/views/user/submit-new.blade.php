@extends('layouts.user')
@section('title', 'Submit Document')
@section('page-title', 'Submit New Document')

@section('content')
<div style="max-width:680px;margin:0 auto;">

    <!-- Page header -->
    <div style="margin-bottom:1.5rem;">
        <h2 style="font-size:1.25rem;font-weight:800;color:#0f172a;">Submit a Document</h2>
        <p style="color:#64748b;font-size:0.875rem;margin-top:0.25rem;">Fill in all required fields. Your tracking number will be generated automatically after submission.</p>
    </div>

    <!-- Main card -->
    <div style="background:#fff;border-radius:1.25rem;border:1px solid #f1f5f9;box-shadow:0 2px 12px rgba(0,0,0,0.06);overflow:hidden;">

        <!-- Card top bar -->
        <div style="height:4px;background:linear-gradient(90deg,#1e40af,#3b82f6,#0ea5e9);"></div>

        <div style="padding:2rem;">

            @if($errors->any())
                <div style="background:#fef2f2;border-left:4px solid #ef4444;border-radius:0.625rem;padding:1rem;margin-bottom:1.5rem;">
                    <p style="font-weight:600;color:#991b1b;font-size:0.875rem;margin-bottom:0.375rem;">Please fix the following errors:</p>
                    <ul style="list-style:none;padding:0;margin:0;">
                        @foreach($errors->all() as $error)
                            <li style="color:#dc2626;font-size:0.8125rem;display:flex;align-items:center;gap:0.375rem;margin-top:0.25rem;">
                                <span style="width:5px;height:5px;background:#ef4444;border-radius:50%;flex-shrink:0;display:inline-block;"></span>{{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('user.submit.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Section: Submitter Info -->
                <div style="margin-bottom:1.75rem;">
                    <p style="font-size:0.7rem;font-weight:700;color:#94a3b8;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:0.75rem;">Submitter Information</p>

                    <div style="background:linear-gradient(135deg,#eff6ff,#f0f9ff);border:1.5px solid #bfdbfe;border-radius:0.875rem;padding:1rem 1.125rem;display:flex;align-items:center;gap:1rem;">
                        <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#1d4ed8,#3b82f6);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1rem;font-weight:800;flex-shrink:0;box-shadow:0 3px 8px rgba(29,78,216,0.3);">
                            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                        </div>
                        <div style="flex:1;">
                            <p style="font-weight:700;color:#1e3a8a;font-size:0.9375rem;">{{ auth()->user()->name }}</p>
                            <p style="color:#3b82f6;font-size:0.8rem;margin-top:0.125rem;">{{ auth()->user()->position ?? 'Staff' }}</p>
                        </div>
                        <div style="background:#dbeafe;color:#1e40af;font-size:0.7rem;font-weight:700;padding:0.25rem 0.75rem;border-radius:9999px;letter-spacing:0.02em;">AUTO-FILLED</div>
                    </div>
                </div>

                <!-- Section: Document Details -->
                <div style="margin-bottom:1.75rem;">
                    <p style="font-size:0.7rem;font-weight:700;color:#94a3b8;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:0.75rem;">Document Details</p>

                    <div style="display:grid;gap:1rem;">

                        <!-- Document Type -->
                        <div>
                            <label style="display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                                Document Type <span style="color:#ef4444;">*</span>
                            </label>
                            <div style="position:relative;">
                                <div style="position:absolute;inset-y:0;left:0;padding-left:0.875rem;display:flex;align-items:center;pointer-events:none;">
                                    <svg style="width:1.125rem;height:1.125rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <select name="document_type" required
                                    style="width:100%;padding:0.8125rem 2.5rem 0.8125rem 2.625rem;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:0.75rem;font-size:0.875rem;color:#0f172a;outline:none;font-family:inherit;appearance:none;-webkit-appearance:none;background-image:url(\"data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e\");background-repeat:no-repeat;background-position:right 0.75rem center;background-size:1.25rem;transition:all 0.2s;"
                                    onfocus="this.style.borderColor='#1d4ed8';this.style.boxShadow='0 0 0 4px rgba(29,78,216,0.08)'"
                                    onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none'">
                                    <option value="" disabled selected>-- Select document type --</option>
                                    <option value="Application Documents" {{ old('document_type')=='Application Documents'?'selected':'' }}>📄 Application Documents</option>
                                    <option value="Communications" {{ old('document_type')=='Communications'?'selected':'' }}>✉️ Communications (Letter, Memo, etc.)</option>
                                    <option value="Daily Time Record (DTR)" {{ old('document_type')=='Daily Time Record (DTR)'?'selected':'' }}>🕐 Daily Time Record (DTR)</option>
                                    <option value="Leave (Form 6)" {{ old('document_type')=='Leave (Form 6)'?'selected':'' }}>📋 Leave (Form 6)</option>
                                    <option value="Reports" {{ old('document_type')=='Reports'?'selected':'' }}>📊 Reports</option>
                                    <option value="Travel Order" {{ old('document_type')=='Travel Order'?'selected':'' }}>🚗 Travel Order</option>
                                    <option value="Others" {{ old('document_type')=='Others'?'selected':'' }}>📁 Others</option>
                                </select>
                            </div>
                        </div>

                        <!-- Details / Description -->
                        <div>
                            <label style="display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                                Document Description / Details <span style="color:#ef4444;">*</span>
                            </label>
                            <textarea name="details" rows="3" required
                                style="width:100%;padding:0.8125rem 1rem;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:0.75rem;font-size:0.875rem;color:#0f172a;outline:none;font-family:inherit;resize:vertical;transition:all 0.2s;"
                                placeholder="Briefly describe the contents or nature of this document..."
                                onfocus="this.style.borderColor='#1d4ed8';this.style.boxShadow='0 0 0 4px rgba(29,78,216,0.08)';this.style.background='#fff'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none';this.style.background='#f8fafc'">{{ old('details') }}</textarea>
                        </div>

                        <!-- Purpose -->
                        <div>
                            <label style="display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                                Purpose of Submission <span style="color:#ef4444;">*</span>
                            </label>
                            <textarea name="purpose" rows="2" required
                                style="width:100%;padding:0.8125rem 1rem;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:0.75rem;font-size:0.875rem;color:#0f172a;outline:none;font-family:inherit;resize:vertical;transition:all 0.2s;"
                                placeholder="Why are you submitting this document? (e.g., For approval, For filing, For review)"
                                onfocus="this.style.borderColor='#1d4ed8';this.style.boxShadow='0 0 0 4px rgba(29,78,216,0.08)';this.style.background='#fff'"
                                onblur="this.style.borderColor='#e2e8f0';this.style.boxShadow='none';this.style.background='#f8fafc'">{{ old('purpose') }}</textarea>
                        </div>

                    </div>
                </div>

                <!-- Section: Routing -->
                <div style="margin-bottom:1.75rem;">
                    <p style="font-size:0.7rem;font-weight:700;color:#94a3b8;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:0.75rem;">Routing Information</p>

                    <!-- To (Admin-set field) -->
                    <div>
                        <label style="display:block;font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:0.375rem;">
                            To (Department / Office)
                            <span style="margin-left:0.375rem;background:#fef3c7;color:#92400e;font-size:0.65rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:9999px;letter-spacing:0.02em;">ADMIN ASSIGNED</span>
                        </label>
                        <!-- Read-only for users: admin will assign this -->
                        <div style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:0.75rem;padding:0.8125rem 1rem;display:flex;align-items:center;gap:0.625rem;">
                            <svg style="width:1.125rem;height:1.125rem;color:#94a3b8;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <p style="font-size:0.875rem;color:#64748b;font-style:italic;">This field will be assigned by the Administrator after submission.</p>
                        </div>
                        <!-- Hidden input so the form still submits a value -->
                        <input type="hidden" name="to_department" value="Administration">
                    </div>
                </div>

                <!-- Section: Attachment -->
                <div style="margin-bottom:2rem;">
                    <p style="font-size:0.7rem;font-weight:700;color:#94a3b8;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:0.75rem;">Attachment <span style="font-weight:500;text-transform:none;letter-spacing:0;">(Optional)</span></p>

                    <label for="fileInput" style="display:block;cursor:pointer;">
                        <div id="dropZone" style="border:2px dashed #cbd5e1;border-radius:0.875rem;padding:2rem 1.5rem;text-align:center;transition:all 0.2s;background:#fafafa;"
                            onmouseover="this.style.borderColor='#1d4ed8';this.style.background='#eff6ff'"
                            onmouseout="this.style.borderColor='#cbd5e1';this.style.background='#fafafa'">
                            <div style="width:48px;height:48px;background:#f1f5f9;border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin:0 auto 0.875rem;">
                                <svg style="width:1.5rem;height:1.5rem;color:#94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                            </div>
                            <p id="fileLabel" style="font-size:0.875rem;font-weight:600;color:#475569;">Click to upload a file</p>
                            <p style="font-size:0.75rem;color:#94a3b8;margin-top:0.25rem;">PDF, DOC, DOCX, JPG, PNG — Max 10MB</p>
                        </div>
                        <input type="file" name="file" id="fileInput" style="display:none;" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                    </label>
                </div>

                <!-- Action Buttons -->
                <div style="display:flex;gap:0.75rem;flex-wrap:wrap;">
                    <button type="submit"
                        style="flex:1;min-width:160px;padding:0.9rem 1.5rem;background:linear-gradient(135deg,#1e40af,#1d4ed8);color:#fff;font-weight:700;font-size:0.9rem;border-radius:0.75rem;border:none;cursor:pointer;transition:all 0.2s;box-shadow:0 4px 15px rgba(29,78,216,0.3);font-family:inherit;letter-spacing:0.01em;"
                        onmouseover="this.style.transform='translateY(-1px)';this.style.boxShadow='0 8px 25px rgba(29,78,216,0.4)'"
                        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 15px rgba(29,78,216,0.3)'">
                        <span style="display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                            <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Submit Document
                        </span>
                    </button>

                    <a href="{{ route('user.dashboard') }}"
                        style="padding:0.9rem 1.25rem;border:1.5px solid #e2e8f0;color:#64748b;font-weight:600;font-size:0.875rem;border-radius:0.75rem;text-decoration:none;transition:all 0.2s;display:inline-flex;align-items:center;gap:0.375rem;font-family:inherit;"
                        onmouseover="this.style.background='#f8fafc';this.style.borderColor='#cbd5e1'"
                        onmouseout="this.style.background='transparent';this.style.borderColor='#e2e8f0'">
                        <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- Info note -->
    <div style="margin-top:1rem;background:#f0f9ff;border:1px solid #bae6fd;border-radius:0.75rem;padding:0.875rem 1rem;display:flex;align-items:flex-start;gap:0.625rem;">
        <svg style="width:1rem;height:1rem;color:#0284c7;flex-shrink:0;margin-top:0.125rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p style="font-size:0.8125rem;color:#0369a1;">After submission, your document will be reviewed by the Administrator who will assign the routing and update its status. You can track it under <strong>Pending</strong>.</p>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('fileInput').addEventListener('change', function() {
        const label = document.getElementById('fileLabel');
        if (this.files.length > 0) {
            label.textContent = '📎 ' + this.files[0].name;
            label.style.color = '#1d4ed8';
        } else {
            label.textContent = 'Click to upload a file';
            label.style.color = '#475569';
        }
    });
</script>
@endpush
@endsection