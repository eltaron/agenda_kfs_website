<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/users/{user}/print', function (User $user) {
    // التأكد أن الذي يقوم بالطباعة هو أدمن (حماية إضافية)
    if (!auth()->check()) {
        abort(403);
    }
    return view('print.user-credentials', compact('user'));
})->name('users.print');
