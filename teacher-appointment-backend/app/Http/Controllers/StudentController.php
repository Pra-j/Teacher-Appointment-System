<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // StudentController
public function index() {
    return Student::with('user')->get()->map(fn($s) => [
        'id' => $s->id,
        'name' => $s->user->name,
        'email' => $s->user->email,
    ]);
}
public function destroy($id) {
    $student = Student::with('appointments', 'user')->findOrFail($id);

    // Delete all appointments related to the student
    $student->appointments()->delete();

    // Delete the user related to the student
    $student->user()->delete();

    // Delete the student record itself
    $student->delete();

    return response()->json(['message' => 'Student, user, and appointments deleted']);
}


public function show($id) {
    $student = Student::with(['user', 'appointments.teacher.user'])->findOrFail($id);
    return response()->json($student);
}

}
