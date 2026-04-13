<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // 1. Core Header Fields
            $table->date('report_date');
            $table->time('shift_start');
            $table->time('shift_end')->nullable();
            $table->string('guard_name')->nullable();
            $table->string('post_location')->nullable();
            $table->string('weather_conditions')->nullable();
            
            // 2. Activity Entries
            $table->text('activity_entries')->nullable();
            
            // 3. Incident Details
            $table->text('incident_details')->nullable();
            
            // 4. Handover Notes
            $table->text('handover_notes')->nullable();
            
            // 5. Tech Access Logs
            $table->text('tech_access_logs')->nullable();
            
            // 6. Equipment Monitoring
            $table->text('equipment_monitoring')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_reports');
    }
};
