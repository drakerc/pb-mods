<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function signup(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
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

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'unauthorized'
            ], 401);
        }

        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'username' => $user->name,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ]);
    }

    /**
     * Revoke the user's token
     *
     * @param Request $request
     * @return \Illuminate\Http\Response response
     */
    public function logout(Request $request) {
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
    public function user(Request $request) {
        return response()->json($request->user());
    }
}
