<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/chat_contact', function () {
    return view('chat_contact');
});
Route::get('/part_shop', function () {
    return view('part_shop');
});
Route::get('/services', function () {
    return view('services');
});
Route::get('/history', function () {
    return view('history');
});

Route::get('/our_profile', function () {
    return view('our_profile');
});
