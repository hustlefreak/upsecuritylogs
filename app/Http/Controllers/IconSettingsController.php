<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IconSettingsController extends Controller
{
    public function index()
    {
        $icons = [
            'hub_main_icon' => 'Main Hub Logo',
            'hub_visitor_icon' => 'Visitor Check-in Icon',
            'hub_staff_icon' => 'Staff Check-in Icon',
            'hub_guard_icon' => 'Security Guard Icon',
            'hub_checkout_icon' => 'Visitor Checkout Icon',
            'dashboard_shift_report_icon' => 'Dashboard Shift Log Icon',
            'dashboard_staff_icon' => 'Dashboard Staff Logs Icon',
            'dashboard_visitor_icon' => 'Dashboard Visitor Logs Icon',
            'dashboard_timeline_icon' => 'Dashboard Calendar Icon',
            'dashboard_reports_icon' => 'Dashboard Export Reports Icon',
            'application_logo' => 'Application Logo',
            'favicon_icon' => 'Favicon Icon',
            'hub_background' => 'Hub Background Image',
            'dashboard_background' => 'Dashboard Background Image',
        ];

        return view('admin.icons.index', compact('icons'));
    }

    public function update(Request $request)
    {
        $keys = [
            'hub_main_icon',
            'hub_visitor_icon',
            'hub_staff_icon',
            'hub_guard_icon',
            'hub_checkout_icon',
            'dashboard_shift_report_icon',
            'dashboard_staff_icon',
            'dashboard_visitor_icon',
            'dashboard_timeline_icon',
            'dashboard_reports_icon',
            'application_logo',
            'favicon_icon',
            'hub_background',
            'dashboard_background'
        ];

        foreach ($keys as $key) {
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $request->validate([
                    $key => 'image|mimes:jpeg,png,jpg,gif,svg,webp,ico|max:5120',
                ]);

                // Store in public disk under 'icons' directory
                $path = $file->store('icons', 'public');

                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => '/storage/' . $path]
                );
            }
        }

        return back()->with('status', 'Icons updated successfully!');
    }

    public function reset(Request $request)
    {
        $keys = [
            'hub_main_icon',
            'hub_visitor_icon',
            'hub_staff_icon',
            'hub_guard_icon',
            'hub_checkout_icon',
            'dashboard_shift_report_icon',
            'dashboard_staff_icon',
            'dashboard_visitor_icon',
            'dashboard_timeline_icon',
            'dashboard_reports_icon',
            'application_logo',
            'favicon_icon',
            'hub_background',
            'dashboard_background'
        ];

        if ($request->has('key') && in_array($request->key, $keys)) {
            Setting::where('key', $request->key)->delete();
            return back()->with('status', 'Icon reset to default successfully!');
        }

        Setting::whereIn('key', $keys)->delete();
        return back()->with('status', 'All icons reset to default successfully!');
    }
}
