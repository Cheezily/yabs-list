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

Route::get('/', function (Request $request) {
    if($request->deleted) {
        Inertia::share('flash', [
            'status' => 'success',
            'message' => 'User and all Submitted Benchmarks Deleted!'
        ]);
    }

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
})->name('welcome');

Route::post('/get_results', [
    \App\Http\Controllers\ResultsController::class, 'get_results'
])->name('get_results');

Route::post('/get_options_counts', [
    \App\Http\Controllers\CountController::class, 'get_options_counts'
])->name('get_options_count');

Route::post('/get_network_details', function (Request $request) {
    return Server::with('networks')->findOrFail($request->get('server'));
})->name('get_network_details');

Route::get('/search/provider', function (Request $request) {
    return Server::where('provider_name', 'like', '%'.$request->search_terms.'%')
        ->select(['provider_name'])
        ->distinct()
        ->limit(10)
        ->get();
})->name('provider_search');

Route::get('/search/city', function (Request $request) {
    return Server::where('city', 'like', '%'.$request->search_terms.'%')
        ->select(['city'])
        ->distinct()
        ->limit(10)
        ->get();
})->name('city_search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/new_yabs', [
        \App\Http\Controllers\HomeController::class, 'new_yabs'
    ])->name('new_yabs');

    Route::get('/dashboard', [
        \App\Http\Controllers\HomeController::class, 'dashboard'
    ])->name('dashboard');

    Route::get('/user/settings', [
        \App\Http\Controllers\UserController::class, 'index'
    ])->name('user_settings');

    Route::post('/user/update/details', [
        \App\Http\Controllers\UserController::class, 'update_details'
    ])->name('update_user_details');

    Route::post('/user/update/password', [
        \App\Http\Controllers\UserController::class, 'update_password'
    ])->name('update_user_password');

    Route::get('/user/delete', [
        \App\Http\Controllers\UserController::class, 'delete'
    ])->name('delete_user');

    Route::post('/server/delete', [
        \App\Http\Controllers\ServerController::class, 'delete'
    ])->name('delete_server');
});

Route::post('/server/create', [
    \App\Http\Controllers\ServerController::class, 'create'
])->name('create_server');

Route::get('/guest/new_yabs', function () {
    if (SettingsHelper::allow_anonymous_submissions() == 1) {
        return Inertia::render('NewYabsGuest', [
            'virt_types' => SettingsHelper::virt_types()
        ]);
    }
})->name('guest_yabs');

require __DIR__.'/auth.php';
