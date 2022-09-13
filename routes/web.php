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

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
