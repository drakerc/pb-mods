<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiAuthController extends Controller
{
    /**
     * Register a new User
     *
     * @param [string] name
     * @param [string] email
     * @param [string] password
     * @param [string password_confirmation
     * @return \Illuminate\Http\Response response
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:6|unique:users',
            'email' => 'required|string|email|min:5|unique:users',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();
        return response()->json([
            'message' => 'User created successfully.'
        ], 201);
    }

    /**
     * @param [string] email
     * @param [string] password
     * @param [boolean] remember_me
     * @retunr \Illuminate\Http\Response response
     */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
        {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('My token');
        $token = $tokenResult->token;

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'username' => $user->name,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
            'gravatar' => $user->gravatar
        ]);
    }

    /**
     * Revoke the user's token
     *
     * @param Request $request
     * @return \Illuminate\Http\Response response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
           'message' => 'Logged out successfully.'
        ]);
    }

    /**
     * Get the authenticated user's details
     *
     * @param Request $request
     */
    public function user(Request $request)
    {
        $user = $request->user();
        $user->studios = $user->studios()->get();
        $user->comments = $user->comments()->get();
        return response()->json($user);
    }

    public function updateUserData(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:6|unique:users',
            'password' => 'required|string'
        ]);
        $user = $request->user();

        $credentials = [
            'email' => $user->email,
            'password' => $request->password
        ];

        if(Auth::guard('web')->attempt($credentials)) {
            $user->name = $request->name;

            $user->save();

            return response()->json([
                'message' => 'User updated successfully.'
            ],200);
        }
        return response()->json([
            'message' => 'Incorrect password was given.'
        ], 400);
    }

    public function updateUserPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'old_password' => 'required|string'
        ]);
        $user = $request->user();

        $credentials = [
            'email' => $user->email,
            'password' => $request->old_password
        ];

        if(Auth::guard('web')->attempt($credentials)) {
            $user->password = bcrypt($request->password);

            $user->save();

            return response()->json([
                'message' => 'User updated successfully.'
            ],200);
        }
        return response()->json([
            'message' => 'Incorrect password was given.'
        ], 400);
    }
}
