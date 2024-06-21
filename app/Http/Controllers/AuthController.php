<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CheckOtpRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResentOtpRequest;
use App\Http\Resources\User\BasicInfoResource;
use App\Models\User;
use App\Traits\APIResponse;
use App\Traits\GenerateRandom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use APIResponse, GenerateRandom;

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

    public function register(RegisterRequest $request)
    {

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'otp' => $this->GenerateRandom4DigitNumber()
        ]);

        // TODO Send OTP

        return $this->successResponse(null, 'we have just sent otp code to your phone.');
    }

    public function loginByOtp(CheckOtpRequest $request)
    {
        $user = User::where('phone', $request->phone)->where('otp', $request->otp)->first();

        if (!$user) {
            return $this->errorResponse('Incorrect Credentials', 401);
        }

        $token = Auth::login($user);

        $data = [
            'user' => new BasicInfoResource($user),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ];

        return $this->successResponse($data, 'User Login Successfully');
    }

    public function resentOtp(ResentOtpRequest $request)
    {
        $user = User::where('phone', $request->phone)->first();

        $user->otp = $this->GenerateRandom4DigitNumber();
        $user->save();

        // TODO Send OTP

        return $this->successResponse(null, 'we have just sent otp code to your phone.');
    }

    public function logout()
    {
        Auth::logout();

        return $this->successResponse(null, 'Successfully logged out');
    }

    public function refresh()
    {
        $data = [
            'user' => new BasicInfoResource(Auth::user()),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ];

        return $this->successResponse($data);
    }

}
