<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function findUserByName(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $users = User::where('name', 'like', '%' . $request->name . '%')->get();

        return response()->json($users);
    }
}
