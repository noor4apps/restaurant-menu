<?php

use Illuminate\Support\Facades\Route;

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
//    $menus = \App\Models\Menu::with('children.children.children')->root()->get();
    $menus = \App\Models\Menu::tree();

    return view('welcome', [
        'menus' => $menus
    ]);
});
