<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->enum('document_type', [
                'Application Documents',
                'Communications',
                'Daily Time Record (DTR)',
                'Leave (Form 6)',
                'Reports',
                'Travel Order',
                'Others'
            ]);
            $table->text('details');
            $table->text('purpose');
            $table->string('to_department');
            $table->string('file_path')->nullable();
            $table->enum('status', ['pending', 'routed', 'deferred', 'approved', 'received'])->default('pending');
            $table->text('remarks')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('routed_at')->nullable();
            $table->timestamp('deferred_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};