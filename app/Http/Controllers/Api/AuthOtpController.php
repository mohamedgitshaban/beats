<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthOtpController extends Controller
{
    public function registerClient(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
        ]);

        $normalizedPhone = preg_replace('/\D+/', '', $validated['phone']);

        $client = User::create([
            'name' => $validated['name'],
            'phone' => $normalizedPhone,
            'email' => $normalizedPhone.'@phone.local',
            'password' => Str::random(40),
            'role' => User::ROLE_CLIENT,
        ]);

        return response()->json([
            'message' => 'Client registered successfully. Request OTP to log in.',
            'data' => $client,
        ], 201);
    }

    public function requestOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $normalizedPhone = preg_replace('/\D+/', '', $validated['phone']);

        $user = User::where('phone', $normalizedPhone)->first();

        if (! $user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        $otp = (string) random_int(100000, 999999);

        $user->forceFill([
            'otp_code' => Hash::make($otp),
            'otp_expires_at' => now()->addMinutes(10),
        ])->save();

        // Replace this with real SMS provider integration in production.
        logger()->info('OTP generated', [
            'phone' => $user->phone,
            'otp' => $otp,
        ]);

        $response = [
            'message' => 'OTP generated successfully. It expires in 10 minutes.',
            'expires_at' => $user->otp_expires_at,
        ];

        if (app()->isLocal()) {
            $response['otp'] = $otp;
        }

        return response()->json($response);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20'],
            'otp' => ['required', 'digits:6'],
        ]);

        $normalizedPhone = preg_replace('/\D+/', '', $validated['phone']);

        $user = User::where('phone', $normalizedPhone)->first();

        if (! $user || ! $user->otp_code) {
            return response()->json([
                'message' => 'Invalid OTP credentials.',
            ], 422);
        }

        if (! $user->otp_expires_at || now()->greaterThan($user->otp_expires_at)) {
            return response()->json([
                'message' => 'OTP expired. Request a new OTP.',
            ], 422);
        }

        if (! Hash::check($validated['otp'], $user->otp_code)) {
            return response()->json([
                'message' => 'Invalid OTP credentials.',
            ], 422);
        }

        $user->forceFill([
            'otp_code' => null,
            'otp_expires_at' => null,
        ])->save();

        $abilities = $user->role === User::ROLE_ADMIN
            ? ['admin', 'admins:manage', 'clients:read']
            : ['client'];

        $token = $user->createToken('api-token', $abilities)->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'token_type' => 'Bearer',
            'abilities' => $abilities,
            'data' => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
