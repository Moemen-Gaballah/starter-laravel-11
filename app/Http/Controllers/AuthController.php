<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\BasicInfoResource;
use App\Models\User;
use App\Traits\APIResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use APIResponse;

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->errorResponse('Unauthorized', 401);
        }

        $user = Auth::user();
        $data = [
            'user' => new BasicInfoResource($user),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];

        return $this->successResponse($data);
    }

    public function register(RegisterRequest $request){

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        $data = [
            'user' => new BasicInfoResource($user),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];

        return $this->successResponse($data, 'User created successfully');
    }

    public function logout()
    {
        Auth::logout();

        return $this->successResponse(null, 'Successfully logged out');
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => new BasicInfoResource(Auth::user()),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
