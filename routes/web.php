<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_middleware', 'verified'),
])->group(function () {
    
    // Cambiamos esta ruta para que apunte a nuestro controlador o vista de AdminLTE
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Mapeamos la URL /blog al controlador que acabamos de crear
    Route::get('/blog', [BlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
});