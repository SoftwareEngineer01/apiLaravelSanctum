<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginCreateRequest;

class LoginController extends Controller
{

    public function login(LoginCreateRequest $request) {

        if (Auth::attempt($request->only('email','password'))) {
            return response()->json([
                // 'token' => auth()->user()->createToken('API Token')->plainTextToken,
                'token'   => $request->user()->createToken('authToken')->plainTextToken,
                'message' => 'Success'
            ]);

        } else {
            return response()->json([
                'message' => 'Unhautorized'
            ], 401);
        }

    }

}
