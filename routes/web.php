<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

Route::get('/', function(){
    return view('index');
}); 

Route::get('/menu', [MenuController::class, 'index']);


Route::get('/hakkımızda', function(){
    return view('hakkımızda');
});

Route::get('/iletisim', function(){
    return view('iletisim');
});


Route::view('{Admin}', 'app')->where('Admin', '.*');


