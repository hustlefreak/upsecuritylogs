<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Visitor;
use App\Models\StaffAttendance;
use App\Models\VisitorAttendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // STAFF
    public function staffIndex(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        
        $attendances = StaffAttendance::with('staff.office')
                        ->whereDate('date', $date)
                        ->get();
                        
        $staffList = Staff::all(); // for check-in dropdown

        return view('attendance.staff', compact('attendances', 'staffList', 'date'));
    }

    public function staffCheckIn(Request $request)
    {
        $request->validate(['staff_id' => 'required|exists:staff,id']);
        
        StaffAttendance::create([
            'staff_id' => $request->staff_id,
            'date' => Carbon::today()->toDateString(),
            'time_in' => Carbon::now(),
            'status' => 'present'
        ]);

        return back()->with('success', 'Staff checked in.');
    }

    public function staffCheckOut(Request $request)
    {
        $request->validate(['attendance_id' => 'required|exists:staff_attendances,id']);
        
        $attendance = StaffAttendance::findOrFail($request->attendance_id);
        $attendance->update([
            'time_out' => Carbon::now()
        ]);

        return back()->with('success', 'Staff checked out.');
    }

    // VISITORS
    public function visitorIndex(Request $request)
    {
        $date = tap($request->input('date', Carbon::today()->toDateString()), function($d) {});
        $attendances = VisitorAttendance::with(['visitor', 'office', 'staff'])
                        ->whereDate('time_in', Carbon::parse($date))
                        ->get();
                        
        $visitorsList = Visitor::all();
        $staffList = Staff::all();
        $officeList = \App\Models\Office::all();

        return view('attendance.visitors', compact('attendances', 'visitorsList', 'staffList', 'officeList', 'date'));
    }

    public function visitorCheckIn(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|exists:visitors,id',
            'purpose' => 'required|string|max:255',
            'office_id' => 'nullable|exists:offices,id',
            'staff_to_visit' => 'nullable|exists:staff,id',
            'person_to_visit_name' => 'nullable|string|max:255',
        ]);

        VisitorAttendance::create([
            'visitor_id' => $request->visitor_id,
            'office_id' => $request->office_id,
            'staff_to_visit' => $request->staff_to_visit,
            'person_to_visit_name' => $request->person_to_visit_name,
            'purpose' => $request->purpose,
            'time_in' => Carbon::now(),
            'badge_returned' => false
        ]);

        return back()->with('success', 'Visitor checked in.');
    }

    public function visitorCheckOut(Request $request)
    {
        $request->validate([
            'attendance_id' => 'required|exists:visitor_attendances,id'
        ]);
        
        $attendance = VisitorAttendance::findOrFail($request->attendance_id);
        $attendance->update([
            'time_out' => Carbon::now()
        ]);

        return back()->with('success', 'Visitor checked out.');
    }

    // CALENDAR
    public function calendar()
    {
        $visitorLogs = VisitorAttendance::with('visitor')->get()->map(function($log) {
            return [
                'title' => 'Visitor: ' . $log->visitor->firstName . ' ' . $log->visitor->lastName,
                'start' => Carbon::parse($log->time_in)->toIso8601String(),
                'end' => $log->time_out ? Carbon::parse($log->time_out)->toIso8601String() : null,
                'color' => '#10B981'
            ];
        });

        $staffLogs = StaffAttendance::with('staff')->get()->map(function($log) {
            return [
                'title' => 'Staff: ' . $log->staff->firstName . ' ' . $log->staff->lastName,
                'start' => Carbon::parse($log->time_in)->toIso8601String(),
                'end' => $log->time_out ? Carbon::parse($log->time_out)->toIso8601String() : null,
                'color' => '#3B82F6'
            ];
        });

        $events = $visitorLogs->merge($staffLogs);

        return view('calendar.index', compact('events'));
    }

    // REPORTS
    public function reports(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $type = $request->input('type', 'staff'); // staff, visitor, or equipment

        if ($type === 'visitor') {
            $data = VisitorAttendance::with(['visitor', 'office', 'staff'])
                        ->whereDate('time_in', $date)->get();
        } elseif ($type === 'equipment') {
            $query = \App\Models\EquipmentLog::with('equipment')
                        ->whereDate('created_at', $date);
            
            if ($request->has('search') && $request->search != '') {
                $searchTerm = $request->search;
                $query->where(function($q) use ($searchTerm) {
                    $q->where('equipment_name', 'like', "%{$searchTerm}%")
                      ->orWhere('brand', 'like', "%{$searchTerm}%")
                      ->orWhere('model', 'like', "%{$searchTerm}%")
                      ->orWhere('serial_numbers', 'like', "%{$searchTerm}%")
                      ->orWhereHas('equipment', function($eqQuery) use ($searchTerm) {
                          $eqQuery->where('name', 'like', "%{$searchTerm}%")
                                  ->orWhere('brand', 'like', "%{$searchTerm}%")
                                  ->orWhere('model', 'like', "%{$searchTerm}%")
                                  ->orWhere('serial_numbers', 'like', "%{$searchTerm}%");
                      });
                });
            }
            $data = $query->get();
        } else {
            $data = StaffAttendance::with('staff.office')
                        ->whereDate('date', $date)->get();
        }

        return view('reports.index', compact('data', 'type', 'date'));
    }

    public function export(Request $request)
    {
        $date = $request->input('date', Carbon::today()->toDateString());
        $type = $request->input('type', 'staff');
        
        $filename = "{$type}_report_{$date}.csv";
        $handle = fopen('php://output', 'w');

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        if ($type === 'visitor') {
            $data = VisitorAttendance::with(['visitor', 'office', 'staff'])
                        ->whereDate('time_in', $date)->get();
            fputcsv($handle, ['Visitor Name', 'Company', 'Purpose', 'Office/Staff', 'Time In', 'Time Out']);
            foreach ($data as $row) {
                $target = $row->office ? $row->office->name : ($row->staff ? $row->staff->firstName : 'N/A');
                fputcsv($handle, [
                    $row->visitor->firstName . ' ' . $row->visitor->lastName,
                    $row->visitor->company,
                    $row->purpose,
                    $target,
                    $row->time_in ? Carbon::parse($row->time_in)->format('H:i') : '',
                    $row->time_out ? Carbon::parse($row->time_out)->format('H:i') : ''
                ]);
            }
        } elseif ($type === 'equipment') {
            $data = \App\Models\EquipmentLog::with('equipment')->whereDate('created_at', $date)->get();
            fputcsv($handle, ['Date/Time', 'Equipment Name', 'Brand', 'Model', 'Serial Numbers', 'Quantity', 'User', 'Action Taken']);
            foreach ($data as $row) {
                $action = $row->action === 'pulled_out' ? 'Pulled Out' : 'Returned';
                fputcsv($handle, [
                    $row->created_at->format('Y-m-d H:i:s'),
                    $row->equipment_name ?? ($row->equipment ? $row->equipment->name : ''),
                    $row->brand ?? ($row->equipment ? $row->equipment->brand : ''),
                    $row->model ?? ($row->equipment ? $row->equipment->model : ''),
                    $row->serial_numbers ?? ($row->equipment ? $row->equipment->serial_numbers : ''),
                    $row->quantity,
                    $row->user_name,
                    $action
                ]);
            }
        } else {
            $data = StaffAttendance::with('staff.office')->whereDate('date', $date)->get();
            fputcsv($handle, ['Staff Name', 'Staff ID', 'Office', 'Time In', 'Time Out', 'Status']);
            foreach ($data as $row) {
                fputcsv($handle, [
                    $row->staff->firstName . ' ' . $row->staff->lastName,
                    $row->staff->staff_id_number,
                    $row->staff->office->name ?? 'N/A',
                    $row->time_in ? Carbon::parse($row->time_in)->format('H:i') : '',
                    $row->time_out ? Carbon::parse($row->time_out)->format('H:i') : '',
                    $row->status
                ]);
            }
        }

        fclose($handle);
        exit;
    }
}
