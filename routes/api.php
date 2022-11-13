<?php

use App\Http\Controllers\Api\Dashboard\ItemController;
use App\Http\Controllers\Api\Dashboard\MenuController;
use App\Http\Controllers\Api\Frontend\HomeController;
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

Route::Resource('menus', MenuController::class);

Route::Resource('items', ItemController::class);

Route::get('menus-tree', [HomeController::class, 'menusTree']);
Route::get('items-selected', [HomeController::class, 'itemsSelected']);
