<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {      
            // $fields = $request->validate([
            //     'name' => 'required|string',
            //     'email' => 'reqired|string|unique:users,email',
            //     'password' => 'required|string|confirmed'
            // ]);

            $fields = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ];

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201); 
    }
}
