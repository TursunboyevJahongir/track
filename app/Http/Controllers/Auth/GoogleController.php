<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Socialite;
use Auth;
use Exception;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {

            $socialite = Socialite::driver('google')->user();
            $user = User::where('google_id', $socialite->id)
                ->orWhere('email', $socialite->email)
                ->firstOrCreate([],[
                    'full_name' => $socialite->name,
                    'email' => $socialite->email,
                    'google_id' => $socialite->id,
                    'is_active' => 1,
                    'phone_confirmed' => 1
                ]);
            $user->google_id ?: $user->update(['google_id' => $socialite->id]);
            Auth::login($user);
            return redirect('/');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
