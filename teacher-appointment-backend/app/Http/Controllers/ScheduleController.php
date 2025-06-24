<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    // Fetch all schedules
 public function index()
{
    // Eager load teacher and teacher's user (name)
    $schedules = Schedule::with('teacher.user')->get();

    // Transform data to include only what you want to send
    $result = $schedules->map(function ($schedule) {
        return [
            'id' => $schedule->id,
            'teacher_id' => $schedule->teacher->id,
            'teacher_name' => $schedule->teacher->user->name ?? 'N/A',
            'department' => $schedule->teacher->department ?? 'N/A',
            'day' => $schedule->day,
            'from_time' => $schedule->from_time,
            'to_time' => $schedule->to_time,
        ];
    });

    return response()->json($result);
}

}
