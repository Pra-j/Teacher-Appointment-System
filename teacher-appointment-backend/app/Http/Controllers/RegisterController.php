<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Schedule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'password' => 'required|min:6',
            'role' => 'required|in:student,teacher',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);

        DB::beginTransaction();

        try {

            $imagePath = null;

if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('uploads'), $imageName);
    $imagePath = 'uploads/' . $imageName;
}

            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'image' => $imagePath,

            ]);

            if ($request->role === 'student') {
                Student::create([
                    'user_id' => $user->id,
                    'roll_number' => $request->roll_number,
                    'department' => $request->department,
                    'year' => $request->year,
                    'section' => $request->section,
                ]);
            } elseif ($request->role === 'teacher') {
                $teacher = Teacher::create([
                    'user_id' => $user->id,
                    'department' => $request->department,
                ]);

                // Save schedule
                Schedule::create([
                    'teacher_id' => $teacher->id,
                    'day' => $request->available_days,
                    'from_time' => $request->from_time,
                    'to_time' => $request->to_time,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Registration failed',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
}
