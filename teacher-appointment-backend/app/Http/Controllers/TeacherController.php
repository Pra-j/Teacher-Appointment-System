<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
public function index() {
    return Teacher::with('user')->get()->map(fn($t) => [
        'id' => $t->id,
        'name' => $t->user->name,
        'email' => $t->user->email,
        'department' => $t->department,
    ]);
}
public function destroy($id) {
    $teacher = Teacher::with('appointments', 'user')->findOrFail($id);

    $teacher->appointments()->delete();

    $teacher->user()->delete();

    $teacher->delete();

    return response()->json(['message' => 'Teacher, user, and appointments deleted']);
}


public function show($id) {
    $teacher = Teacher::with(['user', 'appointments.student.user'])->findOrFail($id);
    return response()->json($teacher);
}
}
