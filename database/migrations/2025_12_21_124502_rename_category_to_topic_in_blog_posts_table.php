<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite 3.25.0+ supports RENAME COLUMN
        if (config('database.default') === 'sqlite') {
            DB::statement('ALTER TABLE blog_posts RENAME COLUMN category TO topic');
        } else {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->renameColumn('category', 'topic');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (config('database.default') === 'sqlite') {
            DB::statement('ALTER TABLE blog_posts RENAME COLUMN topic TO category');
        } else {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->renameColumn('topic', 'category');
            });
        }
    }
};
