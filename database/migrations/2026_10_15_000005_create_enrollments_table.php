<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('admission_session_id')->constrained()->cascadeOnDelete();
            $table->string('reference_code', 32)->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('extension_name')->nullable();
            $table->string('sex');
            $table->date('birthday');
            $table->string('birthplace');
            $table->string('nationality');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('contact_number');
            $table->text('address');
            $table->string('lrn', 12);
            $table->string('last_school_attended');
            $table->string('last_year_attended', 20);
            $table->string('highest_educational_attained');
            $table->string('shs_level', 20);
            $table->string('strand', 20);
            $table->timestamps();

            $table->unique(['admission_session_id', 'lrn']);
            $table->index(['admission_session_id', 'last_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
