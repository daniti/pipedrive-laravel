<?php

namespace App\Http\Controllers\Auth;

use App\User as User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    // Some methods which were generated with the app
    /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('pipedrive')->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('pipedrive')->user();

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser, true);
        return redirect('/home');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user)
    {
        $authUser = User::where('pipedrive_user_id', $user->id)->where('pipedrive_company_id', $user->user['data']['company_id'])->first();

        if (!$authUser) {
            $authUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'pipedrive_user_id' => $user->id,
                'pipedrive_company_id' => $user->user['data']['company_id']
            ]);
        }

        $authUser->storeToken($user->accessTokenResponseBody);
        return $authUser;
    }
}