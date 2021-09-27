<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\GymController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\ExerciseController;
use App\Http\Controllers\Backend\RoutineController;
use App\Http\Controllers\Backend\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::get('dashboard', [DashboardController::class, 'index'])
->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::resource('/gyms', GymController::class);
Route::resource('/exercises', ExerciseController::class);
Route::resource('/routines', RoutineController::class);
Route::resource('/users', UserController::class);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
