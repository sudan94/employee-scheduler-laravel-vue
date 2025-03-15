<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scheduled_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignID('employee_id')->constrained()->onDelete('cascade');
            $table->string('field');
            $table->string('old_value')->nullable();
            $table->string('new_value');
            $table->date('effective_date');
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheduled_changes');
    }
};
