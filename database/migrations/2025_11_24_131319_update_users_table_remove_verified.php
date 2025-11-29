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
    // Only drop the column if it exists to avoid errors when
    // the base users table never had email_verified_at.
    if (Schema::hasColumn('users', 'email_verified_at')) {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email_verified_at'); // remove email verification
        });
    }

    // Add other columns if they do not already exist.
    Schema::table('users', function (Blueprint $table) {
        if (!Schema::hasColumn('users', 'phone_number')) {
            $table->string('phone_number')->nullable()->after('email');
        }
        if (!Schema::hasColumn('users', 'phone')) {
            $table->string('phone')->nullable()->after('phone_number');
        }
        if (!Schema::hasColumn('users', 'profile_photo')) {
            $table->string('profile_photo')->nullable()->after('password');
        }
        if (!Schema::hasColumn('users', 'role')) {
            $table->string('role')->default('user')->after('profile_photo');
        }
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->timestamp('email_verified_at')->nullable();
        $table->dropColumn(['phone_number', 'phone', 'profile_photo', 'role']);
    });
}

};
