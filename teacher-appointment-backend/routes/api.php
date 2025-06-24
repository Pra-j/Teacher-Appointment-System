<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use \App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;




Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/schedules', [ScheduleController::class, 'index']);

Route::middleware('auth:sanctum')->get('/appointments', [AppointmentController::class, 'index']);
Route::middleware('auth:sanctum')->post('/appointments', [AppointmentController::class, 'store']);
Route::middleware('auth:sanctum')->post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus']);

Route::middleware('auth:sanctum')->get('/students', [StudentController::class, 'index']);
Route::middleware('auth:sanctum')->get('/teachers', [TeacherController::class, 'index']);

// Rouutes for admin.
Route::middleware('auth:sanctum')->get('/students/{id}', [StudentController::class, 'show']);
Route::middleware('auth:sanctum')->get('/teachers/{id}', [TeacherController::class, 'show']);
Route::middleware('auth:sanctum')->delete('/students/{id}', [StudentController::class, 'destroy']);
Route::middleware('auth:sanctum')->delete('/teachers/{id}', [TeacherController::class, 'destroy']);

Route::options('/{any}', function (Request $request) {
    return response()->json([], 204);
})->where('any', '.*');
