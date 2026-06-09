<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('phone_number');
            $table->text('message');
            $table->enum('type', ['payment_receipt', 'lesson_reminder', 'clearance', 'general'])->default('general');
            $table->enum('status', ['sent', 'failed', 'pending'])->default('pending');
            $table->string('sms_reference')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};