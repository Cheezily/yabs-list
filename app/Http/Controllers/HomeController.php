<?php

namespace App\Http\Controllers;

use App\Helpers\SettingsHelper;
use Inertia\Inertia;
use App\Models\Server;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with(
            [
                'servers',
                'servers.networks'
            ])
            ->where('id', Auth::user()->id)
            ->first();

        Inertia::share('flash', [
            'status' => 'success',
            'message' => 'this is your test'
        ]);

        return Inertia::render('Dashboard', [
            'user' => $user,
            'settings' => SettingsHelper::all(),
        ]);
    }


    public function new_yabs()
    {
        return Inertia::render('NewYabs', [
            'user' => Auth::user(),
            'settings' => SettingsHelper::all(),
        ]);
    }
}
