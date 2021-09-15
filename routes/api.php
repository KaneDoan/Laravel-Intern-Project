<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\ExerciseController;
use App\Http\Controllers\Api\ExerciseRoutineController;
use App\Http\Controllers\Api\GymController;
use App\Http\Controllers\Api\GymUserController;
use App\Http\Controllers\Api\RoutineController;
use App\Http\Controllers\Api\UserController;
use App\Models\GymUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::apiResource('gyms', GymController::class)->middleware('auth:api');

//Route::apiResource('gyms', GymController::class)->middleware('auth:api');
Route::get('/profile', [UserController::class, 'index'])->name('profile.index');
Route::post('/profile', [UserController::class, 'store'])->name('profile.store');

Route::get('/gym/profile', [GymController::class, 'index'])->name('gym.profile.index');
Route::post('/gym/profile', [GymController::class, 'store'])->name('gym.profile.store');

Route::get('/gym_user', [GymUserController::class, 'index'])->name('gym.user.index');
Route::get('/gym_user/{gym_user}', [GymUserController::class, 'show'])->name('gym.user.show');

Route::group(['middleware' => ['is_admin']], function () {

    Route::get('users', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'store']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::patch('users/{user}', [UserController::class, 'update']);
    //Route::post('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'delete']);

    Route::get('gyms', [GymController::class, 'index']);
    Route::post('gyms', [GymController::class, 'store']);
    Route::put('gyms/{gym}', [GymController::class, 'update']);
    Route::patch('gyms/{gym}', [GymController::class, 'update']);
    //Route::post('gyms/{gym}', [GymController::class, 'update']);
    Route::delete('gyms/{gym}', [GymController::class, 'delete']);

});

Route::group(['middleware' => ['auth:api']], function () {

    Route::apiResource('gyms', GymController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('routines', RoutineController::class);
    Route::apiResource('exercises', ExerciseController::class);
    Route::apiResource('exercise_routine', ExerciseRoutineController::class);

});
