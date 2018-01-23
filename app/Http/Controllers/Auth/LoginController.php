<?php

namespace WoWStats\Http\Controllers\Auth;

use WoWStats\User;
use WoWStats\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('battlenet')
            ->scopes(['wow.profile'])
            ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $socialUser = Socialite::driver('battlenet')->user();
        $nickname = $socialUser->nickname;

        try {
            $user = User::where('name', $nickname)->firstOrFail();

            $user->battlenet_token = $socialUser->token;

            $user->save();

            Auth::loginUsingId($user->id);
        } catch (\Exception $e) {
            $user = User::create([
                'battlenet_id' => $socialUser->getId(),
                'name' => $socialUser->nickname,
                'battlenet_token' => $socialUser->token,
                'password' => str_shuffle(bin2hex(openssl_random_pseudo_bytes(8))),
            ]);

            Auth::loginUsingId($user->id);
        }

        return redirect()->route('home');
    }
}
