<?php

namespace App\Http\Controllers;

use App\Helpers\SettingsHelper;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {
        $user = User::with(
            [
                'servers',
                'servers.networks'
            ])
            ->where('id', Auth::user()->id)
            ->first();

        return Inertia::render('Dashboard', [
            'user' => $user,
            'passed_server_count' => count($user->servers),
            'settings' => SettingsHelper::all(),
        ]);
    }


    public function new_yabs()
    {
        return Inertia::render('NewYabs', [
            'user' => Auth::user(),
            'virt_types_string' => SettingsHelper::virt_types(),
        ]);
    }

    public function user_settings()
    {
        return Inertia::render('UserSettings', [
            'user' => Auth::user(),
            'settings' => SettingsHelper::all(),
        ]);
    }
}
