<?php

namespace App\Http\Controllers;

use App\Models\ShiftReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftReportController extends Controller
{
    public function index()
    {
        $reports = ShiftReport::with('securityGuard')->orderBy('report_date', 'desc')->orderBy('shift_start', 'desc')->get();
        return view('shift_reports.index', compact('reports'));
    }

    public function create()
    {
        return view('shift_reports.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'report_date' => 'required|date',
            'shift_start' => 'required',
            'shift_end' => 'nullable',
            'guard_name' => 'nullable|string|max:255',
            'post_location' => 'nullable|string|max:255',
            'weather_conditions' => 'nullable|string|max:255',
            'activity_entries' => 'nullable|string',
            'incident_details' => 'nullable|string',
            'handover_notes' => 'nullable|string',
            'tech_access_logs' => 'nullable|string',
            'equipment_monitoring' => 'nullable|string',
        ]);

        ShiftReport::create($data);

        return redirect()->route('shift_reports.index')->with('success', 'Shift report logged successfully.');
    }

    public function show(ShiftReport $shiftReport)
    {
        return view('shift_reports.show', compact('shiftReport'));
    }

    public function edit(ShiftReport $shiftReport)
    {
        return view('shift_reports.edit', compact('shiftReport'));
    }

    public function update(Request $request, ShiftReport $shiftReport)
    {
        $data = $request->validate([
            'report_date' => 'required|date',
            'shift_start' => 'required',
            'shift_end' => 'nullable',
            'guard_name' => 'nullable|string|max:255',
            'post_location' => 'nullable|string|max:255',
            'weather_conditions' => 'nullable|string|max:255',
            'activity_entries' => 'nullable|string',
            'incident_details' => 'nullable|string',
            'handover_notes' => 'nullable|string',
            'tech_access_logs' => 'nullable|string',
            'equipment_monitoring' => 'nullable|string',
        ]);

        $shiftReport->update($data);

        return redirect()->route('shift_reports.index')->with('success', 'Shift report updated successfully.');
    }

    public function destroy(ShiftReport $shiftReport)
    {
        $shiftReport->delete();
        return redirect()->route('shift_reports.index')->with('success', 'Shift report deleted.');
    }
}
