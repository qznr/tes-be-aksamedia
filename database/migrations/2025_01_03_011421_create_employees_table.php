<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image')->nullable(); // Store only the file path (nullable)
            $table->string('name');
            $table->string('phone');
            $table->string('position');
            $table->foreignUuid('division_id')->constrained('divisions')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->uuid('id')->default(Str::uuid())->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};