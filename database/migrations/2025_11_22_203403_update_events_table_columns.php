<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn('events', 'slug')) {
                $table->string('slug')->nullable()->after('title');
            }
            
            if (!Schema::hasColumn('events', 'address')) {
                $table->string('address')->nullable()->after('location');
            }
            
            if (!Schema::hasColumn('events', 'currency')) {
                $table->string('currency', 3)->default('USD')->after('price');
            }
            
            if (!Schema::hasColumn('events', 'featured_image')) {
                $table->string('featured_image')->nullable()->after('image');
            }
            
            if (!Schema::hasColumn('events', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_public');
            }
            
            if (!Schema::hasColumn('events', 'is_approved')) {
                $table->boolean('is_approved')->default(true)->after('is_featured');
            }
            
            if (!Schema::hasColumn('events', 'event_category_id')) {
                $table->foreignId('event_category_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('event_categories')
                    ->onDelete('set null');
            }
            
            if (!Schema::hasColumn('events', 'registration_deadline')) {
                $table->dateTime('registration_deadline')->nullable()->after('end_datetime');
            }
            
            if (!Schema::hasColumn('events', 'capacity')) {
                $table->integer('capacity')->default(0)->after('max_participants');
            }
            
            // Rename columns to match the factory if they exist
            if (Schema::hasColumn('events', 'image') && !Schema::hasColumn('events', 'featured_image_old')) {
                $table->renameColumn('image', 'featured_image_old');
            }
            
            if (Schema::hasColumn('events', 'max_participants') && !Schema::hasColumn('events', 'max_attendees')) {
                $table->renameColumn('max_participants', 'max_attendees');
            }
        });

        // Copy data from old columns to new columns if they exist
        if (Schema::hasColumn('events', 'featured_image_old')) {
            DB::statement('UPDATE events SET featured_image = featured_image_old');
            
            // Remove the old columns in a separate transaction
            Schema::table('events', function (Blueprint $table) {
                if (Schema::hasColumn('events', 'featured_image_old')) {
                    $table->dropColumn('featured_image_old');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We'll keep the down method simple since this is a one-time migration
        Schema::table('events', function (Blueprint $table) {
            // We won't automatically drop columns in the down method
            // to prevent data loss during rollback
        });
    }
};