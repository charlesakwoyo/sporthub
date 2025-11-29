<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('id')
                  ->constrained()
                  ->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            // First, check if the column exists before trying to drop it
            if (Schema::hasColumn('events', 'category_id')) {
                // Drop the foreign key constraint if it exists
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
        });
    }
};
