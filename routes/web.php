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
 
Route::get('/test', function () {
    return 'Hello World';
});
Route::get('/flash-sales', function () {
    return Theme::partial('flash-sales');
});
Route::get('/website-under-maintenance', function () {
    return Theme::partial('website-under-maintenance');
});