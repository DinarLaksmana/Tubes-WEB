<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
    Route::get('/', function () {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->type === 'mahasiswa') {
                return redirect()->route('mahasiswa.index');
            } elseif ($user->type === 'dosen') {
                return redirect()->route('dosen.index');
            }
        }

        return redirect()->route('login');
    });
});

Route::middleware(['auth', 'user-access:mahasiswa'])->group(function () {
    // Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/mahasiswa', [HomeController::class, 'mahasiswa'])->name('mahasiswa.index');
    Route::resource('/mahasiswa', StudentController::class);
    Route::post('/submit-task/{task}', [StudentController::class, 'submitTask'])->name('submitTask');
});

Route::middleware(['auth', 'user-access:dosen'])->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register');
    Route::delete('/delete/student/{studentId}', [AuthController::class, 'deleteStudent'])->name('delete.student');
    Route::get('/dosen', [HomeController::class, 'dosen'])->name('dosen.index');
    Route::resource('/dosen', TeacherController::class);
    Route::post('/submit/grade/{taskId}/{userId}', [TeacherController::class, 'submitGrade'])->name('submit.grade');
    Route::put('/edit/grade/{taskId}/{userId}', [TeacherController::class, 'editGrade'])->name('edit.grade');
});