<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\SurveyController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/dashboard', [dashboardController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::resource('/surveys', SurveyController::class);
    Route::resource('/employe', EmployeController::class);
    Route::resource('/client', ClientController::class);
    Route::get('/survey-by-slug/{survey:slug}', [SurveyController::class, 'showForGuest']);
    Route::post('/survey/{survey}/answer', [SurveyController::class, 'storeAnswer']);
    Route::get('/survey-details/{id}', [SurveyController::class, 'SurveyDetails']);
    Route::get('/survey/export/', [SurveyController::class, 'excellExport']);
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
