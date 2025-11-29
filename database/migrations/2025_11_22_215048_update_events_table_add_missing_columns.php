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
        Schema::table('events', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('events', 'max_participants')) {
                $table->integer('max_participants')->nullable()->after('longitude');
            }
            
            if (!Schema::hasColumn('events', 'skill_level')) {
                $table->string('skill_level', 20)->default('All Levels')->after('price');
            }
            
            if (!Schema::hasColumn('events', 'equipment_needed')) {
                $table->string('equipment_needed')->nullable()->after('skill_level');
            }
            
            // Add sport_type if it doesn't exist
            if (!Schema::hasColumn('events', 'sport_type')) {
                $table->string('sport_type')->after('description');
            }
            
            // Check if we need to modify any columns
            if (Schema::hasColumn('events', 'status')) {
                $table->string('status', 20)->default('upcoming')->change();
            }
            
            if (Schema::hasColumn('events', 'is_public')) {
                $table->boolean('is_public')->default(true)->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Drop the columns if they exist
            $columnsToDrop = [];
            
            if (Schema::hasColumn('events', 'max_participants')) {
                $columnsToDrop[] = 'max_participants';
            }
            
            if (Schema::hasColumn('events', 'skill_level')) {
                $columnsToDrop[] = 'skill_level';
            }
            
            if (Schema::hasColumn('events', 'equipment_needed')) {
                $columnsToDrop[] = 'equipment_needed';
            }
            
            if (Schema::hasColumn('events', 'sport_type')) {
                $columnsToDrop[] = 'sport_type';
            }
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
            
            // Revert column modifications if needed
            if (Schema::hasColumn('events', 'status')) {
                $table->string('status')->default('upcoming')->change();
            }
            
            if (Schema::hasColumn('events', 'is_public')) {
                $table->boolean('is_public')->default(true)->change();
            }
        });
    }
};
