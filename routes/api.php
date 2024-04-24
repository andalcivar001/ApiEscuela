<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController; 
use App\Http\Controllers\Api\CursoController; 
use App\Http\Controllers\Api\AdminstradorController; 
use App\Http\Controllers\Api\DashboardController; 
use App\Http\Controllers\Api\CourseStudentController; 


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//students
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

//cursos
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{id}', [CursoController::class, 'show']);
Route::post('/cursos', [CursoController::class, 'store']);
Route::put('/cursos/{id}', [CursoController::class, 'update']);
Route::delete('/cursos/{id}', [CursoController::class, 'destroy']);


//cursos
Route::get('/cursos-estudiante/{id}', [CourseStudentController::class, 'show']);
Route::put('/cursos-estudiante/{id}', [CourseStudentController::class, 'update']);


//administradores
Route::get('/administradores/{correo}/{clave}', [AdminstradorController::class, 'show']);
Route::post('/administradores', [AdminstradorController::class, 'store']);


//dashboard
Route::get('/dashboard/top-cursos', [DashboardController::class, 'topCursos']);
Route::get('/dashboard/top-estudiantes', [DashboardController::class, 'topEstudiantes']);

