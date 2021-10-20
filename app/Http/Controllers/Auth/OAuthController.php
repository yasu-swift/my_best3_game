<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use PhpParser\Node\Identifier;
use App\Models\IdentityProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class OAuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function oauthCallback()
    {
        try {
            $socialUser = Socialite::with('github')->user();
        } catch (\Throwable $th) {
            return redirect('/login')->withErrors(['oauth' => '予期せぬエラーが発生しました']);
        }
        dd($socialUser);
    }
}
