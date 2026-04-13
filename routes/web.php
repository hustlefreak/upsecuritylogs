<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\GuardKioskController;
use App\Http\Controllers\StaffKioskController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\IconSettingsController;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\EquipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { 
    return view('hub'); 
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Self-Service Hub
Route::get('/hub', function () { 
    return view('hub'); 
})->name('hub');

// Equipment Hub Routes
Route::get('/equipment-hub', [EquipmentController::class, 'index'])->name('equipment.hub');
Route::post('/equipment-hub', [EquipmentController::class, 'process'])->name('equipment.process');
Route::post('/equipment', [EquipmentController::class, 'store'])->name('equipment.store');
Route::delete('/equipment/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');
Route::patch('/equipment/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
Route::get('/equipment-logs', [EquipmentController::class, 'logs'])->name('equipment.logs');
Route::get('/equipment-logs/export', [EquipmentController::class, 'export'])->name('equipment.logs.export');

// Public Staff Kiosk Routes
Route::get('/staff-kiosk', [StaffKioskController::class, 'index'])->name('staff_kiosk.index');
Route::get('/staff-kiosk/monitor', [StaffKioskController::class, 'monitor'])->name('staff_kiosk.monitor');
Route::patch('/staff-kiosk/checkout/{id}', [StaffKioskController::class, 'checkout'])->name('staff_kiosk.checkout');
Route::post('/staff-kiosk', [StaffKioskController::class, 'process'])->name('staff_kiosk.process');
Route::get('/staff-kiosk/success', [StaffKioskController::class, 'success'])->name('staff_kiosk.success');

// Public Kiosk Routes
Route::get('/upsecurityhub/visitors', [KioskController::class, 'index'])->name('kiosk.index');
Route::post('/upsecurityhub/visitors', [KioskController::class, 'store'])->name('kiosk.store');
Route::get('/upsecurityhub/visitors/success', [KioskController::class, 'success'])->name('kiosk.success');
Route::get('/upsecurityhub/visitors/monitor', [KioskController::class, 'monitor'])->name('kiosk.monitor');
Route::patch('/upsecurityhub/visitors/checkout/{id}', [KioskController::class, 'checkout'])->name('kiosk.checkout');

// Public Guard Shift Kiosk Routes
Route::get('/guard-kiosk', [GuardKioskController::class, 'index'])->name('guard_kiosk.index');
Route::post('/guard-kiosk', [GuardKioskController::class, 'store'])->name('guard_kiosk.store');
Route::get('/guard-kiosk/success', [GuardKioskController::class, 'success'])->name('guard_kiosk.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // System management routes (Offices, Staff, Visitors)
    Route::resource('admin/users', AdminUserController::class)->except(['show', 'edit', 'update'])->names('admin.users');
    Route::resource('admin/guards', GuardController::class)->names('admin.guards');
    Route::get('admin/icons', [IconSettingsController::class, 'index'])->name('admin.icons.index');
    Route::post('admin/icons', [IconSettingsController::class, 'update'])->name('admin.icons.update');
    Route::post('admin/icons/reset', [IconSettingsController::class, 'reset'])->name('admin.icons.reset');
    
    Route::resource('offices', OfficeController::class);
    Route::resource('staff', StaffController::class);
    Route::resource('visitors', VisitorController::class);
    Route::resource('shift_reports', \App\Http\Controllers\ShiftReportController::class);

    // Dynamic Attendance Routes
    Route::get('/attendance/staff', [AttendanceController::class, 'staffIndex'])->name('attendance.staff');
    Route::post('/attendance/staff/checkin', [AttendanceController::class, 'staffCheckIn'])->name('attendance.staff.checkin');
    Route::patch('/attendance/staff/checkout', [AttendanceController::class, 'staffCheckOut'])->name('attendance.staff.checkout');

    Route::get('/attendance/visitors', [AttendanceController::class, 'visitorIndex'])->name('attendance.visitors');
    Route::post('/attendance/visitors/checkin', [AttendanceController::class, 'visitorCheckIn'])->name('attendance.visitors.checkin');
    Route::patch('/attendance/visitors/checkout', [AttendanceController::class, 'visitorCheckOut'])->name('attendance.visitors.checkout');

    // Analytics and Reporting Routes
    Route::get('/calendar', [AttendanceController::class, 'calendar'])->name('calendar.index');
    Route::get('/reports', [AttendanceController::class, 'reports'])->name('reports.index');
    Route::get('/reports/export', [AttendanceController::class, 'export'])->name('reports.export');
});

require __DIR__.'/auth.php';
