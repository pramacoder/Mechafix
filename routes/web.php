<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        return match($user->role) {
            'admin' => redirect('/admin'),
            'mekanik' => redirect('/mekanik'),
            'konsumen' => view('konsumen.dashboard'),
            default => abort(403),
        };
    });
});