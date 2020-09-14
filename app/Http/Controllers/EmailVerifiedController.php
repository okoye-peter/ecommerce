<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailVerifiedController extends Controller
{
    public function verify(Request $request)
    {
        if ($request->code == null) {
            return redirect('/login')->withErrors(['error'=>'invalid verification token']);
        }
        $code = hex2bin($request->code);
        $user = \DB::table('users')->where('verification_token', $code)->first();
        if ($user != null) {
            $date = Carbon::parse($user->updated_at);
            $date->addMinute(10);
            $now = Carbon::now();
            $diff = $now->diff($date);
            if ($diff->invert === 1) {
                return redirect('/login')->withErrors(['error' => 'verification link has expired, login and request for a new link']);
            } else {
                User::find($user->id)->update([
                    'email_verified_at' => $now
                ]);

                return redirect('/login')->with('success', 'email verified you can now login');
            }
            
        }else{
            return redirect('/login')->withErrors(['error' => 'invalid verification token']);
        }
    }
}
