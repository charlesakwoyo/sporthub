<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove is_admin column if it exists
            if (Schema::hasColumn('users', 'is_admin')) {
                $table->dropColumn('is_admin');
            }

            // Ensure role column exists with correct enum values
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'organizer', 'user'])->default('user')->after('email_verified_at');
            } else {
                // Update role column to ensure it has correct enum values
                \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'organizer', 'user') NOT NULL DEFAULT 'user'");
            }
        });
    }

    public function down(): void
    {
        // In case you need to rollback, we'll add is_admin back
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('email_verified_at');
            }
            // No need to drop role column in down() as it's part of the new structure
        });
    }
};