<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::post('/get_results', [
    \App\Http\Controllers\ResultsController::class, 'results'
])->name('results');

Route::post('/update_results', [
    \App\Http\Controllers\ResultsController::class, 'update_results'
])->name('update_results');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'can_login' => Route::has('login'),
        'can_register' => Route::has('register'),
        'server_count' => \App\Models\Server::count(),
        'passed_servers' => \App\Models\Server::with(['networks', 'user'])
        ->orderBy('created_at', 'desc')
        ->limit(50)
        ->get()
    ]);
});

Route::get('/dashboard', [
    \App\Http\Controllers\HomeController::class, 'index'
])->middleware(['auth', 'verified'])->name('dashboard');


Route::post('/get_options_counts', [
    \App\Http\Controllers\CountController::class, 'get_options_counts'
])->name('metrics');

require __DIR__.'/auth.php';
