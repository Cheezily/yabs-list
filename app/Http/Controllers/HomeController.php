<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::with(
            [
                'servers',
                'servers.networks'
            ])
            ->where('id', Auth::user()->id)
            ->first();

        return view('dashboard', [
            'user' => $user,
            'settings' => Setting::first(),
        ]);
    }
}
