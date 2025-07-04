<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramController;

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

Route::get('/', function () {
    if (function_exists('opcache_get_status')) {
        $status = opcache_get_status();
        if ($status && isset($status['opcache_enabled']) && $status['opcache_enabled']) {
            return 'Opcache 已开启';
        } else {
            return 'Opcache 未开启';
        }
    }
    return 'Opcache 扩展未安装';
    
    return view('welcome');
});
