<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFac;
use myPHPnotes\Microsoft\Auth;
use myPHPnotes\Microsoft\Models\User;
use Laravel\Socialite\Facades\Socialite;

class MicrosoftAuthController extends Controller
{
    public function signInForm()
    {
        return view('login.login');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('azure')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('azure')->user();
        $rol = $user->user;

        $id = $user->id;
        $name = $user->name;
        $email = $user->email;

        $userData = ModelsUser::updateOrCreate(
            ['id' => $id],
            [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'rol' => $rol['jobTitle']
            ]
        );
        AuthFac::loginUsingId($userData->id);
        return redirect()->route('home');
    }
    public function logout()
    {
        AuthFac::logout();

        // Opcionalmente, puedes redirigir al usuario a otra página después de cerrar sesión
        return redirect()->route('login');
    }


    // public function microsoftOAuth()
    // {
    //     $microsoft = new Auth(env('TENANT_ID'), env('CLIENT_ID'), env('CLIENT_SECRET'), env('CALLBACK_URL'), ["User.Read"]);

    //     $url = $microsoft->getAuthUrl();

    //     return redirect($url);
    // }

    // public function microsoftOAuthCallback(Request $request)
    // {
    //     $microsoft = new Auth(env('TENANT_ID'), env('CLIENT_ID'), env('CLIENT_SECRET'), env('CALLBACK_URL'), ["User.Read"]);

    //     $tokens = $microsoft->getToken($request->code);

    //     $accessToken = $tokens->access_token;

    //     $microsoft->setAccessToken($accessToken);

    //     $user = new User;
    //     $id = $user->data->getId();
    //     $name = $user->data->getDisplayName();
    //     $email = $user->data->getUserPrincipalName();
    //     $rol = $user->data->getJobTitle();
    //     if($rol==env('rol')){
    //         $userData = ModelsUser::updateOrCreate(
    //             ['user_id' => $id],
    //             [
    //                 'user_id' => $id,
    //                 'name' => $name,
    //                 'email' => $email,
    //                 'rol' => $rol
    //             ]
    //         );
    //         AuthFac::loginUsingId($userData->id);
    //     }





    //     $request->session()->put('user_id', $id);
    //     return redirect()->route('home');
    // }



}
