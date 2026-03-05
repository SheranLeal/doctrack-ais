<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number', 'submitted_by', 'document_type', 'details',
        'purpose', 'to_department', 'file_path', 'status', 'remarks',
        'handled_by', 'routed_at', 'deferred_at'
    ];

    protected $casts = [
        'routed_at' => 'datetime',
        'deferred_at' => 'datetime',
    ];

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public static function generateTrackingNumber(): string
    {
        $prefix = 'AIS-' . date('Y') . '-';
        $latest = self::where('tracking_number', 'like', $prefix . '%')->count() + 1;
        return $prefix . str_pad($latest, 5, '0', STR_PAD_LEFT);
    }
}