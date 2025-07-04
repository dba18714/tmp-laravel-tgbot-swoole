<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/telegram/webhook', [TelegramController::class, 'webhook']);
Route::get('/telegram/set-webhook', [TelegramController::class, 'setWebhook']); 

Route::get('/opcache-status', function () {
    if (function_exists('opcache_get_status')) {
        $status = opcache_get_status();
        if ($status && isset($status['opcache_enabled']) && $status['opcache_enabled']) {
            return 'Opcache 已开启';
        } else {
            return 'Opcache 未开启';
        }
    }
    return 'Opcache 扩展未安装';
});