<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->text('serial_numbers')->nullable()->after('model');
        });
        
        Schema::table('equipment_logs', function (Blueprint $table) {
            $table->text('serial_numbers')->nullable()->after('model');
        });
    }

    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn('serial_numbers');
        });

        Schema::table('equipment_logs', function (Blueprint $table) {
            $table->dropColumn('serial_numbers');
        });
    }
};
