<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;

class AppointmentController extends Controller
{
public function index(Request $request)
{
    $user = $request->user();

    $role = $user->role;

    if ($role === 'student') {
        $student = $user->student;

        if (!$student) {
            return response()->json(['message' => 'No student profile found for this user'], 404);
        }

        $appointments = Appointment::with('teacher.user')
            ->where('student_id', $student->id)
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'teacher_name' => $appointment->teacher->user->name ?? 'N/A',
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'status' => $appointment->status,
                ];
            });

        return response()->json($appointments);

    } elseif ($role === 'teacher') {
        // Get teacher's appointments
        $teacher = $user->teacher;

        if (!$teacher) {
            return response()->json(['message' => 'No teacher profile found for this user'], 404);
        }

        $appointments = Appointment::with('student.user')
            ->where('teachers_id', $teacher->id)
            ->get()
            ->map(function ($appointment) {
                return [
                    'id' => $appointment->id,
                    'student_name' => $appointment->student->user->name ?? 'N/A',
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time,
                    'status' => $appointment->status,
                ];
            });

        return response()->json($appointments);
    }

    return response()->json(['message' => 'Invalid user role'], 403);
}

    public function store(Request $request){
        $validated = $request->validate([
            'teachers_id' => 'required|exists:teachers,id',
            'student_id' => 'required|exists:students,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|string',
        ]);

        $appointment = Appointment::create($validated);

        // ✅ 3. Return response
        return response()->json([
            'message' => 'Appointment created successfully',
            'appointment' => $appointment,
        ], 201);

    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|string',
    ]);

    $appointment = Appointment::find($id);

    if (!$appointment) {
        return response()->json(['message' => 'Appointment not found'], 404);
    }

    $appointment->status = $request->input('status');
    $appointment->save();

    return response()->json(['message' => 'Status updated successfully']);
}

}
