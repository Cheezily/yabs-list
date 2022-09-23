<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Server;
use App\Helpers\SettingsHelper;

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
        'anon_yabs' => SettingsHelper::allow_anonymous_submissions() == 1,
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

Route::get('/new_yabs', [
    \App\Http\Controllers\HomeController::class, 'new_yabs'
])->middleware(['auth', 'verified'])->name('new_yabs');

Route::post('/get_options_counts', [
    \App\Http\Controllers\CountController::class, 'get_options_counts'
])->name('metrics');

Route::post('/get_network_details', function (Request $request) {
    return Server::with('networks')->findOrFail($request->get('server'));
});

Route::post('/server/create', [
    \App\Http\Controllers\ServerController::class, 'create'
]);

Route::get('/guest/new_yabs', function () {
    if (SettingsHelper::allow_anonymous_submissions() == 1) {
        return Inertia::render('NewYabsGuest', [
            'virt_types' => SettingsHelper::virt_types()
        ]);
    }
})->name('guest_yabs');
require __DIR__.'/auth.php';
