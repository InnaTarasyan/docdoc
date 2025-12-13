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
        Schema::table('reviews', function (Blueprint $table) {
            // Make doctor_id nullable to support organization reviews
            $table->foreignId('doctor_id')->nullable()->change();
            
            // Add organization_id as nullable foreign key
            $table->foreignId('organization_id')->nullable()->after('doctor_id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
            // Note: Making doctor_id non-nullable again might fail if there are organization reviews
            // In production, you'd want to handle this more carefully
        });
    }
};
