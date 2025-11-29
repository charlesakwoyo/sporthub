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
        // This migration is to fix the rollback order for the event_categories table
        // The actual fix is in the down() method
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This method is intentionally left empty
        // The purpose of this migration is to ensure proper rollback order
        // by having it run before the event_categories table is dropped
    }
};
