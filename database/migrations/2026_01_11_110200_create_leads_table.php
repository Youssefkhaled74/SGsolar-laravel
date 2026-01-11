<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->index();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->text('product_text')->nullable();

            $table->foreignId('source_id')->nullable()->constrained('lead_sources')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('status_id')->nullable()->constrained('lead_statuses')->cascadeOnUpdate()->nullOnDelete();

            $table->foreignId('assigned_to')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            $table->timestamps();

            $table->index('source_id');
            $table->index('status_id');
            $table->index('assigned_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
