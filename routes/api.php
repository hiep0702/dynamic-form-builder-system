<?php

use App\Http\Controllers\Api\FormController;
use App\Http\Controllers\Api\SubmissionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

Route::apiResource('forms', FormController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::post('forms/{id}/fields', [FormController::class, 'addField']);
Route::put('forms/{id}/fields/{fieldId}', [FormController::class, 'updateField']);
Route::delete('forms/{id}/fields/{fieldId}', [FormController::class, 'removeField']);
Route::get('forms/active', [FormController::class, 'activeForms']);
Route::get('forms/active/{id}', [FormController::class, 'activeFormDetail']);
Route::post('forms/{id}/submit', [SubmissionController::class, 'submit']);
Route::apiResource('submissions', SubmissionController::class)->only(['index', 'show']);
