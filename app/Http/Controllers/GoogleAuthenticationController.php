<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class GoogleAuthenticationController extends Controller
{
    public function google()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function googleRedirect()
    {
            $user = Socialite::driver('google')->stateless()->user();
            
            $user = User::firstOrCreate([
                'email' => $user->email
            ],[
                'name' => $user->name,
                'password' => Hash::make(Str::random(10)),
                'email' => $user->email,
                'verification_token' => Str::random(45),
                'email_verified_at' => now()
            ]);

            Auth::login($user, true);
            return redirect('/');
    }
}
