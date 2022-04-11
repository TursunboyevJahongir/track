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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();
            $finduser = User::whereGoogleId($user->id)->first();

            if($finduser){
                Auth::login($finduser);
                return redirect('/');

            }else{
                $newUser = User::create([
                    'full_name' => $user->name,
                    'email' => $user->email,
                    'phone' => '',
                    'google_id'=> $user->id,
                    'password' => '123456'
                ]);

                Auth::login($newUser);

                return redirect('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
