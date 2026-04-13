<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('name');
            $table->string('model')->nullable()->after('brand');
        });
        
        // Let's add them to equipment_logs as well so manual logs or snapshots have them
        Schema::table('equipment_logs', function (Blueprint $table) {
            // we probably only need to add foreignId since equipment has brand and model. 
            // Wait, if equipment hub allows manual input, does it create an equipment or just log it?
            // "make in Manually input in Equipment include brand and model in Manage Equipment and Equipment Logs Report"
            // If they mean "make it Manually input", they probably want manual input instead of select. Oh wait, "in Manage Equipment" is where you add. So maybe add it to equipment table.
            
            $table->string('brand')->nullable()->after('equipment_id');
            $table->string('model')->nullable()->after('brand');
            $table->string('equipment_name')->nullable()->after('equipment_id');
        });
        
        // Wait, equipment_logs has `equipment_id`. If manual, equipment_id could be nullable.
        Schema::table('equipment_logs', function (Blueprint $table) {
            $table->foreignId('equipment_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropColumn(['brand', 'model']);
        });

        Schema::table('equipment_logs', function (Blueprint $table) {
            $table->dropColumn(['brand', 'model', 'equipment_name']);
        });
    }
};
