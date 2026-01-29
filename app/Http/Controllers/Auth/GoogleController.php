<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();
            if (!$user) {
                $user = User::create(['name' => $googleUser->getName(), 'email' => $googleUser->getEmail(), 'password' => bcrypt(str()->random(16)),  'google_id' => $googleUser->getId(),]);
            }
            Auth::login($user);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login dengan Google dibatalkan atau gagal.');
        }
    }
}
