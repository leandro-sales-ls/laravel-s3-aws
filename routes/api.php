<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UploadController;

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

Route::post('upload', [UploadController::class, 'sendFile']);
Route::post('list-files', [UploadController::class, 'listFiles']);
Route::post('get-file', [UploadController::class, 'listFileId']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


