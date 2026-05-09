<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Otp;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function signup(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
        ]);

        // Create a new admin user
        $admin = Admin::create([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
        ]);
        Otp::updateOrCreate(
            ['user_id' => $admin->id],[
            'otp_code' => '12345',
            'expires_at' => now()->addMinutes(10),
        ]);
        // Return a success response
        return response()->json([
            'message' => 'Admin registered successfully',
            'admin' => $admin,
        ], 201);
    }
    public function verifyOtp(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
            'otp' => 'required|string|max:6',
        ]);

        // Find the admin by phone number
        $admin = Admin::where('phone', $validatedData['phone'])->first();

        if (! $admin) {
            return response()->json([
                'message' => 'Admin not found.',
            ], 404);
        }

        // Check if the OTP is valid and not expired
        if ($admin->otp->otp_code !== $validatedData['otp'] || now()->greaterThan($admin->otp->expires_at)) {
            return response()->json([
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }

        // Mark the admin as verified
        $admin->phone_verified_at = now();
        $admin->otp->delete(); // Clear the OTP
        $admin->status = 'active';
        $token = $admin->createToken('api-token')->plainTextToken;
        $admin->save();

        // Return a success response
        return response()->json([
            'message' => 'OTP verified successfully. Admin is now verified.',
            'admin' => $admin,
            'token' => $token,
        ]);
    }
    public function sendOtp(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        // Find the admin by phone number
        $admin = Admin::where('phone', $validatedData['phone'])->first();

        if (! $admin) {
            return response()->json([
                'message' => 'Admin not found.',
            ], 404);
        }

        // Generate and save a new OTP
        Otp::updateOrCreate(
            ['user_id' => $admin->id],[
            'otp_code' => '12345',
            'expires_at' => now()->addMinutes(10),
        ]);

        // Return a success response
        return response()->json([
            'message' => 'OTP sent successfully.',
        ]);
    }
    public function login(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'phone' => 'required|string|max:20',
            'otp' => 'required|string|max:5',
        ]);
        // Find the admin by phone number
        $admin = Admin::where('phone', $validatedData['phone'])->first();
        if (! $admin) {
            return response()->json([
                'message' => 'Admin not found.',
            ], 404);
        }
        // Check if the OTP is valid and not expired
        if ($admin->otp->otp_code !== $validatedData['otp'] || now()->greaterThan($admin->otp->expires_at)) {
            return response()->json([
                'message' => 'Invalid or expired OTP.',
            ], 400);
        }
        $admin->otp->delete(); // Clear the OTP
        $token = $admin->createToken('api-token')->plainTextToken;
        // Return a success response
        return response()->json([
            'message' => 'Login successful. Admin is now verified.',
            'admin' => $admin,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ]);
    }
}
