<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('license_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g. Class B, Class C, Class CE
            $table->text('description')->nullable();
            $table->decimal('total_fee', 10, 2);
            $table->integer('required_practical_hours');
            $table->integer('required_theory_lessons');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('license_categories');
    }
};